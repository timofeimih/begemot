<?php
$this->menu = require dirname(__FILE__) . '/../commonMenu.php';

$connection=Yii::app()->db;

$sql ='SELECT * FROM atvbtr.seo_word group by group_id,id';

$command=$connection->createCommand($sql);

$dataReader=$command->query();

$filePath = Yii::getPathOfAlias('webroot.files').'/wordsExport.csv';
$fp = fopen($filePath, 'w');

$emptyRow = array('','');
$group = null;
foreach($dataReader as $row) {

    if ($group === null){
        $group=$row['group_id'];
    }

    if ($group!=$row['group_id']){
        fputcsv($fp, $emptyRow);
        $group=$row['group_id'];
    }
    fputcsv($fp, $row);

}

fclose($fp);


?>
<h1>Выгрузка СЯ в CSV</h1>
Выгружаю...<br/>
Готово.<br/>
<a href="/files/wordsExport.csv">Семантическое ядро(CSV)</a>