<?php

require '_postsMenu.php';

?>

<h1>Управление статьями</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'posts-grid',
    'dataProvider' => $model->search($tag_id),
    'filter' => $model,
    'type'=>'striped bordered condensed',    
    'columns' => array(
        'id',
        'title',
        'tag' => array(
            "class" => "CDataColumn",
            "name" => "tag_id", //параметр модели
            "header" => "Раздел",
            "value" => 'PostsTags::getTagName($data->tag_id)', //пхп код
        ),
      
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'viewButtonUrl'=>'Yii::app()->urlManager->createUrl(\'post/site/view\',array(\'title\'=>$data->title_t,\'id\'=>$data->id,))',
        ),
    ),
));
?>
