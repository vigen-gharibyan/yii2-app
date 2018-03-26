<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->can('updatePost', ['post' => $model])) { ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if(Yii::$app->user->can('deletePost')) { ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'title',
			[
				'attribute' => 'content',
				'format' => 'raw',
                'value' => $model->content,
            ],
            [
                'attribute' => 'categories',
                'format' => 'raw',
                'value' => function($model) {
                    $categories = [];
                    foreach ($model->categories as $category) {
                        $categories[] = $category->name;
                    }
                    $categories = implode(', ', $categories);

                    return $categories;
                }
            ],
            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => function($model) {
                    $user = $model->user;
                    if(!empty ($user)) {
                        $username = $user->username;
                        $email = $user->email;

                        return "$username ($email)";
                    }
                }
            ],
			'created_at:datetime',
			'updated_at:datetime',
		//	'enabled',
        ],
    ]) ?>

</div>
