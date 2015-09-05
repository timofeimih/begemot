<?php 


class JobManager extends CApplicationComponent{

	private $dir = '';


	public function __construct()
	{

		$logMessage = 'JobManager __construct - зашли в конструктор ';
		Yii::log($logMessage,'trace','cron');

		if ( ! is_writable(dirname(Yii::app()->request->scriptFile) . "/files/parsersData/")) {
			$logMessage = 'JobManager __construct -  '.dirname(Yii::app()->request->scriptFile) . "/files/parsersData/ нету прв для записи";
			Yii::log($logMessage,'trace','cron');
			throw new Exception(dirname(Yii::app()->request->scriptFile) . "/files/parsersData/ нету прв для записи" , 503);
		}

		$this->dir = dirname(Yii::app()->request->scriptFile) . "/files/parsersData/";

		foreach(glob(Yii::app()->basePath . "/modules/*", GLOB_ONLYDIR) as $path) {    

            if(file_exists($path)){
                if(file_exists($path . "/jobs")){
                    Yii::import('application.modules.' . basename($path) . ".jobs.*");
                }
            }
            
        }
	}

	public function getPeriodOfItem($jobIndex)
	{
		$all = (array) $this->getListCronJob();

		if (array_key_exists($jobIndex, $all)) {

			return $this->timeToString($all[$jobIndex]['period']);
		}
	}

	public function getAllJobs()
	{
		$itemClassesList = array();

		if($this->getListOfAllJobs()){
			foreach ($this->getListOfAllJobs() as $item) {
				$itemName = basename($item);

				$name = str_replace('.php', '', $itemName);
				$itemClassesList[] = $name;
			}
		}
		

		return $itemClassesList;
	}

	public static function getListOfAllJobs()
	{	
		$arrayOfJobs = array();
		if (glob(Yii::app()->basePath . "/jobs/*.php")) {
			foreach(glob(Yii::app()->basePath . "/jobs/*.php") as $path) {	
				$arrayOfJobs[] = $path;
			}
		}

		if (glob(Yii::app()->basePath . "/modules/*/jobs/*.php")) {
			foreach(glob(Yii::app()->basePath . "/modules/*/jobs/*.php") as $path) {	
				$arrayOfJobs[] = $path;
			}
		}
		
		return $arrayOfJobs;
	}

	public function newTask($parameters)
	{
        $logMessage = 'JobManager newTask - создаем задачу '.var_export($parameters,true);
        Yii::log($logMessage,'trace','cron');
        //every day = 86 400 sec
        //every week = 604 800 sec
        //2 days in a week = 302 400 sec

		$filename = $parameters['filename'];
		$arrayIndex = $filename . " - " . time() ;

		$today  = strtotime("00:00:00");
		$yesterday  = strtotime("-2 day", $today);

		$parameters['lastExecuted'] = 0;
        //$parameters['lastExecuted'] = $yesterday + $parameters['time'] + $parameters['hour'] + $parameters['minutes'];
        $parameters['executable'] = true;
        $parameters['lastExecutedForText'] = 0;

        $parameters['filename'];

        $arr = array(
	        $arrayIndex => $parameters
        );

        $all = (array) $this->getListCronJob();

        $arr = array_merge($all, $arr);

        $this->saveConfigFile($arr);

        return 1;
        
	}

