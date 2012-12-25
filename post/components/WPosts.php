<?php

class WPosts extends CWidget {
    
    
    
    public function run(){
        $this->renderContent();
    }
    
    public function renderContent(){
        $this->render('post.components.view.WPostsView');
        
    }
    
}
?>
