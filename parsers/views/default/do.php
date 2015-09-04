<?php 
Yii::app()->clientScript->registerCssFile(
    Yii::app()->assetManager->publish(Yii::app()->getModule("parsers")->basePath . "/assets/parsers.css")
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(Yii::app()->getModule("parsers")->basePath . "/assets/jquery.quicksearch.js"), CClientScript::POS_HEAD
);


$this->menu = array(
    array("label" => "Все парсеры", "url" => array("/parsers/default/index")),
    array("label" => "Все связи", "url" => array("/parsers/default/linking")),
);
 ?>

<?php $this->widget("bootstrap.widgets.TbMenu", array(
    "type"=>"tabs", // "", "tabs", "pills" (or "list")
    "stacked"=>false, // whether this is a stacked menu
    "items"=>array(
        array("label"=>"Изменились", "url"=>"/parsers/default/do/file/".$filename . "/tab/changed", "active"=>$tab=="changed"),
        array("label"=>"Новые", "url"=>"/parsers/default/do/file/".$filename . "/tab/new", "active"=>$tab=="new"),
        array("label"=>"Новые с возможностью связать по ID", "url"=>"/parsers/default/do/file/".$filename . "/tab/newWithId", "active"=>$tab=="newWithId"),
        array("label"=>"Все связи", "url"=>"/parsers/default/do/file/".$filename . "/tab/allSynched", "active"=>$tab=="allSynched" ),

    ),
)); ?>

<h1>Парсер "<?php echo $filename?>"</h1>

<?php //print_r($itemList["combinedAndChanged"]) ?>


<?php if ($tab == "changed"): ?>

<form action="/parsers/default/doChecked" method="post">

		<table>
			<thead>
				<tr>
					<td><input type="checkbox" class="checkAll"></td>
					<td>Изображение</td>
					<td>Артикул</td>
					<td>Название</td>
					<td>Старая цена</td>
					<td>Новая цена</td>
					<td>Наличие</td>
					<td>Обновить</td>
				</tr>
			</thead>
			<tbody>
			<?php if ($itemList): ?>
				<?php foreach($itemList as $item): ?>
					<tr class="<?php echo $item->id?>">
						<td><input type="checkbox" name="item[<?php echo $item->item->id ?>][id]" value="<?php echo $item->item->id ?>"></td>
						<td><img src="<?php echo $item->item->getItemMainPicture("innerSmall")?>"></td>
						<td><?php echo $item->fromId?></td>
						<td class="name"><?php echo $item->item->name?></td>
						<td><?php echo $item->item->price?></td>
						<td><input type="text" value="<?php echo $item->linking->price?>" name="item[<?php echo $item->item->id ?>][price]" class="price input-small"></td>
						<td><input type="text" value="<?php echo $item->linking->quantity?>" name="item[<?php echo $item->item->id ?>][quantity]" class="quantity input-small"></td>
						<td><button type="button" class="updatePrice" data-id="<?php echo $item->item->id ?>">Обновить цену и наличие</button></td>
					</tr>
						
				<?php endforeach ?>
			<?php endif ?>
			</tbody>
		</table>

		<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]?>">
		<input type="submit" class="btn btn-primary btn-medium" value="Применить выделенные">

	</form>
<?php endif ?>

<?php if ($tab == "new"): ?>
	<?php
	 Yii::import("begemot.extensions.grid.EImageColumn");

	 $this->widget("bootstrap.widgets.TbGridView",array(
		"id"=>"test-grid",
		"dataProvider"=>$itemList->search(),
		"filter"=>$itemList,
	    "type"=>"striped bordered condensed",
	    'rowCssClassExpression' => function($row, $data){
	    	return "item-" . $data->id;
	    },
		"columns"=>array(
	    	"id" => array('name' => 'id', 'htmlOptions' => array('class' => 'id')),
	    	"name" => array('name' => 'name', 'htmlOptions' => array('name')),
	    	"price" => array('name' => 'price', 'htmlOptions' => array('price')),
	    	array(
	            "header" => "Связать с ...",
	            "type"=>"raw",
	            "value"=>  array($this, "getSyncButtons")
	        ),
	        array(
	            "header" => "Добавить как новый",
	            "type"=>"raw",
	            "value"=>array($this, "getAddAsNewButton"),
	        ),
		),
	)); ?>
<?php endif ?>

