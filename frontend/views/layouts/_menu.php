<?php
use yii\widgets\Menu;
?>

<?php
$items = [
	[
		'label' => \Yii::t('app', 'Home'), 
		'url' => ['/site/index']
	],
	[
		'label' => \Yii::t('app', 'About'), 
		'url' => ['/site/about']
	],
	[
		'label' => \Yii::t('app', 'Contact'), 
		'url' => ['/site/contact']
	],
];

if(Yii::$app->user->isGuest) {
	$items[] = [
		'label' => \Yii::t('app', 'Signup'), 
		'url' => ['/site/signup'], 
	];
	$items[] = [
		'label' => \Yii::t('app', 'Login'), 
		'url' => ['/site/login'], 
	];
}
else {
	$items[] = [
		'label' => \Yii::t('app', 'Logout') .' (' . Yii::$app->user->identity->username .')' , 
		'url' => ['/site/logout'], 
	];
}

echo Menu::widget(array(
	'options' => array('class' => 'nav'),
	'items' => $items,
)); 
?>
