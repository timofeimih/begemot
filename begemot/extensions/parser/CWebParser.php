<?php

/**
 *  Базовый класс для сбора данных с других сайтов.
 *
 * Основное преимущество в том, что парсит не все и сразу, а делит процесс на этапы.
 * Обычные парсеры на больших сайтах могут отъедать ресурсы, подвешивать сервер и
 * могут не успеть выполниться за установленный в php параметр выполнения
 * времени скрипта. Основной упор на полный контроль и мониторинг процесса парсинга.
 * Удобство и скорость создания новых парсеров для сайта с инеграцией в админку - цель.
 *
 * Задача оптимального расходования ресурсов сервера и временных ресурсов не цель данной библиотеки.
 *
 * Этот класс парсит нужное количество страниц за один запуск. Что позволяет тонко настраивать и контролировать процесс
 * сбора информации. Пишется сценарий сбора информации и класс запускается до тех пор, пока процесс не завершиться.
 *
 * Основные цели написания библиотеки:
 * - устойчивость процесса
 * - не убивать сервер одним долгим и ресурсоемким процессом сбора, в случае большого количества страниц
 * - простота создания новых парсеров данных, путем написания сценариев
 * - управление. Возможность поставить на паузу или вернуться к процессу через какое-то количество
 * времени
 *
 *
 * Работа по сценарию распределена на два этапа. Навигация и сбор данных
 *
 * Навигация - это сбор ссылок на страницы которые надо будет обработать на
 * следующем запуске парсера. В сценарии указывается в какой части страницы могут
 * быть ссылки для определенных сценариев. Эти ссылки собираются в список
 * и генерируются новые задачи в план выполнения с пометкой по какому сценарию надо
 * их обработать.
 *
 */

Yii::import('TaskManager');

class CWebParser
{
    public $urlArray = array();
    public $filteredUrlArray = array();
    public $urlFilterArray = array();

    /**
     * @var int Сколько задач обрабатывается за один запуск процесса
     */
    public $tasksPerExecute = 5;


    /**
     * Нужно установить. По указанному хосту фильтруются внешние ссылки.
     */
    public $host = null;

    /**
     * Номер процесса сборки данных. Основной параметр по которому
     * все данные в таблицах группируются. Что бы можно было работать
     * в рамках одного процесса. И вернуться к выполнению любого старого
     * незавершенного.
     */
    private $processId = null;

    /**
     * Параметр необходим, что бы принципиально разделять данные сбора.
     * Например когда нужно разделить парсеры по модулям и что бы у каждого
     * модуля были свои процессы.
     */
    private $parserName = null;
    private $parseScenario = null;

    public $doneTasks = array();

    public function getProcessId()
    {
        return $this->processId;
    }

    /**
     * @var TaskManager Экземпляр класса управляющего задачами для текущего процесса
     */
    public $taskManager = null;

    public function CWebParser($parserName, $host, $scenario, $processId)
    {
        Yii::log('Запускаем парсер '.$parserName.' хост: '.$host.' Id процесса:'.$processId,'trace','webParser');
        Yii::import('begemot.extensions.parser.models.*');
        $dir = Yii::getPathOfAlias('begemot.extensions.parser');
        require_once($dir . '/phpQuery-onefile.php');
        $this->parserName = $parserName;
        $this->host = $host;
        $this->setScenario($scenario);
        $this->processId = $processId;

        $this->taskManager = new TaskManager($processId);


    }

    /**
     * Собственно главный процесс, который надо выполнять многократно
     * с определенным сценарием.
     */
    public function parse()
    {
        $processId = $this->getProcessId();

        $status = null;
        if (is_null($processId)) {
            $status = $this->startNewParseProccess();
        } else {
            $this->processId = $processId;
            $status = $this->continueParseProccess($this->parseScenario);
        }
        return $status;
    }

    public function getProcessStatus()
    {

        $processId = $this->processId;

        $webParserProcess = WebParserProcess::model()->findByPk($processId);

        return $webParserProcess->status;

    }

