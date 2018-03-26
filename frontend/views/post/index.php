<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if(Yii::$app->user->can('createPost')) { ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
	<?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function($model){
                    return $model->title;
                },
                'options' => ['width'=>'200'],
            ],
            [
                'attribute' => 'content',
                'format' => 'raw',
                'value' => function ($model) {
                    $content = strip_tags($model->content);

                    if(strlen($content) > 300) {
                        $position = strpos($content, ' ', 300);
                        if($position != false) {
                            $content = substr($content, 0, $position) .' ...';
                        }
                    }

                    return $content;
                },
                'contentOptions' => ['style' => 'text-align: justify'],
            ],
        //  'created_by',
        //  'created_at:datetime',
            [
                'attribute' => 'updated_at',
                'filter' => false,
                'format' => 'raw',
                'value' => function($model){
                    $updated_at = date('d.m.Y', $model->updated_at);
                    return $updated_at;
                }
            ],
            /*
			[
				'attribute' => 'enabled',
				'format' => 'html',
				'value' => function ($model) {
					return Post::statuses()[$model->enabled];
				},
			],
			*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if(Yii::$app->user->can('updatePost', ['post' => $model])) {
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
