<?php
/**
 * CAuthorBehavior class file.
 *
 * @author Piskunov Anton
 */

 /**
 * CAuthorBehavior will automatically fill author id.
 *
 */

class CAuthorBehavior extends CActiveRecordBehavior {
	
	/**
	* @var mixed The name of the attribute to store the author user ID.  Defaults to 'authorId'
	*/
	public $authorIdAttribute = 'authorId';


	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the author user ID attribute
	*
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event) {
		if ($this->getOwner()->getIsNewRecord()){
			if (isset(Yii::app()->user->id) && Yii::app()->user->id!==null){
				$this->owner->{$this->authorIdAttribute} = Yii::app()->user->id;
			}
		}
	}

}