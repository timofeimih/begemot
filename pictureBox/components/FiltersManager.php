<?php

/**
 * Класс служит для пакетной работы с изображениями. 
 * 
 * Может пименять к изображению один фильтр или очередь фильтров. 
 *  
 */
class FiltersManager {

    private $config;
    private $fileName;
    public $resultFiles = array();

    public function FiltersManager($_fileName, $_config) {

        $this->config = $_config;
        $this->fileName = $_fileName;


        $this->checkFilters();
    }

    public function getFilteredImages() {
        return $this->resultFiles;
    }

    public function checkFilters() {

        $filePathInfo = pathinfo($this->fileName);

        $filePath = $filePathInfo['dirname'];
        $fileName = $filePathInfo['basename'];
        $fileExt = $filePathInfo['extension'];
        $fileNameClear = $this->delFileExt($fileName);

        foreach ($this->config['imageFilters'] as $filterName => $filters) {

            foreach ($filters as $filter) {

                $resultFileName = $filePath . '/' . $fileNameClear . '_' . $filterName . '.' . $fileExt;
                $resultFileNameForOutput = $fileNameClear . '_' . $filterName . '.' . $fileExt;

                $filterClassName = $filter['filter'] . 'Filter';


                if (file_exists($resultFileName)) {

                    /**
                     * Если существует, то фильтруем существующий
                     * т.к. очередь фильтров уже началась 
                     */
                    $filterInstance = new $filterClassName($resultFileName, $resultFileName, $filter['param']);
                } else {
                    /**
                     * Если не существует, то фильтруем оригинал
                     */
                    $filterInstance = new $filterClassName($this->fileName, $resultFileName, $filter['param']);
                }

                $filterInstance->make();
                $this->resultFiles[$filterName] = $resultFileNameForOutput;
            }
        }

        if (isset($this->config['original'])) {
            foreach ($this->config['original'] as $originalFilter) {
                $filterClassName = $originalFilter['filter'] . 'Filter';
                $filterInstance = new $filterClassName($this->fileName, $this->fileName, $originalFilter['param']);
                $filterInstance->make();
            }
        }
    }

    //возвращаем 
    public function delFileExt($filename) {

        $filename = strrev($filename);

        for ($i = 0; $i < strlen($filename); ++$i) {
            if ($filename{$i} != '.') {
                $filename{$i} = '';
            } else {
                $filename{$i} = '';
                break;
            }
        }
        return strrev(trim($filename));
    }

}

?>
