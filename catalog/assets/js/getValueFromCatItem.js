$ = jQuery.noConflict();

$(document).ready(function(){
	$(".getValueFromCatItem").each(function(){
		var id = $(this).attr("id");
		var param = $(this).attr("param");
		var field = $(this);


		$.get('/catalog/site/getField/itemId/' + id + '/field/' + param, function(data){
			field.html(data);
		});
	})
})