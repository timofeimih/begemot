<div class="popup__block zoom-anim-dialog popup-dialog" style='width: 425px'>
	<h2>Заявка на выполнение</h2>

	<?php
	$this->renderPartial('_willDoForm', array(
			'model' => $model,
			'buttons' => 'create'));
	?>
	

</div>