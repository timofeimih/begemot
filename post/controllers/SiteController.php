<?php

class SiteController extends Controller
{
    
    public $layout='begemot.views.layouts.column2';





    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
              $this->layout = PostModule::$postViewLayout;
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    /**
     * Lists all models.
     */
    public function actionIndex($tagId=null) {

        $this->layout = PostModule::$postLayout;
        
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
            'pages' => $pages,
    
        ));

    }
    
    public function actionTagIndex($id=null) {
        $this->layout = PostModule::$postLayout;
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
            'pages' => $pages,
            'tag_id'=>$id,
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