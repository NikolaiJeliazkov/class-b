<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$params = require (dirname ( __FILE__ ) . '/params.php');
$mainConfig = require (dirname ( dirname ( __FILE__ ) ) . '/main.php');

return CMap::mergeArray ( $mainConfig, array (
	'name' => $params ['appName'],
	'language' => 'bg',
	'components' => array (
		'db' => array (
			'connectionString' => 'mysql:host=localhost;dbname=classbn_main',
			'emulatePrepare' => true,
			'username' => 'classbn_www',
			'password' => '3301',
			'charset' => 'utf8',
			'enableParamLogging' => true
		)
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => $params
) );