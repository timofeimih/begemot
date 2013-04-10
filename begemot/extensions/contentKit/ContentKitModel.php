<?php
/**
 * Created by JetBrains PhpStorm.
 * User: anton
 * Date: 4/1/13
 * Time: 4:31 PM
 * To change this template use File | Settings | File Templates.
 */

class ContentKitModel extends CActiveRecord {

    public function scopes(){
        return
            array(
                'published' => array(
                    'condition' => 'published=1',
                ),
                'ordered' => array(
                    'order' => '`order`'
                )
            );
    }


    public function behaviors(){
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ),
            'CAuthorBehavior' => array('class' => 'begemot.extensions.contentKit.behavior.CAuthorBehavior',),
            'CBOrderModelBehavior' => array('class' => 'begemot.extensions.contentKit.behavior.CBOrderModelBehavior',),
        );
    }

    public function rules(){
        return array(
            array('published','safe'),
        );
    }

    public function attributeLabels()
    {
        return array( 'published' => 'Is published');
    }

    public function beforeSave(){

        parent::beforeSave();

        if (!isset($this->pub_date)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                  ADD COLUMN `pub_date` INT(10) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (!isset($this->create_time)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                  ADD COLUMN `create_time` INT(10) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (!isset($this->update_time)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                  ADD COLUMN `update_time` INT(10) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (!isset($this->published)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                    ADD COLUMN `published` TINYINT(1) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (!isset($this->order)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                  ADD COLUMN `order` INT(10) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (!isset($this->authorId)){
            $sql = "ALTER TABLE `".$this->tableName()."`
	                  ADD COLUMN `authorId` INT(10) NOT NULL;";
            Yii::app()->db->createCommand($sql)->execute();
        }

        if (isset($this->pub_date) && $this->pub_date==0 && $this->published==1){

           $this->pub_date = time();

        }
        return true;
    }


}