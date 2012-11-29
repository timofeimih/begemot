<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>


<?php
  
$picturesConfig = array(
    'divId'=>'pictureBox',
    'nativeFilters'=>array(
      'cropForHead' =>false,  
      'cropForHead1' =>true,  
    ),    
    'filtersTitles'=>array(
      'cropForHead' =>'Тестовое описание фильтра 12',  
      'cropForHead1' =>'Тестовое описание фильтра 2',  
    ),
    'imageFilters' => array(
        'cropForHead' => array(
            0 => array(
                'filter' => 'Resize',
                'param' => array(
                    'width' => 100,
                    'height' => 200,
                ),
            ),
            1 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 50,
                    'height' => 50,
                ),
            ),
        ),
        'cropForHead1' => array(
            0 => array(
                'filter' => 'Resize',
                'param' => array(
                    'width' => 100,
                    'height' => 200,
                ),
            ),
            1 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 150,
                    'height' => 150,
                ),
            ),
        ),
    )
);


$this->widget(
        'application.modules.pictureBox.components.PictureBox', array(
    'id' => 'books',
    'elementId' => 2,
    'config' => $picturesConfig,
        )
);


?>
