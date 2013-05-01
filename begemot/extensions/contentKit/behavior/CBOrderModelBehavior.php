<?php
class CBOrderModelBehavior extends CActiveRecordBehavior {
    
    public $orderAttribute = 'order';    
    
    public $modelOrder = 0;
    
    public function events(){
        return array(
            'onBeforeSave' => 'orderBeforeSave',
        );
    }       
    
    public function orderUp(){
        return;
    }
    
    public function orderDown(){
        return;
    }
    
    public function afterFind ($event){
       $this->modelOrder = $this->getOwner()->order;
    }
    public function beforeSave ($event=null){

        parent::beforeSave($event=null);

        if ($this->getOwner()->isNewRecord){
          if (isset($this->owner->order)){
              $criteria = new CDbCriteria;

              $criteria->select = 'MAX(`order`) as `order`';


              $order = $this->getOwner()->findAll($criteria);

              $model = $this->getOwner()->order = $order[0]->order+1;
          }


        }
        return true;
    }
    
    public function orderBeforeSave(){
        $this->beforeSave();
    }
    
}

?>
