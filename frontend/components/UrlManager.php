<?php
namespace frontend\components;

use common\models\Lang;
use Yii;

class UrlManager extends \yii\web\UrlManager
{
	public function createUrl($params)
	{
		$params = (array) $params;

		if (!isset($params['language']) AND 
			Yii::$app->params['currentLanguage'] !== Yii::$app->params['defaultLanguage'])
		{
			$params['language'] = Yii::$app->params['currentLanguage'];
		}
		
		return parent::createUrl($params);
	}
}