<?php

class ParsersModule extends CWebModule {

    static public $galleryLayout = 'application.views.layouts.galleryLayout';

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
        	'parsers.components.*',
            'parsers.models.*',
            'catalog.models.CatItem',
<<<<<<< HEAD
<<<<<<< HEAD
            'crontabs.components.CrontabBase'
=======
            'begemot.commands.ParseBase'
>>>>>>> 48ebd67b1e3736a0807868177cda7b80ee2334c7
=======
            'crontabs.components.CrontabBase'
>>>>>>> 54087355c3ea62ec0af894855a004786a2ff8558
        ));

    }

    public function beforeControllerAction($controller, $action) {
        
        if ($controller->id != 'site') {

           Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

}
