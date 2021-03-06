<?php

/**
 * This is the model base class for the table "video_gallery".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "VideoGallery".
 *
 * Columns in table "video_gallery" available as properties of the model,
 * followed by relations of table "video_gallery" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $name_t
 * @property string $text
 * @property integer $order
 * @property string $seo_title
 *
 * @property VideoGalleryVideo[] $videoGalleryVideos
 */
abstract class BaseVideoGallery extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'video_gallery';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'VideoGallery|VideoGalleries', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
                  
                    	array('text, order, seo_title', 'safe'),
			array('order', 'numerical', 'integerOnly'=>true),
			array('name, name_t, seo_title', 'length', 'max'=>255),
			array('id, name, name_t, text, order, seo_title', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'videoGalleryVideos' => array(self::HAS_MANY, 'VideoGalleryVideo', 'gallery_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'name_t' => Yii::t('app', 'Name T'),
			'text' => Yii::t('app', 'Text'),
			'order' => Yii::t('app', 'Order'),
			'seo_title' => Yii::t('app', 'Seo Title'),
			'videoGalleryVideos' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('name_t', $this->name_t, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('order', $this->order);
		$criteria->compare('seo_title', $this->seo_title, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}