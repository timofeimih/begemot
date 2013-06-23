<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class NewPage extends CFormModel
{
	public $url;
	public $title;
	public $keywords;
	public $description;

    public $id;




	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('url', 'required'),
            array('title, keywords, description','safe'),
            array('id','safe','on'=>'update')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'url'=>'Адрес страницы',
			'title'=>'title',
			'keywords'=>'keywords',
			'description'=>'description',
		);
	}


}
