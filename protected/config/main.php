<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Time to pray',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'eddsees.empt8',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			// 'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'session' => array(
			'autoStart'=>true,
		),
		'facebook'=>array(
			'class' => 'ext.yii-facebook-opengraph.SFacebook',
			'appId'=>'292898010730930', // needed for JS SDK, Social Plugins and PHP SDK
			'secret'=>'9d99741e688368fa6cfaa813b0d4eca0', // needed for the PHP SDK 
			'locale'=>'es_ES', // override locale setting (defaults to en_US)
			// 'jsSdk'=>true, // don't include JS SDK
			// 'async'=>true, // load JS SDK asynchronously
			// 'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
			// 'status'=>true, // JS SDK - check login status
			// 'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
			// 'oauth'=>true,  // JS SDK - enable OAuth 2.0
			// 'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
			//'frictionlessRequests'=>true, // JS SDK - enable frictionless requests for request dialogs
			// 'html5'=>true,  // use html5 Social Plugins instead of XFBML
			'ogTags'=>array(  // set default OG tags
				'title'=>'Time to pray',
				'description'=>'Sitio web para orar con otros',
				// 'image'=>'URL_TO_WEBSITE_LOGO',
			),
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),/*
		// uncomment the following to use a MySQL database
		/*/


		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_ttpray',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
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
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);