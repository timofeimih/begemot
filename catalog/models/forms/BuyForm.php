<?php
class BuyForm extends CFormModel{

    public $name;
    public $eMail;
    public $phone;
    public $count;
    public $msg;

    public function rules()
    {

        return array(
                        //array('name','required'),
                        array(' name, eMail, phone, count, msg', 'safe'),
                    );


    }

}
?>
