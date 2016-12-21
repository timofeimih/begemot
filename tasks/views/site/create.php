<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Create',
);

$this->menu = array(
	array('label'=>'List' . ' ' . $model->label(2), 'url' => array('index')),
	array('label'=>'Manage' . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<div class="popup__block zoom-anim-dialog popup-dialog" style='max-width: 420px'>
<h2>Новое задание</h2>

	<?php
	$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));
	?>
</div>