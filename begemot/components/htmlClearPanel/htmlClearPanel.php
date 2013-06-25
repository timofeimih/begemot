<?php

class htmlClearPanel extends CWidget{
    
    public $id = 'CatItem_text';
    
    public function run(){
        $this->render('index',array('id'=>$this->id));
    }
    
}

?>
