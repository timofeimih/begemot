<?php
/* @var $this updateFormController */
/* @var $model updateForm */
/* @var $form CActiveForm */
$this->menu = require dirname(__FILE__).'/../commonMenu.php';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-form-update-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
	
            	<?php 
                   $this->widget('begemot.extensions.ckeditor.CKEditor',
                    array('model' => $model, 'attribute' => 'text', 'language' => 'ru', 'editorTemplate' => 'full'));
                ?>
		<?php echo $form->error($model,'text'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'seoTitle'); ?>
		<?php echo $form->textField($model,'seoTitle'); ?>
		<?php echo $form->error($model,'seoTitle'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->