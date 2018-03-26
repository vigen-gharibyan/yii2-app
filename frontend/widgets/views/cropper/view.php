<div class="container" id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view" title="<?= Yii::t('app', 'Change the avatar') ?>">
      <img src="<?= $this->theme->baseUrl ?>/img/picture.jpg" alt="Avatar">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/site/crop" enctype="multipart/form-data" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label"><?= Yii::t('app', 'Change Avatar') ?></h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
                  <label for="avatarInput"><?= Yii::t('app', 'Local upload') ?></label>
                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <div class="col-md-9">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">
						<?= Yii::t('app', 'Rotate Left') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">
						-15<?= Yii::t('app', 'deg') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">
						-30<?= Yii::t('app', 'deg') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">
						-45<?= Yii::t('app', 'deg') ?>
					  </button>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 <?= Yii::t('app', 'deg') ?>rees">
						<?= Yii::t('app', 'Rotate Right') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">
						15<?= Yii::t('app', 'deg') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">
						30<?= Yii::t('app', 'deg') ?>
					  </button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">
						45<?= Yii::t('app', 'deg') ?>
					  </button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block avatar-save"><?= Yii::t('app', 'Done') ?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>
  
<script>
	var baseUrl = '<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>';
</script>
