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
class DateRangPickerAsset extends PluginAsset
{
    public $js = [
        'js/bootstrap-daterangepicker/daterangepicker.js',
    ];
    public $css = [
        'css/bootstrap-daterangepicker/daterangepicker.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'frontend\assets\BootstrapAsset',
        'frontend\assets\plugins\MomentAsset',
    ];
}
