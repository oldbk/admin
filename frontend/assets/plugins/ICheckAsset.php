<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets\plugins;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ICheckAsset extends PluginAsset
{
    public $js = [
        'js/iCheck/icheck.min.js',
    ];
    public $css = [
        'css/iCheck/custom.css'
    ];
}
