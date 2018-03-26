<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        //  'id',
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'contentOptions' => ['style'=>'max-width: 200px;'],
                'options' => ['width'=>'100'],
            ],
        ],
    ]); ?>
</div>
