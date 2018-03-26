<?php
namespace frontend\modules\admin\components;

use Yii;
use yii\filters\AccessControl;

class Controller extends \frontend\modules\components\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['moderator'],
                    ]
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->setTheme('admin');
    }
}
