<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$params = require(dirname(__FILE__).'/params.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
	'name'=>$params['appName'],
	'language' => 'bg',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap', // preload the bootstrap component
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.EGalleria.*'
	),
	'defaultController'=>'post',

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'qwerty',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'imgManager' => array(
			'import'=>array('imgManager.*','imgManager.components.*'),
			'layout'=>'application.views.layouts.column1',
			'upload_directory'=>'gal_images',
			'max_file_number' => '10',//max number of files for bulk upload.
			'max_file_size' => '10mb',
		),
	),

	// application components
	'components'=>array(
// 		'request' => array(
// 			'class' => 'CHttpRequest',
// 			'enableCookieValidation' => true,
// 			'enableCsrfValidation' => !isset($_POST['dontvalidate']) ? true : false,
// 			'csrfCookie' => array( 'domain' => '.' . $current_domain )
// 		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>false,
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=classbn_a',
			'emulatePrepare' => true,
			'username' => 'classbn_www',
			'password' => '3301',
			'charset' => 'utf8',
			'enableParamLogging'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
// 					'class'=>'CWebLogRoute',
// 					'levels'=>'trace,info,error,warning',
// 					'filter' => array(
// 						'class' => 'CLogFilter',
// 						'prefixSession' => true,
// 						'prefixUser' => false,
// 						'logUser' => false,
// 						'logVars' => array(),
// 					),
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>$params,

);