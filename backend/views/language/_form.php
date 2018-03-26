<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Lang;

/* @var $this yii\web\View */
/* @var $model common\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lang-form">

    <?php $form = ActiveForm::begin([
    //  'enableClientValidation' => false,
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 2]) ?>

    <?= $form->field($model, 'local')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'enabled')->dropDownList(Lang::statuses(), ['prompt' => Yii::t('app', 'Select ...')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
