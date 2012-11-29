<?php

class PagesModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'pages.models.*',
			'pages.components.*',
	
		));
                Yii::app()->getComponent('bootstrap');
                
                
//                $urlManeger = Yii::app()->urlManager;
//
//
//                $urlRules = array(
//                    'posts1' => array('posts/index'),
//                );
//
//
//
//                $urlManeger->addRules($urlRules);
        
	}

	public function beforeControllerAction($controller, $action)
	{

		if(parent::beforeControllerAction($controller, $action))
		{

                        
			return true;
		}
		else
			return false;
	}
}