<?php if ($tab == "newWithId"): ?>
	<?php
	 Yii::import("begemot.extensions.grid.EImageColumn");

	 $this->widget("bootstrap.widgets.TbGridView",array(
		"id"=>"test-grid",
		"dataProvider"=>$itemList->search(),
		"filter"=>$itemList,
	    "type"=>"striped bordered condensed",
	    'rowCssClassExpression' => function($row, $data){
	    	return "item-" . $data->id;
	    },
		"columns"=>array(
	    	"id" => array('name' => 'id', 'htmlOptions' => array('class' => 'id')),
	    	"name" => array('name' => 'name', 'htmlOptions' => array('name')),
	    	"price" => array('name' => 'price', 'htmlOptions' => array('price')),
	    	array(
	            "header" => "Связать с ...",
	            "type"=>"raw",
	            "value"=>  array($this, "getSyncButtons")
	        ),
	        array(
	            "header" => "Добавить как новый",
	            "type"=>"raw",
	            "value"=>array($this, "getAddAsNewButton"),
	        ),
		),
	)); ?>
<?php endif ?>

<?php if ($tab == "allSynched"): ?>

	<?php
	Yii::import('begemot.extensions.grid.EImageColumn');

 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'test-grid',
	'dataProvider'=>$itemList->search(),
	'filter'=>$itemList,
    'type'=>'striped bordered condensed',
	'columns'=>array(
                         
		'fromId',
		array(
            'class' => 'EImageColumn',
            'htmlOptions'=>array('width'=>120),
            // see below.
            'imagePathExpression' => '$data->item->getItemMainPicture("innerSmall")',
            // Text used when cell is empty.
            // Optional.
            'emptyText' => '—',
            // HTML options for image tag. Optional.
            'imageOptions' => array(
                'alt' => 'no',
                'width' => 120,
                'height' => 120,
            ),
        ),   


        array(
            'header' => 'Название',
            'type'=>'text',
            'value'=>'$data->linking->name',
            'htmlOptions' => array('class' => 'id'),
        ),
        array(
            'header' => 'Связан с ',
            'type'=>'text',
            'value'=>'$data-item->name',
        ),
        array(
        	'header' => 'Удалить связь',
            'type'=>'raw',
            'value'=>array($this, "deteleLinkingButton"),
        )

	),
));?>

<?php endif ?>

<?php if ($tab == "new" | $tab == "newWithId"): ?>
	<div class="modal fade" style="display:none">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Связать элемент с ...</h4>
      </div>
      <form action="/parsers/default/syncCard" method="post" class="ajaxSubmit" data-hideafter=".modal" data-removeafter="">
	      <div class="modal-body">
	      	<div id="error"></div>
	      	Нажмите на название карточки когда выберите в списке.<br/>
	      	<input type="text" id="search" placeholder="Поиск">
	      	<ul id="search_in_items">
	      		<?php foreach ($allItems as $item): ?>
	        		<li data-itemid="<?php echo $item->id ?>"><?php echo $item->name ?> (<?php echo $item->id ?>) <a href="<?php echo $this->createUrl("/catalog/catItem/update", array("id" => $item->id )) ?>">Просмотреть</a></li>
	       		<?php endforeach ?>
	      	</ul>
			
			
	      	<input type="hidden" name="ParsersLinking[filename]" id="filename" required >
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Закрыть</button>
	        <button class="syncCard btn btn-primary" type="submit">Соединить карточку (<span class="cardName"></span>)</button>
	        <br/>
	        <div class="bottom" style="margin-top: 10px;">
	        	<div style="margin:auto">Сохранится для id: <input type="text" name="ParsersLinking[fromId]" id="name" class="required" required></div>
	      		<div style="margin:auto">Привяжет к ID карточки: <input type="text" name="ParsersLinking[toId]" id="itemIdModal" required ></div>
	        </div>
	        
	      </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php endif ?>

