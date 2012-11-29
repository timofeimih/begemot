<?php 

  
$picturesConfig = array(
    'divId'=>'pictureBox',
    'nativeFilters'=>array(
      'cropForHead' =>false,  
      'cropForHead1' =>true,  
    ),    
    'filtersTitles'=>array(
      'cropForHead' =>'Имя',  
      'cropForHead1' =>'Имя2',  
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
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 50,
                    'height' => 50,
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
$filesArray = array();

$images = require (Yii::getPathOfAlias('webroot').'/files/pictureBox/books/2/data.php');
foreach ($images['images'] as $id=>$item){

    $filesArray[]= $item;
}
$listDataProvider = new CArrayDataProvider($filesArray);

$this->widget('begemot.extensions.bootstrap.widgets.TbThumbnails', array(
    'dataProvider'=>$listDataProvider,
    'template'=>"{items}\n{pager}",
    'itemView'=>'_thumb',
));
?>


