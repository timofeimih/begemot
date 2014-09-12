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
			
			echo $CrontabBase->changeTime($_POST['name'], (int) $_POST['time']);

			
		}
	}

	public function actionSyncCard()
	{
		$model = new ParsersLinking;

		$return = array('code'=> true, 'toUpdate' => '', 'toAllLinks' => '');

		if(isset($_POST['ParsersLinking']))
		{
			$model->attributes=$_POST['ParsersLinking'];

			if($model->save()){

				$stockModel = ParsersStock::model()->findByPk($_POST['ParsersLinking']['fromId']);
				$stockModel->linked = 1;
				$stockModel->save();

				if ($model->linking->price != $model->item->price || $model->linking->quantity != $model->item->quantity) {
					$return['toUpdate'] = $this->renderPartial('oneItem',array(
						'item'=>$model,
					), true);
				}
				

				$return['toAllLinks'] = $this->renderPartial('oneItemLinking',array(
					'item'=>$model,
				), true);
			}
				
		}


		ob_clean();
		echo json_encode($return);


	}

	public function actionGetParsedForCatItem($itemId, $file)
	{
		$catItems = CatItem::model()->findByPk($itemId);

		$this->renderPartial('listForCatItems',array(

		 	'itemList' => ParsersStock::model()->findAllByAttributes(array('filename' => $file, 'linked' => 0)),
		 	'itemId' => $itemId
		));
	}

	public function actionUpdateCard()
	{

		if (isset($_POST['id'])) {
			
			$model = CatItem::model()->findByPk($_POST['id']);
			$model->price = $_POST['price'];
			$model->quantity = $_POST['quantity'];

			ob_clean();
			if ($model->save()) {
				echo "1";
			}
			else{
				echo "0";
			}
		}
	}

	public function actionCron()
	{
		$cron = new ParseBase();
	 	
	 	if (isset($_GET['createNew'])) {

	 		$cron->addJob($_GET['filename'], intval($_GET['time']));
	 	}

	 	if (isset($_GET['deleteJob'])) {
	 		$cron->removeJob($_GET['deleteJob']);

	 	}


	 	

		$this->render('cron',array(
		 	'jobs_obj' => $cron->getListJob(),
		 	'files' => $this->getFiles(),
		 	'cron' => $cron,
		 ));
	}

	public function actionDoChecked()
	{
		
		if(isset($_POST['item'])){
			foreach ($_POST['item'] as $item) {
				if (isset($item['id'])) {
					$model = CatItem::model()->findByPk($item['id']);
					$model->price = $item['price'];
					$model->quantity = $item['quantity'];
					$model->save();
				}
			}
		}

		$this->redirect($_POST['url']);
	}

	public function actionParseNew()
	{
		$json = file_get_contents('http://'.$_SERVER['HTTP_HOST'] . "/parsers/" . $_GET['file'] . "?newDate"); 
		$json = json_decode($json);

		ParsersStock::model()->deleteAll(array('condition' => "`filename`='" . $json->name . "'"));

		$length = count($json->items);

		foreach ($json->items as $item) {
			$new = new ParsersStock;
			$item = (array)$item;
			$item['filename'] = $json->name;
			$item['name'] = substr($item['name'], 0, 99);

			if (ParsersLinking::model()->find(array(
				'condition'=>'fromId=:fromId',
    			'params'=>array(':fromId'=>$item['id'])))
			) {
				$item['linked'] = 1;
			}

			$new->attributes = $item;
			
			$new->save();
		}
		ob_clean();
		echo date("d.m.Y H:i", $json->time);

	}

	public function actionDo($file)
	{	

		$catItems = CatItem::model()->findAll(array('order' => 'name ASC'));

		$itemList = array(
			'combined' => ParsersLinking::model()->findAllByAttributes(array('filename' => $file), array('order' => 'id ASC')), 
			'combinedAndChanged' => array(),
			'notCombined' => ParsersStock::model()->findAllByAttributes(array('filename' => $file, 'linked' => 0), array('order' => 'id ASC')), 
		);

		if ($itemList['combined']) {
			foreach ($itemList['combined'] as $item) {
				if ($item->linking->price != $item->item->price || $item->linking->quantity != $item->item->quantity) {
				 	$itemList['combinedAndChanged'][] = $item;
				}
			}

		}
		
		

		 $this->render('do',array(
		 	// 'models'=>$models,
		 	// 'return' => $return,
		 	'filename' => $file,
		 	'itemList' => $itemList,
		 	'allItems' => $catItems
		 ));
                       
	}


	public function getFiles()
	{
		$fileListOfDirectory = array ();
		$pathTofileListDirectory = Yii::app()->basePath.'/../parsers' ;

		$tempfile = file_get_contents($pathTofileListDirectory . '/history/time.txt');
        $timeArray = json_decode($tempfile);
        $timeArray = (array)$timeArray;


		if(!is_dir($pathTofileListDirectory ))
		{
		    die(" Invalid Directory");
		}

		if(!is_readable($pathTofileListDirectory ))
		{
		    die("You don't have permission to read Directory");
		}

		foreach ( new DirectoryIterator ( $pathTofileListDirectory ) as $file ) {
		    if ($file->isFile () === TRUE && $file->getBasename () !== '.DS_Store') {

		        if ($file->getExtension () == "php") {

		        	$time = 0;

		        	if (array_key_exists($file->getBasename(), $timeArray)) {
		        		$time = $timeArray[$file->getBasename()];
		        	}
		            array_push ( $fileListOfDirectory, array('name' => $file->getBasename(), 'time' => $time) );
		        }
		    }
		}

		return $fileListOfDirectory;
	}

	public function actionDeleteLinking($id)
	{
		$model=ParsersLinking::model()->findByPk($id);

		$stockModel = ParsersStock::model()->findByPk($model->fromId);
		$stockModel->linked = 0;
		$stockModel->save();


		ob_clean();
		if ($model->delete()) {
			echo "1";
		} 
		else{
			echo "0";
		}

	}

}