    /**
     *
     * Продолжаем процесс сбора данных с удаленного сайта
     *
     * @param $parseScenario array Массив сценариев на базе которого каждый раз принимается решение что делать сейчас и что делать дальше
     *
     */


    private function continueParseProccess($parseScenario)
    {

        $processId = $this->processId;

        $webParserProcess = WebParserProcess::model()->findByPk($processId);
        if ($webParserProcess->status == 'created') {

            $webParserProcess->status = 'proccessing';
            $webParserProcess->save();
        }

        //Начинаем обработку очередной страницы по сценарию сбора информации

        //Для начала узнаем есть ли существующие задания для сценарием в БД
        //Для нашего id процесса и со статусом new
        if (ScenarioTask::isExistSomeTask($this->processId)) {

            //Задачи есть. Выполняем что можем за один запуск
            $this->doSomeTasks();
        } else {
            /*
             * Задач нет. Это может означать:
             *
             * - Запустились первый раз и значит нужно пройтись по сценариям в поиске
             * параметра startUrl. Проверяем наличие startUrl в спарсенных страницах. Если их нет,
             * значит запускаемся первый раз. Начинаем процесс.
             * - Если все ссылки startUrl уже есть в таблице страниц. Процесс закончен.
             * Все страницы обработаны в соответствии со всеми сценариями. Завершаем процесс.
             *
             */

            //Вытаскиваем все startUrl для проверки
            $startUrlArray = array();
            foreach ($parseScenario as $scenarioName => $scenarioItem) {
                if (isset($scenarioItem['startUrl'])) {
                    $startTaskItem = array();
                    $startTaskItem['scenarioItemName'] = $scenarioName;
                    $startTaskItem['url'] = $this->normalizeUrl($this->removeHostFromUrl($scenarioItem['startUrl']));
                    $startTaskItem['target_type'] = WebParserDataEnums::TASK_TARGET_DATA_TYPE_URL;
                    $startTaskItem['task_type'] = 'start_navigation';
                    $startUrlArray[] = $startTaskItem;
                }
            }

            /*
             * Проверяем были ли обработаны эти стартовые страницы раньше
             * Если нет, то ставим их в план на обработку
             */

            //Флаг отвечает за наличие добавленных задач в план. По нему принимаем решение
            //завершаем процесс или нет

            $weHaveNewTasks = false;
            $taskManager = $this->taskManager;

            foreach ($startUrlArray as $startTask) {


                $target_type = WebParserDataEnums::TASK_TARGET_DATA_TYPE_URL;

                $WebParserUrl = $this->getUrlObject($startTask['url']);

                $targetId = $WebParserUrl->id;
                //TODO на забыть добавить всем проверкам на существование задания тип задания
                if (!$this->isTaskExist($targetId, $target_type, $startTask['scenarioItemName'])) {
                    $taskManager->createTask(WebParserDataEnums::TASK_TYPE_START_NAVIGATION,$targetId, $target_type, $startTask['scenarioItemName']);
                    $weHaveNewTasks = true;
                }

            }

            if (!$weHaveNewTasks) {
                /**
                 * Процесс парсинга закончен. Все что парсер мог сделать - он сделал.
                 */
                $webParserProcess->status = 'done';
                $webParserProcess->save();
            }

        }

    }

    public function getUrlObject($url){

        if (!($webParserUrl = WebParserUrl::model()->find('`url`="'.$url.'" and `procId`='.$this->processId))) {
            $webParserUrl = new WebParserUrl();

            $webParserUrl->procId= $this->processId;
            $webParserUrl->url = $url;


            if ($webParserUrl->save()){
                $webParserUrl->id = Yii::app()->db->getLastInsertId();
            }
        }


        return $webParserUrl;
    }

