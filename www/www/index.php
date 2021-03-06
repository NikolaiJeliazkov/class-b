<?php
error_reporting ( E_ALL & ~ E_NOTICE );

$incPath = dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR;

$yii = $incPath . 'framework' . DIRECTORY_SEPARATOR . 'yii.php';
$config = $incPath . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'class-b.net' . DIRECTORY_SEPARATOR . 'main.php';

// remove the following lines when in production mode
defined ( 'YII_DEBUG' ) or define ( 'YII_DEBUG', true );
// specify how many levels of call stack should be shown in each log message
defined ( 'YII_TRACE_LEVEL' ) or define ( 'YII_TRACE_LEVEL', 3 );

require_once ($yii);
Yii::createWebApplication ( $config )->run ();
