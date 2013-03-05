<?php
$this->breadcrumbs = array(
    'Seo Word Groups',
);

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';
?>

<h1>Seo Word Groups</h1>

<?php
$this->widget('application.modules.begemot.components.NestedDynaTree.NestedDynaTree', array(
    //the class name of the model.
    'modelClass' => "SeoWordGroup",
    // action taken on click on item. (default empty)
    'clickAction' => "/seo/seoWordGroup/update/id/",
    //if given, AJAX load a result of clickAction to the container (default empty)
    'clickAjaxLoadContainer' => 'updateTree',
    //can insert, delete and ( if enabled)drag&drop (default true) 
    'manipulationEnabled' => true,
    //can sort items by drag&drop (default true)
    'dndEnabled' => true,
    //AJAX controller absolute path if you don`t use controllerMap
    'ajaxController' => Yii::app()->baseUrl . '/seo/AXtree/' //default('/AXtree/')
));
?><div class="span3">

</div>
<div id="updateTree" class="span9">

</div>
<?php 

$categories = SeoWordGroup::model()->findAll(array('order' => 'lft'));

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test',
            'nestedData'=>$categories,
            'default'=>'root'
        ));

?>






