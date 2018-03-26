<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate', 'token' => $user->password_reset_token]);
?>
<div class="activate-account">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p><?= Yii::t('app', 'Click the following link to activate your account') ?></p>

    <p><?= Html::a(Html::encode($activationLink), $activationLink) ?></p>
</div>
