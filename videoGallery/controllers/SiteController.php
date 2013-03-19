<?php
    	
class SiteController extends Controller
{
        public $layout='begemot.views.layouts.column2';
        

        
	public function actionIndex() {
		
                $this->layout = VideoGalleryModule::$galleryLayout;
                $cats = VideoGallery::model()->findAll();
                
		$this->render('index', array(
			'videoCats' => $cats,
		));
	}  
        
	public function actionGallery($gallId) {
		
                $this->layout = VideoGalleryModule::$galleryLayout;
                $cat = VideoGallery::model()->findByPk($gallId);

		$this->render('gallery', array(
			'cat' => $cat,
		));
	}           
}