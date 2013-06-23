<?php

class PostModule extends CWebModule {

    static public $postLayout = 'application.views.layouts.postLayout';
    static public $postViewLayout = 'application.views.layouts.postViewLayout';

    public $tidyConfig = array(
        'imageTag'=>'admin'
    );

    //static public $catalogCategoryViewLayout = 'application.views.layouts.catalogCategoryViewLayout';
    //static public $catalogItemViewLayout = 'application.views.layouts.catalogItemViewLayout';

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'post.models.*',
            'post.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if ($controller->id != 'site') {
            Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

}
