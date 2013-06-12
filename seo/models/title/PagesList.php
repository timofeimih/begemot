<?php
/**
 * Created by JetBrains PhpStorm.
 * User: anton
 * Date: 08.06.13
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

class PagesList {

    public $pages = array();
    public $lastId = 0;

    public function __construct(){
        $this->loadPagesList();
    }

    public function addPage($url,$title,$keywords,$description){

        $page = array();

        $page['url']=$url;
        $page['title']=$title;
        $page['keywords']=$keywords;
        $page['description']=$description;

        $id = $this->lastId++;

        $this->pages[$id]=$page;

        $this->savePagesList();

    }

    public function deletePage($id){
        if (isset($this->pages[$id])){
            unset($this->pages[$id]);

            $this->savePagesList();
        }
    }

    public function updatePage($id,$url,$title,$keywords,$description){

        if (isset($this->pages[$id])){
            $this->pages[$id]['url']=$url;
            $this->pages[$id]['title'] = $title;
            $this->pages[$id]['keywords'] = $keywords;
            $this->pages[$id]['description'] = $description;

            $this->savePagesList();
        }

    }

    public function savePagesList(){
        $data = array();
        $data['pages']=$this->pages;
        $data['lastId']=$this->lastId;

        $dataFilePath = $this->getDataFilePath();

        file_put_contents($dataFilePath, '<?php return '.var_export($data,true).'; ?>');
    }

    public function loadPagesList(){

        $dataFilePath = $this->getDataFilePath();

        if (file_exists($dataFilePath)){

            $data = require($dataFilePath);

            $this->lastId = $data['lastId'];
            $this->pages = $data['pages'];

        }
    }



    private function getDataFilePath() {
        return  $this->getDirPath().'/data.php';
    }

    public function getDirPath(){
        $dir = Yii::getPathOfAlias('webroot.files.meta');

        if (!file_exists($dir)){
            mkdir($dir,0777);
        }

        return $dir;
    }

}