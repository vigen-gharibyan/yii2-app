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
class DefaultAsset extends AssetBundle
{
    public $sourcePath = '@webroot/themes/default';
	public $baseUrl = '@web/themes/default';
    public $css = [
        'css/site.css',
    ];
    public $js = [
		'js/tab.js',
		'js/tinymce/tinymce.js',
		'js/scripts.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
		'yii\jui\JuiAsset',
		'frontend\assets\BootstrapAsset',
		'frontend\assets\BootstrapPluginAsset',
	//	'yii\bootstrap\BootstrapAsset',
	//	'yii\bootstrap\BootstrapPluginAsset',
    ];
}
