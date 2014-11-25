<?php

$this->menu = require dirname(__FILE__) . '/../commonMenu.php';

// It may take a whils to crawl a site ...
set_time_limit(10000);

$dir =  Yii::getPathOfAlias('application.modules.begemot.extensions.PHPCrawl.libs');
include ($dir.'/PHPCrawler.class.php');
include ($dir.'/PHPCrawlerUtils.class.php');
include ($dir.'/UrlCache/PHPCrawlerURLCacheBase.class.php');
include ($dir.'/UrlCache/PHPCrawlerMemoryURLCache.class.php');
include ($dir.'/UrlCache/PHPCrawlerSQLiteURLCache.class.php');
include ($dir.'/PHPCrawlerHTTPRequest.class.php');
include ($dir.'/PHPCrawlerLinkFinder.class.php');
include ($dir.'/PHPCrawlerDNSCache.class.php');
include ($dir.'/PHPCrawlerCookieDescriptor.class.php');
include ($dir.'/PHPCrawlerResponseHeader.class.php');
include ($dir.'/CookieCache/PHPCrawlerCookieCacheBase.class.php');
include ($dir.'/CookieCache/PHPCrawlerMemoryCookieCache.class.php');
include ($dir.'/CookieCache/PHPCrawlerSQLiteCookieCache.class.php');
include ($dir.'/PHPCrawlerURLFilter.class.php');
include ($dir.'/PHPCrawlerRobotsTxtParser.class.php');
include ($dir.'/PHPCrawlerProcessReport.class.php');
include ($dir.'/PHPCrawlerUserSendDataCache.class.php');
include ($dir.'/PHPCrawlerURLDescriptor.class.php');
include ($dir.'/PHPCrawlerDocumentInfo.class.php');
include ($dir.'/PHPCrawlerBenchmark.class.php');
include ($dir.'/PHPCrawlerUrlPartsDescriptor.class.php');
include ($dir.'/PHPCrawlerStatus.class.php');
include ($dir.'/Enums/PHPCrawlerAbortReasons.class.php');
include ($dir.'/Enums/PHPCrawlerRequestErrors.class.php');
include ($dir.'/Enums/PHPCrawlerUrlCacheTypes.class.php');
include ($dir.'/Enums/PHPCrawlerMultiProcessModes.class.php');
include ($dir.'/ProcessCommunication/PHPCrawlerProcessCommunication.class.php');
include ($dir.'/ProcessCommunication/PHPCrawlerDocumentInfoQueue.class.php');

// Inculde the phpcrawl-mainclass
//include("libs/PHPCrawler.class.php");
SeoPages::model()->deleteAll(); 
SeoLinks::model()->deleteAll(); 
// Extend the class and override the handleDocumentInfo()-method 
class MyCrawler extends PHPCrawler 
{
  function handleDocumentInfo($DocInfo) 
  {
    
    preg_match("/<title>(.+)<\/title>/i", $DocInfo->content, $matches);

    if (isset($matches[1])){
        $title = $matches[1];
    }
    else{
        $title = "title - не найден!";
    }

    $model = new SeoPages();
  
    $model->url = $DocInfo->url;
            
    $model->content = $DocInfo->content;
    $model->title = $title;
    $model->status = 0;
    $model->save();
    //$this->UrlFilter->filterUrls($DocInfo);  
    // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>").
    if (PHP_SAPI == "cli") $lb = "\n";
    else $lb = "<br />";

    // Print the URL and the HTTP-status-Code
    echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
    
    // Print the refering URL
    
    echo "Referer-page: ".$DocInfo->referer_url.$lb;
    //echo '<pre>';
  echo 'Найдено ссылок - '.count($DocInfo->links_found_url_descriptors).'<br/>';
   // echo '</pre>';
    // print_r($DocInfo->links_found_url_descriptors);
    // die();
    foreach ($DocInfo->links_found_url_descriptors as $link){
        

        if ($this->UrlFilter->urlMatchesRules($link)){
            //echo $link->link_raw.'<br/>';  
            $linkModel = new SeoLinks();
            $linkModel->url = $DocInfo->url;
            $linkModel->href = $link->link_raw;
            $linkModel->anchor = $link->linktext;
            
            $linkModel->type = 0;
            $linkModel->save();
           // $linkModel
        }
    }
    
    // Print if the content of the document was be recieved or not
    if ($DocInfo->received == true)
      echo "Content received: ".$DocInfo->bytes_received." bytes".$lb;
    else
      echo "Content not received".$lb; 
    
    
    
    // Now you should do something with the content of the actual
    // received page or file ($DocInfo->source), we skip it in this example 
    
    echo $lb;
    
    flush();
  } 
}

// Now, create a instance of your class, define the behaviour
// of the crawler (see class-reference for more options and details)
// and start the crawling-process. 
$site_name =  $_SERVER['SERVER_NAME'];
$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL($site_name);

// Only receive content of files with content-type "text/html"
$crawler->addContentTypeReceiveRule("#text/html#");

// Ignore links to pictures, dont even request pictures
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|js|css)$#i");

// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
//$crawler->setTrafficLimit(1000 * 1024);

// Thats enough, now here we go
$crawler->go();

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();

if (PHP_SAPI == "cli") $lb = "\n";
else $lb = "<br />";
    
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 
?>