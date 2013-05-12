<?php
/**
 * Created by JetBrains PhpStorm.
 * User: anton
 * Date: 12.05.13
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

class HTMLAction extends  CViewAction{

    public function run()
    {

        $dataDirPath = Yii::getPathOfAlias('webroot').'/protected/views/site/pages/';
        $dataPath = $dataDirPath.'data/';
        $dataFilePath = $dataPath.md5('./protected/views/site/pages/'.$this->getRequestedView().'.php').'.data';

        if (file_exists($dataFilePath)){
            $data = require($dataFilePath);

            Yii::app()->controller->pageTitle =$data['seoTitle'];
        }

        $this->resolveView($this->getRequestedView());

        $controller=$this->getController();
        if($this->layout!==null)
        {
            $layout=$controller->layout;
            $controller->layout=$this->layout;
        }

        $this->onBeforeRender($event=new CEvent($this));
        if(!$event->handled)
        {
            if($this->renderAsText)
            {
                $text=file_get_contents($controller->getViewFile($this->view));
                $controller->renderText($text);
            }
            else
                $controller->render($this->view);
            $this->onAfterRender(new CEvent($this));
        }

        if($this->layout!==null)
            $controller->layout=$layout;
    }

}