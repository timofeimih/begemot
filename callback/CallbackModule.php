<?php

class CallbackModule extends CWebModule
{
    public $mails=array();

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'callback.models.*',
			'callback.components.*',
		));
	}

    public function beforeControllerAction($controller, $action) {
        if ($controller->id != 'site') {
            Yii::app()->getComponent('bootstrap');
        }
        return true;
    }

    public static function addMessage($title,$text,$group='',$sendMail=false){
        Yii::import('application.modules.callback.models.Callback');

        if ($sendMail){
            $mails = Yii::app()->getModule('callback')->mails;

            if (count($mails)>0){


                $headers = 'From: info@innoeco.com' . "\r\n" .
                    'Reply-To: scott2to@gmail.com' . "\r\n" .
                    'Content-type:text/html; charset = utf-8' . "\r\n".
                    'X-Mailer: PHP/' . phpversion();

                foreach ($mails as $mail){

                    mail($mail, $title, $text,$headers);
                }
            }
        }

        $msg = new  Callback();
        $msg->title = $title;
        $msg->text = $text;
        $msg->group = $group;
        $msg->date = time();
        $msg->save();





    }


}
