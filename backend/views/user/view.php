<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'filter' => User::getRoles(),
                'value' => function($model) {
                    $roles = User::getRoles();
                    if(array_key_exists($model->role, $roles)) {
                        return $roles[$model->role];
                    }

                    return NULL;
                }
            ],
            [
                'attribute' => 'status',
                'filter' => User::getStatuses(),
                'value' => function($model) {
                    $statuses = User::getStatuses();
                    if(array_key_exists($model->status, $statuses)) {
                        return $statuses[$model->status];
                    }

                    return NULL;
                }
            ],
            [
                'attribute' => 'created_at',
                'filter' => false,
                'format' => 'raw',
                'value' => function($model){
                    return date('d.m.Y H:i', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'filter' => false,
                'format' => 'raw',
                'value' => function($model){
                    return date('d.m.Y H:i', $model->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
