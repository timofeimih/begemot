<?php

class DefaultController extends Controller
{
    	public $layout='begemot.views.layouts.column2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index', 'turnOnOff', 'changeTime'),
                'expression'=>'Yii::app()->user->canDo("")'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$crons = new CrontabBase();

		$this->render('index',array(
		 	'itemList' => (array) $crons->getListJob(),
		 ));

	}

	public function actionTurnOnOff()
	{
		if (isset($_POST['name']) AND isset($_POST['turn'])) {

			$CrontabBase = new CrontabBase;
			if ($_POST['turn'] == 1) {
				$CrontabBase->turnOn($_POST['name']);
			} else{
				$CrontabBase->turnOff($_POST['name']);
			}

			echo "1";
		}


	}

	public function actionChangeTime()
	{
		if (isset($_POST['time']) AND isset($_POST['name'])) {

			$CrontabBase = new CrontabBase;
			
			echo $CrontabBase->changeTime($_POST['name'], (int) $_POST['time'], (int) $_POST['hour']);

			
		}
	}


}