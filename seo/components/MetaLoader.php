<?php
/**
 * Created by JetBrains PhpStorm.
 * User: anton
 * Date: 09.06.13
 * Time: 11:48
 * To change this template use File | Settings | File Templates.
 */

class MetaLoader {
    private static $title;
    private static $kewords;
    private static $description;

    public static $wasLoaded = false;

    public static function getTitle(){

        self::loadData();

        if (self::$title==null){
            return Yii::app()->controller->pageTitle;
        } else {
            return self::$title;
        }

    }

    public static function getKeywords(){

        self::loadData();
        return self::$kewords;
    }

    public static function getDescription(){

        self::loadData();
        return self::$description;
    }


    public static function loadData(){
        if (!self::$wasLoaded){
            $filePath = Yii::getPathOfAlias('webroot.files.meta').'/data.php';

            if (file_exists($filePath)){

                $data = require ($filePath);
                $currentUri = $_SERVER['REQUEST_URI'];


                foreach ($data['pages'] as $page){
                    if (isset($page['url'])){
                        if ($page['url']==$currentUri){

                            self::$title = $page['title'];
                            self::$kewords = $page['keywords'];
                            self::$description = $page['description'];

                            self::$wasLoaded = true;

                            break;
                        }
                    }
                }

            }
        }
    }

}