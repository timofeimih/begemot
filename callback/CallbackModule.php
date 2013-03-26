<?php

class CallbackModule extends CWebModule
{
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

    public static function addMessage($title,$text,$group=''){
        $msg = new  Callback();
        $msg->title = $title;
        $msg->text = $text;
        $msg->group = $group;
        $msg->date = time();
        $msg->save();

    }


}
