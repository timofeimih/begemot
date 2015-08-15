<?php if(count($comments) > 0):?>
    <ul class="comments">
        <?php foreach($comments as $comment):?>
        <li id='comment-<?php echo $comment->comment_id?>'>
            <div class="avtr1">
                <span class="avtr-brb"></span>
                <img src="images/avtr-def.jpg">
            </div>
            <div class="comment"    >
                <p class="name"><?php echo $comment->user_name;?>  <span><?php echo date("d.m.Y h:i",$comment->create_time);?></span></p>
                <p class="text"><?php echo CHtml::encode($comment->comment_text);?></p>
            </div>
        <?php if(Yii::app()->user->isAdmin() === true):?>     
                <div class="container">
            <?php if($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED) echo CHtml::ajaxSubmitButton(Yii::t('CommentsModule.msg', 'approve'), Yii::app()->urlManager->createUrl(
                        CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                    ), array(
                        'type' => 'POST',
                        // Результат запроса записываем в элемент, найденный
                        // по CSS-селектору #output.
                        'success'=>'
                            function(data){
                            alert("Утвержден");
                            var data = jQuery.parseJSON(data);
                            $("#comment-" + data.approvedID).find(".approve").remove();
                        }',

                        'update' => '#output',

                        ), array('class' => 'approve commentAdminButton', 'style' => 'width:80px'));?>


                     <?php echo CHtml::ajaxSubmitButton(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                        CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                    ), array(
                        'type' => 'POST',
                        // Результат запроса записываем в элемент, найденный
                        // по CSS-селектору #output.
                        'success'=>'
                            function(data){
                            alert("Удален");
                            var data = jQuery.parseJSON(data);

                            $("#comment-" + data.deletedID).remove();
                        }',

                        'update' => '#output',

                        ), array('class' => 'delete commentAdminButton', 'style' => 'width:80px'));?>
                    <input type='button' style='width: 200px;' class='answer commentAdminButton' value='Ответить на комментарий'>
                    <form action="/comments/comment/ajaxSubmit" class='answerForm' style='display:none'>
                        <input type="hidden" class='owner_name' name='Comment[owner_name]'>
                        <input type="hidden" class='owner_id' name='Comment[owner_id]'>
                        <input type="hidden" name='Comment[user_name]' value='<?php echo Yii::app()->user->name?>'>
                        <input type="hidden" name='Comment[creator_id]' value='<?php echo Yii::app()->user->id?>'>
                        <input type="hidden" name='Comment[user_email]' value='scoot@ya.ru'>
                        <input type="hidden" name='Comment[parent_comment_id]' value='<?php echo $comment->comment_id?>'>
                        <textarea name="Comment[comment_text]" id="" cols="10" rows="5"></textarea>
                        <input type="submit">
                    </form>
                    <script>
                        $(document).on("click", ".answer", function(){
                            $(this).parent().find("FORM").show()

                        })

                        $(function(){
                            $(".owner_id").val($("#Comment_owner_id").val());
                            $(".owner_name").val($("#Comment_owner_name").val());
                        })

                        $(".answerForm").submit(function(e){
                            e.preventDefault();
                        e.stopImmediatePropagation();
                            var form = $(this);
                        form.find("INPUT[type='submit']").attr("disabled", 'disabled');
                            $.post(form.attr("action"), form.serialize(), function(data){
                                //alert("Комментарий добавлен");

                            form.find("INPUT[type='submit']").attr("disabled", false);
                                location.reload();
                            }).fail(function(){
                                alert("Не вышло");
                            });
                        })

                    </script>
                </div>
                
        <?php endif; ?>
        <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) : ?>
            <ul style="width: 86%;margin-left: 90px;padding-top: 10px;margin-bottom: 0px;">
            <?php foreach($comment->childs as $childComment): ?>
                
                    <li id='comment-<?php echo $childComment->comment_id?>'>
                        <div class="avtr1">
                            <span class="avtr-brb"></span>
                            <img src="images/admin_icon.png">
                        </div>
                        <div class="comment"    >
                            <p class="name"><?php echo $childComment->user_name;?>  <span><?php echo date("d.m.Y h:i",$childComment->create_time);?></span></p>
                            <p class="text"><?php echo CHtml::encode($childComment->comment_text);?></p>
                        </div>

                        <?php if($this->adminMode === true):?>

                            <div class="admin-panel">

                             <?php echo CHtml::ajaxSubmitButton(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                                    CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$childComment->comment_id)
                                ), array(
                                'type' => 'POST',
                                // Результат запроса записываем в элемент, найденный
                                // по CSS-селектору #output.
                                'success'=>'
                                    function(data){
                                    alert("Удален");
                                    var data = jQuery.parseJSON(data);

                                    $("#comment-" + data.deletedID).remove();
                                }',

                                'update' => '#output',

                                ), array('class' => 'delete commentAdminButton', 'style' => 'width:80px'));?>
                            </div>
                        <?php endif; ?>
                    </li>
            <?php endforeach; ?>
            </ul>
        <?php endif;?>
        

        
        </li>
        <?php endforeach;?>

<!--        <p class="more-comm">-->
<!--            <a href="javascript:void(0)" class="more-link cf">Показать ещё</a>-->
<!--            <a href="javascript:void(0)" class="more-link-clsd">Скрыть все</a>-->
<!--        </p>-->
    </ul>


<?php else:?>
    <div class="noComments"><p><?php echo Yii::t('CommentsModule.msg', 'Нет комментариев');?></p></div>
<?php endif; ?>