    /**
     * Процедура запускается когда ясно что есть задачи
     * в плане и их нужно выполнять.
     *
     * По сути основная логика именно разбора кода страницы по сценарию и формирования следующих
     * заданий происходит тут.
     */
    private function doSomeTasks()
    {
        $tasks = ScenarioTask::model()->findAll(
            array(
                'limit' => $this->tasksPerExecute,
                'condition' => 'processId=:processId and taskStatus="new"',
                'params' => array(
                    ':processId' => $this->processId
                )
            )
        );

        foreach ($tasks as $task) {
            $this->doTask($task);
        }
    }

    /**
     *
     * @param $task ScenarioTask
     */
    private function doTask($task)
    {
        //Действуем от типа задачи


        if ($task->taskType == WebParserDataEnums::TASK_TYPE_START_NAVIGATION){

            //Данный тип задач обрабатываем так. Проверяем код ответа http. Проверяем mime,
            //Если все норм - грузим страницу и сохраняем в виде WebParserPage
            $url = $task->getTargetData();

            if ($data = $this->checkRemotePage($url)){

                if ($data['mime']=='text/html' && $data['httpCode']==200){

                    $webParserPage = $this->parsePage($url);


                    if (!$this->isTaskExist(WebParserDataEnums::TASK_TARGET_DATA_TYPE_WEBPAGE,$webParserPage->id,$task->scenarioName)){

                        $this->taskManager->createTask(
                            WebParserDataEnums::TASK_TYPE_PROCESS_URL,
                            $webParserPage->id,
                            WebParserDataEnums::TASK_TARGET_DATA_TYPE_WEBPAGE,
                            $task->scenarioName);
                    }
                }
            }

        }


        if ($task->taskType == WebParserDataEnums::TASK_TYPE_PROCESS_URL){

            $pageContent = $task->getTargetData();

            $scenarioItem = $this->getScenarioItem($task->scenarioName);

            $doc = phpQuery::newDocument($pageContent);
            phpQuery::selectDocument($doc);

            $taskManager = $this->taskManager;

            if (isset($scenarioItem['parser_rules']) && is_array($scenarioItem['parser_rules'])) {
                foreach ($scenarioItem['parser_rules'] as $scenarioTaskName => $navigationRule) {

                    $searchHrefsDocumentPart = pq($navigationRule);

                    //Перебираем все части кода которые нашли по правилу сценария
                    foreach ($searchHrefsDocumentPart as $navigationPart) {
                        //Создаем ScenarioTask для каждого найденного урл
                        $urlArray = $this->getAllUrlFromContent($navigationPart);
                        foreach ($urlArray as $url) {

                            $target_type = WebParserDataEnums::TASK_TARGET_DATA_TYPE_URL;

                            $WebParserUrl = $this->getUrlObject($url);

                            $targetId = $WebParserUrl->id;

                            if (!$this->isTaskExist($targetId, $target_type,$scenarioTaskName)) {
                                $taskManager->createTask(WebParserDataEnums::TASK_TYPE_START_NAVIGATION,$targetId, $target_type, $scenarioTaskName);

                            }

                            //Тип цели нам известен, выставляем его сразу
                            $target_type = WebParserDataEnums::TASK_TARGET_DATA_TYPE_URL;

                            //$target_id = $this->getDocumentId($url);

//                            if (!$this->isTaskExist($target_id, $target_type, $scenarioTaskName)) {
//
//                                $taskManager->createTask($target_id, $target_type, $scenarioTaskName);
//                            }
                        }
                    }


                }
            }
        }


        //TODO: переработать сбор данных еще надо

        /**
         * Начинаем сбор данных по набору фильтров.
         * Если фильтр начинается с "@", то он процедурный. То есть это
         * не css путь, а некий стандартный модификатор. Например @url - это фильтр,
         * который в качестве данных просит вернуть url страницы с которой ведется работа. И т.д.
         *
         * Если имя фильтра начинается с @, то это так же не простое имя поля данных
         */


//        if (isset($scenarioItem['dataFields']) && is_array($scenarioItem['dataFields'])) {
//
//            foreach ($scenarioItem['dataFields'] as $fieldName => $fieldFilter) {
//
//                if ($fieldName=='@') continue;
//
//                $dataFieldModel = new WebParserData();
//
//
//                $dataFieldModel->processId = $this->processId;
//
//                $dataFieldModel->fieldName = $fieldName;
//                $planeData = $this->executeFilter($fieldFilter, $task);
//                $dataFieldModel->fieldData = $planeData;
//
//                if (isset($scenarioItem['dataFields']['@'])) {
//                    foreach ($scenarioItem['dataFields']['@'] as $massFilterKey=>$massFilter) {
//                        switch ($massFilterKey) {
//                            case WebParserDataEnums::DATA_ID_ARRAY_KEY :
//
//                                $dataFieldModel->fieldId =  $this->executeFilter($massFilter, $task);
//
//                                break;
//                        }
//                    }
//                }
//
//                $dataFieldModel->save();
//
//
//            }
//
//        }


        $task->completeTask();
        $this->doneTasks[] = $task;

    }

