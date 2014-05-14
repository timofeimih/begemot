<tr>
	<td><input type="checkbox" name='item[<?php echo $item->id ?>]['id']' value='<?php echo $item->id ?>'></td>
	<td class='name'><?php echo $name?></td>
	<td><?php echo $item->item->price ?></td>
	<td><input type='text' value='<?php echo $newPrice?>' name='item[<?php echo $item->id ?>][price]' class='price'></td>
	<td><button type='button' class='updatePrice' data-id='<?php echo $item->item->id ?>'>Обновить цену и наличие</button></td>
</tr>
