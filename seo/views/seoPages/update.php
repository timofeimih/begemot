<?php

$this->breadcrumbs=array(
	'Seo Pages'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeoPages','url'=>array('index')),
	array('label'=>'Create SeoPages','url'=>array('create')),
	array('label'=>'View SeoPages','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SeoPages','url'=>array('admin')),
);
?>

<h1>Update SeoPages <?php echo $model->id; ?></h1>

<?php 

    echo $this->renderPartial('_form',array('model'=>$model)); 
    //echo $site_name = $_SERVER['HTTP_HOST'].'<br/>';
    $url_array =  parse_url($model->url);
    $path = $url_array['path'];
    
    $links = SeoLinks::model()->findAll(array('condition'=>'`href` = "'.$path.'"'));
    
    foreach ($links as $link){
        echo $link->url.' ';
        echo $link->anchor.'<br/>';
    }
?>