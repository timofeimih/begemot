<?php

class WPosts extends CWidget {
    
    public $limit=4;
    
    public function run(){
        $this->renderContent();
    }
    
    public function renderContent(){

        Yii::import('post.models.Posts');

        $posts = Posts::model()->findAll(array('condition'=>'tag_id<>"0" and published<>0','limit'=>$this->limit,'offset'=>0,'order'=>'date desc'));

        $this->render('WPostsView',array('posts'=>$posts));
        
    }
    
}
?>
