<?php

Yii::import('application.modules.videoGallery.models._base.BaseVideoGallery');

class VideoGallery extends BaseVideoGallery
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
            if ($this->isNewRecord) {   
                $this->name_t = $this->mb_transliterate($this->name);
                return true;
            } else {
                $this->name_t = $this->mb_transliterate($this->name);
                return true;
            }
        }
        
}