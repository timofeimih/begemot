<?php

class VarsModule extends CWebModule {


    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'vars.models.*',
            'vars.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {


        $dataFile = VarsModule::getDataFilePath();
        if (!file_exists($dataFile)){
            $fp = fopen($dataFile, "w");
            fwrite($fp, '<?php return array();?>');
            fclose ($fp);

        }
        Yii::app()->getComponent('bootstrap');

        return true;
    }

    public static function getDataFilePath(){
        return Yii::getPathOfAlias('webroot').'/files/vars.data';
    }

    public static function getData(){
        return require self::getDataFilePath();
    }

    public static function setData($data){

        $dataFile = VarsModule::getDataFilePath();

        if (!file_exists($dataFile)){
            $fp = fopen($dataFile, "w");
            fwrite($fp, '<?php return array();?>');
            fclose ($fp);
        }

        file_put_contents($dataFile,'<?php'.var_export($data).'?>');


    }
}
