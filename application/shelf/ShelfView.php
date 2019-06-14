<?php

namespace shelf;

use field\FieldModel;
use system\View;

class ShelfView extends View
{
    /**
     * @param array $output
     */
    public function __construct(array $output)
    {
        parent::__construct($output);
    }

    /**
     * @return void
     */
    protected function setTemplate(): void
    {
        $this->template = 'shelf.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables(): void
    {
        $this->output['CURRENT_SHELF'] = $this->args['active'];
        $this->output['CURRENT_SHELF_NAME'] = (new ShelfModel())->get($this->args['active'])->getName();
        $this->output['FIELDS'] = (new FieldModel())->getTwigDataByShelfId($this->args['active']);
        $this->addStyles(['shelf']);
        $this->addScripts(['shelf']);
        $this->addJsStrings([
            'NEW_PRODUCT' => $this->strings['NEW_PRODUCT'],
        ]);
    }
}
