<?php

class DefaultController extends Controller
{
    public $layout='begemot.views.layouts.column2';
    
    public function actions()
    {
        return array(

            'fileManager'=>array(
                'class'=>'begemot.extensions.elfinder.ElFinderAction',
            ),
        );
    }


	public function actionIndex()
	{
		$this->render('index');
	}
}