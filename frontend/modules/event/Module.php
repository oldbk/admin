<?php

namespace frontend\modules\event;

/**
 * library module definition class
 */
class Module extends \common\modules\event\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\event\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
