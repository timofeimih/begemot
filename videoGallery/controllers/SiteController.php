<?php
    	
class SiteController extends Controller
{
        public $layout='begemot.views.layouts.column2';
        

        
	public function actionIndex() {

        $withArray = array(
            'videoGalleryVideos'=>array(
                'scopes'=>array(
                    // passing only one parameter
                    'published',
                ),
            ),
        );

        $this->layout = VideoGalleryModule::$galleryLayout;
        $cats = VideoGallery::model()->findAll(array('with'=>$withArray));
                
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