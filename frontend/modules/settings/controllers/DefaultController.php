<?php
namespace frontend\modules\settings\controllers;

use frontend\modules\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionAdd()
    {
        return $this->render('add');
    }
	
	public function actionEdit()
    {
        return $this->render('edit');
    }
}
