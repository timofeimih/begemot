<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />


        
    
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" style="margin-top:50px;">



        
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>'Begemot',
    'brandUrl'=>'/begemot',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                        //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>'Каталог', 'url'=>array('/catalog/catItem')),
                        array('label'=>'Статьи', 'url'=>array('/post/default/admin')),
                        array('label'=>'HTML', 'url'=>array('/pages')),
                        array('label'=>'Файлы', 'url'=>array('/elfinder')),
                        array('label'=>'Галлерея', 'url'=>array('/gallery')),
                        array('label'=>'Login', 'url'=>array('/begemot'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/begemot/default/logout'), 'visible'=>!Yii::app()->user->isGuest)
                ),
        ),
    ),
)); ?>
      
        


	<?php echo $content; ?>





</div><!-- page -->

