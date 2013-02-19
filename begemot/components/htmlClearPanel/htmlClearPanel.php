<?php

class htmlClearPanel extends CWidget{
    
    public $id = '';
    
    public function run(){
        $this->render('index',array('id'=>$this->id));
    }
    
}

?>
