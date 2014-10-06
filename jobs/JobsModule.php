<?php

class JobsModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components

         $imports;
        foreach(glob(Yii::app()->basePath . "/modules/*", GLOB_ONLYDIR) as $path) {    

            if(file_exists($path)){
                if(file_exists($path . "/jobs")){
                    Yii::import(basename($path) . ".jobs.*");
                }
            }
            
        } 


        $this->setImport(array(
        	'jobs.components.*',
        ));

    }

    public function beforeControllerAction($controller, $action) {
        
        if ($controller->id != 'site') {

           Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

}
