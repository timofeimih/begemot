
<div class="container_12 news">
		<ul>
<?php

Yii::import('post.models.Posts');

$posts = Posts::model()->findAll(array('condition'=>'tag_id<>"0"','limit'=>'4','offset'=>0,'order'=>'date desc'));
$output = '';

foreach ($posts as $post) {

?>

			<li>
				<p><?php echo date('d.m.Y',$post->date); ?></p>
                                <?php echo CHtml::link(strip_tags(mb_strcut($post->text, 0,150,'UTF-8')).'...' ,array('/post/site/view','id'=>$post->id,'title'=>$post->title_t));?>
                             
			</li>


<?php } ?>
                        
        </ul>
</div>                         
                        


<?php

return;
$posts = Posts::model()->findAll(array('condition'=>'tag_id<>"0"','limit'=>'4','offset'=>0,'order'=>'date desc'));
$output = '';

foreach ($posts as $post) {
    
   $favDataFile = Yii::app()->basePath.'/../files/pictureBox/posts/'.$post->id.'/favData.php'; 
   $image='';
   if (file_exists($favDataFile)){
       $image = require ($favDataFile);
       //echo '<pre>';print_r($image);echo '<pre>';
       $image = array_shift($image);
       //$image = $image['small'];
      // echo '<pre>';print_r($image);echo '<pre>';
   }
   
   $image['alt'] = !isset($image['alt'])?'':$image['alt'];
   $image['title'] = !isset($image['title'])?'':$image['title'];
   $output .= '
        <li>

            <figure class="thumbnail">
            
              '.CHtml::link('<img width="219" height="178" src="'.$image['small'].'" class="attachment-post-thumbnail wp-post-image" alt="'.$image['alt'].'" title="'.$image['title'].'" />',array('posts/view','id'=>$post->id,'title'=>$post->title_t)).'  
            </figure>
            <div class="post-data">
                <div class="inner">
                    <h4>
                    '.CHtml::link($post->title ,array('posts/view','id'=>$post->id,'title'=>$post->title_t)).'

                    </h4>
                    <b>'.date('d',$post->date).' ' .RusDate::getMonth((int)date('m',$post->date)).' '.date('Y',$post->date).'</b>

                    '. myutf8_substr2(html_entity_decode(strip_tags($post->text),ENT_COMPAT,'UTF-8'),0,50).'
                </div>
            </div>

        </li>  
'; 
}
?>
<div id="my_postwidget-2">                  
    <h2>Новое на сайте</h2>						

    <ul class="latestpost">

        <?php echo $output; ?>
    </ul>



    <!-- Link under post cycle -->


</div>	