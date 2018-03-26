<?php
namespace frontend\widgets;

use common\models\Lang;

class Languages extends \yii\bootstrap\Widget
{
	public $callingController;
	
    public function init(){}

    public function run() {
		$languages = Lang::getAll();
		$currentLanguageCode = Lang::getCurrent();
		$current = $languages[$currentLanguageCode];
		unset($languages[$currentLanguageCode]);
		
        return $this->render('languages/view', [
            'currentLanguage' => $current,
			'otherLanguages' => $languages,
        ]);
    }
}