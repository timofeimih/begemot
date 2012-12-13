<?php

class DefaultController extends Controller
{
    public $layout='begemot.views.layouts.column2';
    
    public function actions()
    {
        return array(

            'fileManager'=>array(
                'class'=>'begemot.extensions.elfinder.ElFinderAction',
            ),
        );
    }


	public function actionIndex()
	{
		$this->render('index');
	}
        
	public function actionLogin()
	{
		$model=new BegemotLoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['BegemotLoginForm']))
		{
			$model->attributes=$_POST['BegemotLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('index',array('model'=>$model));
	}     
        
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('/begemot');
	}        
        
}