<div class="video gallery container_12">
    <ul>
        <?php foreach ($videos as $video):?>
        <?php
            Yii::import('application.modules.pictureBox.components.PBox');
            $pBox = new PBox('videoGallery',$video->id);
        ?>
        <li><a href="<?php echo $video->url;?>" class="play" rel="prettyPhoto[gallery1]" title=""></a><img src="<?php echo $pBox->getImage(0,'widget');?>" title="" alt="" /></li>
        <?php endforeach;?>
    </ul>
    <div id="parallax_hs" class="container_12">
			<a href="javascript:;" class="show-parallax hide"><span>Скрыть видео<span></a>
</div>