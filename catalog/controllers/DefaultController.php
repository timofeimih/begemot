<?php

class DefaultController extends Controller {

    public $layout = 'begemot.views.layouts.column2';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionRenderImages() {

        Yii::import('begemot.extensions.CLongTaskQueue');

        $queueId = 'catalog';
        $queue = new CLongTaskQueue($queueId);

        $activeTask = '';
        
        $webroot = Yii::getPathOfAlias('webroot');
        
        if (!$queue->isQueueExist()) {


            $data = CatItem::model()->findAll();

            $taskArray = array();
            
            foreach ($data as $dataItem) {
                if ($dataItem->id!=47) continue;
                $itemDataFile = $webroot . '/files/pictureBox/catalogItem/' . $dataItem->id . '/data.php';
                $data = require ($itemDataFile);
                foreach ($data['images'] as $image) {
                    $taskArray[] = $image['original'];
                }
            }

            $queue->startNewQueue($taskArray);
        } else {
            Yii::import('pictureBox.components.FiltersManager');
            Yii::import('pictureBox.components.filters.*');
            
            $activeTask = $queue->getNewActiveTask();

            $config = require Yii::getPathOfAlias('application') . '/config/catalog/categoryItemPictureSettings.php';

            $this->renderImageAgain($id, $elemId, $pictureId, $config);
            
            $filterManager = new FiltersManager($webroot.$activeTask, $config);
            $filters = $filterManager->getFilteredImages();
            
            $queue->activeTaskCompleted();
        }

        print_r($taskArray);
        $this->render('renderImages', array('activeTask' => $activeTask));
    }

    //Функция пересборки изображений 
    public function renderImageAgain($id, $elemId, $pictureId, $config) {


    }

}