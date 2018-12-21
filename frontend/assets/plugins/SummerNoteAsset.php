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
class SummerNoteAsset extends PluginAsset
{
    public $js = [
        'js/summernote/summernote.min.js',
    ];
    public $css = [
        'css/summernote/summernote.css',
        //'css/summernote/summernote-bs3.css',
    ];
}
