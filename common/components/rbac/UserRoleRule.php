<?php
namespace common\components\rbac;

use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
	
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            //Значение из поля role базы данных
            $role = Yii::$app->user->identity->role;
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === 'moderator') {
                //moderator является потомком admin, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR;
            } elseif ($item->name === 'worker') {
                //worker является потомком moderator, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR
                || $role == User::ROLE_WORKER;
            } elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR
                || $role == User::ROLE_WORKER || $role == User::ROLE_USER;
            }
        }

        return false;
    }
}