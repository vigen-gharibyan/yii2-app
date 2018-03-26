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
class SinglepageAsset extends AssetBundle
{
//	public $sourcePath = '@webroot/themes/singlepage';
	public $basePath = '@webroot/themes/singlepage';
	public $baseUrl = '@web/themes/singlepage';
    public $css = [
        'css/site.css',
    ];
    public $js = [
		'js/app.js',
		'js/controllers.js',
    ];
    public $depends = [
		'frontend\assets\AngularAsset',
		'yii\web\YiiAsset',
		'yii\jui\JuiAsset',
		'frontend\assets\BootstrapAsset',
		'frontend\assets\BootstrapPluginAsset',
	//	'yii\bootstrap\BootstrapAsset',
	//	'yii\bootstrap\BootstrapPluginAsset',
    ];
}
