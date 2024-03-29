<?php

namespace system;

use PDO;

class StringsModel extends Model
{
    /**
     * @param PDO $database
     */
    public function __construct(PDO $database)
    {
        parent::__construct($database);
    }

    /**
     * @param array  $keys
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
                'lang' => 'de'
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
                'lang' => 'de'
            ]
        )->fetchColumn();
    }
}
