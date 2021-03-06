<?php /** @var BootActiveForm $form */

if (!Yii::app()->user->isGuest){
    echo '<h1>Добро пожаловать в админку CMS BEGEMOT</h1>';
    echo '<p>Для навигации по модулям вашего сайта используйте верхнее меню.</p>';
    return;
} 

Yii::import('begemot.models.BegemotLoginForm');
$model = new BegemotLoginForm();
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
    'action'=>'/begemot/default/login',
    'htmlOptions'=>array('class'=>'well span3'),
)); ?>
 
<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
 
<?php $this->endWidget(); ?>
