<?php
class CropResizeFilter extends BaseFilter{
       
    public function make (){
        
        $im = new Imagick($this->fileName);
        $im->adaptiveResizeImage ($this->param['width'],$this->param['height'],true);
        $im->writeImage($this->newFileName);
        $im->clear();
        $im->destroy();  
        
    }
    
}
?>
