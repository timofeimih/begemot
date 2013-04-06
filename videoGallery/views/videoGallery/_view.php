<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name_t')); ?>:
	<?php echo GxHtml::encode($data->name_t); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('text')); ?>:
	<?php echo GxHtml::encode($data->text); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('order')); ?>:
	<?php echo GxHtml::encode($data->order); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('seo_title')); ?>:
	<?php echo GxHtml::encode($data->seo_title); ?>
	<br />

</div>