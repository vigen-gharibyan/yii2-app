<?php
namespace frontend\modules\components;

use Yii;

class Controller extends \frontend\components\Controller
{
	public function createMultilanguageReturnUrl($lang = 'en', $params = [])
	{
		if (count($_GET) > 0) {
			$arr = $_GET;
			$arr['language'] = $lang;
		} else {
			$arr = array('language' => $lang);
		}
		
		$param_temp = [
			$this->module->module->requestedRoute,	//for controllers of module
		];
		$param_temp = array_merge($param_temp, $arr);
		$params = array_merge($param_temp, $params);
		$urlManager = Yii::$app->urlManager;
		
		return $urlManager->createUrl($params);
    }
}
