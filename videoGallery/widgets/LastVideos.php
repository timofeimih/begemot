<?php

class LastVideos extends CWidget {
    
    public $limit = 3;
    
    public function run(){
        Yii::import('videoGallery.models.VideoGalleryVideo');
        $dataProvider = new CActiveDataProvider(
            'VideoGalleryVideo',
            array(
                'criteria' => array(
                    'order' => 'id desc',
                    'limit'=>'2',
                    'condition'=>'top=1'
                )
            )
        );
        $dataProvider->pagination=false;
        $this->render('lastVideo',array('videos'=>$dataProvider->getData()));
        
    }
    
}

?>
