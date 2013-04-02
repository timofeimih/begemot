<?php
Yii::import('pictureBox.components.PBox');

?>
<hr>
<h1>Заголовок галлереи: <?php echo $cat->name;?></h1>
Описание галлереи: <?php echo $cat->text;?><br>
Сео заголовок: <?php echo $cat->seo_title;?><br>
    <div>
    <?php foreach ($cat->videoGalleryVideos as $video){?>  

    Заголовок видео-ролика:<?php echo $video->title;?><br>
    Описание: <?php echo $video->text;?><br>
    Ссылка: <?php echo $video->url;?><br><br>
    
    <?php
        $PBox = null;
        $PBox = new PBox('videoGallery',$video->id);
        $image='';
        if ($PBox->pictures!=null){
            
           $image = $PBox->getFirstImageHtml('main',array('class'=>'123'));
        }
        
    ?>
    <?php echo $image;?>
    <?php }?>
    
    </div>

