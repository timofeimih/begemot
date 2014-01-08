<?php
/* @var $this CatItemController */
/* @var $model CatItem */

$this->breadcrumbs=array(
	'Cat Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu = require dirname(__FILE__).'/commonMenu.php';
?>

<h1>Редактирование позиции "<?php echo $model->name; ?>"</h1>

    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Данные', 'url'=>'/catalog/catItem/update/id/'.$model->id, 'active'=>$tab=='data'),
        array('label'=>'Разделы', 'url'=>'/catalog/catItem/update/id/'.$model->id.'/tab/cat', 'active'=>$tab=='cat'),
        array('label'=>'Опции', 'url'=>'/catalog/catItem/update/id/'.$model->id.'/tab/options', 'active'=>$tab=='options'),
        array('label'=>'Изображения', 'url'=>'/catalog/catItem/update/id/'.$model->id.'/tab/photo', 'active'=>$tab=='photo'),
    ),
)); ?>

<?php
    if ($tab=='data')
        echo $this->renderPartial('_form', array('model'=>$model)); 
?>
<?php if ($tab=='cat'){ ?>
<h2>Разделы</h2>
<?php
    if (!$model->isNewRecord) {  

        $categories = CatItemsToCat::model()->with('item')->findAll(array('condition'=>'itemId='.$model->id));

        if (is_array($categories) && count($categories)>0){
            foreach ($categories as $cat){

                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'ajaxButton',
                    'icon'=>'icon-remove',
                    'label'=>'',
                    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'mini', // null, 'large', 'small' or 'mini'
                    'url'=>'/catalog/catItem/deleteItemToCat/catId/'.$cat->catId.'/itemId/'.$model->id,
                    'ajaxOptions'=>array('success'=>'function (){location.reload()}'),
                ));


                if ($cat->catId!=$cat->item->catId){
                    echo ' <a href="?setMainCat='.$cat->catId.'">'.CatCategory::model()->getCatName( $cat->catId).'</a><br/>';
                } else{

                echo ' '.CatCategory::model()->getCatName( $cat->catId).'  [<strong>основной раздел</strong>]<br/>';
                }

            }
            echo '<br/>';
       }

        $itemToCat = new CatItemsToCat();
        $testForm = new CForm('catalog.models.forms.catToItemForm',$itemToCat);


        $testForm['itemId']->value = $model->id;
        echo '<div class="container-fluid">'.$testForm->render().'</div>';
    }?>
<?php }  ?>

<?php if ($tab=='options'){ ?>
<h2>Опции</h2>
<form method='post'>
    <div id="price_option">
    <?php
        if (!$model->isNewRecord) {  
            $alreadyGot = CatItemsToItems::model()->findAll(array('select'=>'toItemId', 'condition' => 'itemId='.$model->id));

            $arrayOfItems = array();
            foreach ($alreadyGot as $item) {
                array_push($arrayOfItems, $item->toItemId);
            }
            $arrayOfItems = array_filter($arrayOfItems);
            $items = CatItem::model()->findAll(array('order'=>'id ASC'));

            if (is_array($items) && count($items)>0){

                foreach ($items as $item){ ?>

                    <?php $checked = in_array($item->id, $arrayOfItems) ? "checked" : "" ?>
                    
                    <div class="price_col" style="width: 340px; display: inline-block;outline: 0px solid red; background-color: white; overflow: auto; box-sizing: border-box; padding-bottom: 43px;">
                        <ul class="price_col_blocks" style=" vertical-align:top;display: inline-block;margin: 0px;width: 100%;">
                           <li class="price_chekbox" style="height: 100px; outline: 0px solid red;list-style-type: none; float: left; margin-bottom: -1px ;"><span class="niceCheck"><input type="checkbox" <?=$checked?> name="itemsId[]" value='<?=$item->id?>'></span></li>
                            <li class="price_pict" style="
        width: 134px; height: 100px; outline: 0px solid red; background-image: url(../images/chek_pict_1.png); background-repeat: no-repeat;
        list-style-type: none; float: left;"><img style="width:100%;" src="<?php echo $item->getItemMainPicture("three"); ?>" alt=""></li>
                            <li class="price_describe" style="
        width: 150px; height: 83px; outline: 0px solid red;display: inline; font: 14px Arial; color: #272e33; margin-top: 17px;
    "><?php echo $item->name?><br> 
                                <span class="price_describe_style"><?php echo number_format($item->price, 0, ',', ' ');?> руб.</span></li>
                        </ul>
                    </div>

                <? }
           }

            
        }?>
    </div>
    <input type="submit" name='saveItemsToItems' value='сохранить'/>
</form>
<?php }  ?>



<?php if ($tab=='photo'){ ?>

<?php 
        
    $picturesConfig = array();
    $configFile = Yii::getPathOfAlias('webroot').'/protected/config/catalog/categoryItemPictureSettings.php';
    if (file_exists($configFile)){

        $picturesConfig = require($configFile);

        $this->widget(
            'application.modules.pictureBox.components.PictureBox', array(
            'id' => 'catalogItem',
            'elementId' => $model->id,
            'config' => $picturesConfig,
                )
        );
    } else{
        Yii::app()->user->setFlash('error','Отсутствует конфигурационный файл:'.$configFile);
    }
?>    
<?php } ?>