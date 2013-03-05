<?php

/**
 * This is the model class for table "argo_posts".
 *
 * The followings are the available columns in table 'argo_posts':
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $author
 * @property integer $date
 */
class Posts extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Posts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'argo_posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, text, author, date,tag_id,from,from_url,title_t,title_seo', 'safe'),
            array('author, date', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, text, author, date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title(H1)',
            'text' => 'Text',
            'author' => 'Author',
            'date' => 'Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($tag_id) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('author', $this->author);
        $criteria->compare('date', $this->date);

        $criteria->compare('tag_id', $tag_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->date = time();
            $this->title_t = $this->mb_transliterate($this->title);
            return true;
        } else {
            $this->title_t = $this->mb_transliterate($this->title);
            return true;
        }
    }

    public function behaviors() {
        return array(
        'SlugBehavior' => array(
            'class' => 'begemot.extensions.SlugBehavior',
        ));
    }


}