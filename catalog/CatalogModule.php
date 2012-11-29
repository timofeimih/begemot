<?php

class CatalogModule extends CWebModule
{   
        static public $catalogLayout = 'application.views.layouts.catalogLayout';
        static public $catalogCategoryViewLayout = 'application.views.layouts.catalogCategoryViewLayout';
        static public $catalogItemViewLayout = 'application.views.layouts.catalogItemViewLayout';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'catalog.models.*',
			'catalog.components.*',
		));
                 Yii::app()->getComponent('bootstrap');                
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
