<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use backend\components\Controller;

/**
 * Test controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        if(file_exists("C:\xampp\htdocs\yii2site\www/frontend/themes/default")) {
            exit('file_exists');
        } else {
            exit('not');
        }

        echo Html::a('text', Yii::$app->urlManagerFrontend->createUrl('/post'), []);
    //  return $this->render('index');
    }
}
