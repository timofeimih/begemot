<?php
class CropResizeFilter extends BaseFilter{
       
    public function make (){
        
        $im = new Imagick($this->fileName);
        $im->cropthumbnailimage($this->param['width'],$this->param['height']);                
        $im->writeImage($this->newFileName);
        $im->clear();
        $im->destroy();  
        
    }
    
}
?>
