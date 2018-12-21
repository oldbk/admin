<?php

namespace frontend\modules\wordfilter;

/**
 * frontedit module definition class
 */
class Module extends \common\modules\wordfilter\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\wordfilter\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}