<?php 
    $tagsOutput = '';
    $tags = PostsTags::model()->findAll();
    
    foreach ($tags as $tag){
        
        $tagsOutput.='
                <li >
                    '.CHtml::link($tag->tag_name,array('/post/site/tagIndex','id'=>$tag->id,'title'=>$tag->tag_name_t)).'
                 
                </li>            
';
    }
    
    
$output = '';
Yii::import('begemot.extensions.RusDate');
foreach ($models as $model):

    $imagesData = Yii::app()->basePath.'/../files/pictureBox/posts/'.$model->id.'/data.php';
    $image = '';

    if (file_exists($imagesData)){
        $imagesArray = require($imagesData);
        $image = array_shift(array_shift($imagesArray));

        if (is_array($image)&&(count($image))>0)
            $imgHtml = '                    <div class="img">
                                                    
                                                    '.CHtml::link('<span></span><img src="'.$image['small'].'" />' ,array('/post/site/view','id'=>$model->id,'title'=>$model->title_t)).'
                                    
                                            </div>';
        else
             $imgHtml='';
    } else {
        $imgHtml='';
    }
    
    $output .= '
				<div class="articles">
                                        '.$imgHtml.'
					<div class="text">
						<h3>'.CHtml::link($model->title ,array('/post/site/view','id'=>$model->id,'title'=>$model->title_t)).'</h3>
						<p class="data">Дата публикации: '.date('d',$model->date).' '.  RusDate::getShortMonth ((int)date('m',$model->date)-1).', '.date('Y',$model->date).'<b></b></p>
						<p>'. mb_substr(html_entity_decode(strip_tags($model->text),ENT_COMPAT,'UTF-8'),0,255,'UTF-8').'...</p>
					</div>
				</div>        
';




endforeach;

?>  


<div id="content">
		<div class="container_12">
			<div class="grid_3 left">
             
				<ul class="menu">
              
                                    <?php
                                    echo '<li>'.CHtml::link('Все',array('/post/site/index')).'</li>';
                                    echo $tagsOutput;
                                    ?>
		
				</ul>
			</div>
			
			<div class="grid_8 right">
				
				
				<div id="articles">
                                    <h3>Статьи</h3>
                                    <?php echo $output;?>
									
				</div>
				

				
			</div>
		</div>
	</div><!-- #content-->



<?php


return;
$output = '';
Yii::import('begemot.extensions.RusDate');
foreach ($models as $model):

    $imagesData = Yii::app()->basePath.'/../files/pictureBox/posts/'.$model->id.'/favData.php';
    $image = '';
    if (file_exists($imagesData)){
        $imagesArray = require($imagesData);
        $image = array_shift($imagesArray);
       
        //$image = $image['list'];
    }
    
    $output .= '
                <article id="post-75" class="post-75 post type-post status-publish format-standard hentry category-aliquam-erat category-duis-ultricies category-nam-elit category-proin-ullamcorper tag-morbi tag-sagittis tag-suspendisse tag-tincidunt tag-ultrices tag-varius cat-6-id cat-7-id cat-5-id cat-1-id">

                <div class="post-header">
                   
                    <strong>'.date('d',$model->date) .'<br />'.  RusDate::getShortMonth ((int)date('m',$model->date)).'</strong>

                    <h5>
                    '.CHtml::link($model->title ,array('posts/view','id'=>$model->id,'title'=>$model->title_t)).'
                    </h5>
                    <i>Автор: администратор</i>
                </div>

                <div class="post-block">

                    <figure class="featured-thumbnail"><span class="img-wrap">
                     '.CHtml::link('<img width="369" height="278" src="'.$image['list'].'" class="attachment-big-post-thumbnail wp-post-image" alt="'.$image['alt'].'" title="'.$image['title'].'" />' ,array('posts/view','id'=>$model->id,'title'=>$model->title_t)).'
                    </span></figure>                
                    <div class="excerpt">
                    '. mb_substr(html_entity_decode(strip_tags($model->text),ENT_COMPAT,'UTF-8'),0,455,'UTF-8').'...'.'
                    </div>
                    '.CHtml::link('<i>весь текст</i>',array('posts/view','id'=>$model->id,'title'=>$model->title_t),array('class'=>'button')).'
                    


                </div>

            </article>
';

//echo  $model->title.'</br>'; 


endforeach;

?>
<div class="wrapper">	<div id="content" class="grid_9 alpha right">

        <div class="right-indent">

            <h1>Снегоболотоход Арго</h1>


<?php echo $output; ?>



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

<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
))
?>
