<?php

class Page extends CInputWidget{

    public $page;
    
    public function run(){
        parent::run();
        
        $this->render('application.views.site.pages.'.$this->page);
        
        $dataDirPath = Yii::getPathOfAlias('webroot').'/protected/views/site/pages/';
        $dataPath = $dataDirPath.'data/';
        $dataFilePath = $dataPath.md5('./protected/views/site/pages/'.$this->page.'.php').'.data';
           
        if (file_exists($dataFilePath)){
            $data = require($dataFilePath);
            
            Yii::app()->controller->pageTitle =$data['seoTitle'];
        }
        
       
    }
}
?>
