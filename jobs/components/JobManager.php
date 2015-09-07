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
	/**
	 * 2-5 - проверит попадание в интервал от 2 до 5 включительно
	 * 1,2-10/3,7 - проверит на равенство 1,
	 * попадание в интервал от 2 до 10 с шагом 3
	 * то есть 2,5,8
	 * и проверит на равенство 7
	 * * - звездочка эмениться на полный интервал, для минут от 0 до 59 и т.д.
	 *
	 * Аналог записей crontab. Так же как и в ctontab при указании и дня недели и дня
	 * месяца возьмет будет проверять пересечение по логическому or. Все остальные
	 * по логическому and.
	 */
	public function checkForStart($cronItem){
		//print_r($cronItem);
		//Правильные интервалы значений в соответствии с date()
		$minInterval = '0-59'; // 'i' - минута
		$hourInterval = '0-23';// 'H' - час
		$dayInterval = '1-31';// 'd' - день
		$monthInterval = '1-12';//'m' - число дня месяца
		$dayWeekInterval = '0-6';// 'w' - порядковый номер дня недеи, 0 - воскресенье

		//Если чего то нет, то заменяем на общий интервал
		if (!isset($cronItem['min'])){$cronItem['min']=$minInterval;}
		if (!isset($cronItem['hour'])){$cronItem['hour']=$hourInterval;}
		if (!isset($cronItem['day'])){$cronItem['day']=$dayInterval;}
		if (!isset($cronItem['month'])){$cronItem['month']=$monthInterval;}
		if (!isset($cronItem['dayWeek'])){$cronItem['dayWeek']=$dayWeekInterval;}

		//Для удобства все звездочки заменяем на правильные интервалы
		$cronItem['min'] = str_replace ('*',$minInterval,$cronItem['min']);
		$cronItem['hour'] = str_replace ('*',$hourInterval,$cronItem['hour']);
		$cronItem['day'] = str_replace ('*',$dayInterval,$cronItem['day']);
		$cronItem['month'] = str_replace ('*',$monthInterval,$cronItem['month']);
		$cronItem['dayWeek'] = str_replace ('*',$dayWeekInterval,$cronItem['dayWeek']);

		//Собираем текущие значения. Минуту, час, день, месяц и день недели
		$actTime = time();
		$actMin = date('i',$actTime);
		$actHour = date('H',$actTime);
		$actDay = date('d',$actTime);
		$actMonth = date('m',$actTime);
		$actDayWeek = date('w',$actTime);

		//флаг совпадения для минуты изначально false
        echo 'Время:'.date('H:i d.m w').'<br>';


        $resultMinArray = $this->parseIntervalString($cronItem['min']);
        $resultHourArray = $this->parseIntervalString($cronItem['hour']);
        $resultDayArray = $this->parseIntervalString($cronItem['day']);
        $resultMonthArray = $this->parseIntervalString($cronItem['month']);
        $resultDayWeekArray = $this->parseIntervalString($cronItem['dayWeek']);



        $minFlag = false;
        if (array_search($actMin,$resultMinArray)!==false){
            $minFlag=true;

        }

        $hourFlag = false;
        if (array_search($actHour,$resultHourArray)!==false){
            $hourFlag=true;
        }

        $dayFlag = false;
        if (array_search($actDay,$resultDayArray)!==false){
            $dayFlag=true;
        }

        $monthFlag = false;
        if (array_search($actMonth,$resultMonthArray)!==false){
            $monthFlag=true;
        }

        $dayWeekFlag = false;
        if (array_search($actDayWeek,$resultDayWeekArray)!==false){
            $dayWeekFlag=true;
        }

        //Дни счетаем из дня недели и дня месяца. Эти флаги надо обрабатывать отдельно
        $commonDaysFlag = false;

        if (($cronItem['day']===$dayInterval) or ($cronItem['dayWeek']===$dayWeekInterval)){
          //Если один из интервалов дня *, то делаем and
            $commonDaysFlag = ($dayWeekFlag and $dayFlag);
        } else {
            //Если оба интервала дня отличны от базового, то делаем or
            $commonDaysFlag = ($dayWeekFlag or $dayFlag);
        }
        echo var_export($resultDayWeekArray,true);
        return $minFlag and $hourFlag and $commonDaysFlag and $monthFlag;

	}

	/**
     *
     * Преобразуем конечный интервал в массив отдельных чисел
     * для последующей простой проверки попадания в массив текущего
     * значения.
     *
	 * @param $interval Интервал вида x-y
	 * @param null $step Шаг, если есть, который пишется через "/"
	 */
	private function processInterval($interval,$step=null){
        $intervalArray = explode('-',$interval);

        $resultIntervalArray = [];

        $start = $intervalArray[0];
        $end = $intervalArray[1];

        for ($i=$start;$i<=$end;){
            $resultIntervalArray[]=$i;
            $i=$i+$step;
        }


        return $resultIntervalArray;
        return array();
	}

    /*
     * анализируем строку что бы получить массив всех конкретных значений
     *
     * если исходная строка 0,1,4-11/3
     *
     * то выходной массив должен получиться
     *
     * array(
     * 	0,1,4,7,10
     * )
     *
     * а потом просто перебором проверяем на равенство текущему значению.
     * По идее так проще будет отлаживать если что пойдет не так.
     */

    private function parseIntervalString($intervalStr){
        $resultDigitsArray = array();

        //разбиваем по запятым на набор интервалов
        $intervalArray = explode (',',$intervalStr);
       // print_r($intervalArray);
        //Набиваем этот массив всеми конкретными значениями которые найдем

        foreach ($intervalArray as $key => $intervalOfArray){
            //Проверяем на наличие "-"
            if(strstr($intervalOfArray,'-')){
                //есть дефис, значит интервал вида x-y/z, но шага / может и не быть
                //проверяем на наличие /

                $step = 1;
                //Разбиваем по /, если будет элемент с индексом 1, то это шаг
                $currentIntervalArray = explode('/',$intervalOfArray);
                if (isset($currentIntervalArray[1])){
                    $step = $currentIntervalArray[1];
                }


                $resultDigitsArray = array_merge($resultDigitsArray,$this->processInterval($currentIntervalArray[0],$step));
            } else{
                //если "-" нет, то просто проверяем на равенство
                $resultDigitsArray[] = $intervalOfArray;
            }
        }

        return array_merge($resultDigitsArray);
    }

}