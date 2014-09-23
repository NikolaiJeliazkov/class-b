<?php

// change the following paths if necessary
$yii=dirname(dirname(dirname(__FILE__))).'/inc/framework/yii.php';
$config=dirname(dirname(dirname(__FILE__))).'/inc/a.to4ka.net/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();