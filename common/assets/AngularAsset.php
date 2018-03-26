<?php
namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
    //  'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js',
        'angular/angular.js',
    //  'angular-upload/angular-upload.min.js',
    //  'angular-route/angular-route.js',
    //  'angular-strap/dist/angular-strap.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}

