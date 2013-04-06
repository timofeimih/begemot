<?php

class SeoWordController extends Controller
{

    public $layout='begemot.views.layouts.column1';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','changeGroup','csvUpload'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SeoWord;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SeoWord']))
		{
			$model->attributes=$_POST['SeoWord'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SeoWord']))
		{
			$model->attributes=$_POST['SeoWord'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SeoWord');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SeoWord('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SeoWord']))
			$model->attributes=$_GET['SeoWord'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionCsvUpload()
	{
            $model = new CsvForm();
            $form = new CForm('seo.models.csvFormData', $model);
            
            $csvOutput = '';
            
            if($form->submitted('CsvForm') && $form->validate()){

                $path = Yii::getPathOfAlias('webroot').'/files/csv.csv';
                file_put_contents($path, $model->csv);
                $row = 1;
                if (($handle = fopen($path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        $num = count(array_diff($data, array('')));
                        $csvOutput .= "<p> $num полей в строке $row: <br /></p>\n";
                        $row++;
                        for ($c=0; $c < $num; $c++) {
                            $csvOutput .= $data[$c] . "<br />\n";
                        }
                        
                        $word = new SeoWord();
                        $word->word = $data[0];
                        $word->weight = $data[1];
                        $word->group_id = $model->catId;
                        $word->save();
                    }
                    fclose($handle);
                }
            
                $this->render('csvUploaded', array('csv'=>$csvOutput));
            }
            else
                $this->render('csvUpload', array('form'=>$form));
	}

	public function actionChangeGroup($groupId)
	{

           if( Yii::app()->request->isAjaxRequest){
               if (is_array($_REQUEST['id'])){
                foreach($_REQUEST['id'] as $id){
                   $word = SeoWord::model()->findByPk($id);
                   $word->group_id = $groupId;
                   $word->save();
                }
               }else {
                   $word = SeoWord::model()->findByPk($_REQUEST['id']);
                   $word->group_id = $groupId;
                   $word->save();  
                 if(!isset($_REQUEST['ajax']))
                    $this->redirect(Yii::app()->request->urlReferrer);                   
               }

           }
        
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SeoWord::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='seo-word-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
