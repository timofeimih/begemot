<?php

Yii::import('application.modules.videoGallery.models._base.BaseVideoGalleryVideo');

class VideoGalleryVideo extends BaseVideoGalleryVideo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        public function behaviors() {
            return array(
            'SlugBehavior' => array(
                'class' => 'begemot.extensions.SlugBehavior',
            ));
        }
        
        public function beforeSave() {
            parent::beforeSave();
            if ($this->isNewRecord) {   
                $this->title_t = $this->mb_transliterate($this->title);
                return true;
            } else {
                $this->title_t = $this->mb_transliterate($this->title);
                return true;
            }
        }        
}