<?php 
$assetsDir = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.elfinder.assets'));

 //= Yii::getPathOfAlias('application.modules.elfinder.assets');
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsDir.'/css/elfinder.min.css');

$cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css');


//$cs->registerCoreScript('jquery');
//$cs->registerCoreScript('jquery.ui');

$cs->registerScriptFile($assetsDir.'/js/elfinder.min.js');
$cs->registerScriptFile($assetsDir.'/js/i18n/elfinder.ru.js');

$elfinderScript = "
        $().ready(function() {

                var elf = $('#elfinder').elfinder({
                        url : '/elfinder/default/connector',  // connector URL (REQUIRED)
                         lang: 'ru',             // language (OPTIONAL)
                }).elfinder('instance');
                

        });   
";
Yii::app()->clientScript->registerScript('elfinderScript',$elfinderScript,3);
?>



<div id="elfinder"></div>