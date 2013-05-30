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

        $categories = CatItemsToCat::model()->findAll(array('condition'=>'itemId='.$model->id));

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

                echo ' '.CatCategory::model()->getCatName( $cat->catId).'<br/>';
            }


            echo '<br/>';




       }
        $itemToCat = new CatItemsToCat();
        $testForm = new CForm('catalog.models.forms.catToItemForm',$itemToCat);
       // $testFrom->action = '/'.$this->route.'/id/'.$model->id;

        $testForm['itemId']->value = $model->id;
        echo '<div class="container-fluid">'.$testForm->render().'</div>';
    }?>
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