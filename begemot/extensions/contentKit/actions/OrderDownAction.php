<?php

class OrderDownAction extends CAction{

    public function run($modelId, $className, $groupId=null, $groupName=null){

        $model = $className::model()->findByPk($modelId);

        $firstModel = clone ($model);



        //Если группировка не задана, то меняем порядок относительно
        //всей таблицы.

        //по всей таблице
        $criteria = new CDbCriteria;
        if ($groupId === null || $groupName === null)
            $criteria->condition = '`order`>' . $firstModel->order;
        else
            $criteria->condition = '`order`>' . $firstModel->order . ' AND `' . ($groupName) . '`=' . $groupId . '';


        $criteria->order = '`order`';
        $criteria->limit = '1';


        $secondLines = $model->findAll($criteria);


        if (count($secondLines) == 0) {
            return;
        }

        if (!isset($secondLines[0]) || $secondLines[0]->id == null) {
            return;
        } else {
            $secondModel = $className::model()->findByPk($secondLines[0]->id);

            $bottomOrder = $secondModel->order;

            $secondModel->order = $firstModel->order;
            if (!$secondModel->save()) {
                throw new CHttpException(500,'Can`t save model');
            }

            $firstModel->order = $bottomOrder;

            if (!$firstModel->save()){
                throw new CHttpException(500,'Can`t save model');
            }
        }


    }

}