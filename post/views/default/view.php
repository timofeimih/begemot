<?php
$this->pageTitle = $model->title_seo;

$imagesData = Yii::app()->basePath . '/../files/pictureBox/posts/' . $model->id . '/favData.php';
$image = array();

     $image['title']=''; 
     $image['alt']=''; 
     $image['bigInner']='';

if (file_exists($imagesData)) {
    $imagesArray = require($imagesData);
    $image = array_shift($imagesArray);

    //$image = $image['bigInner'];
}
?>
<div class="wrapper">	<div id="content" class="grid_9 alpha right">

        <div class="right-indent">



            <article class="single-post">
                <h1><?php echo $model->title;?></h1>
                <figure class="featured-thumbnail large">
                    <span class="img-wrap"><span class="f-thumb-wrap"><img width="619" height="388" src="<?php echo $image['bigInner']; ?>" class="attachment-post-thumbnail-xl wp-post-image" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" /></span></span></figure>                
                <div class="indent-right">
<?php echo $model->text; ?>
                </div><!--.post-content-->
            </article>




        </div>
    </div><!--#content-->
    <aside id="sidebar" class="grid_3 omega">
        <div id="categories-2" class="widget"><h3>Разделы</h3>		<ul>

<?php 
    $output = '';
    $tags = PostsTags::model()->findAll();
    foreach ($tags as $tag){
        
        $output.='
                <li class="cat-item cat-item-6">
                    '.CHtml::link($tag->tag_name,array('posts/tagIndex','id'=>$tag->id,'title'=>$tag->tag_name_t)).'
                  <!--  <a href="/posts/index/tagId/'.$tag->id.'" >'.$tag->tag_name.'</a>!-->
                </li>            
';
    }
    echo $output;
?>                
                
                


            </ul>
        </div></aside><!--sidebar-->						</div> 


