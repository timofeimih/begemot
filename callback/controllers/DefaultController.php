<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{

        CallbackModule::addMessage('111','222','333');
		$this->render('index');
	}
}