<?php
namespace frontend\components;

use Yii;
use yii\base\Theme;
use common\models\Lang;
use common\models\Settings;

/**
 * Base controller
 */
class Controller extends \yii\web\Controller
{
//	protected $theme = 'default';
//	public $layout = '/main';

	public function init()
	{
		parent::init();
		$settings = Settings::getAll();
		if(array_key_exists('theme', $settings)) {
			$this->setTheme($settings['theme']);
		}

		$languages = Lang::getAll();
		$defaultLanguageCode = Lang::getDefault();
		
		if(!empty($languages)) {
			if(array_key_exists($defaultLanguageCode, $languages)){
				$i = array_search($defaultLanguageCode, array_keys($languages));
				$defaultLanguage = array_splice($languages, $i, 1);
				$languages = $defaultLanguage + $languages;
			} else {
				$defaultLanguageCode = key($languages);
			}
			
			Yii::$app->params['languages'] = $languages;
			Yii::$app->params['defaultLanguage'] = $defaultLanguageCode;
			$currentLanguage = Yii::$app->params['defaultLanguage'];
			
			// If there is a post-request, redirect the application to the provided url of the selected language
			if (isset($_POST['language'])) {
				$lang = $_POST['language'];
				$MultilangReturnUrl = $_POST[$lang];
				$this->redirect($MultilangReturnUrl);
			}
			// Set the application language if provided by GET, session or cookie
			if (isset($_GET['language']) AND 
				array_key_exists($_GET['language'], Yii::$app->params['languages']))
			{
				$currentLanguage = $_GET['language'];
			}
			
			Lang::setCurrent($currentLanguage);
			$homeUrl = Yii::$app->urlManager->createUrl([NULL]);
			Yii::$app->setHomeUrl($homeUrl);
		}
	}
	
	public function createMultilanguageReturnUrl($lang = 'en', $params = [])
	{
		if (count($_GET) > 0) {
			$arr = $_GET;
			$arr['language'] = $lang;
		} else {
			$arr = ['language' => $lang];
		}
		
		$param_temp = [
			$this->module->requestedRoute,
		];
		$param_temp = array_merge($param_temp, $arr);
		$params = array_merge($param_temp, $params);
		$urlManager = Yii::$app->urlManager;

		return $urlManager->createUrl($params);
    }
	
	protected function setTheme($theme='default')
	{
		Yii::$app->view->theme = new Theme([
			'basePath' => '@webroot/themes/'. $theme,
			'baseUrl' => '@web/themes/'. $theme,
			'pathMap' => [
				'@app/views' => '@webroot/themes/'. $theme . '/views'
			],
		]);
	}
}
