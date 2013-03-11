<?php
$this->breadcrumbs = array(
    'Seo Words' => array('index'),
    'Manage',
);

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';
?>

<h1>Manage Seo Words</h1>



<?php
if (!isset($_REQUEST['leftCatId'])){    
    $leftCatId=0;
} else{
   $leftCatId=$_REQUEST['leftCatId'];
}

if (!isset($_REQUEST['rightCatId'])){
    $rightCatId=0;
} else{
    $rightCatId=$_REQUEST['rightCatId'];    
}

echo '
    <script>
        var leftCatId='.$leftCatId.';
        var rightCatId='.$rightCatId.';
    </script>
';

$categories = SeoWordGroup::model()->findAll(array('order' => 'lft','condition'=>'`id`<>0'));
echo '<div style="float:left;width:50%;">';
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Корень',
	'type' => 'primary',
	'size' => 'small',
        'url' => '?rightCatId='.$rightCatId.'&leftCatId=0'
));

$leftCat = SeoWordGroup::model()->findByPk($leftCatId);
$leftCatName = $leftCat->title;

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test',
            'nestedData'=>$categories,
            'default'=>$leftCatName,
            'callBackJs'=>'categoryLeftSelect'
        ));

$gridLeft = 'left-grid';

 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>$gridLeft,
    'type' => 'striped bordered',
    'dataProvider' => $model->search($leftCatId),
    'template' => "{items}",
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Переместить',
                'click' => 'js:function(values){ajaxGroupChange(values,'.$rightCatId.');}'
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
                    'url'=>'Yii::app()->controller->createUrl("changeGroup",array("groupId"=>'.$rightCatId.',"id"=>$data->id))',
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

$categories = SeoWordGroup::model()->findAll(array('order' => 'lft','condition'=>'`id`<>0'));

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Корень',
	'type' => 'primary',
	'size' => 'small',
        'url' => '?leftCatId='.$leftCatId.'&rightCatId=0'
));

$rightCat = SeoWordGroup::model()->findByPk($rightCatId);
$rightCatName = $rightCat->title;

$this->widget('begemot.components.NestedDynaTree.widget.WNestedSelect', 
        array(
            'id'=>'test1',
            'nestedData'=>$categories,
            'default'=>$rightCatName,
            'callBackJs'=>'categoryRightSelect'
        ));    
    
 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>$gridRight,
    'type' => 'striped bordered',
    'dataProvider' => $model->search($rightCatId),
    'template' => "{items}",
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Переместить',
                'click' => 'js:function(values){ajaxGroupChange(values,'.$leftCatId.');}'
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
                    'url'=>'Yii::app()->controller->createUrl("changeGroup",array("groupId"=>'.$leftCatId.',"id"=>$data->id))',
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
    
    function categoryLeftSelect(id){
        document.location.href ='?rightCatId=<?php echo $rightCatId;?>&leftCatId='+id;
        
    }
    function categoryRightSelect(id){
        document.location.href ='?rightCatId='+id+'&leftCatId=<?php echo $leftCatId;?>';
    }  

    

</script>
