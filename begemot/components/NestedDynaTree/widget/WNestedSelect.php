<?php

class WNestedSelect extends CWidget {

    public $id;
    public $nestedData;
    public $default = 'нет значения';

    public function init() {
        
        $script = "
            function setNestedData(event,data){

                $('#'+data.inputId).html(data.title);

                event.stopPropagation(); 
            }
        ";
        
        Yii::app()->clientScript->registerScript('nested', $script, 4);
    }

    public function run() {
        $this->render('nestedSelect',array('id'=>$this->id,'data'=>$this->nestedData,'default'=>$this->default));
    }

}

?>
