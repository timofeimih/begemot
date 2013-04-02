<?php

return array(
    'title'=>'CSV',
 
    'elements'=>array(
        'csv'=>array(
            'type'=>'textarea',
            'attributes'=>array(
              'style'=>'width:100%;height:400px;'
              
            )
            
        ),
        'catId'=>array(
            'type'=>'hidden',
            'value'=>0
        )        
    ),
 
    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Отправить',
        ),
    ),
);
?>
