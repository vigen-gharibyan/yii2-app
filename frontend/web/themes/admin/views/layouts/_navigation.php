<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
	'brandLabel' => 'My Company',
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => 'navbar-default navbar-fixed-top',
	],
]);
$menuItems = [
	['label' => \Yii::t('app', 'Home'), 'url' => ['/site/index']],
	['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']],
	['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
	$menuItems[] = ['label' => \Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
	$menuItems[] = ['label' => \Yii::t('app', 'Login'), 'url' => ['/site/login']];
} else {
	$menuItems[] = [
		'label' => \Yii::t('app', 'Logout') .' (' . Yii::$app->user->identity->username . ')',
		'url' => ['/site/logout'],
		'linkOptions' => ['data-method' => 'post']
	];
}

$languageItems = [];
if(count(Yii::$app->params['languages']) > 1) {
	foreach(Yii::$app->params['languages'] as $language) {
		$languageItems[] = [
			'label' => $language['name'],
			'url' => $this->context->createMultilanguageReturnUrl($language['code']),
		];
	}

	$menuItems[] = [
		'label' => \Yii::t('app', 'Languages'),
		'items' => $languageItems,
	];
}

echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $menuItems,
]);
NavBar::end();

?>
