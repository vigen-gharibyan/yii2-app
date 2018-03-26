<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Lang;
use common\models\Settings;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Add {modelClass}', [
            'modelClass' => 'Language',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            //  'header' => '',
                'options' => ['width'=>'50'],
                'headerOptions' => ['class' => 'text-right'],
                'contentOptions' => ['class' => 'text-right'],
            ],
        //  'id',
            'code',
            'local',
            'name',
        //  'default',
            [
                'attribute' => 'flag',
                'format' => 'html',
                'value' => function($model){
                    $frontend_dir = Yii::getAlias('@frontend');
                    $dir = '/img/flags/';
                    $theme = Settings::get('theme');

                    if(!empty($theme)) {
                        $theme_dir = '/themes/'. $theme;
                        if(file_exists($frontend_dir .'/web'. $theme_dir)) {
                            $dir = $theme_dir .'/img/flags/';
                        }
                    }

                    if(!empty($model->flag)) {
                        $src = Yii::$app->urlManagerFrontend->createUrl($dir . $model->flag);
                        return Html::img($src, ['width' => 18, 'title' => $model->name]);
                    }
                    return '';
                },
                'options' => ['width'=>'150'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'attribute' => 'enabled',
                'format' => 'html',
                'value' => function($model){
                    if($model->enabled == Lang::STATUS_ACTIVE) {
                        $glyphicon = 'glyphicon-ok';
                    } else {
                        $glyphicon = 'glyphicon-minus';
                    }
                    return '<span class="glyphicon '. $glyphicon .'"></span>';
                },
                'options' => ['width'=>'150'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            // 'created_at',
            // 'updated_at',
            // 'order',
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width'=>'100'],
                'contentOptions' => ['class'=>'text-center'],
            ],
        ],
    ]); ?>

</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderLanguages">
    <?= Yii::t('app', 'Order Languages') ?>
</button>

<!-- Modal -->
<div class="modal fade" id="orderLanguages" tabindex="-1" role="dialog" aria-labelledby="orderLanguagesLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Order Languages') ?></h4>
            </div>
            <div class="modal-body">
                <div id="error-message" class="error"></div>
                <ul id="sortable">
                    <?php foreach($dataProvider->models as $model): ?>
                        <li class="ui-state-default" data-orderId="<?= $model->id ?>">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                            <?= $model->code ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
                <button type="button" class="btn btn-primary" id="order-save"><?= Yii::t('app', 'Save') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var error_message = '<?= Yii::t('app', 'Something went wrong. Please try again.') ?>';
</script>