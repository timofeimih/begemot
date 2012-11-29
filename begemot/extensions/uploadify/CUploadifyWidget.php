<?php

class CUploadifyWidget extends CWidget{
   
   public $filePath = ' '; 
   public $uploader = ' ';
   public $formDataJson = '';
    
   public function run(){
      $this->render('index',array(
            'filePath'=>$this->filePath,
            'uploader'=>$this->uploader,
            'formDataJson'=>$this->formDataJson,
      ));
   } 
    
}
?>
