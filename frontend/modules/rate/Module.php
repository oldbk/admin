<?php

namespace frontend\modules\rate;

/**
 * quest module definition class
 */
class Module extends \common\modules\rate\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\rate\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
