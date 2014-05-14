<?php 
$this->menu = array(
    array('label' => 'Все парсеры', 'url' => array('/parsers/default/index')),
    array('label' => 'Все связи', 'url' => array('/parsers/default/linking')),
);
 ?>





<?php if ($items): ?>
	<form action="/parsers/default/doChecked" method='post'>

		<table>
			<thead>
				<tr>
					<td><input type="checkbox" class='checkAll'></td>
					<td>Название</td>
					<td>Старая цена</td>
					<td>Новая цена</td>
					<td>Наличие</td>
					<td>Обновить</td>
				</tr>
			</thead>
			<tbody>

			<?php foreach($items as $item): ?>
				<tr class='<?php echo $item->id?>'>
					<td><input type="checkbox" name="item[<?php echo $item->itemId ?>][id]" value='<?php echo $item->itemId ?>'></td>
					<td class='name'><?php echo $item->name?></td>
					<td><?php echo $item->oldPrice?></td>
					<td><input type='text' value='<?php echo $item->price?>' name='item[<?php echo $item->itemId ?>][price]' class='price'></td>
					<td><input type='text' value='<?php echo $item->quantity?>' name='item[<?php echo $item->itemId ?>][quantity]' class='quantity input-small'></td>
					<td><button type='button' class='updatePrice' data-id='<?php echo $item->itemId ?>'>Обновить цену и наличие</button></td>
				</tr>
					
			<?php endforeach ?>
			</tbody>
		</table>

		<input type="hidden" name='url' value='<?php echo $_SERVER['REQUEST_URI']?>'>
		<input type='submit' class='btn btn-primary btn-medium' value='Применить все'>

	</form>
<?php else: ?>
	Ничего не надо обновлять
<?php endif ?>

<script>
	$(document).on("click", ".updatePrice", function(e){

		var button = $(this);
		var params = {'id': $(this).attr("data-id"), 'price': $(this).parents("TR").find(".price").val(), 'quantity': $(this).parents("TR").find(".quantity").val()};


		$.post('/parsers/default/updateCard', params, function(data){
			if (data == '1') {
				button.parents("TR").fadeOut('1000');
				setTimeout(function(){
					button.parents("TR").remove();
				}, 1000)
				
			};
			
		})

	})


	$(document).on("click", '.checkAll', function(){
		var checkboxes = $(this).parents("TABLE").find("INPUT[type='checkbox']");

		if ($(this).attr("checked")) {
			checkboxes.attr("checked", true);
		} else checkboxes.attr("checked", false);
	})
</script>