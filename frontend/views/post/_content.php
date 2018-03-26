<br />
<?= $form->field($model, 'title'. $suffix)->textInput() ?>

<?= $form->field($model, 'content'. $suffix)->textArea(['rows' => '6', 'class' => 'editor']) ?>
