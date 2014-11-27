<?php


class CWebParser
{

    public $urlArray = array();
    public $filteredUrlArray = array();

    public $urlFilterArray = array();
    public $host = null;

    public function CWebParser()
    {

        $dir = Yii::getPathOfAlias('begemot.extensions.parser');
        require_once($dir . '/phpQuery-onefile.php');

    }

    public function getPageContent($url)
    {


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;
    }

    public function getAllUrlFromPage($pageContent)
    {

        $doc = phpQuery::newDocument($pageContent);
        phpQuery::selectDocument($doc);

        foreach (pq('a') as $a) {
            $a = pq($a);
            $this->urlArray[] = $a->attr('href');
        }
        $this->normalizeUrlArray();

        $this->urlArray =  array_unique ( $this->filteredUrlArray , SORT_STRING  );


        $this->filterUrlArray();


    }

    public function addUrlFilter($regExpFilter)
    {
        $this->urlFilterArray[] = $regExpFilter;
    }

    public function filterUrlArray()
    {
        $this->filterOtherHostUrl();
        $this->filteredUrlArray = array_filter($this->filteredUrlArray, array(get_class($this), 'regExpChecker'));
    }

    private function filterOtherHostUrl (){

        foreach ($this->filteredUrlArray as $key=>$url){
            $url_data = parse_url($url);

            if (isset($url_data['host'])){
                if ($url_data['host']!=$this->host){
                    unset ($this->filteredUrlArray[$key]);
                }
            }

        }

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


    private function normalizeUrlArray (){



        foreach ($this->urlArray as $key=>$url){
             $this->filteredUrlArray[$key]=$this->normalizeUrl($url);
        }
    }

    public function normalizeUrl($url){

        $url=strtolower($url);

        if (!preg_match('#^/#',$url)){
            $url='/'.$url;
        }

        if (preg_match('#\?#',$url)){

             $url = preg_replace('#\?.+#','',$url);
        }


        return $url;
    }

} 