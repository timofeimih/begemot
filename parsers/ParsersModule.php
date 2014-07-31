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
            'crontabs.components.CrontabBase'
<<<<<<< HEAD
=======
            'begemot.commands.ParseBase'
>>>>>>> Парсер и мелкие правки
=======
            'crontabs.components.CrontabBase'
>>>>>>> Парсер и планировщик
=======
>>>>>>> подчистил косяки с конфликтами
        ));

    }

    public function beforeControllerAction($controller, $action) {

        if ($controller->id != 'site') {

            Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

}
