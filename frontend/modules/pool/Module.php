<?php

namespace frontend\modules\pool;

use common\modules\pool\Module as BaseModule;
/**
 * dialog module definition class
 */
class Module extends BaseModule
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'frontend\modules\pool\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
