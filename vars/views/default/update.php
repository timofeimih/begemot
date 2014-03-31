<?php
/* @var $this updateFormController */
/* @var $model updateForm */
/* @var $form CActiveForm */
$this->menu = require dirname(__FILE__).'/../commonMenu.php';
?>
<h1>Обновление переменной</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-form-update-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'varname'); ?>
		<?php echo $form->textField($model,'varname'); ?>
		<?php echo $form->error($model,'varname'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'vardata'); ?>
        <?php echo $form->textField($model,'vardata'); ?>
        <?php echo $form->error($model,'varname'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->