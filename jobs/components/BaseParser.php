<?php
abstract class BaseParser extends BaseJob{
	private $items = array();
    private $name = '';
    private $time = 0;


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


    // Передалать в save to file.
    public function saveToFile()
    {  
        $this->saveTime();

        $arr = array_merge(array('time' => $this->getTime()), array('items' => $this->items));
    	
        $this->saveParserData($arr);
    }

    public function saveParserData((array) $arrayToWrite)
    {
        $tempFile = fopen(Yii::app()->basePath . "../files/parsersData/" . $this->name . '.data', 'w');

        fwrite($tempFile, json_encode($arrayToWrite)); 

        fclose($tempFile); 
    }

    public function saveTime()
    {   


        if (isset($_GET['newDate'])) {
            $this->time = time();
            $dir    = Yii::app()->basePath . "../files/parsersData/";

            $files  = scandir($dir);

            $arr = array($this->name => $this->time);

            $tempFile = fopen($dir . 'time.txt', 'w');

            if (array_search('time.txt', $files)) {
                $json = json_decode(file_get_contents($dir . 'time.txt'));
                if (is_array($json)) {
                    $arr = array_merge($json, $arr);
                }
                
            }

            fwrite($tempFile, json_encode($arr)); 

            fclose($tempFile); 
        }
        

    }

    public function getTime(){
        if($this->time != undefined){
            return $this->time;
        } else return "Нету времени";
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}