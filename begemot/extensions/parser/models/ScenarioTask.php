<?php

/**
 * This is the model class for table "webParserScenarioTask".
 *
 * The followings are the available columns in table 'webParserScenarioTask':
 * @property integer $id
 * @property integer $processId
 * @property string $scenarioName
 * @property string $url
 */
class ScenarioTask extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScenarioTask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'webParserScenarioTask';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('processId', 'numerical', 'integerOnly'=>true),
			array('scenarioName', 'length', 'max'=>45),
			array('url', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, processId, scenarioName, url', 'safe', 'on'=>'search'),
		);
	}

    public function completeTask (){
        $this->taskStatus = 'done';
        $this->save();
    }

    static public function isExistSomeTask ($processId){
        $sql = "SELECT COUNT(*) FROM webParserScenarioTask WHERE processId=".$processId.' and taskStatus="new"';
        $taskCount = Yii::app()->db->createCommand($sql)->queryScalar();

        if ($taskCount==0){
            return false;
        } else {
            return true;
        }
    }

    static public function isExistTask ($url,$scenarioName,$processId){
        $sql = "SELECT COUNT(*) FROM webParserScenarioTask WHERE url='".$url."' and scenarioName='".$scenarioName."' and processId = ".$processId;
        $taskCount = Yii::app()->db->createCommand($sql)->queryScalar();

        if ($taskCount==0){
            return false;
        } else {
            return true;
        }
    }


}