
<h2>Сбор контента всех страниц сайта</h2>
<p>
    Используется для дальнейшего анализа.
</p>

<?php



Yii::import('begemot.extensions.parser.*');


$site_name =  $_SERVER['SERVER_NAME'];

$webParser = new CWebParser();
$webParser->host = $_SERVER['SERVER_NAME'];

$pageContent =  $webParser->getPageContent('http://www.buggy-motor.ru/catalog/buggy_79.html');

$webParser->addUrlFilter('#mailto#i');
$webParser->addUrlFilter('#\##i');
$webParser->getAllUrlFromPage($pageContent);




echo '<pre>';
print_r($webParser->filteredUrlArray);
echo '</pre>';
