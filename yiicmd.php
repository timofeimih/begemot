// yiicmd.php
<?php
// change the following paths if necessary
$yii 	=   './../yiic';
$config =	'./../config/console.php';
 
// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createConsoleApplication($config)->run();