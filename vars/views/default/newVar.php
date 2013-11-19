<?php
/* @var $this LoginFormController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
$this->menu = require dirname(__FILE__).'/../commonMenu.php';
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'new-file-test-form',
	'enableAjaxValidation'=>false,
        
)); ?>

        <h1>Создать статическую переменную</h1>
<div class="container-fluid offset">
	<?php echo $form->errorSummary($model,'Исправьте следующие ошибки:'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'varname'); ?>
		<?php echo $form->textField($model,'varname'); ?>
		<?php echo $form->error($model,'varname'); ?>
	</div>
        

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->