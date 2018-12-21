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
class DatePickerAsset extends PluginAsset
{
    public $js = [
        'js/datapicker/bootstrap-datepicker.js',
    ];
    public $css = [
        'css/datapicker/datepicker3.css'
    ];
}
