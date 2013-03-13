<h2>CSV Загрузка слов </h2><?php

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';

//echo $form->render();
echo $form->renderBegin();


$categories = SeoWordGroup::model()->findAll(array('order' => 'lft','condition'=>'`id`<>0'));

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Корень',
	'type' => 'primary',
	'size' => 'small',
        'url' => '?rightCatId=&leftCatId=0'
));

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test',
            'nestedData'=>$categories,
            'default'=>'корень',
            'callBackJs'=>'categoryLeftSelect'
        ));

foreach($form->getElements() as $element)
    echo $element->render();

echo '<br/><input type="submit"/>';

echo $form->renderEnd();
?>
