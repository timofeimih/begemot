<?php
$assetPath = Yii::getPathOfAlias('begemot.extensions.uploadify.assets');
$dir = Yii::app()->assetManager->publish($assetPath);
Yii::app()->clientScript->registerCssFile($dir.'/uploadify.css');

Yii::app()->clientScript->registerScriptFile($dir.'/jquery.uploadify-3.1.min.js',0);

$uploadifyJsScript = '
      $(function() {
        $(\'#file_upload\').uploadify({
            \'swf\'      : \''.$dir.'/uploadify.swf\',
            \'uploader\' : \''.$uploader.'\',
            // Your options here
            "buttonText":"Загрузить файлы",
            "formData":'.$formDataJson.',
            "onQueueComplete":function(queueData){location.reload();;}
        });
    }); 
';
Yii::app()->clientScript->registerScript('uploadify',$uploadifyJsScript,0);


?>



<input type="file" name="file_data" id="file_upload" />
