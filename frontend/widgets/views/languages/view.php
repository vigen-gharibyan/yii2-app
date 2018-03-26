<?php
use yii\helpers\Html;
?>

<?php if(count($otherLanguages) > 1): ?>
	<div class="dropdown">
		<button class="btn-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			<?= $currentLanguage['name'] ?> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<?php foreach ($otherLanguages as $language): ?>
				<li role="presentation">
					<?= Html::a($language['name'], $this->context->callingController->createMultilanguageReturnUrl($language['code'])) ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php else: ?>
	
<?php endif; ?>