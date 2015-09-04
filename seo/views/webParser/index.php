<?php


?>


    <h2>Сбор контента всех страниц сайта</h2>
    <p>
        Используется для дальнейшего анализа.
    </p>

<?php
$this->menu = require dirname(__FILE__) . '/../commonMenu.php';
//echo $processId;


Yii::import('begemot.extensions.parser.*');
Yii::import('begemot.extensions.parser.models.*');

$site_name = 'buggy-motor.ru';



$parseScenario = [
    'allPages'=>[
        'type' => WebParserDataEnums::TASK_TYPE_START_NAVIGATION,
        'startUrl' => 'http://www.buggy-motor.ru/catalog/Baggi_79/FC-1100_Sport_430.html',
        'parser_rules' => [
            'allPages' => '',
        ],
    ],
//    'seoData'=>[
//        'type'=>WebParserDataEnums::TASK_TYPE_DATA
//    ]
];

$webParser = new CWebParser('seoParser',$site_name ,$parseScenario,$processId);


$webParser->addUrlFilter('#mailto#i');
$webParser->addUrlFilter('#\##i');
$webParser->tasksPerExecute = 5;
$webParser->parse();


//$pageContent = $webParser->getPageContent('http://www.buggy-motor.ru/catalog/buggy_79.html');
//$webParser->getAllUrlFromPage($pageContent);
//echo  md5('123', true);

echo 'Количество активных задач:'. $webParser->taskManager->getActiveTaskCount().'!!';

echo '<br>';
foreach ($webParser->doneTasks as $doneTask){
    echo $doneTask->id.'<br>';
}
//echo '<pre>';
//print_r($webParser->filteredUrlArray);
//echo '</pre>';

echo $webParser->getProcessStatus();
if($webParser->getProcessStatus()!='done')
echo '<script>location.reload();</script>';

