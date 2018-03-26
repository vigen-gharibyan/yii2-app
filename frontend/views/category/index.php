<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Yii::$app->user->can('createPost')) { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function($model){
                    return $model->name;
                },
            ],
            [
                'attribute' => 'description',
                'format' => 'html',
                'value' => function($model){
                    return $model->description;
                },
            ],
            'enabled',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if(Yii::$app->user->can('createPost', ['post' => $model])) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                        }

                        return '';
                    },
                    'delete' => function ($url, $model) {
                        if(Yii::$app->user->can('deletePost')) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                        return '';
                    },
                ],
                'contentOptions' => ['style'=>'max-width: 200px;'],
                'options' => ['width'=>'100'],
            ],
        ],
    ]); ?>
</div>
