<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'posts-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'title_seo'); ?>
        <?php echo $form->textField($model, 'title_seo', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'title_seo'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>

        
            <?php 
                    $this->widget('begemot.extensions.ckeditor.CKEditor',
            array('model' => $model, 'attribute' => 'text', 'language' => 'ru', 'editorTemplate' => 'full',));
            ?>        
        
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'author'); ?>
        <?php
        $tags = PostsTags::getTags();
        echo $form->dropDownList($model, 'tag_id', $tags);
        ?>
        <?php echo $form->error($model, 'author'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'author'); ?>
        <?php echo $form->textField($model, 'author'); ?>
        <?php echo $form->error($model, 'author'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Источник'); ?>
        <?php echo $form->textField($model, 'from'); ?>
        <?php echo $form->error($model, 'from'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Ссылка на источник'); ?>
        <?php echo $form->textField($model, 'from_url'); ?>
        <?php echo $form->error($model, 'from_url'); ?>
    </div>    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

    <?php
    
    require Yii::getPathOfAlias('webroot').'/protected/config/postConfig.php';

    if (!$model->isNewRecord)
        $this->widget(
                'application.modules.pictureBox.components.PictureBox', array(
            'id' => 'posts',
            'elementId' => $model->id,
            'config' => $picturesConfig,
                )
        );
    ?>

</div><!-- form -->