<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Breadcrumbs;
use frontend\assets\SinglepageAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

SinglepageAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>My Angular Yii Application</title>
	<?php $this->head() ?>
    <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />
</head>
<body ng-controller="MainController">
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?= $this->render('//layouts/_navigation'); ?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <div ng-show="flash" class="alert alert-{{ flash.get().class }}">
                {{ flash.get().message }}
            </div>
            <div ng-view></div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
