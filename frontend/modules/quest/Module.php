<?php

namespace frontend\modules\quest;

use \common\modules\quest\Module as BaseModule;
/**
 * quest module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\quest\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
