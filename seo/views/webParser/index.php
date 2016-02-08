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

$site_name = 'pelec.ru';

Yii::log('    ЗАШЛИ В ОТОБРАЖЕНИЕ!', 'trace', 'webParser');

$parseScenario = [
    'allPages' => [

        'startUrl' => '/catalog/models',

        'type' => WebParserDataEnums::TASK_TYPE_PROCESS_URL,
        'parser_rules' => [
            'seoData' => 'h2.product-title',
        ],
    ],
    'seoData' => [
        'type' => WebParserDataEnums::TASK_TYPE_DATA,
        'dataFields' => [
            WebParserDataEnums::DATA_ID_ARRAY_KEY => WebParserDataEnums::DATA_FILTER_URL,
            'title' => 'title',
            '-pageContent' => 'body',
        ],
        'parse_data_rules' => [
            '-pageContent' => ['vehicle_parse', 'options_parse'],
        ]
    ],
    'options_parse' => [
        'type' => WebParserDataEnums::TASK_TYPE_DATA,

        'dataFields' => [
            WebParserDataEnums::DATA_ID_ARRAY_KEY => WebParserDataEnums::DATA_FILTER_URL,
            '-option' => 'div.view-product-options  tr'
        ],
        'parse_data_rules' => [
            '-option' => 'optionData'
        ]
    ],
    'optionData' => [
        'type' => WebParserDataEnums::TASK_TYPE_DATA,

        'dataFields' => [
            WebParserDataEnums::DATA_ID_ARRAY_KEY => 'input|val',
            'title' => 'td.views-field-title-field',
            'price' => 'td.views-field-field-option-cost|price',
            'image' => '@download a|href ',

        ],
    ],
    'vehicle_parse' => [
        'type' => WebParserDataEnums::TASK_TYPE_DATA,

        'dataFields' => [
            WebParserDataEnums::DATA_ID_ARRAY_KEY => WebParserDataEnums::DATA_FILTER_URL,
            'title' => 'h1',
            'price' => 'div.field-name-field-cost|price',
            '-vehMOdifTable' => 'table#product-modifications',
        ],

    ],
];

$webParser = new CWebParser('seoParser', $site_name, $parseScenario, $processId);


$webParser->addUrlFilter('#mailto#i');
$webParser->addUrlFilter('#\##i');
$webParser->tasksPerExecute = 1;
$webParser->isInterface = true;
$webParser->parse();


//$pageContent = $webParser->getPageContent('http://www.buggy-motor.ru/catalog/buggy_79.html');
//$webParser->getAllUrlFromPage($pageContent);
//echo  md5('123', true);

//echo 'Количество активных задач:'. $webParser->taskManager->getActiveTaskCount().'!!';

echo '<br>';
//foreach ($webParser->doneTasks as $doneTask){
//    echo $doneTask->id.'<br>';
//}
//echo '<pre>';
//print_r($webParser->filteredUrlArray);
//echo '</pre>';

Yii::log('    проверяем закончен ли процесс!', 'trace', 'webParser');
//echo $webParser->getProcessStatus();
if ($webParser->getProcessStatus() != 'done') {
    echo '<script>location.reload();</script>';
} else {
    $dataManager = new CParserDataManager($processId);


    $dataTreeArray = $dataManager->getDataTreeArray();
    echo '<pre>';
    print_r($dataTreeArray);
    echo '</pre>';

}




