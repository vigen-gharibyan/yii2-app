<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')
        ->dropDownList(
            User::getStatuses(),
            [
                'prompt' => Yii::t('app', 'Select ...'),
            ]
        ) ?>

    <?= $form->field($model, 'role')
        ->dropDownList(
            User::getRoles(),
            [
                'prompt' => Yii::t('app', 'Select ...'),
            ]
        ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
