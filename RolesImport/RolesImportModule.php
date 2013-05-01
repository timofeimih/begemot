<?php

class RolesImportModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'RolesImport.models.*',
			'RolesImport.components.*',
		));

        Yii::app()->getComponent('bootstrap');
        Yii::app()->theme = 'bootstrap';

        $webroot = Yii::getPathOfAlias('webroot');

        if (!file_exists($webroot.'/files/RolesImport/')){
                //die($webroot.'/files/RolesImport/');
                mkdir($webroot.'/files/RolesImport/',777);
        }

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
