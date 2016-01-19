<?php
/* @var $this updateFormController */
/* @var $model updateForm */
/* @var $form CActiveForm */
$this->menu = require dirname(__FILE__).'/../commonMenu.php';


function crPhpArr($array, $file) {


	$code = "<?php
  return
 " . var_export($array, true) . ";
?>";
	file_put_contents($file, $code);
}

function getFileId($file){
	if (file_exists($file)){
		$id = require $file;
		if (is_int($id)){
			crPhpArr(1+$id,$file);
			return $id;

		} else {
			return -1;
		}
	} else {
		$id = 0 ;
		crPhpArr(1+$id,$file);
		return $id;
	}
}


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

<?php
//Достаем id файла html

$filesIndexPath =  Yii::getPathOfAlias('webroot').'/files/pages/pagesList.php';
if (file_exists($filesIndexPath)){
	$pagesFilesList = require $filesIndexPath;
} else {
	$pagesFilesList = array();
	crPhpArr($pagesFilesList,$filesIndexPath);
}

if (isset($pagesFilesList[$file])){
	$fileId = $pagesFilesList[$file];
} else {
	$idHtmlFile = Yii::getPathOfAlias('webroot').'/files/pages/filesId.php';
	$fileId = getFileId($idHtmlFile);
	$pagesFilesList[$file] = $fileId;

	crPhpArr($pagesFilesList,$filesIndexPath);

}

$picturesConfig = array();
$configFile = Yii::getPathOfAlias('webroot').'/protected/config/catalog/categoryItemPictureSettings.php';
if (file_exists($configFile)){

	$picturesConfig = require($configFile);
	$file = str_replace('.','',$file);
	$this->widget(
		'application.modules.pictureBox.components.PictureBox', array(
			'id' => 'htmlPage',
			'elementId' =>$fileId,
			'config' => $picturesConfig,
		)
	);
} else{
	Yii::app()->user->setFlash('error','Отсутствует конфигурационный файл:'.$configFile);
}
?>