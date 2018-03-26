<?php
namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MaterialAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'angular-material/angular-material.min.css',
    ];
    public $js = [
        'angular-material/angular-material.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}

