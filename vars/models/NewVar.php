<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class NewVar extends CFormModel
{
	public $varname;




	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('varname', 'required'),
			array(
                            'varname',
                            'match',
                            'pattern'=>'/^([A-Za-z0-9_])+$/',
                            'message'=>'Только латинские символы и цифры.',
                            ),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'varname'=>'Имя переменной',
		);
	}


}
