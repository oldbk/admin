<?php

namespace frontend\modules\users;

/**
 * quest module definition class
 */
class Module extends \common\modules\users\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\users\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
