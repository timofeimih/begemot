<?php

/**
 * Created by PhpStorm.
 * User: anton
 * Date: 11.10.15
 * Time: 23:04
 */
class CParserDataManager
{

    private $processId;

    public function CParserDataManager($processId)
    {
        $this->processId = $processId;
    }

    /**
     * Убираем все промежуточные данные и
     * пробрасываем родительские связи
     */
    public function cutDataTree()
    {

        $sql = "
        SELECT * FROM webParserData
         WHERE  fieldName like :search
         and processId=:processId
         LIMIT 1";
        $searchParams = array(':search' => '-%','processId'=>$this->processId);


        while ($tempDataCollection = WebParserData::model()->findBySql($sql, $searchParams)){

            $tempData = $tempDataCollection;


            $tempData->delete();
        }






    }

    public function getDataTreeArray()
    {
        $resultArray = [];

        $tempDataCollection = WebParserData::model()->findAll("processId=" . (int)$this->processId);

        foreach ($tempDataCollection as $tempData) {
            if (!isset($resultArray[$tempData->fieldId])) {
                $resultArray[$tempData->fieldId] = [];
            }

            $resultArray[$tempData->fieldId][$tempData->fieldName] = $tempData->fieldData;

            if (!is_null($tempData->parentDataId)) {
                $parentFieldId = $this->getFieldNameByDataId($tempData->parentDataId);


                if (!isset($resultArray[$tempData->fieldId]['parents'])) {
                    $resultArray[$tempData->fieldId]['parents'] = [];
                }
                $resultArray[$tempData->fieldId]['parents'][] = $tempData->parentDataId;
            }

        }

        return $resultArray;
    }

    public function getFieldNameByDataId($dataId)
    {

        $field = WebParserData::model()->findByPk($dataId);
        if (!is_null($field)){
            return $field->fieldId;
        }
    }
} 