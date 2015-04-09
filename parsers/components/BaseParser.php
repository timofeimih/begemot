<?php
/* Для того чтобы экземпляр класса рассмативался как файл для парсинга данных, его название должно заканчиваться на ParserJob.php (Пример названия: ArgoParserJob.php) */
class BaseParser extends BaseJob{
    protected $items = array();
    protected $time = 0;
    protected $name = '';


    public function addItem($id, $price, $name, $text, $quantity)
    {

        $name = str_replace('&quot;',"\"",  $name);
        $text = str_replace('&quot;', "'",$text);

        $this->items[] = array(
            'id' => $id,
            'price' => $price,
            'name' => $name,
            'text' => $text,
            'quantity' => $quantity,
        );

    }

    public function runJob()
    {
        return true;
    }



    public function getLastParsedData()
    {   
        $file = dirname(Yii::app()->request->scriptFile) . "/files/parsersData/" . $this->name . '.data';
        return require($file);
    }


    // Передалать в save to file.
    public function saveToFile()
    {  
        $this->saveTime();

        $arr = array_merge(array('name' => $this->name), array('items' => $this->items));
        
        $this->saveParserData($arr);
    }

    public function saveParserData($arrayToWrite)
    {

        if ( ! is_writable(dirname(Yii::app()->request->scriptFile) . "/files/parsersData/")) {
            throw new Exception("Файл " . dirname(Yii::app()->request->scriptFile) . "/files/parsersData/" . " не может быть изменен. Недостаточно прав", 503);
            
        }

        PictureBox::crPhpArr($arrayToWrite, dirname(Yii::app()->request->scriptFile).'/files/parsersData/' . $this->name . '.data');
    }

    public function saveTime()
    {   

        if ( ! is_writable(dirname(Yii::app()->request->scriptFile) . "/files/parsersData/time.txt")) {
            throw new Exception("Файл " . dirname(Yii::app()->request->scriptFile) . "/files/parsersData/time.txt" . " не может быть изменен. Недостаточно прав", 503);
            
        }

        $this->time = time();
        $dir    = dirname(Yii::app()->request->scriptFile) . "/files/parsersData/";

        $files  = scandir($dir);

        $arr = array($this->name => $this->time);

        if (array_search('time.txt', $files)) {
            $json = require(dirname(Yii::app()->request->scriptFile).'/files/parsersData/time.txt');
            if (is_array($json)) {
                $arr = array_merge($json, $arr);
            }
            
        }

        PictureBox::crPhpArr($arr, dirname(Yii::app()->request->scriptFile).'/files/parsersData/time.txt');

    }

    public function getTime(){
        if($this->time != 0){
            return $this->time;
        } else return "Нету времени";
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}