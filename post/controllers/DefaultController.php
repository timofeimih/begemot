<?php

class DefaultController extends Controller
{
    
    public $layout='begemot.views.layouts.column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','tagIndex'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout ='begemot.views.layouts.column2';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $model = new Posts;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex($tagId=null) {
         $this->layout ='begemot.views.layouts.column2';
        if ($tagId!=null){
             $criteria = new CDbCriteria(array(
                    'select' => '*',
                    'distinct' => true,
                    'condition'=>'tag_id = '.$tagId
                ));
        } else{
             $criteria = new CDbCriteria();   
        }

        $count = Posts::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $models = Posts::model()->findAll($criteria);



        $dataProvider = new CActiveDataProvider('Posts');
        $this->render('index', array(
            'models' => $models,
            'pages' => $pages
        ));
    }
    
    public function actionTagIndex($id=null) {
        $this->layout ='begemot.views.layouts.column2';
        if ($id!=null){
            
            $tag = PostsTags::model()->findByPk($id);
            $this->pageTitle = $tag->title_seo;
            
            if (isset($_GET['page'])){
               $this->pageTitle .= ' - страница '.$_GET['page'];
            }
            
            $criteria = new CDbCriteria(array(
                    'select' => '*',
                    'distinct' => true,
                    'condition'=>'tag_id = '.$id
                ));

        } else{
             $criteria = new CDbCriteria();   
        }

        $count = Posts::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $models = Posts::model()->findAll($criteria);



        $dataProvider = new CActiveDataProvider('Posts');
        $this->render('index', array(
            'models' => $models,
            'pages' => $pages
        ));
    }
    
    /**
     * Manages all models.
     */
    public function actionAdmin($tag_id=null) {
        
        echo $tag_id;
        
         $this->layout ='begemot.views.layouts.column2';
        $model = new Posts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Posts']))
            $model->attributes = $_GET['Posts'];

        $this->render('admin', array(
            'model' => $model,
            'tag_id'=>$tag_id,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Posts::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'posts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}