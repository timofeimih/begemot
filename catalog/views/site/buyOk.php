<?php

    Yii::import('pictureBox.components.PBox');
    $pBox = new PBox('catalogItem',$id);


?>

<section id="content">
    <div class="container_24">
        <div class="wrapper">
            <article class="grid_14">
                <h5>магазин</h5>
                <p>
                    Ваш запрос принят в обработку. В ближайшее время наши менеджеры
                    свяжуться с Вами.

                </p>
            </article>
            <article class="grid_9 prefix_1">
               <span class="map_wrapper">
                  <img src="<?php  echo $pBox->getImage(0,'main');?>" class="textImg" alt="">
               </span>
                <h1><?php  echo $item->name;?></h1>
                <div class="kol_vo">
<!--                    <span>Количество:</span>-->
<!--                    <a href="javascript:;" class="button green">–</a>-->
<!--                    <span class="kol">1 <b>шт.</b></span>-->
<!--                    <a href="javascript:;" class="button green">+</a>-->
                    <p class="prise">OT <?php  echo number_format($item->price, 0, ',', ' ');?></p>
                </div>
            </article>
        </div>
    </div>
</section>