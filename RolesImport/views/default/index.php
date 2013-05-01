<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);


?>
<h1>Importing roles</h1>
<?php foreach($data as $moduleName =>$moduleData):?>
<?php  $moduleData['title']= $moduleName;?>
<?php $this->renderPartial('moduleRoles',array('data'=>$moduleData));?>
<?endforeach;?>