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
            'pictureBox.components.*'
        ));

    }

    public function beforeControllerAction($controller, $action) {

        if ($controller->id != 'site') {

            Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

}
