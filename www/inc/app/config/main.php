<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array (
	'name' => $params ['appName'],
	'language' => 'bg',

	'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	'preload' => array (
		'log',
		'booster'
	),

	// autoloading model and component classes
	'import' => array (
		'application.models.*',
		'application.components.*',
		'application.extensions.EGalleria.*'
	),
	'defaultController' => 'post',

	'modules' => array (
		// uncomment the following to enable the Gii tool
		'gii' => array (
			'class' => 'system.gii.GiiModule',
			'password' => 'qwerty',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array (
				'127.0.0.1',
				'::1'
			)
		),
		// 'imgManager' => array(
		// 'import'=>array('imgManager.*','imgManager.components.*'),
		// 'layout'=>'application.views.layouts.column1',
		// 'upload_directory'=>'gal_images',
		// 'max_file_number' => '10',//max number of files for bulk upload.
		// 'max_file_size' => '10mb',
		// ),
		'admin'
	),

	// application components
	'components' => array (
		// 'request' => array(
		// 'class' => 'CHttpRequest',
		// 'enableCookieValidation' => true,
		// 'enableCsrfValidation' => !isset($_POST['dontvalidate']) ? true : false,
		// 'csrfCookie' => array( 'domain' => '.' . $current_domain )
		// ),

		'user' => array (
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'loginUrl' => array (
				'site/login'
			)
		),
		// uncomment the following to enable URLs in path-format
		'urlManager' => array (
			'urlFormat' => 'path',
			'rules' => array (
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>'
			),
			'showScriptName' => false
		),
		// Auth Manager DB
		'authManager' => array (
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
			'itemTable' => 'authitem',
			'assignmentTable' => 'authassignment',
			'itemChildTable' => 'authitemchild'
		),

		'errorHandler' => array (
			// use 'site/error' action to display errors
			'errorAction' => 'site/error'
		),
		'log' => array (
			'class' => 'CLogRouter',
			'routes' => array (
				array (
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning'
				),
				array (
					'class' => 'CWebLogRoute',
					'showInFireBug' => true,
					'levels' => 'trace',
					'categories' => 'vardump'  // ,system.db.CDbCommand',
								)
			)
		),
		'booster' => array (
			'class' => 'ext.booster.components.Booster'
		)
	)
)
;