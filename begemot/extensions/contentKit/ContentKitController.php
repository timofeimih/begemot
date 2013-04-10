<?php
/**
 * Created by JetBrains PhpStorm.
 * User: anton
 * Date: 4/1/13
 * Time: 4:30 PM
 * To change this template use File | Settings | File Templates.
 */

class ContentKitController extends YummiAdminController{



    public function behaviors(){
        return array(

            'CBOrderControllerBehavior' => array(
                'class' => 'Yummi.extensions.order.BBehavior.CBOrderControllerBehavior',
                'className'=>'LocalPartner',
                'groupName'=>'group_id'
            )

        );
    }

    public function actionOrderUp($id){
        $model = LocalPartner::model()->findByPk($id);


        $this->groupId = $model->group_id;
        $this->orderUp($id,$model);

    }

    public function actionOrderDown($id){
        $model = LocalPartner::model()->findByPk($id);


        $this->groupId = $model->group_id;
        $this->orderDown($id,$model);
    }
}