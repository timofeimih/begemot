
<?php
$pbPath = Yii::getPathOfAlias('pictureBox');
Yii::app()->clientScript->registerCssFile('/protected/modules/pictureBox/assets/css/tiles.css');

Yii::app()->clientScript->registerScriptFile('https://code.jquery.com/ui/1.12.0/jquery-ui.js');

$script = '

            function loadPage(page,state,divId){

                    state.imageNumber=page;

                refreshPictureBox(divId,state)
            }

            function setTitleAlt(state,divId){
                 var title = $("#"+divId+" input[name=title]").val();
                 var alt = $("#"+divId+" input[name=alt]").val();
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


                    },
                    error:function(param,param1,param2){
                        alert(param.responseText);
                    }
                });
            }

              $( function() {
                $( "#sortable" ).sortable(
                    {
                        cursor: "move",
                        stop: function( event, ui ) {updateSortArray()}
                    }
                );
              //  $( "#sortable" ).disableSelection();
              } );

              function updateSortArray(){
                var sortArray=Object();
                var sortIndex = 0;
                $("div#'.$config['divId'].' ul.tiles img").each(
                    function(index, domElement){
                        
                        sortArray[$(domElement).attr("data-id")+""]=sortIndex;
                        sortIndex++;

                });

                $.ajax({
                        url:"/pictureBox/default/newSortOrder",
                        data:{
                            sort:sortArray,
                            galleryId:"'.$id.'",
                            id:'.$elementId.'

                        },
                        cache:false,
                        async:false,
                        success:function(html){




                        },
                        error:function(param,param1,param2){
                            alert(param.responseText);
                        }
                    });

              }

';

Yii::app()->clientScript->registerScript('pictureBox-js-'.$config['divId'], $script, 0);


$thisPictureBoxScript = '
                var PB_'.$config['divId'].' = {};
                PB_'.$config['divId'].'.pictureBoxPage = 1;
                PB_'.$config['divId'].'.id = "'.$id.'";
                PB_'.$config['divId'].'.elementId = '.$elementId.';
                PB_'.$config['divId'].'.theme = "tiles";


                refreshPictureBox("'.$config['divId'].'",PB_'.$config['divId'].');


    ';
Yii::app()->clientScript->registerScript('pictureBox-js-'.$config['divId'], $thisPictureBoxScript, 2);


?>


<div id="<?php echo $config['divId']?>" style="width:100%;">

</div>