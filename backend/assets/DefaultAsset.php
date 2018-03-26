<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DefaultAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/default';
    public $baseUrl = '@web/themes/default';
    public $css = [
        'css/jquery-ui.css',
        'css/site.css',
        'css/style.css',
    ];
    public $js = [
		'js/jquery-ui.js',
		'js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
