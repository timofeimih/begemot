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
                'actions'=>array('linking', 'create','update','index','view', 'do', 'syncCard', 'updateCard', 'doChecked', 'deleteLinking', 'parseChecked', 'parseNew', 'getParsedForCatItem', 'cron'),
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
        $finded = ParsersLinking::model()->findAllByAttributes(array('filename'=>$files));
        $items = array();

        foreach ($finded as $item) {
            if ($item->linking->price != $item->item->price || $item->linking->quantity != $item->item->quantity) {
                $items[] = $item;
            }
        }
        $this->render('parseChecked',array(
            'items' => $items,
        ));

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

    public function actionParseNew($className)
    {   

        $class = new $className;
        $class->runJob();
        $json = $class->getLastParsedData();

        ParsersStock::model()->deleteAll(array('condition' => "`filename`='" . $class->getName() . "'"));
        
    
        foreach ($json['items'] as $item) {
            $new = new ParsersStock;
            $item = (array)$item;
            $item['filename'] = $json['name'];
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

        $tempfile = require(dirname(Yii::app()->request->scriptFile) . "/files/parsersData/time.txt");


        echo date("d.m.Y H:i", $tempfile[$class->getName()]);


    }

    public function actionDo($file, $tab = 'changed')
    {

        
        $catItems = array();
        $itemList = array();

        
        if ($tab == 'allSynched') {
            $itemList = ParsersLinking::model()->findAllByAttributes(array('filename' => $file), array('order' => 'id ASC'));

        }

        if ($tab == 'changed') {
            $combined = ParsersLinking::model()->findAllByAttributes(array('filename' => $file), array('order' => 'id ASC'));

            if ($combined) {
                foreach ($combined as $item) {
                    if ($item->linking) {
                        if ($item->linking->price != $item->item->price || $item->linking->quantity != $item->item->quantity) {
                            $itemList[] = $item;
                        }
                    }
                    
                }

            }
        }

        if ($tab == 'new' | $tab == 'newWithId') {
            $parserLinkingIds = ParsersLinking::model()->findAll();

            $iDsArray = array();
            foreach ($parserLinkingIds as $parserData) {
                $iDsArray[] = $parserData['toId'];
            }

            $criteria = new CDbCriteria();
            $criteria->addNotInCondition("id", $iDsArray);
            $criteria->order = 'name ASC';

            $catItems = CatItem::model()->findAll($criteria);
        }

        if ($tab == 'new') {

            $itemList = new ParsersStock;

            $itemList->filename = $file;
            $itemList->linked = 0;
            $itemList->ids = array();

            
           
        }

        if ($tab == 'newWithId') {

            $ids = array();
            foreach ($catItems as $item) {
                if ($item->article != '') {
                    $ids[] = $item->article;
                }
    
            }

            if (!$ids) {
                $ids = ["none"];
            }

            // print_r($ids);
            // return;

            $itemList = new ParsersStock;

            $itemList->filename = $file;
            $itemList->linked = 0;
            $itemList->ids = $ids;


        }

        if ($tab == 'allSynched') {
            $itemList = new ParsersLinking;

            $itemList->filename = $file;
        }

        if (isset($_GET['ParsersStock']))
                $itemList->Attributes = $_GET['ParsersStock'];




        $this->render('do',array(
            // 'models'=>$models,
            // 'return' => $return,
            'filename' => $file,
            'itemList' => $itemList,
            'allItems' => $catItems,
            'tab' => $tab
        ));

    }

    public function deteleLinkingButton($data)
    {
        return "<input type='button' value='Удалить связь' data-id='{$data->id}' class='deleteLinking btn'>";
    }

    public function getSyncButtons($data, $row){
        $return = "<button type='button'  data-filename='{$data->filename}' class='composite btn btn-info' name='{$data->name}'>Объединить с ...</button>";
        if ($data->findedByArticle()){
            $return .= "<form action='/parsers/default/syncCard' data-removeAfter='.item-{$data->id}' class='ajaxSubmit'>
                <input type='hidden' name='ParsersLinking[fromId]' id='name' value='{$data->id}'><br/>
                <input type='hidden' name='ParsersLinking[toId]' id='itemId' value='{$data->findedByArticle()}' >
                <input type='hidden' name='ParsersLinking[filename]' id='itemId' value='{$data->filename}' >
                <button type='submit' class='compositeRightNow btn btn-primary' data-id='{$data->findedByArticle()}' title=''>Привязать сразу по артиклю к (<a style='color:white;text-decoration:underline' href='" . $this->createUrl('/catalog/catItem/update', array('id' => $data->findedByArticle() )) . "'>{$data->findedByArticle()}</a>)</button></td>
            </form>"; 

        }

        return $return;
    }

    public function getAddAsNewButton($data){ 
        return '<button type="button" class="addAsNew" data-filename="{$data->filename}" data-id="{$data->id}" price="{$data->price}" name="{$data->name}" text="{$data->text}">Добавить как новый</button>';
    }

    public function actionLinking()
    {

        $model = ParsersLinking::model()->findAll(array('order' => 'id DESC'));

        $this->render('linking',array(

            'items' => $model
        ));
    }

    public function actionIndex()
    {

        $timeFile = require(Yii::app()->basePath.'/../files/parsersData/time.txt');

        $this->render('index',array(
            // 'models'=>$models,
            // 'return' => $return,
            'fileListOfDirectory' => $this->getFiles(),

            'timeArray' => $timeFile
        ));

    }

    public function getFiles()
    {
        $fileListOfDirectory = array();
        $timeArray = array();


        $parserDataDir = Yii::getPathOfAlias('webroot').'/files/parsersData/';
        $parserTimeFile = $parserDataDir.'time.txt';

        if ( ! is_writable($parserDataDir)) {
            throw new Exception($parserDataDir. "не может быть изменена. Недостаточно прав", 503);
            
        }



        if ( ! file_exists($parserTimeFile)) {

            $myfile = fopen($parserTimeFile, "w");
            fclose($myfile);

            PictureBox::crPhpArr(array(), $parserTimeFile);
        }
        
        if (file_exists($parserTimeFile)) {
            $timeArray = require($parserTimeFile);
        }


        foreach(glob(Yii::app()->basePath.'/jobs/*ParserJob.php') as $path) {  



            $className = basename($path);
            $className = str_replace('.php', '', $className);
            $class = new $className;


            $time = '';

            foreach ($timeArray as $key => $value) {

                if ($key == $class->getName()){
                   $time = date("d.m.Y H:i", $value) ."<br/>";

                   break;
                    
                } else{
                    $time = "Еще не выполнялась<br/>";
                }
            }


            array_push ( $fileListOfDirectory, array('name' => $class->getName(), 'time' => $time, 'className' => $className) );
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
