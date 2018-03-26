<?php
namespace frontend\widgets;

class Cropper extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
		
        return $this->render('cropper/view', []);
    }
}