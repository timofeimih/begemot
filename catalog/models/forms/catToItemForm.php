<?php
return array(
    'title'=>'Добавить элемент в категорию',
   
    'elements'=>array(
        'catId'=>array(
            'type'=>'dropdownlist',
            'items'=>CHtml::listData(CatCategory::model()->findAll(),'id','name'),
            'prompt'=>'Выберите значение:',
            'label'=>'Раздел каталога:',
        ),
        'itemId'=>array(
            'type'=>'hidden',
            'maxlength'=>32,
        ),      
    ),
 
    'buttons'=>array(
        'catToItemSubmit'=>array(
            'type'=>'submit',
            'label'=>'Прикрепить',
        ),
    ),
); 
?>
