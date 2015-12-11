<?php
/* @var $this ParsersCategoryConnectionController */
/* @var $model ParsersCategoryConnection */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parsers-category-connection-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'connect_name'); ?>
		<?php echo $form->textField($model,'connect_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'connect_name'); ?>
	</div>

	<?php 
		$select = '';
		$categories = CatCategory::model()->findAll(array('order' => 'id ASC'));
	?>
	<div class="row">
		<select name='ParsersCategoryConnection[category_id]' id='loadValues' >
	       <option value="">Выберите раздел</option>
	       <?php foreach ($categories as $cat): ?>

	       		<?php 
		       		if (!$model->isNewRecord) {
		       			if ($model->category_id == $cat->id) {
		       				$select = 'selected';
		       			}
					} 
				?>
	            <option <?php echo $select?>value='<?php echo $cat->id?>'><?php echo CatCategory::model()->getCatName( $cat->id)?></option>
	            <?php $select = "" ?>
	      <?php endforeach ?>
	    </select>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->