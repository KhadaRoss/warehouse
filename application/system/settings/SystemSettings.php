<?php

namespace system\settings;

use models\SettingsModel;

class SystemSettings
{
    /**
     * @var array
     */
    private static $settings;

    private function __construct()
    {
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
    private function getAll(): void
    {
        self::$settings = (new SettingsModel())->getAll();
    }

    /**
     * @return void
     */
    public static function updateAll(): void
    {
        new self();
    }
}
