<?php

class MaxSizeFilter extends BaseFilter{

    public function make (){

        $im = new Imagick($this->fileName);
        $width = $im->getImageWidth();
        $height = $im->getImageHeight();

        if ($width > $this->param['width']){
            $im->resizeImage($this->param['width'],null,2,0.9);
        }

        if ($height > $this->param['height']){
            $im->resizeImage(null,$this->param['height'],2,0.9);

        }


        //$im->cropthumbnailimage($this->param['width'],$this->param['height']);

        $im->writeImage($this->newFileName);
        $im->clear();
        $im->destroy();

    }

}

?>
