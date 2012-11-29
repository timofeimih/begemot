    <h1>Фотогаллерея сайта</h1>


    <?php  
        foreach ($allGall as $gallery){

            $filename = Yii::getPathOfAlias('webroot').'/files/pictureBox/gallery/'.$gallery->id.'/data.php';

            $images = array();

            if (file_exists($filename)){
                $images = require $filename;
                $images = array_values($images['images']);
            } 
        
    
    ?>
    <h2><a href="<?php echo Yii::app()->urlManager->createUrl('gallery/siteGallery/viewGallery',array('id'=>$gallery->id,'title'=>$gallery->name_t))?>"><?php echo $gallery->name;?></a></h2>
    
        <div id="tab1" class="tab-content">
            <div class="inner">
               <div class="wrapper">
                     <?php foreach ($images as $id=>$image){ 
                         if ($id>7) break;
                         ?>
                     <div class="col-1" style="overflow:hidden;height:180px;">
                       <figure><a class="lightbox-image" datagal="prettyPhoto[1]" title="" href="<?php echo $image['original'];?>"><img src="<?php echo $image['admin'];?>" alt="<?php echo (isset($image['alt'])?$image['alt']:'');?>" title="<?php echo (isset($image['title'])?$image['alt']:'');?>"></a></figure>
                       <div class="text3">  <?php echo (isset($image['alt'])?$image['alt']:'');?></div>
<!--                       <div class="aligncenter"><?php echo (isset($image['title'])?$image['alt']:'');?></div>-->


                       </div>
                     <?php }?>
                   
                    <div class="aligncenter"><a href="<?php echo Yii::app()->urlManager->createUrl('gallery/siteGallery/viewGallery',array('id'=>$gallery->id,'title'=>$gallery->name_t))?>" class="link1 link1-pad2">ВСЕ ФОТО</a></div>
  
            </div>
        </div> 
    </div>
    <?php  }?>        
