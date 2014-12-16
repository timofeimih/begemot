<?php

/**
 *  Базовый класс для сбора данных с других сайтов.
 *
 * Основное преимущество в том, что парсит не все и сразу, а делит процесс на этапы.
 * Обычные парсеры на больших сайтах могут отъедать ресурсы, подвешивать сервер и
 * могут не успеть выполниться за установленный в php параметр выполнения
 * времени скрипта.
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
 * Каждая обработка задачи из плана это обработка одной страницы по одному указанному сценарию.
 *
 * Работа по сценарию распределена на два этапа. Навигация и сбор данных
 *
 * Навигация - это сбор ссылок на страницы которые надо будет обработать на
 * следующем запуске парсера. В сценарии указывается в какой части страницы могут
 * быть ссылки для определенных сценариев. Эти ссылки собираются в список
 * и генерируются новые задачи в план выполнения с пометкой по какому сценарию надо
 * их обработать.
 *
 * Сбор данных - если у сценария есть параметр dataFields, это значит на данной странице
 * могут быть данные которые надо вытащить и сохранить.
 */
class CWebParser
{
    public $urlArray = array();
    public $filteredUrlArray = array();
    public $urlFilterArray = array();

    /**
     * @var int Сколько задач обрабатывается за один запуск процесса
     */
    public $tasksPerExecute = 1;


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

    public function getProcessId()
    {
        return $this->processId;
    }

    public function CWebParser($parserName, $host,$scenario)
    {
        Yii::import('begemot.extensions.parser.models.*');
        $dir = Yii::getPathOfAlias('begemot.extensions.parser');
        require_once($dir . '/phpQuery-onefile.php');
        $this->parserName = $parserName;
        $this->host = $host;
        $this->setScenario($scenario);
    }

    /**
     * Собственно главный процесс, который надо выполнять многократно
     * с определенным сценарием.
     */
    public function parse($processId = null)
    {
        $status = null;
        if (is_null($processId)) {
            $status = $this->startNewParseProccess();
        } else {
            $this->processId = $processId;
            $status = $this->continueParseProccess($this->parseScenario);
        }
        return $status;
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
        //Для нашего id процесса естественно
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
            foreach ($parseScenario as $scenarioItem) {
                if (isset($scenarioItem['startUrl'])) {
                    $startTaskItem = array();
                    $startTaskItem['scenarioItemName'] = $scenarioItem['name'];
                    $startTaskItem['url'] = $this->removeHostFromUrl($scenarioItem['startUrl']);

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
            foreach ($startUrlArray as $startTask) {

                    //Проверять было задание или нет тут не нужно. Мы знаем, что заданий нет никаких.
                    //Ни новых, ни выполненных.
                    $this->createTask($startTask['url'], $startTask['scenarioItemName']);
                    $weHaveNewTasks = true;

            }

        }

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

        $ch = curl_init( 'http://'.$this->host. $task->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_exec($ch);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if ($mime!='text/html') return;

        $pageContent = $this->getPageContent($task->url);
        $scenarioItem = $this->getScenarioItem($task->scenarioName);

        $doc = phpQuery::newDocument($pageContent);
        phpQuery::selectDocument($doc);

        foreach ($scenarioItem['navigation'] as $scenarioName=>$navigationRule){

            $searchHrefsDocumentPart = pq($navigationRule);

            //Перебираем все части кода которые нашли по правилу сценария
            foreach ($searchHrefsDocumentPart as $navigationPart){
                //Создаем ScenarioTask для каждого найденного урл
                $urlArray = $this->getAllUrlFromContent($navigationPart);
                foreach($urlArray as $url){
                    echo $url.' '.$scenarioName;
                    echo ($this->isTaskExist($url,$scenarioName)?'уже есть':'новые');
                    echo '<br>';
                    if (!$this->isTaskExist($url,$scenarioName)){

                        $this->createTask($url,$scenarioName);
                    }
                }
            }



        }

        $task->completeTask();

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
     *
     * Смотрит в БД собирали ли уже данные по этому адресу. Если собирали, то
     * берем из базы, что бы второй раз не делать запрос к сайту.
     * Если не собирали то curl забирает код удаленного документа.
     *
     * @param $url адрес страницы которую скачиваем или достаем из базы
     * @return string возвращаем контент страницы по адресу
     */
    private function getPageContent($url)
    {

        //die($url);
        $webPageFromBase = 'none';
        $url = $this->normalizeUrl($url);


        if ($this->isUrlUniq($url, $webPageFromBase)) {
            $pageUrl = $this->host.$url;

            $ch = curl_init($pageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $data = curl_exec($ch);

            curl_close($ch);

            $webParserPage = new WebParserPage();

            $webParserPage->url = $url;
            $webParserPage->content = $data;
            $webParserPage->procId = $this->processId;

            if (!$webParserPage->save()) {
                die('Ошибка сохранения модели бprotected/modules/begemot/extensions/parser/CWebParser.php:87');
            }

        } else {
            $data = $webPageFromBase->content;

        }

        return $data;
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


        $urlArray = array ();
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


        return  array_filter($urlArray, array(get_class($this), 'regExpChecker'));
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

    private function regExpChecker($var)
    {

        foreach ($this->urlFilterArray as $urlFilter) {
            if (preg_match($urlFilter, $var)) {
                return false;
            }
        }
        return true;
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

        $url = strtolower($url);

       if (!preg_match('#^/#',$url)) {
          $url='/'.$url;
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

    private function isTaskExist($url, $scenarioItemName)
    {
        return ScenarioTask::isExistTask($url, $scenarioItemName, $this->processId);
    }

    private function createTask($url, $scenarioItemName, $status = null)
    {

        $newTask = new ScenarioTask();
        $newTask->url = $url;
        $newTask->processId = $this->processId;
        $newTask->scenarioName = $scenarioItemName;
        if (is_null($status)) {
            $newTask->taskStatus = 'new';
        } else {
            $newTask->taskStatus = $status;
        }
        $newTask->save();
    }

    private function setScenario($scenarioInput)
    {
        $scenarioArray = array();
        foreach ($scenarioInput as $scenarioItem) {
            $scenarioArray[$scenarioItem['name']] = $scenarioItem;
        }

        $this->parseScenario = $scenarioArray;

    }

    private function getScenarioItem($name){
        return $this->parseScenario[$name];
    }

    private function removeHostFromUrl ($url){
        $url_data = parse_url($url);

        $url = $url_data['path'].
        (isset($url_data['query'])?'?'.$url_data['query']:'').
        (isset($url_data['fragment'])?'#'.$url_data['fragment']:'');

        return $url;

    }

} 