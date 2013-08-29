<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 18.06.13
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

class BaseTemplate
{

    protected $imageCount;
    protected $images = array();

    public $templateType = 'random'; //random, head, bottom
    public $templateFile = null;
    public function getImageCount()
    {
        return $this->imageCount;
    }

    public function cutImagesFromArray(&$images)
    {

        for ($i = 0; $i < $this->imageCount; $i++) {


            $this->images[] = array_shift($images);;


        }

    }

    protected function getImage()
    {
       return array_shift ($this->images);
    }

    public function renderTemplate()
    {
        throw new Exception('Переопределите функцию render()');
    }

    public function render (){
        return '<!-- template !-->'.$this->renderTemplate().'<!-- endtemplate !-->';
    }

    public function renderFileTemplate($view, $data){
        extract($data);
        ob_start();
        include Yii::getPathOfAlias($view).'.php';
        return ob_get_clean();
    }

}