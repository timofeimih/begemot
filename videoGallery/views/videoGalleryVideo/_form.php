<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'video-gallery-video-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title'); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model, 'text'); ?>
		<?php echo $form->error($model,'text'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model, 'url'); ?>
		<?php echo $form->error($model,'url'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'gallery_id'); ?>
		<?php echo $form->dropDownList($model, 'gallery_id', GxHtml::listDataEx(VideoGallery::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'gallery_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton('Save');
$this->endWidget();
?>
</div><!-- form -->