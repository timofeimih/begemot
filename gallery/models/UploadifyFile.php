<?php

class UploadifyFile extends CFormModel
{
    public $uploadifyFile;
 
    public function rules()
    {
        return array(
            array(
                'uploadifyFile',
                'file','safe'=>true, 
                'types'=>'jpg, png, torrent',
                'maxSize'=>1024*1024*1024*2

            ),
        );
    }
       
}

?>
