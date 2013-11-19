<?php

class DefaultController extends Controller
{
    public $layout = 'begemot.views.layouts.column2';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(

            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'newVar', 'delete', 'update'),
                'expression' => 'Yii::app()->user->canDo("")'
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {

        $varsArray = VarsModule::getData();

        $gridDataProvider = new CArrayDataProvider($varsArray);
        $gridDataProvider->pagination = array('pageSize' => 20);

        $this->render('index', array('data' => $gridDataProvider));
    }

    public function actionNewVar()
    {
        $model = new NewVar();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'new-file-test-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }


        if (isset($_POST['NewVar'])) {
            $model->attributes = $_POST['NewVar'];
            if ($model->validate()) {

                $dataPath = $this->getDataDir();

                $webroot = Yii::getPathOfAlias('webroot');
                $file = fopen($dataPath . '/' . $model->filename . '.php', 'w');
                fclose($file);


                $this->redirect('/pages');
                return;
            }
        }

        $this->render('newVar', array('model' => $model));
    }

    public function actionDelete($file)
    {
        $file = str_replace("*", "/", $file);

        unlink($file . '.php');
    }

    public function actionUpdate($file)
    {

        $model = new updateForm($file . '.php');


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form-update-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }


        if (isset($_POST['updateForm'])) {

            $model->attributes = $_POST['updateForm'];
            if ($model->validate()) {
                $model->saveFile();

            }
        }
        $this->render('update', array('model' => $model));
    }

}