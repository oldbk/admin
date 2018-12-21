<?php

namespace frontend\modules\stats;

/**
 * quest module definition class
 */
class Module extends \common\modules\stats\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\stats\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
