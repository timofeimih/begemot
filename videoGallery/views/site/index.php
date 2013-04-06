<?php foreach ($videoCats as $videoCat){?>
<hr>
<h1>Заголовок галлереи: <?php echo $videoCat->name;?></h1>
Описание галлереи: <?php echo $videoCat->text;?><br>
Сео заголовок: <?php echo $videoCat->seo_title;?><br>
    <div>
    <?php foreach ($videoCat->videoGalleryVideos as $video){?>  

    Заголовок видео-ролика:<?php echo $video->title;?><br>
    Описание: <?php echo $video->text;?><br>
    Ссылка: <?php echo $video->url;?><br><br>

    <?php }?>
    </div>
<?php }?>
