<?php

class SiteController extends Controller {

//    public function filters() {
//        return array(
//            array(
//                'COutputCache + index',
//                'duration' => 60,
//             //   'varyByParam' => array('id'),
//            ),
//        );
//    }

    public function actionIndex() {
        $this->layout = CatalogModule::$catalogLayout;

        $categories = CatCategory::model()->findAll(array('condition' => 'level = 0', 'order' => '`order`'));

        $this->render('index', array('categories' => $categories));
    }

    public function actionItemView($catId = 0, $item = 0) {

        $uri = $_SERVER['REQUEST_URI'];

        $this->layout = CatalogModule::$catalogItemViewLayout;
        $item = CatItem::model()->findByPk($item);
        $category = CatCategory::model()->findByPk($item->catId);


        $hrefParams = array(
            'title'=>$category->name_t,
            'catId'=>$category->id,
            'itemName'=>$item->name_t,
            'item'=>$item->id,
        );

        $itemHref =  Yii::app()->urlManager->createUrl('catalog/site/itemView',$hrefParams);

        if ($itemHref!==$uri)
        {

            $this->redirect($itemHref, true, 301);
        }

        $this->render('itemView', array('item' => $item, 'category' => $category));
    }

    public function actionCategoryView($catId = 0) {


      
        $this->layout = CatalogModule::$catalogCategoryViewLayout;

        $category = CatCategory::model()->findByPk($catId);

        $dataProvider = new CActiveDataProvider('CatItemsToCat', array('criteria' => array('select' => 't.itemId', 'condition' => '`t`.`catId` = ' . $catId . '', 'with' =>array( 'item'=>array('condition'=>'published=1')), 'order' => 't.order'),'pagination'=>array( 'pageSize'=>1000)));
       // $dataProvider=CatItemsToCat::model()->published()->with('item')->findAll();
        $this->render('categoryView', array('categoryItems' => $dataProvider->getData(), 'category' => $category));
    }

    public function actionRCategoryView($catId = 0) {
        
        $this->layout = CatalogModule::$catalogCategoryViewLayout;

        $category = CatCategory::model()->findByPk($catId);

        $catsIDs = $category->getAllCatChilds($catId);

        $iDsArray = array($catId);
        foreach ($catsIDs as $catData) {
            $iDsArray[] = $catData['id'];
        }

        $iDsStr = '(' . implode(',', $iDsArray) . ')';

        $items = CatItemsToCat::model()->findAll(array('condition' => '`catId` in ' . $iDsStr));
        $dataProvider = new CActiveDataProvider('CatItemsToCat', array('criteria' => array('select' => 't.itemId', 'condition' => '`t`.`catId` in ' . $iDsStr . '', 'with' => 'item', 'order' => 't.order', 'distinct' => true, 'group')));

        $this->render('categoryView', array('categoryItems' => $dataProvider->getData()));
    }

    public function actionBuy ($itemId){
        Yii::import('catalog.models.forms.BuyForm');
        $buyFormModel = new BuyForm();

        $this->layout = CatalogModule::$catalogCategoryViewLayout;

        $item = CatItem::model()->findByPk($itemId);

        if(isset($_POST['BuyForm'])){

            $buyFormModel->attributes = $_POST['BuyForm'];
            if ($buyFormModel->validate()){
            //отправка сообщения
                Yii::import('application.modules.callback.CallbackModule');

                $msg =
                    $buyFormModel->name.'<br>'.
                    $buyFormModel->phone.'<br>'.
                    $buyFormModel->name.'<br>'.
                    $buyFormModel->count.'<br>'.
                    $buyFormModel->eMail.'<br>'.
                    $buyFormModel->msg.'
                    ';

                CallbackModule::addMessage('innoeco.ru - заказ',$msg,'order',true);
                $this->render('buyOk',array('id'=>$itemId,'item'=>$item,'buyFormModel'=>$buyFormModel));
            }

        }




        $this->render('buy',array('id'=>$itemId,'item'=>$item,'buyFormModel'=>$buyFormModel));
    }

}