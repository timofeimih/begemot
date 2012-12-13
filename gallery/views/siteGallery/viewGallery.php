<?php
$this->pageTitle=$gallery->seo_title;
?>

<h1><a href="<?php echo Yii::app()->urlManager->createUrl('gallery/siteGallery/index')?>">Галлерея</a>::<?php echo $gallery->name;?></h1>

   
        <div id="tab1" class="tab-content">
            <div class="inner">
               <div class="wrapper">
                     <?php foreach ($images as $id=>$image){ 
       
                         ?>
                     <div class="col-1" style="overflow:hidden;height:180px;">
                       <figure><a class="lightbox-image" datagal="prettyPhoto[1]" title="" href="<?php echo $image['original'];?>"><img src="<?php echo $image['admin'];?>" alt="<?php echo (isset($image['alt'])?$image['alt']:'');?>" title="<?php echo (isset($image['title'])?$image['alt']:'');?>"></a></figure>
                       <div class="text3">  <?php echo (isset($image['alt'])?$image['alt']:'');?></div>
<!--                       <div class="aligncenter"><?php echo (isset($image['title'])?$image['alt']:'');?></div>-->


                       </div>
                     <?php }?>
                   
                   
  
            </div>
        </div> 
    </div>
    
