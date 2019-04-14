<?php

namespace helpers;

class CssHelper
{
    /** @var string */
    private $styles = '';

    /**
     * @param array $fileNames
     *
     * @return CssHelper
     */
    public function getStyles(array $fileNames): string
    {
        foreach ($fileNames as $fileName) {
            list($fileName) = explode('.', $fileName, 2);
            $this->styles .= '<link rel="stylesheet" type="text/css" href="' . URL . 'css/' . $fileName . '.css">';
        }

        return $this->styles;
    }
}
