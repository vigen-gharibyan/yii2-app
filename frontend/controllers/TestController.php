<?php

namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use common\models\Settings;

/**
 * PostController implements the CRUD actions for Post model.
 */
class TestController extends Controller
{
    public function actionIndex()
    {
		$homeUrl = Yii::$app->homeUrl;

        if(Settings::setTheme('default')) {
            $theme = Settings::get('theme');
            dd($theme);
        } else {
            dd('false');
        }

        /*
        Yii::$app->mailer
            ->compose([
                'html' => 'signup-html',
            //  'text' => 'contact-text',
            ])
            ->setFrom('from@domain.com')
            ->setTo('to@domain.com')
            ->setSubject('Message subject')
            ->send();
        */

        return $this->render('index');
    }

}
