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
            'CAuthorBehavior' => array('class' => 'Yummi.extensions.contentKit.behavior.CAuthorBehavior',),
            'CBOrderModelBehavior' => array('class' => 'Yummi.extensions.contentKit.behavior.CBOrderModelBehavior',),
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

        if (isset($this->pub_date) && $this->pub_date==0 && $this->published==1){

           $this->pub_date = time();

        }
        return true;
    }


}