<?php

namespace frontend\modules\news;

/**
 * quest module definition class
 */
class Module extends \common\modules\news\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\news\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
