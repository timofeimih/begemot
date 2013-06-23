<div class="video gallery container_12">
    <ul>
        <?php foreach ($videos as $video):?>
        <?php
            Yii::import('application.modules.pictureBox.components.PBox');
            $pBox = new PBox('videoGallery',$video->id);
        ?>
        <li><a href="<?php echo $video->url;?>" class="play" rel="prettyPhoto[gallery1]" title="Видео 1"></a><img src="<?php echo $pBox->getImage(0,'widget');?>" title="" alt="" /></li>
        <?php endforeach;?>
    </ul>
</div>