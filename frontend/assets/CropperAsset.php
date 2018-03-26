<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CropperAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/cropper';
    public $baseUrl = '@web/themes/cropper';
    public $css = [
		'dist/cropper.min.css',
		'css/main.css',
        'css/site.css',
        'css/style.css',
    ];
    public $js = [
		'js/tab.js',
		'js/tinymce/tinymce.js',
		'dist/cropper.min.js',
		'js/main.js',
		'js/scripts.js',
    ];
    public $depends = [
    	'yii\bootstrap\BootstrapAsset',
    	'yii\web\YiiAsset',
    ];
}
