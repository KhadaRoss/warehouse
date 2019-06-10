<?php

namespace helpers;

use DateTime;
use models\SettingsModel;

class Date
{
    /** @var string */
    private $date;

    /**
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function nowEncode(): string
    {
        $this->date = DateTime::createFromFormat($this->getFormatBySystemLanguage(), $this->date);

        return $this->date->format('Y-m-d');
    }

    /**
     * return string
     */
    public function nowDecode(): string
    {
        $this->date = DateTime::createFromFormat('Y-m-d', $this->date);

        return $this->date->format($this->getFormatBySystemLanguage());
    }

    /**
     * @return string
     */
    private function getFormatBySystemLanguage(): string
    {
        switch (SettingsModel::get('CURRENT_LANGUAGE')) {
            case 'de':
                return 'd.m.Y';
            case 'en':
                return 'm.d.Y';
            default:
                return 'Y-m-d';
        }
    }
}
