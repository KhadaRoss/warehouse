<?php

namespace helpers;

class JsHelper
{
    /**
     * @var string
     */
    private $scrips = '';

    /**
     * @param string[] $fileNames
     *
     * @return string
     */
    public function getScripts(array $fileNames): string
    {
        foreach ($fileNames as $fileName) {
            list($fileName) = explode('.', $fileName, 2);
            $this->scrips .= '<script src="' . URL . 'js/' . $fileName . '.js"></script>';
        }

        return $this->scrips;
    }
}
