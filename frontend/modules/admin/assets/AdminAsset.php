<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $baseUrl = '@web/themes/admin';
//  public $basePath = '@webroot/themes/admin';
    public $sourcePath = '@webroot/themes/admin';
    public $css = [
        'lib/bootstrap/dist/css/bootstrap.min.css',
        'lib/metisMenu/dist/metisMenu.min.css',
        'dist/css/sb-admin-2.css',
        'lib/morrisjs/morris.css',
        'lib/font-awesome/css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js = [
        'lib/jquery/dist/jquery.min.js',
        'lib/bootstrap/dist/js/bootstrap.min.js',
        'lib/metisMenu/dist/metisMenu.min.js',
        'lib/raphael/raphael.min.js',
        'lib/morrisjs/morris.min.js',
        'data/morris-data.js',
        'dist/js/sb-admin-2.js',
        'js/scripts.js',
    ];
    public $depends = [];
}
