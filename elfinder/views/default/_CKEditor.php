<?php 
$assetsDir = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.elfinder.assets'));

 //= Yii::getPathOfAlias('application.modules.elfinder.assets');
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsDir.'/css/elfinder.min.css');

$cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css');


$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');

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

<script type="text/javascript" charset="utf-8">
    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;
        
        return (match && match.length > 1) ? match[1] : '' ;
    }

    $().ready(function() {
        var funcNum = getUrlParam('CKEditorFuncNum');

        var elf = $('#elfinder').elfinder({
            url : '/elfinder/default/connector',
            getFileCallback : function(file) {
                window.opener.CKEDITOR.tools.callFunction(funcNum, file);
                window.close();
            },
            resizable: false
        }).elfinder('instance');
    });
</script>