<script>

	$(document).on("change", ".search", function(){
		$(this).quicksearch(".tableToSearch tbody tr", {
		    selector: $(this).attr("data-selector")
		});
	})
	$(document).on("click", ".addAsNew", function(){
		var button = $(this);
		var params = {"CatItem": {"name": $(this).attr("name"), "price": $(this).attr("price"), "text": $(this).attr("text")}, "returnId": true};


		$.post("/catalog/catItem/create", params, function(data){
			button.parents("TR").find(".composite").html("Уже обьединено");
			button.parents("TR").find("BUTTON").attr("disabled", true);
			button.parent().html('<a href="/catalog/catItem/update/id/' + data + '" target="_blank">Редактировать</a>');
			var toId = data;

			$.post("/parsers/default/syncCard", {"ParsersLinking": {"fromId": button.attr("data-id"), "toId": toId, "filename": button.attr("data-filename")}}, function(data){
				data = $.parseJSON(data);
				console.log(data);
				if (data.code) {

					if (data.toUpdate != "") {
						$("#toDo").find("TBODY").append(data.toUpdate);
						$(".countChanged").html(parseInt($(".countChanged").html()) + 1);
					}

					if (data.toAllLinks != "") {
						$("#combined").find("TBODY").append(data.toAllLinks);
					}
					console.log(data);
				}
			});
		})

	})

	$(document).on("click", ".deleteLinking", function(e){

		var link = $(this);
		var id = $(this).attr("data-id");


		$.get("/parsers/default/deleteLinking/id/" + id, function(data){
			if (data == "1") {
				link.parents("TR").fadeOut("1000");

				if ($("." + id).attr("class") != "") {
					if (parseInt($(".countChanged").html() >= 0)) {
						$(".countChanged").html(parseInt($(".countChanged").html()) - 1);
					}
					
					$("." + id).remove();
				};
				setTimeout(function(){
					link.parents("TR").remove();
				}, 1000)
				
			} else{
				alert("error");
			}
			
		})

	})

	$(document).on("click", ".composite", function(){
		var name = $(this).parents("TR").find(".name").html();
		var id = $(this).parents("TR").find(".id").html();
		var className = $(this).parents("TR").attr("class");
		var price = $(this).parents("TR").find(".price").html();
		var filename = $(this).attr("data-filename");
		$("#search").val(name);
		$("#search").quicksearch("UL#search_in_items li").search(name);
		$(".error").hide();

		

		$("#search_in_items LI").each(function(){
			if ($(this).css("display") != "none") {
				$(this).addClass("active");
				$("#itemIdModal").val($(this).attr("data-itemid"));
				return false;
			}
			
		})
		
		$(".modal").show().addClass("in");
		$(".modal FORM").attr("data-removeafter", "." + className);
		$(".modal FORM").find(".cardName").html(name);
		$(".modal FORM").find("#name").val(id);
		$(".modal FORM").find("#filename").val(filename);
	})

	$(document).on("click", "#search_in_items LI", function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	
		$("#itemIdModal").val($(this).attr("data-itemid"));
		
	})

	$(document).on("click", ".checkAll", function(){

		if($(this).prop("checked")){
			$(this).parents("TABLE").find("input[type='checkbox']").prop("checked", true);
		} 
		else $(this).parents("TABLE").find("input[type='checkbox']").prop("checked", false);
	})


	$(document).on("submit", ".ajaxSubmit", function(e){
		e.preventDefault();
		var form = $(this);
		var hideAfter = $(this).attr("data-hideafter");
		var removeAfter = $(this).attr("data-removeAfter");
		var status = true;
		$(this).find(".required").removeClass("form_error");

		$(this).find(".required").each(function(){
			if ($(this).val() == "") {status = false}
				$(this).addClass("form_error");
		})
		if (!status) return false;

		$.post(form.attr("action"), form.serialize(), function(data){
			data = $.parseJSON(data);
			if (data.code) {
				$(hideAfter).removeClass("in").hide();
				$(removeAfter).fadeOut(1000);
				setTimeout(function(){
					$(removeAfter).remove();
				}, 1000)

				if (data.toUpdate != "") {
					$("#toDo").find("TBODY").append(data.toUpdate);
					$(".countChanged").html(parseInt($(".countChanged").html()) + 1);
				}

				if (data.toAllLinks != "") {
					$("#combined").find("TBODY").append(data.toAllLinks);
				}
				console.log(data);
			} else{
				$("#error").html(data.html);
				$("#error").fadeIn();
				$(".modal-body").scrollTo(0);
			}
		})
	})

	$(document).on("click", ".closeModal", function(e){
		$(".modal").removeClass("in").hide();
	})

	$(".close").click(function(){
		$(".modal").removeClass("in").addClass("out");
	})

	$(document).on("click", ".updatePrice", function(e){

		var button = $(this);
		var params = {"id": $(this).attr("data-id"), "price": $(this).parents("TR").find(".price").val(), "quantity": $(this).parents("TR").find(".quantity").val()};


		$.post("/parsers/default/updateCard", params, function(data){
			if (data == "1") {
				button.parents("TR").fadeOut("1000");
				setTimeout(function(){
					button.parents("TR").remove();
				}, 1000)
				
			};
			
		})

	})
	

	

	$("input#search").quicksearch("UL#search_in_items li");


$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == "function" && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : "swing"
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == "function") { callback.call(this); }
    });
  });
}

</script>
