   <?php
    $this->pageTitle = $category->seo_title;
    
   ?> 
<a href="<?php echo Yii::app()->urlManager->createUrl('catalog/site/index');?>">Каталог</a> > 
    <?php echo $category->name; ?>  
<h1><?php echo $category->name;?></h1>
    <span class="text-top3"><?php echo $category->text;?></span> 
    <br/>  <br/>
<div class="inner">
    <div class="wrapper">
        <?php foreach ($categoryItems as $categoryItem){ ?>
        <?php
            $hrefParams = array(
                'title'=>$category->name_t,
                'catId'=>$category->id,
                'itemName'=>$categoryItem->item->name_t,
                'item'=>$categoryItem->item->id,
            );
            $itemHref =  Yii::app()->urlManager->createUrl('catalog/site/itemView',$hrefParams);
        ?>
        <div class="col-1" style="height:320px;">
                <figure><a class="lightbox-image" title="" href="<?php echo $itemHref;?>"><img src="<?php echo $categoryItem->item->getItemMainPicture("small");?>" alt=""></a></figure>
            <div class="text3"><?php echo $categoryItem->item->name;?></div>
            <div class="aligncenter"><?php echo mb_strcut(strip_tags($categoryItem->item->text), 0,100,'UTF-8').'...';?></div>
            <div class="price">Цена: <?php echo number_format($categoryItem->item->price,0,',',' ');?> рублей</div>
            <div class="aligncenter"><a href="<?php echo $itemHref;?>" class="link1 link1-pad2">посмотреть</a></div>
        </div>
        <?php }; ?>

    </div>
 </div>
