<?php
$this->breadcrumbs = array(
    'Seo Words' => array('index'),
    'Manage',
);

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';
?>

<h1>Manage Seo Words</h1>



<?php


$categories = SeoWordGroup::model()->findAll(array('order' => 'lft'));
echo '<div style="float:left;width:50%;">';
$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test',
            'nestedData'=>$categories,
            'default'=>'root'
        ));

$gridLeft = 'left-grid';

 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>$gridLeft,
    'type' => 'striped bordered',
    'dataProvider' => $model->search(0),
    'template' => "{items}",
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Переместить',
                'click' => 'js:function(values){ajaxGroupChange(values,1);}'
            )
        ),
        // if grid doesn't have a checkbox column type, it will attach
        // one and this configuration will be part of it
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
    'columns' => array(
        'word',
        'weight',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'right'=>array(
                    'icon'=>'icon-arrow-right',
                    'url'=>'Yii::app()->controller->createUrl("changeGroup",array("groupId"=>1,"id"=>$data->id))',
                    'click'=>"function(){
                        $.fn.yiiGridView.update('".$gridLeft."', {  //change my-grid to your grid's name
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                            
                                  location.reload();  
                            }
                        })
                        return false;
                      }
                    ",
                ),
            ),
            'template' => ' {right}',
        ),
    ),
    'htmlOptions' => array('style' => " float: left;")
        ));
echo '</div>';
    $gridRight = 'grid-right';

$categories = SeoWordGroup::model()->findAll(array('order' => 'lft'));

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test1',
            'nestedData'=>$categories,
            'default'=>'root'
        ));    
    
 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>$gridRight,
    'type' => 'striped bordered',
    'dataProvider' => $model->search(1),
    'template' => "{items}",
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Переместить',
                'click' => 'js:function(values){ajaxGroupChange(values,0);}'
            )
        ),
        // if grid doesn't have a checkbox column type, it will attach
        // one and this configuration will be part of it
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
    'columns' => array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'left'=>array(
                    'icon'=>'icon-arrow-left',
                    'url'=>'Yii::app()->controller->createUrl("changeGroup",array("groupId"=>0,"id"=>$data->id))',
                    'click'=>"function(){
                        $.fn.yiiGridView.update('".$gridRight."', {  //change my-grid to your grid's name
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                            
                                   location.reload();  
                            }
                        })
                        return false;
                      }
                    ",
                ),
            ),
            'template' => ' {left}',
        ),        
        'word',
        'weight',

    ),
    'htmlOptions' => array('style' => " float: left;width: 50%;")
        ));


$url = Yii::app()->controller->createUrl('changeGroup');
?>

<script>
    
    function ajaxGroupChange(values,group){

        var myData = "groupId="+group;
        
        for (var i=0;i<values.length; i++) {
            //var val = values[key];
            if (values[i] instanceof HTMLInputElement){
                // alert (values[i]['value']);
                myData+= "&id["+i+"]="+values[i]['value'];
            }
        }
        //return;
        //alert(myData);
        

        
        $.ajax({
            url: '<?php echo $url; ?>',
            data:myData,
            async:false,
            method:'POST',
            success: function(){
                location.reload();  
            }
        });
        //alert(values[0]['value']); 
        
    }  
    

    

</script>
