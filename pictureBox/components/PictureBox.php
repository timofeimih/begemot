<?php

class PictureBox extends CWidget {

    //Идентификатор множестка
    //например:books

    public $id = null;
    //Идентификатор элемента множества
    //например:1,2,3,4 и т.д. 
    public $elementId = null;
    public $config = array();

    public $divId = 'pictureBox';

    public $theme = 'default';

    public function init() {
        if (!file_exists(Yii::app()->basePath . '/../files/pictureBox/')) {
            mkDir(Yii::app()->basePath . '/../files/pictureBox/',777);
        }
    }

    public function run() {

        $this->config = array_merge_recursive(PictureBox::getDefaultConfig(),$this->config);

        if (session_id()=='')
            session_start();
        $this->divId=$this->id.'_'.$this->elementId;
        $this->config['divId'] = $this->divId;


        $_SESSION['pictureBox'][$this->divId] = $this->config;


        $this->renderContent();
    }

    public static function getDefaultConfig(){
        $defaultConfig = array(

            'nativeFilters'=>array(
                'admin' =>true,
            ),
            'filtersTitles'=>array(
                'admin' =>'Системный',

            ),
            'imageFilters' => array(
                'admin' => array(
                    0 => array(
                        'filter' => 'CropResize',
                        'param' => array(
                            'width' => 298,
                            'height' => 198,
                        ),
                    ),
                ),
            )
        );

        return $defaultConfig;
    }

    protected function renderContent() {

        if ($this->theme=='default'){
            $theme = 'pictureBox.components.view.pictureBoxView';
        } else {
            $theme = 'pictureBox.components.view.'.$this->theme;
        }

        $this->render($theme,array('id'=>$this->id,'elementId'=>$this->elementId,'config'=>$this->config));

    }

    static public function crPhpArr($array, $file) {


        $code = "<?php
  return
 " . var_export($array, true) . ";
?>";
        file_put_contents($file, $code);


    }

}

?>