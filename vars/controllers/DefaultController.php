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

        $varsArrayForGrid = array();

        foreach($varsArray as $id=>$var){
            $varItem = array();
            $varItem['id']=$id;
            $varItem['varname']=$var['varname'];
            $varItem['vardata']=$var['vardata'];
            $varsArrayForGrid[] = $varItem;
        }

        $gridDataProvider = new CArrayDataProvider($varsArrayForGrid);
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


                $data = VarsModule::getData();

                $dataItem = array();
                $dataItem['varname'] = $model->varname;
                $dataItem['vardata'] = $model->vardata;

                $data[] = $dataItem;
                VarsModule::setData($data);

                $this->redirect('/vars');
                return;
            }
        }

        $this->render('newVar', array('model' => $model));
    }

    public function actionDelete($id)
    {
        $data = VarsModule::getData();
        unset($data[$id]);
        VarsModule::setData($data);

    }

    public function actionUpdate($id)
    {

        $model = new NewVar();

        $model->loadModel($id);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form-update-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }


        if (isset($_POST['NewVar'])) {

            $model->attributes = $_POST['NewVar'];
            if ($model->validate()) {

                $model->saveModel();
            }
        }

        $this->render('update', array('model' => $model));
    }

}