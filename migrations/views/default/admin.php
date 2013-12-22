
<h1>Миграция базы данных</h1>
<div class="center-block"><?=$return?></div>
<table>
	<thead>
		<tr>
			<td>Название</td>
			<td>Описание</td>
			<td>Применено или нет</td>
			<td>Применить или откатить</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($models as $item): ?>
		<?php $model = new $item; ?>
		<tr>
			<td><?=get_class($model)?></td>
			<td><?=$model->getDescription();?></td>
			<td><?=$model->isConfirmed()?></td>
			<td>
				<?php if (is_bool($model->isConfirmed(true)) && !$model->isConfirmed(true)): ?>
					<a href='?file=<?=get_class($model)?>&go=up' class="btn btn-primary">Применить</a>
				<?php elseif(is_bool($model->isConfirmed(true)) && $model->isConfirmed(false)): ?>
					<a href='?file=<?=get_class($model)?>&go=down' class="btn btn-warning">Откатить</a>
				<?php else: ?>
					<a href='?file=<?=get_class($model)?>&go=up' class="btn btn-primary">Применить</a>
					<a href='?file=<?=get_class($model)?>&go=down' class="btn btn-warning">Откатить</a>
				<?php endif ?>
			</td>
		</tr>
			
	<?php endforeach ?>
	</tbody>
</table>

<a href='?file=all&go=up' class='btn btn-primary btn-large'>Применить все</a>
