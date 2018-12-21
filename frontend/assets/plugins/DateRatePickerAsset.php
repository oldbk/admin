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
class DateRatePickerAsset extends PluginAsset
{
    public $js = [
        'js/daterangepicker/daterangepicker.js',
    ];
    public $css = [
        'css/daterangepicker/daterangepicker-bs3.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'frontend\assets\BootstrapAsset',
        'frontend\assets\plugins\MomentAsset',
    ];
}
