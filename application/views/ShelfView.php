<?php

namespace views;

use models\ShelfModel;

class ShelfView extends View
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
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
        $this->addStyles(['shelf']);
        $this->addScripts(['shelf']);
    }
}
