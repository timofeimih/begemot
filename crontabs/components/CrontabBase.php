<?php 
class CrontabBase extends CApplicationComponent{

	public $dir = '';


	public function __construct()
	{
		$this->dir = Yii::app()->basePath . '/config/';
	}

	public function getPeriodOfItem($jobIndex)
	{
		$all = (array) $this->getListJob();

		if (array_key_exists($jobIndex, $all)) {

			return $this->timeToString($all[$jobIndex]['period']);
		}
	}

	public function addJob($filename, $period = 86400, $className, $website)
	{

        //every day = 86 400 sec
        //every week = 604 800 sec
        //2 days in a week = 302 400 sec
        $arr = array(
	        $filename => array(
	        	'period' => $period,
	        	'lastExecuted' => '0',
	        	'class' => $className,
	        	'executable' => true,
	        	'website' => $website,
        	)
        );

        $all = (array) $this->getListJob();

        $arr = array_merge($all, $arr);

        $this->writeFile($arr);
        
	}

	public function changeTime($jobIndex, $period = 86400, $time = '1')
	{
		$all = (array) $this->getListJob();

		if (array_key_exists($jobIndex, $all)) {

			$all[$jobIndex]->period = $period;
			$all[$jobIndex]->time = $time;

			$this->writeFile((array) $all);

			return $this::timeToString($period);
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	public function turnOff($jobIndex)
	{
		$all = (array) $this->getListJob();

		if (array_key_exists($jobIndex, $all)) {
			$all[$jobIndex]->executable = false;

			$this->writeFile($all);

			return "Сохранено";
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	public function turnOn($jobIndex)
	{
		$all = (array) $this->getListJob();

		if (array_key_exists($jobIndex, $all)) {
			$all[$jobIndex]->executable = true;

			$this->writeFile($all);

			return "Сохранено";
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	

	public function removeJob($filename)
	{
		$all = (array) $this->getListJob();

		if ($all[$filename]) {
			unset($all[$filename]);

	        $this->writeFile($all);
		}

    }

	public static function timeToString($time)
	{

		$string = '';

		if ($time == 86400) {
			$string = 'Каждый день';
		} else if ($time == 604800){
			$string = 'Раз в неделю';
		} else if ($time == 302400){
			$string = 'Два раза в неделю';
		} else if ($time < 86400){
			$string = $time / 3600;
		} else{
			$string = 'Не известно';
		}


		return $string;
	}

	private function writeFile($arrayToWrite)
	{
		$tempFile = fopen($this->dir . 'cronConfig.php', 'w');

        fwrite($tempFile, json_encode($arrayToWrite)); 

        fclose($tempFile); 
	}

	public function getListJob()
	{

		$array = array();

		$files  = scandir($this->dir);

		if (array_search('cronConfig.php', $files)) {
		    $json = json_decode(file_get_contents($this->dir . 'cronConfig.php'));
		    
		    $array = $json;

		    
		}
		

		return (array) $array;
	}

	public function changeTimeOfLastExecuted($name, $time = 0)
	{

		$array = array();
		$directory = dirname(Yii::app()->basePath) . "/parsers/history/";

		$files  = scandir($directory);

		

		if (array_search('time.txt', $files)) {
			$tempFile = fopen($directory . 'time.txt', 'c');

		    $json = json_decode(file_get_contents($directory . 'time.txt'));
		    //print_r($files);
		    $array = (array) $json;

		    if(is_array($array)){
		    	if (array_key_exists($name, $array)) {
			    	$array[$name] = $time;
			    }

			    fwrite($tempFile, json_encode($array)); 
		    }
		    

		    fclose($tempFile); 
		}
		
		return true;
	}

	public function runAll()
	{
		$all = $this->getListJob();
		$save = array();

		if ($all) {
			foreach ($all as $filename => $item) {

				$item = (array) $item;

				if ($item['executable'] == true) {
						
					if (($item['lastExecuted'] + $item['period'] + $item['time']) < time()) {
						
						$classItem = new $item['class'];
						//$classItem->runJob($filename);
						$this->runJob($filename);
						$this->changeTimeOfLastExecuted($filename, time());

						$item['lastExecuted'] = mktime(0, 0, 0, date('n'), date('j')) + $item['period'] + $item['time'];
						
						echo "run" . time() .  " - " . $filename .  " - " . $item['lastExecuted'];
					}
					else echo 'no run' . time();
				}
				

				$save[$filename] = $item;
			}

			print_r($save);


			$this->writeFile($save);
		}
		

	}

	private function runJob($filename)
	{
		return true;
	}
}