	public function changeTime($jobIndex, $time = 86400, $hour = '1', $minutes = 0)
	{
		$all = (array) $this->getListCronJob();

		if (array_key_exists($jobIndex, $all)) {

			$today  = strtotime("00:00:00");
			$yesterday  = strtotime("-2 day", $today);

			$all[$jobIndex]['time'] = $time;
			$all[$jobIndex]['hour'] = $hour;
			$all[$jobIndex]['minutes'] = $minutes;
			$all[$jobIndex]['lastExecuted'] = $yesterday + $all[$jobIndex]['time'] + $all[$jobIndex]['hour'] + $all[$jobIndex]['minutes'];
			$all[$jobIndex]['lastExecutedForText'] = 0;

			$this->saveConfigFile((array) $all);

			return $this->timeToString($time);
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	public function turnOff($jobIndex)
	{
		$all = (array) $this->getListCronJob();

		if (array_key_exists($jobIndex, $all)) {
			$all[$jobIndex]['executable'] = false;

			$this->saveConfigFile($all);

			return "Сохранено";
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	public function turnOn($jobIndex)
	{
		$all = (array) $this->getListCronJob();

		if (array_key_exists($jobIndex, $all)) {
			$all[$jobIndex]['executable'] = true;

			$this->saveConfigFile($all);

			return "Сохранено";
		} else{
			return "error: нету такого индекса в заданиях";
		}
	}

	

	public function removeTask($filename)
	{
		$all = $this->getListCronJob();

		if (isset($all[$filename])) {
			unset($all[$filename]);

	        $this->saveConfigFile($all);
		}

		print_r($all);

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

	private function saveConfigFile($arrayToWrite)
	{

		PictureBox::crPhpArr($arrayToWrite, $this->dir . 'cronConfig.php');
	}

	public function getListCronJob()
	{

		$array = array();

		$files  = scandir($this->dir);


		if (array_search('cronConfig.php', $files)) {

		    $array = require($this->dir . 'cronConfig.php');	    
		} 
		

		return $array;
	}

	public function changeTimeOfLastExecuted($name, $time = 0)
	{

        $dir    = Yii::app()->basePath . "/../files/parsersData/";

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $files  = scandir($dir);

        $arr = array($name => $time);

        if (array_search('time.txt', $files)) {
            $array = file_get_contents($dir . 'time.txt');
            if (is_array($array)) {
                $arr = array_merge($array, $arr);
            }

        }

        PictureBox::crPhpArr($arr, Yii::app()->basePath . "/../files/parsersData/time.txt");


		
		return true;
	}

	public function isTaskSettedUp($name)
	{
		$logMessage = 'function isTaskSettedUp - проверяем '.$name;
		Yii::log($logMessage,'trace','cron');
		return array_key_exists($name, $this->getListCronJob());
	}

	public function runAll()
	{

		$logMessage = 'JobManager runAll - начинаем проверку задач на запуск.';
		Yii::log($logMessage,'trace','cron');

		foreach(glob(Yii::app()->basePath . "/modules/*", GLOB_ONLYDIR) as $path) {    

            if(file_exists($path)){
                if(file_exists($path . "/jobs")){
                    Yii::import('application.modules.' . basename($path) . ".jobs.*");
                }
            }
            
        } 

        Yii::import('application.modules.parsers.components.*');
        Yii::import('application.modules.pictureBox.components.*');

		$all = $this->getListCronJob();
		$save = array();

		if ($all) {
			foreach ($all as $filename => $item) {

				$item = (array) $item;

				if ($item['executable'] == true) {
                    $logMessage = 'JobManager runAll - Проверяем задачу '.$filename.' Текущая метка:'.time().', расчетная метка: '.($item['lastExecuted'] + $item['time'] + $item['hour'] - 60);
                    Yii::log($logMessage,'trace','cron');
                    $dif = ($item['lastExecuted'] + $item['time'] + $item['hour'] - 60) - time();
                    $logMessage = 'JobManager runAll - Проверяем задачу '.$filename.' до запуска:'.$dif;
                    Yii::log($logMessage,'trace','cron');
                    if (($item['lastExecuted'] + $item['time'] + $item['hour'] - 60) < time()) {
						
						$className = $item['filename'];
						$classItem = new $className;
						//$classItem->runJob($filename);
						$classItem->runJob($item);
						$this->changeTimeOfLastExecuted($filename, time());
						echo $filename;
						$logMessage = 'JobManager runAll - запускаем '.$filename;
						Yii::log($logMessage,'trace','cron');


						$item['lastExecutedForText'] = time();

						$item['lastExecuted'] = mktime(0, 0, 0);
						
						echo "run" . time() .  " - " . $filename .  " - " . $item['lastExecuted'];
					}
					else echo 'no run' . time();
				}
				

				$save[$filename] = $item;
			}

			print_r($save);


			$this->saveConfigFile($save);
		}
		

	}

	private function runJob()
	{
		return true;
	}
}