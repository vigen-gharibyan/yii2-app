<?php
namespace backend\components;

use Yii;

/**
 * Base controller
 */
class Controller extends \yii\web\Controller
{
//	public $layout = '/main';

	public function init()
	{
		parent::init();
		$this->setTheme('default');
		Yii::$app->language = 'ru-Ru';
	}

	protected function setTheme($theme='default')
	{
		$this->getView()->theme = Yii::createObject([
			'class' => '\yii\base\Theme',
			'pathMap' => ['@app/views' => '@webroot/themes/'. $theme . '/views'],
			'baseUrl' => '@web/themes/'. $theme,
		]);
	}
}
