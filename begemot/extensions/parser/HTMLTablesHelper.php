<?php

/**
 *
 * Из одной таблицы делает несколько. Создает несколько таблиц. Количество таблиц равно
 * количеству столцов минус один. Первый столбец приставляется к каждому столбцу и генерируется
 * таблица.
 *
 * Допустим есть таблица модификаций вездеходов. Слева первый столбец характеристик типа модификация,
 * мощность, габариты и т.д.
 *
 * Тогда первый столбец это набор этих характеристик для одной модификации, потом следующий ко
 * второй модификации и т.д.
 *
 * Эта функция делает из таблицы нескольких модификаций - несколько отдельных таблиц модификций.
 *
 * @param $htmlTable HTML код разбираемой таблицы
 * @return array Массив HHTML кода. Каждый элемент - таблица.
 */
function leftTableExtract ($htmlTable){

    $doc = phpQuery::newDocumentHTML($htmlTable);
    phpQuery::selectDocument($doc);
    $lines = pq('tr')->eq(0)->find('th,td');


    $tableColCounts = count($lines);

    $tableColsHTMLArray=[];

    for ($colI=0;$colI<$tableColCounts;$colI++){
        $tableColsHTMLArray[] = tableCut($htmlTable,$colI);
        $tableColsHTMLArray[$colI];
    }

    $resultsHTMLTables = [];

    $tableRow1 = $tableColsHTMLArray[0];
    for ($colI=1;$colI<$tableColCounts;$colI++){
        $tableRow2 =$tableColsHTMLArray[$colI];
        $resultsHTMLTables[] = concatTableRow($tableRow1,$tableRow2);
    }

    return $resultsHTMLTables;
}

function tableCut ($htmlTable,$cautedRow){
    phpQuery::newDocumentHTML($htmlTable);
    $tdOfRowArray = pq('tr');
    $resultRow = '<table>';
    foreach ($tdOfRowArray as $td){

        $resultTd =  pq($td)->find('th:eq('.$cautedRow.'),'.'td:eq('.$cautedRow.')');

        $resultRow.='<tr>'.$resultTd.'</tr>';
    }
    $resultRow .= '</table>';
    return $resultRow;
}

function concatTableRow ($tableRow1,$tableRow2){



    phpQuery::newDocumentHTML($tableRow1);

    $rowOneTDArray = [];
    $tdOfRowArray = pq('tr');

    foreach ($tdOfRowArray as $td){
        $rowOneTDArray[]=pq($td)->find('th,td');
    }

    phpQuery::newDocumentHTML($tableRow2);

    $rowTwoTDArray = [];
    $tdOfRowArray = pq('tr');

    foreach ($tdOfRowArray as $td){
        $rowTwoTDArray[]=pq($td)->find('th,td');
    }
//    print_r($rowTwoTDArray);
    $resultTable = '<table>';
    foreach ($rowOneTDArray as $key=>$tdOne){
        $tdTwo = $rowTwoTDArray[$key];
        $resultTable.='<tr>';

        $resultTable.='<td>'.$tdOne->html().'</td><td>'.$tdTwo->html().'</td>';

        $resultTable.='</tr>';
    }
    $resultTable .= '</table>';

    return $resultTable;
}
