<?php

class ModelsWidget extends CWidget {
    
    public $limit = 3;
    
    public function run(){
        Yii::import('catalog.models.CatItemsToCat');
        Yii::import('catalog.models.CatItem');
        Yii::import('catalog.models.CatCategory');
        $dataProvider = new CActiveDataProvider('CatItemsToCat', array('criteria' => array('select' => 't.itemId, t.catId', 'with' => 'item', 'order' => 't.order'),'pagination'=>array( 'pageSize'=>1000)));

        $this->render('index',array('categoryItems'=>$dataProvider->getData()));
        
    }
    
}

?>
