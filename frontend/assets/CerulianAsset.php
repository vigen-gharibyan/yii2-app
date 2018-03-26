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
class CerulianAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/cerulian';
    public $baseUrl = '@web/themes/cerulian';
    public $css = [
    	'css/bootstrap.css',
    //	'css/form.css',
    	'css/bootstrap-responsive.css',
    	'css/site.css',
    	'css/chosen.css',
    	'css/style.css',
    ];
    public $js = [
		'js/jquery.js',
	//	'js/bootstrap-transition.js',
	//	'js/bootstrap-alert.js',
	//	'js/bootstrap-modal.js',
		'js/bootstrap-dropdown.js',
	//	'js/bootstrap-scrollspy.js',
	//	'js/bootstrap-tab.js',
	//	'js/bootstrap-tooltip.js',
	//	'js/bootstrap-popover.js',
	//	'js/bootstrap-button.js',
		'js/bootstrap-collapse.js',
	//	'js/bootstrap-carousel.js',
		'js/chosen.jquery.js',
		'js/scripts.js',
    ];
    public $depends = [
    //	'yii\web\YiiAsset',
    //	'yii\bootstrap\BootstrapAsset',
    ];
}
