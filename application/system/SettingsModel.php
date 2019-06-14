<?php

namespace system;

class SettingsModel extends Model
{
    /**
     * @var array
     */
    private static $settings;

    private function __construct()
    {
        parent::__construct();

        $this->getAll();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function get(string $key)
    {
        if (self::$settings === null) {
            new self();
        }

        return self::$settings[$key];
    }

    /**
     * @return void
     */
    public static function updateAll(): void
    {
        new self();
    }

    /**
     * @return void
     */
    public function getAll(): void
    {
        $settings = $this->prepareAndExecute('SELECT id, type, setting FROM settings')->fetchAll();

        $data = [];
        foreach ($settings as $setting) {
            $data[$setting['id']] = $this->format(
                [
                    'setting' => $setting['setting'],
                    'type'    => $setting['type']
                ]
            );
        }

        self::$settings = $data;
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
