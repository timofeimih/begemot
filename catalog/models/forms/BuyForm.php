<?php
class BuyForm extends CFormModel{

    public $name;
    public $email;
    public $phone;
    public $count;
    public $msg;
    public $model;

    public function rules()
    {

        return array(
                        //array('name','required'),
                        array(' name, email, phone, count, msg, model', 'safe'),
                    );


    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'count' => 'Количество',
            'phone' => 'Телефон',
            'eMail' => 'e-mail',
            'msg' => 'Сообщение',
        );
    }
}
?>
