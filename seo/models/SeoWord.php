<?php

/**
 * This is the model class for table "seo_word".
 *
 * The followings are the available columns in table 'seo_word':
 * @property integer $id
 * @property string $word
 * @property integer $weight
 * @property integer $group_id
 */
class SeoWord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seo_word';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('weight, group_id', 'numerical', 'integerOnly'=>true),
			array('word', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, word, weight, group_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'word' => 'Word',
			'weight' => 'Weight',
			'group_id' => 'Group',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($group=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

	
		//$criteria->compare('word',$this->word,true);
		//$criteria->compare('weight',$this->weight);
                
                if (!is_null($group)){
                    $criteria->condition = "`group_id` = ".$group;   
                }
                  
                $dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
                $dataProvider->pagination = array('pageSize'=>10000);
		return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeoWord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
