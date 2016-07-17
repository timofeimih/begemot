<ul class='tiles' id="sortable">
 <?php


 ?>
<?php foreach ($data['images'] as $key=>$image):?>
 <li><img data-id="<?=$key?>" src="<?php echo $image['admin']?>" /></li>
<?php endforeach;?>
</ul>