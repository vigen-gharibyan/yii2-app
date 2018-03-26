<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use common\models\Post;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = [];
    foreach (Yii::$app->params['languages'] as $language) {
        $active = $language['code'] == Yii::$app->params['defaultLanguage'];
        $suffix = $active ? '' : '_' . $language['code'];
        $content = $this->render('_content', [
            'model' => $model,
            'form' => $form,
            'suffix' => $suffix,
            'language' => $language,
        ]);
        $items[] = [
            'label' => $language['code'],
            'icon' => 'user',
            'content' => $content,
            'active' => $active,
            'options' => ['id' => $language['code']],
        ];
    }

    echo Tabs::widget([
        'items' => $items,
    ]);
    ?>

    <?= $form->
    field($model, 'categories')->
    dropDownList(
        ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        ['multiple' => 'multiple']
    )
    ?>

    <?= $form->field($model, 'enabled')
        ->dropDownList(
            Post::statuses(),
            ['prompt' => Yii::t('app', 'Select ...')]
        ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
