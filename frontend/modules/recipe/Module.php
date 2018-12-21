<?php

namespace frontend\modules\recipe;

use \common\modules\recipe\Module as BaseModule;
/**
 * quest module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\recipe\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
