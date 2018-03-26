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
class FancyboxAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/fancybox';
    public $baseUrl = '@web/themes/fancybox';
    public $css = [
        'fancybox/jquery.fancybox-1.3.4.css',
        'css/style.css',
    ];
    public $js = [
		'js/jquery-1.4.3.min.js',
		'fancybox/jquery.mousewheel-3.0.4.pack.js',
		'fancybox/jquery.fancybox-1.3.4.pack.js',
		'js/scripts.js',
    ];
    public $depends = [
    //	'yii\web\YiiAsset',
	//	'yii\bootstrap\BootstrapAsset',
    ];
}
