<?php

$modulePath = Yii::getPathOfAlias('application.modules.elfinder.php');
include_once $modulePath.DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once $modulePath.DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once $modulePath.DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once $modulePath.DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';

function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}


class DefaultController extends Controller
{
        public $layout='begemot.views.layouts.column1';
        
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('connector','index','cke'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
                Yii::app()->getComponent('bootstrap');
            //  $this->layout = 'clear';
		$this->render('iframe');
	}
        

        
	public function actionCke()
	{
            $this->layout = 'clear';
   
            $this->render('_CKEditor');
	}
        
        public function actionConnector()
	{
            $opts = array(
                        // 'debug' => true,
                        'roots' => array(
                                array(
                                        'mimeDetect' => "internal",
                                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                                        'path'          => Yii::getPathOfAlias('webroot').'/',         // path to files (REQUIRED)
                                        'URL'           => 'http://'.$_SERVER['SERVER_NAME'], // URL to files (REQUIRED)
                                        'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
                              
                                )
                        )
                );

            
            $elfinder = new elFinder($opts);
            $connector = new elFinderConnector($elfinder);
            $connector->run();
	}
}
