<?php
//Move this file into application.config
//for implement new configuration in any new site
return array(
    'divId'=>'pictureBox',
    'nativeFilters'=>array(
      'small' =>true,  
    ),    
    'filtersTitles'=>array(
      'small' =>'Маленькая',  

    ),
    'imageFilters' => array(
        'small' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 190,
                    'height' => 136,
                ),
            ),
        ),
    )
);

?>
