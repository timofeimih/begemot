<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'video-gallery-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->

		<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model, 'text'); ?>
		<?php echo $form->error($model,'text'); ?>
		</div><!-- row -->
		<div class="row">
		<div class="row">
		<?php echo $form->labelEx($model,'seo_title'); ?>
		<?php echo $form->textField($model, 'seo_title', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'seo_title'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('videoGalleryVideos')); ?></label>
		<?php echo $form->checkBoxList($model, 'videoGalleryVideos', GxHtml::encodeEx(GxHtml::listDataEx(VideoGalleryVideo::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton('Save');
$this->endWidget();
?>
</div><!-- form -->