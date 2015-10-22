<?php

/**
 * Class WebParserDataEnums
 *
 * Различные константы для парсера
 *
 * Имена для процедурных фильтров и ключей для фильтров определяются тут.
 *
 * Если константа начинается с DATA_ID_ , то это нестандартный процедурный ключ-имя фильтра.
 *
 * Если константа имя процедурного фильтра начинаем с DATA_FILTER_
 */



class WebParserDataEnums {



    /**
     * Зарезервированное имя фильтра. По этому фильтру достаем данные и
     * сохраняем их для всех данных этого сценария в поле "fieldId" в БД.
     * Ключевой параметр по которому данные группируются. Этот же параметр в идеале
     * должен быть артикулом, по которому идет связывание с позициями каталога.
     */
     const DATA_ID_ARRAY_KEY = '@data_id';

    /**
     * Возвращаем url текущего документа
     */
     const DATA_FILTER_URL = '@url';


    /**
     * Типы задач
     */

    /**
     * Так помечаем все новые ссылки.
     */
    const TASK_TYPE_START_NAVIGATION = 'start_navigation';
    /**
     * Если ссылка прошла проверку и данные были спарсены, то создаем такую задачу.
     */
    const TASK_TYPE_PROCESS_URL = 'process_url';
    const TASK_TYPE_DATA = 'process_data';
    const TASK_TYPE_IMAGE = 'navigation';
    /**
     * Типы входных данных для задач
     */

    const TASK_TARGET_DATA_TYPE_URL = 'url';
    const TASK_TARGET_DATA_TYPE_WEBPAGE = 'web_page';
    const TASK_TARGET_DATA_TYPE_DATA = 'data';


}
