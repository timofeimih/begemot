<?php


Yii::import('zii.widgets.grid.CGridColumn');


class CBOrderColumn extends CButtonColumn
{

    public $className = '';

    public $orderGroup;
    public $orderGroupId;

    public $template='{up} {down}';
    
    public $upButtonLabel;
    public $upButtonUrl;
    public $upButtonImageUrl;
    public $upButtonOptions;
    
    public $afterUp;

    public $downButtonLabel;
    public $downButtonUrl;
    public $downButtonImageUrl;
    public $downButtonOptions;
    
    public $afterDown;                                        
    
	protected function initDefaultButtons()
	{
        $orderGroupParamStr='';
        $orderGroupIdParamStr='';
        if (!is_null($this->orderGroup)){
            $orderGroupParamStr = $this->orderGroup!=null?',"groupName"=>"'.$this->orderGroup.'"':'';
            $orderGroupIdParamStr = ',"groupId"=>$data->'.$this->orderGroup.'';
        }


        $this->upButtonUrl = 'Yii::app()->controller->createUrl("orderUp",array("modelId"=>$data->primaryKey,"className"=>"'.$this->className.'"'.$orderGroupParamStr.$orderGroupIdParamStr.'))';
        $this->downButtonUrl = 'Yii::app()->controller->createUrl("orderDown",array("modelId"=>$data->primaryKey,"className"=>"'.$this->className.'"'.$orderGroupParamStr.$orderGroupIdParamStr.'))';

		if($this->upButtonLabel===null)
			$this->upButtonLabel='';                
		if($this->upButtonImageUrl===null)
			$this->upButtonImageUrl=$this->grid->baseScriptUrl.'/up.png';                
		if($this->upButtonOptions===null)
			$this->upButtonOptions=array('class'=>'icon-arrow-up');                

		if($this->downButtonLabel===null)
			$this->downButtonLabel='';                
		if($this->downButtonImageUrl===null)
			$this->downButtonImageUrl=$this->grid->baseScriptUrl.'/down.png';                
		if($this->downButtonOptions===null)
			$this->downButtonOptions=array('class'=>'icon-arrow-down');                    
                
		foreach(array('up','down') as $id)
		{
			$button=array(
				'label'=>$this->{$id.'ButtonLabel'},
				'url'=>$this->{$id.'ButtonUrl'},
			
				'options'=>$this->{$id.'ButtonOptions'},
                                       
			);
			if(isset($this->buttons[$id]))
				$this->buttons[$id]=array_merge($button,$this->buttons[$id]);
			else
				$this->buttons[$id]=$button;
		}
           
		if(!isset($this->buttons['up']['click']))
		{
			
                        $confirmation='';

			if(Yii::app()->request->enableCsrfValidation)
			{
				$csrfTokenName = Yii::app()->request->csrfTokenName;
				$csrfToken = Yii::app()->request->csrfToken;
				$csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
			}
			else
				$csrf = '';
                        
                        $this->afterUp='function(){}';
             
			$this->buttons['up']['click']=<<<EOD
function() {
	$confirmation
	var th=this;
	var afterUp=$this->afterUp;
	$.fn.yiiGridView.update('{$this->grid->id}', {
		type:'POST',
		url:$(this).attr('href'),$csrf
		success:function(data) {
			$.fn.yiiGridView.update('{$this->grid->id}');
			afterUp(th,true,data);
		},
		error:function(XHR) {
			return afterUp(th,false,XHR);
		}
	});
	return false;
}
EOD;
		}                
                
		if(!isset($this->buttons['down']['click']))
		{
			
                        $confirmation='';

			if(Yii::app()->request->enableCsrfValidation)
			{
				$csrfTokenName = Yii::app()->request->csrfTokenName;
				$csrfToken = Yii::app()->request->csrfToken;
				$csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
			}
			else
				$csrf = '';
                        
                        $this->afterDown='function(){}';

			$this->buttons['down']['click']=<<<EOD
function() {
	$confirmation
	var th=this;
	var afterDown=$this->afterDown;
	$.fn.yiiGridView.update('{$this->grid->id}', {
		type:'POST',
		url:$(this).attr('href'),$csrf
		success:function(data) {
			$.fn.yiiGridView.update('{$this->grid->id}');
			afterDown(th,true,data);
		},
		error:function(XHR) {
			return afterDown(th,false,XHR);
		}
	});
	return false;
}
EOD;
		}    
	}
    
}
