<!--<div class="moving-block" id="move">-->
<!--    <form id="messang1" class="art-comm-mess">-->
<!--        <p class="bold">Написать комментарий</p>-->
<!--        <label>Имя</label>-->
<!--        <input type="text" name="name" value="">-->
<!--        <label>Сообщение</label>-->
<!--        <textarea name="message" ></textarea>-->
<!--        <input type="submit" value="Отправить">-->
<!--    </form>-->
<!--</div>-->
<div class="moving-block" id="move">
  <?php

    $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->urlManager->createUrl($this->postCommentAction),
        'id'=>$this->id,
        //'htmlOptions'=>array('class'=>'art-comm-mess'),
        'enableAjaxValidation'=>true,
        'enableClientValidation' => true,


    )); ?>
    <?php echo $form->errorSummary($newComment); ?>
    <?php
    echo $form->hiddenField($newComment, 'owner_name');
    echo $form->hiddenField($newComment, 'owner_id');
    echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
    ?>
    <?php if(Yii::app()->user->isGuest == true):?>
        <div class="row">
            <?php echo $form->labelEx($newComment, 'user_name'); ?>
            <?php echo $form->textField($newComment,'user_name', array('size'=>40)); ?>
            <?php echo $form->error($newComment,'user_name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($newComment, 'user_email'); ?>
            <?php echo $form->textField($newComment,'user_email', array('size'=>40)); ?>
            <?php echo $form->error($newComment,'user_email'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($newComment, 'comment_text'); ?>
        <?php echo $form->textArea($newComment, 'comment_text', array('cols' => 60, 'rows' => 10)); ?>
        <?php echo $form->error($newComment, 'comment_text'); ?>
    </div>
<?php
echo CHtml::ajaxSubmitButton('Обработать', '/comments/comment/ajaxSubmit.html', array(
        'type' => 'POST',
        // Результат запроса записываем в элемент, найденный
        // по CSS-селектору #output.
        'success'=>'
            function(data){
                alert("Ваше сообщение отправлено. После проверки модератором оно появится на сайте.");
                document.getElementById("'.$this->id.'").reset();
        }',

        'update' => '#output',

    ),
    array(
        // Меняем тип элемента на submit, чтобы у пользователей
        // с отключенным JavaScript всё было хорошо.
        'type' => 'submit'
    ));
?>
<?php $this->endWidget();?>
</div>
<?php
return;
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->urlManager->createUrl($this->postCommentAction),
        'id'=>$this->id,
)); ?>
    <?php echo $form->errorSummary($newComment); ?>
    <?php
        echo $form->hiddenField($newComment, 'owner_name');
        echo $form->hiddenField($newComment, 'owner_id');
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
    ?>
    <?php if(Yii::app()->user->isGuest == true):?>
        <div class="row">
            <?php echo $form->labelEx($newComment, 'user_name'); ?>
            <?php echo $form->textField($newComment,'user_name', array('size'=>40)); ?>
            <?php echo $form->error($newComment,'user_name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($newComment, 'user_email'); ?>
            <?php echo $form->textField($newComment,'user_email', array('size'=>40)); ?>
            <?php echo $form->error($newComment,'user_email'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($newComment, 'comment_text'); ?>
        <?php echo $form->textArea($newComment, 'comment_text', array('cols' => 60, 'rows' => 10)); ?>
        <?php echo $form->error($newComment, 'comment_text'); ?>
    </div>

    <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
        <div class="row">
            <?php echo $form->labelEx($newComment,'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha', array(
                    'captchaAction'=>Yii::app()->urlManager->createUrl(CommentsModule::CAPTCHA_ACTION_ROUTE),
                )); ?>
                <?php echo $form->textField($newComment,'verifyCode'); ?>

            </div>
            <div class="hint">
                <?php echo Yii::t('CommentsModule.msg', '
                    Please enter the letters as they are shown in the image above.
                    <br/>Letters are not case-sensitive.
                ');?>
            </div>
            <?php echo $form->error($newComment, 'verifyCode'); ?>
        </div>
    <?php endif; ?>
<?php $this->endWidget(); ?>
</div><!-- form -->
