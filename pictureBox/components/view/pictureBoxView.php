<?php

$assetsDir = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.pictureBox.assets'));

Yii::app()->clientScript->registerCssFile($assetsDir.'/css/pictureBox.css');


$script = '
                
            function loadPage(page,state,divId){
                    
                    state.imageNumber=page;
   
                refreshPictureBox(divId,state)
            }
            
            function setTitleAlt(state,divId){
                 var title = $("#"+divId+" input[name=title]").attr("value");
                 var alt = $("#"+divId+" input[name=alt]").attr("value");
                 
                 var data = {};
                 data.title = title;
                 data.alt = alt;
                 data.id = state.id;
                 data.elementId = state.elementId;
                 data.pictureId = state.pictureBoxPage;

                $.ajax({
                    url:"/pictureBox/default/ajaxSetTitle",
                    data:data,
                    cache:false,
                    async:true,
                    type:"post",
                    success:function(html){
         
                         alert("Сохранено. ");
                         refreshPictureBox(divId,state);
                         
                    }
                });
             
               
            }

            function refreshPictureBox(divId,state){
               
                $.ajax({
                    url:"/pictureBox/default/ajaxLayout",
                    data:state,
                    cache:false,
                    async:false,
                    success:function(html){

                        $("#"+divId).html(html);

                        
                    }
                });
            }
';

Yii::app()->clientScript->registerScript('pictureBox-js', $script, 0);

$thisPictureBoxScript = '
                var PB_'.$config['divId'].' = {};
                PB_'.$config['divId'].'.pictureBoxPage = 1;
                PB_'.$config['divId'].'.id = "'.$id.'";
                PB_'.$config['divId'].'.elementId = '.$elementId.';

                refreshPictureBox("'.$config['divId'].'",PB_'.$config['divId'].');
               
                
    ';
Yii::app()->clientScript->registerScript('pictureBox-js-'.$config['divId'], $thisPictureBoxScript, 2);


?>

<div id="<?php echo $config['divId']?>" style="height:400px;width:100%;">
    
</div>





