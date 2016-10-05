<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		$this->layout = '//layouts/withHead';
		$this->render('index');
	}

	public function actionSuccessPaypal()
	{

		$text = '';
		foreach ($_POST as $item => $value) {
			$text .= "{$item}: {$value} <br/> ";
		}
		//mail('timofeimih@gmail.com', 'ФОНД', $text);


		if (isset($_POST['item_name'])) {
			$model = new PaymentArchive;

			$data = json_decode($_POST['custom']);

			$model->from = $data->name;
			$model->account = $_POST['payer_email'];
			$model->to = $data->to;
			$model->sum = $_POST['mc_gross'];
			$model->way = 'paypal';
			$model->description = $data->description;
			$model->email = $data->email;

			$valid=$model->validate();            
            if($valid){

            	if ($model->save()) {
            		echo "Все валидно";
            		$this->changePriceOfCard($model->to, $model->sum);
            	};
            	
            }
            else{
                $error = CActiveForm::validate($model);
                if($error!='[]')
                    echo $error;
          
            }

			
		}
	}

	public function actionSuccessYandex()
	{

		//2DPv4Bx1FzxXtg2PnpX4rd6X

		$text = '';
		foreach ($_POST as $item => $value) {
			$text .= "{$item}: {$value} <br/> ";
		}
		//mail('timofeimih@gmail.com', 'ФОНД', $text);

		if (isset($_POST['sha1_hash'])) {
			$model = new PaymentArchive;

			$id = intval($_POST['label']);
			$description = CatItem::model()->findByPk($id);
			if ($desctiption) {
				$description = 'Пожертвование для ' . $desctiption->name;
			} else $description = 'Пожертвование';

			if ($_POST['notification_type'] == 'card-incoming') {
				$way = 'card';
				$_POST['sender'] = 'visa-card';
			} else $way = 'yandex';
			

			$model->from = 'Аноним';
			$model->account = $_POST['sender'];
			$model->to = $id;
			$model->sum = $_POST['amount'];
			$model->way = $way;
			$model->description = $description;
			$model->email = 'anonim@gmail.com';


			$valid=$model->validate();            
            if($valid){

            	if ($model->save()) {
            		echo "Все валидно";
            		$this->changePriceOfCard($model->to, $model->sum);
            	};
            	
            }
            else{
                $error = CActiveForm::validate($model);
                if($error!='[]')
                    echo $error;
          
            }

			
		}
	}

	public function actionSuccessWebmoney()
	{

		$text = '';
		foreach ($_POST as $item => $value) {
			$text .= "{$item}: {$value} <br/> ";
		}
		mail('timofeimih@gmail.com', 'ФОНД', $text);

		// $_POST['name'] ='timofei';
		// $_POST['LMI_PAYER_PURSE'] ='R435435435';
		// $_POST['LMI_PAYEE_PURSE'] ='R213231213123';
		// $_POST['LMI_PAYMENT_AMOUNT'] ='10.01';
		// $_POST['LMI_PAYMENT_DESC'] ='Русский текст';
		$model = new PaymentArchive;

		$description = CatItem::model()->findByPk(intval($_POST['to']));
		if ($desctiption) {
			$description = 'Пожертвование для ' . $desctiption->name;
		} else $description = 'Пожертвование';

		$model->from = $_POST['name'];
		$model->account = $_POST['LMI_PAYER_PURSE'];
		$model->to = $_POST['to'];
		$model->sum = $_POST['LMI_PAYMENT_AMOUNT'];
		$model->way = 'webmoney';
		$model->description = $description;
		$model->email = $_POST['email'];


		$valid=$model->validate();            
        if($valid){

        	if ($model->save()) {
        		echo "Все валидно";
        		$this->changePriceOfCard($model->to, $model->sum);
        	};
        	
        }
        else{
            $error = CActiveForm::validate($model);
            if($error!='[]')
                echo $error;
      
        }
		
	
		echo 'ok';
	}

	public function actionSuccess()
	{

		$text = 'post';
		foreach ($_POST as $item => $value) {
			$text .= "{$item}: {$value} <br/> ";
		}

		$text .= "get";
		foreach ($_GET as $item => $value) {
			$text .= "{$item}: {$value} <br/> ";
		}
		//mail('timofeimih@gmail.com', 'ФОНД', $text);

		$this->layout = '//layouts/withHead';
		$this->render("success");
	}

	public function actionFail()
	{
		$this->layout = '//layouts/withHead';
		$this->render('fail');
	}

	private function changePriceOfCard($id, $price){
		$model = CatItem::model()->findByPk($id);

		$model->ostalos_sobrat = str_replace(' ', '', $model->ostalos_sobrat);
		$model->ostalos_sobrat = $model->ostalos_sobrat - $price;


		$this->addToSobrano($price);

		$model->save();
	}


	private function addToSobrano($price){
		$model = CatItem::model()->findByPk(23);
		$model->price += intval($price);
		$model->save();
	}

	public function actionStatistics()
	{
		$models = PaymentArchive::model()->with("item")->findAll(array('order'=>'t.date DESC'));



		$this->layout = '//layouts/withHead';

		$this->render('statistics', array('models' => $models));
	}

	public function actionDonate($id)
	{

		Yii::import('application.modules.catalog.models.CatItem');

        $criteria = new CDbCriteria;

        $criteria->select = '`t`.`itemId`';
        $criteria->condition = '`t`.`catId` in (98, 84)'; 
        
        $criteria->with = array(
            'item'=>array(
                'condition'=>'published=1'
            )
        ); 
        $criteria->group = 'item.id';
        $criteria->distinct = True;
        $criteria->order = 'item.top DESC, t.order ASC';

        $dataProvider = new CActiveDataProvider('CatItemsToCat', array('criteria' => $criteria,'pagination' => array('pageSize'=>100000)));


		if (!$dataProvider) {
			throw new Exception("Error Processing Request", 1);
		}

		$this->layout = '//layouts/withHead';

		$this->render('donate', array('selectedId' => $id, 'cards' => $dataProvider->getData()));
	}

}