<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PBox
 *
 * @author Антон
 */
class PBox {
    
    public $pictures;
    public $favPictures;
    
    protected $galleryId;
    protected $id;
    
    protected $count;

    static public function getTitleFromArray($image){
        if (isset($image['title'])){
            return $image['title'];
        } else{
            return '';
        }
    }

    static public function getAltFromArray($image){
        if (isset($image['alt'])){
            return $image['alt'];
        } else{
            return '';
        }
    }

    public function __construct($galleryId,$id) {
        $pictureBoxDir = Yii::getPathOfAlias('webroot').'/files/pictureBox/';
        $datafile = $pictureBoxDir.$galleryId.'/'.$id.'/data.php';
        $favDatafile = $pictureBoxDir.$galleryId.'/'.$id.'/favData.php';
        if (file_exists($datafile)){
            $array = require ($datafile);
            $this->pictures= $array['images'];   
            $this->galleryId = $galleryId;
            $this->id = $id;
            
            if (file_exists($favDatafile)){
                
                $array = require($favDatafile);
                if (count($array)>0){
                    $this->favPictures = require($favDatafile);
                }
                
            }
            
            

        }
    }
    
    public function getImage($id,$tag){
        if (isset($this->pictures[$id][$tag])){
            return $this->pictures[$id][$tag];
        } else{
            return false;
        }
    }
   
    public function getImageHtml($id,$tag,$htmlOptions=array()){
        
        $src = $this->getImage($id, $tag);
        
        $alt = $this->getAlt($id);
        $title = $this->getTitle($id);
        
        return CHtml::image($src,$alt,array_merge(array('title'=>$title),$htmlOptions) );
        return '<img src="'.$src.'" alt="'.$alt.'" title="'.$title.'"/>';
    }    
    
    public function getFirstImageHtml($tag,$htmlOptions=array()){

        if (is_null($this->favPictures )){
            $array = $this->pictures;
        } else{
            $array = $this->favPictures;
        }
        if (is_array($array)){
            $id = key($array);
        
            return $this->getImageHtml($id, $tag,$htmlOptions);
        } else{
            return '<img src=""/>';
        }
        
    }  
    
    public function getImageCount(){
        return count($this->pictures);
    }
    
    public function getTitle($id){
        if (isset($this->pictures[$id]['title'])){
            return $this->pictures[$id]['title'];
        } else{
            return false;
        }
    }
    
    public function getAlt($id){
        if (isset($this->pictures[$id]['alt'])){
            return $this->pictures[$id]['alt'];
        } else{
            return false;
        }
    } 

}

?>
