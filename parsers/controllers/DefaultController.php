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
				'actions'=>array('linking', 'create','update','index','view', 'do', 'syncCard', 'updateCard', 'doChecked', 'deleteLinking', 'parseChecked', 'parseNew'),
                'expression'=>'Yii::app()->user->canDo("")'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionParseChecked()
	{
		$files = $_GET['parse'];
		$items = array();

		foreach ($files as $file) {

			$items = array_merge((array)$items, (array)$this->getItemsToDo($file, 'combinedAndChanged'));
		}

		$this->render('parseChecked',array(
		 	'items' => $items,
		 ));

	}

	public function actionSyncCard()
	{
		$newPrice = $_POST['price'];
		$name = $_POST['name'];

		$model = new ParsersStock;

		$return = array('code'=> true, 'toUpdate' => '', 'toAllLinks' => '');

		if(isset($_POST['ParsersStock']))
		{
			$model->attributes=$_POST['ParsersStock'];
			if($model->save()){

				if ($model->item->price != $newPrice) {
					$return['toUpdate'] = $this->renderPartial('oneItem',array(
						'item'=>$model,
						'newPrice' => $newPrice,
						'name' => $name
					), true);
				}
				

				$return['toAllLinks'] = $this->renderPartial('oneItemLinking',array(
					'item'=>$model,
					'name' => $name
				), true);
			}
				
		}



		echo json_encode($return);


	}

	public function actionUpdateCard()
	{

		if (isset($_POST['id'])) {
			
			$model = CatItem::model()->findByPk($_POST['id']);
			$model->price = $_POST['price'];
			$model->quantity = $_POST['quantity'];
			if ($model->save()) {
				echo "1";
			}
			else{
				echo "0";
			}
		}
	}

	public function actionDoChecked()
	{
		
		if(isset($_POST['item'])){
			foreach ($_POST['item'] as $item) {
				if (isset($item['id'])) {
					$model = CatItem::model()->findByPk($item['id']);
					$model->price = $item['price'];
					$model->save();
				}
			}
		}

		$this->redirect($_POST['url']);
	}

	public function actionParseNew()
	{
		$json = file_get_contents('http://'.$_SERVER['HTTP_HOST'] . "/parsers/library/parseFile.php?file=" . $file . "&parseNew=1"); 
		if ($json != "") {
			echo "1";
		}

	}

	public function actionDo($file)
	{	

		$catItems = CatItem::model()->findAll(array('order' => 'name ASC'));

		

		 $this->render('do',array(
		 	// 'models'=>$models,
		 	// 'return' => $return,
		 	'filename' => $file,
		 	'itemList' => $this->getItemsToDo($file),
		 	'allItems' => $catItems
		 ));
                       
	}

	public function actionLinking()
	{

		$model = ParsersStock::model()->findAll(array('order' => 'id DESC'));

		 $this->render('linking',array(

		 	'items' => $model
		 ));
	}

	public function getItemsToDo($file, $param = '0')
	{

		$json = file_get_contents('http://'.$_SERVER['HTTP_HOST'] . "/parsers/library/parseFile.php?file=" . $file . "&parseNew=" . $param); 
		$json = json_decode($json);

		$itemList = array('combined' => array(), 'notCombined' => array(), 'combinedAndChanged' => array());


		foreach ($json as $item) {
			$finded = ParsersStock::model()->with('item')->find(array('condition' => "t.fromId='". $item->id . "'"));


			if ($finded) {
				$to = array('id' => '', 'fromId' => '', 'name' => '', 'itemName' => '');
				$to['id'] = $finded->id;
				$to['fromId'] = $finded->fromId;
				$to['name'] = $item->name;
				$to['itemName'] = $finded->item->name;
				$to = (object) $to;
				$itemList['combined'][] = $to;

				if ($finded->item->price != $item->price) {

					
					$item = (array) $item;
					$item['id'] = $finded->id;
					$item['itemId'] = $finded->item->id;
					$item['fromId'] = $finded->fromId;
					$item['oldPrice'] = $finded->item->price;
					$item = (object) $item;
					$itemList['combinedAndChanged'][] = $item;
				}
				
			} else{
				$findedByArticle = CatItem::model()->find(array('condition' => "article='". $item->id . "'"));

				if ($findedByArticle) {
					$item = (array) $item;
					$item['findedByArticle'] = $findedByArticle->id;
					$item = (object) $item;
				}
				$itemList['notCombined'][] = $item;
			}
		}

		if ($param == 'combinedAndChanged') {
			return $itemList['combinedAndChanged'];
		}

		return $itemList;
	}

	public function actionIndex()
	{	

		$fileListOfDirectory = array ();
		$pathTofileListDirectory = Yii::app()->basePath.'/../parsers' ;

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
		            array_push ( $fileListOfDirectory, $file->getBasename () );
		        }
		    }
		}
		

		$this->render('index',array(
			// 'models'=>$models,
			// 'return' => $return,
			'fileListOfDirectory' => $fileListOfDirectory
		));
                       
	}

	public function actionDeleteLinking($id)
	{
		$model=ParsersStock::model()->findByPk($id);
		if ($model->delete()) {
			echo "1";
		} 
		else{
			echo "0";
		}

	}

}