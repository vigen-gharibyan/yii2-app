<?php
use yii\helpers\Html;
?>
<div class="settings-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
		<br />
		<br /><?= Html::a(Html::encode('Index page'), ['/settings/default/index'], ['class'=>'brand']) ?>
		<br /><?= Html::a(Html::encode('Add page'), ['/settings/default/add'], ['class'=>'brand']) ?>
		<br /><?= Html::a(Html::encode('Edit page'), ['/settings/default/edit'], ['class'=>'brand']) ?>
    </p>
</div>
