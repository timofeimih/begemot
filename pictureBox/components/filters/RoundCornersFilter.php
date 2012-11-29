<?php
class RoundCornersFilter extends BaseFilter{
       
    public function make (){
        //echo $this->fileName;
        $im = new Imagick($this->fileName);
        $im->roundCorners( $this->param['round'],$this->param['round'] ); 
        $im->writeImage($this->newFileName);
        $im->clear();
        $im->destroy();  
        
    }
    
}
?>
