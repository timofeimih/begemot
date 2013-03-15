<h2>CSV Загрузка слов </h2><?php

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';

//echo $form->render();
echo $form->renderBegin();

if (!isset($_REQUEST['сatId'])){    
    $сatId=0;
} else{
   $сatId=$_REQUEST['сatId'];
}

$categories = SeoWordGroup::model()->findAll(array('order' => 'lft','condition'=>'`id`<>0'));

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Корень',
	'type' => 'primary',
	'size' => 'small',
        'url' => '?сatId=0'
));

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test',
            'nestedData'=>$categories,
            'default'=>'корень',
            'callBackJs'=>'setCatId'
        ));

foreach($form->getElements() as $element)
    echo $element->render();

echo '<br/><input type="submit"/>';

echo $form->renderEnd();
?>
<script>
    function setCatId(id){
        document.getElementById("CsvForm_catId").value = id;
        
    }
</script>
