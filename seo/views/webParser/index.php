<?php


?>


    <h2>Сбор контента всех страниц сайта</h2>
    <p>
        Используется для дальнейшего анализа.
    </p>

<?php
$this->menu = require dirname(__FILE__) . '/../commonMenu.php';
echo $processId;


Yii::import('begemot.extensions.parser.*');


$site_name = $_SERVER['SERVER_NAME'];



$parseScenario = array(
    array(
        'name' => 'allPages',
        'startUrl' => 'http://www.buggy-motor.ru/catalog/buggy_79.html',
        'navigation' => array(
            'allPages' => '',
        ),
        'dataFields' => array(
            'title'=>'title',
            'pageHtmlCode'=>'html',
        ),
    ),
);

$webParser = new CWebParser('seoParser',$site_name ,$parseScenario);


$webParser->addUrlFilter('#mailto#i');
$webParser->addUrlFilter('#\##i');
$webParser->parse($processId);


//$pageContent = $webParser->getPageContent('http://www.buggy-motor.ru/catalog/buggy_79.html');
//$webParser->getAllUrlFromPage($pageContent);
//echo  md5('123', true);


echo '<pre>';
print_r($webParser->filteredUrlArray);
echo '</pre>';
