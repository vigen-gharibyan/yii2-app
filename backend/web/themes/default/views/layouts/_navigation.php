<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => \Yii::t('app', 'Dashboard'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    [
        'label' => \Yii::t('app', 'Home'),
        'url' => ['/site/index']
    ],
    [
        'label' => \Yii::t('app', 'Settings'),
        'url' => ['/settings']
    ],
    [
        'label' => \Yii::t('app', 'Languages'),
        'url' => ['/languages']
    ],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => \Yii::t('app', 'Login'), 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => \Yii::t('app', 'Logout') .' ('. Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
