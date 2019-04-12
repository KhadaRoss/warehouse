<?php

namespace models;

class SettingsModel extends Model
{
    /**
     * @return array
     */
    public function getAll(): array
    {
        $settings = $this->prepareAndExecute('SELECT id, type, setting FROM settings')->fetchAll();

        $return = [];
        foreach ($settings as $setting) {
            $return[$setting['id']] = $this->format(
                [
                    'setting' => $setting['setting'],
                    'type'    => $setting['type']
                ]
            );
        }

        return $return;
    }

    /**
     * @param array $setting
     *
     * @return mixed
     */
    private function format(array $setting)
    {
        switch ($setting['type']) {
            case 'int':
                return (int)$setting['setting'];
            case 'bool':
                return $setting['setting'] === '1';
            case 'float':
                return (float)$setting['setting'];
            case 'enum':
                return \explode('|', $setting['setting']);
            default:
                return \trim($setting['setting']);
        }
    }
}
