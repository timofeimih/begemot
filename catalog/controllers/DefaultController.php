<?php

class DefaultController extends Controller
{
    	public $layout='begemot.views.layouts.column2';
	public function actionIndex()
	{
		$this->render('index');
	}

        public function actionRenderImages(){
            
           Yii::import('begemot.extensions.CLongTaskQueue'); 
           
           $queueId = 'catalog';
           $queue = new CLongTaskQueue($queueId); 
           
           $activeTask = '';
           
           if (!$queue->isQueueExist()){
               
               
               $data =  CatItem::model()->findAll();
               
               $taskArray = array();
               
               foreach ($data as $dataItem){
                   $taskArray[] = $dataItem->id; 
               }
               
               $queue->startNewQueue($taskArray);
               
           } else {
               
                $activeTask =  $queue->getNewActiveTask();
                $queue->activeTaskCompleted();
                
           }
               
           
           $this->render('renderImages',array('activeTask'=>$activeTask));
        }
        
        
}