    /**
     * Ищем документ с таким адресом. Если документа нет, то парсим его. Как итог возвращаем id
     *
     * @param $url адрес страницы документа
     */
    private function getDocumentId($url)
    {

        $webParserPage = WebParserPage::model()->find('url = "' . $url . '" and `procId` = '.$this->processId);

        if (!$webParserPage) {

            $webParserPage = $this->parsePage($url);
        }

        return $webParserPage->id;
    }

    private function executeFilter($filter, $task)
    {


        if ($filter{0} == "@") {
            //Процедурный фильтр

            if ($filter == WebParserDataEnums::DATA_FILTER_URL) {
                return $task->url;
            }
        }


        return pq($filter)->html();


    }

    private function startNewParseProccess()
    {

        $webParserProcess = new WebParserProcess();
        $webParserProcess->date = time();
        $webParserProcess->status = 'created';
        $webParserProcess->name = $this->parserName;

        $webParserProcess->save();

        $webParserProcess = WebParserProcess::model()->findByPk(Yii::app()->db->getLastInsertId());


        $controller = Yii::app()->getController();
        $controller->redirect($controller->createUrl('', array('processId' => $webParserProcess->id) + $_GET));

    }


    /**
     * Парсим страницу. Сохраняем в базу в соответствии с моделью. Сохраняем контент, код http
     * на случай ошибки и mime тип.
     *
     * @param $url string ссылка на страницу. относительная
     * @return WebParserPage спасенная страница возвращается в виде экземпляра модели WebParserPage
     */
    public function parsePage($url)
    {

        $webParserPage = new WebParserPage();

        $fullPageUrl = 'http://' . $this->host . $url;

        $webParserPage->url = $url;



        $webParserPage->procId = $this->processId;

        if ($this->checkRemotePage($webParserPage->url)) {

            $ch = curl_init($fullPageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $data = curl_exec($ch);

            curl_close($ch);

            $webParserPage->content = $data;
            $webParserPage->mime = $mime;
            $webParserPage->http_code = $httpCode;


            if (!$webParserPage->save()) {
                die('Ошибка сохранения модели в protected/modules/begemot/extensions/parser/CWebParser.php');
            }

        }

        return $webParserPage;
    }

    /**
     *
     * Вытаскивает все ссылки со страницы. Убирает те, которые попадают под фильтры.
     *
     * @param $pageContent html код
     *
     */
    public function getAllUrlFromContent($сontent)
    {

        $urlArray = array();
        foreach (pq($сontent)->find('a') as $a) {
            $a = pq($a);
            $urlArray[] = $a->attr('href');
        }


        $urlArray = $this->filterOtherHostUrl($urlArray);
        $normalizedUrlArray = $this->normalizeUrlArray($urlArray);

        $urlArray = array_unique($normalizedUrlArray, SORT_STRING);


        return $this->filterUrlArray($urlArray);

    }

    public function addUrlFilter($regExpFilter)
    {
        $this->urlFilterArray[] = $regExpFilter;
    }

    public function filterUrlArray($urlArray)
    {

        return array_filter($urlArray, array(get_class($this), 'regExpChecker'));
    }


    /**
     * Функция убирает внешние ссылки из массива всех ссылок
     */
    private function filterOtherHostUrl($urlArray)
    {

        foreach ($urlArray as $key => $url) {
            $url_data = parse_url($url);

            if (isset($url_data['host'])) {
                if ($url_data['host'] != $this->host) {
                    unset ($urlArray[$key]);
                } else {
                    $urlArray[$key] = $this->removeHostFromUrl($url);
                }
            }

        }

        return $urlArray;

    }

    private function normalizeUrlArray($urlArray)
    {

        foreach ($urlArray as $key => $url) {
            $urlArray[$key] = $this->normalizeUrl($url);
        }

        return $urlArray;
    }

    public function normalizeUrl($url)
    {

        //$url = strtolower($url);

        if (!preg_match('#^/#', $url)) {
            $url = '/' . $url;
        }

        return $url;
    }

    /**
     *
     * Проверяем есть в базе код страницы с указанным адресомм
     *
     * @param $url адрес страницы
     * @param null $webPage в эту переменную возвращает код из базы
     * @return bool true - значит url в базе нет, false - уже парсили и код есть в базе и скопирован в переменную &$webPage
     */
    protected function isUrlUniq($url, &$webPage = null)
    {
        $WebParserPages = WebParserPage::model()->findAll(
            array(
                'condition' => 'url_hash=:url_hash and procId=:processId',
                'params' => array(
                    ':url_hash' => md5($url),
                    ':processId' => $this->processId
                )
            )
        );

        if (count($WebParserPages) !== 0) {
            foreach ($WebParserPages as $WebParserPage) {
                if ($WebParserPage->url === $url) {

                    if (!is_null($webPage)) {
                        $webPage = $WebParserPage;
                    }

                    return false;
                }
            }
        }

        return true;

    }

    private function isTaskExist($target_id, $target_type, $scenarioItemName)
    {
        return ScenarioTask::isExistTask($target_id, $target_type, $scenarioItemName, $this->processId);
    }


    private function regExpChecker($var)
    {
        foreach ($this->urlFilterArray as $urlFilter) {
            if (preg_match($urlFilter, $var)) {
                return false;
            }
        }
        return true;
    }


    /**
     * @param $scenarioInput Массив с описанием сценария работы для парсера
     */
    private function setScenario($scenarioInput)
    {
        $scenarioArray = array();
        foreach ($scenarioInput as $scenarioName => $scenarioItem) {


            /*
             * Ищем и кладем отдельно фильтры с процедурными именами
             */
            if (isset($scenarioItem['dataFields'])) {

                foreach ($scenarioItem['dataFields'] as $key => $scenarioFilter) {
                    if ($scenarioFilter{0} == '@') {
                        if (!isset($scenarioItem['dataFields']['@'])) {
                            $scenarioItem['dataFields']['@'] = array();
                        }

                        $scenarioItem['dataFields']['@'][$key] = $scenarioFilter;
                        unset ($scenarioItem['dataFields'][$key]);

                    }
                }
            }

            $scenarioArray[$scenarioName] = $scenarioItem;

        }

        $this->parseScenario = $scenarioArray;

    }

    private function getScenarioItem($name)
    {
        return $this->parseScenario[$name];
    }

    private function removeHostFromUrl($url)
    {
        $url_data = parse_url($url);

        $url = $url_data['path'] .
            (isset($url_data['query']) ? '?' . $url_data['query'] : '') .
            (isset($url_data['fragment']) ? '#' . $url_data['fragment'] : '');

        return $url;

    }

    /**
     * @param $webParserPage WebParserPage
     * @return bool
     */
    private function checkRemotePage($url){

        $fullPageUrl = 'http://' . $this->host . $url;

        $ch = curl_init($fullPageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_exec($ch);

        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($mime!='text/html') return false;
        if ($httpCode!=200) return false;

        $returnData = [];
        $returnData['mime']=$mime;
        $returnData['httpCode']=$httpCode;



        return $returnData;
    }



} 