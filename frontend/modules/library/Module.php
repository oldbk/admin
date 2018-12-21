<?php

namespace frontend\modules\library;

/**
 * library module definition class
 */
class Module extends \common\modules\library\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\library\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
