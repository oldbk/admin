<?php

namespace frontend\modules\export;

/**
 * library module definition class
 */
class Module extends \common\modules\export\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\export\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
