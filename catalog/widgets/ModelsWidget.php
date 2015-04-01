<?php

class ModelsWidget extends CWidget {
    
    public $limit = 3;
    public $onlyTop = true;
    public $order = null;
    
    public function run(){
        Yii::import('catalog.models.CatItemsToCat');
        Yii::import('catalog.models.CatItem');
        Yii::import('catalog.models.CatCategory');

        $criteria = array();

        if ($this->onlyTop){
            $criteria =  array('condition'=>'`published`=1 AND `top`=1', 'with'=>array('category'));
            //$criteria->distinct = true;
        } else {
            $criteria =  array('condition'=>'`published`=1', 'with'=>array('category'));
        }

        if (!is_null($this->order)){
            $criteria['order']= $this->order;
        }

        $dataProvider = new CActiveDataProvider('CatItem', array('criteria' => $criteria,'pagination'=>array('pageSize'=>$this->limit)));

        $this->render('index',array('items'=>$dataProvider->getData()));
        
    }
    
}

?>
