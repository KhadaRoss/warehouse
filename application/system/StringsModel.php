<?php

namespace system;

class StringsModel extends Model
{
    /**
     * @param array $keys
     * @param string $lang
     *
     * @return array
     */
    public function getAll(array $keys, string $lang = ''): array
    {
        $in = \implode("', '", $keys);

        $query = <<<SQL
SELECT id, string FROM strings WHERE id IN('{$in}') AND language = :lang
SQL;
        $strings = $this->prepareAndExecute(
            $query,
            [
                'lang'    => ($lang === '' ? SettingsModel::get('CURRENT_LANGUAGE') : $lang)
            ]
        )->fetchAll();

        $return = [];
        foreach ($strings as $string) {
            $return[$string['id']] = $string['string'];
        }

        return $return;
    }

    /**
     * @param string $key
     * @param string $lang
     *
     * @return string
     */
    public function get(string $key, string $lang = ''): string
    {
        $query = <<<SQL
SELECT string FROM strings WHERE id = :id AND language = :lang;
SQL;

        return $this->prepareAndExecute(
            $query,
            [
                'id'   => $key,
                'lang' => $lang === '' ? SettingsModel::get('CURRENT_LANGUAGE') : $lang
            ]
        )->fetchColumn();
    }
}
