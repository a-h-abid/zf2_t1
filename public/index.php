<?php

/**
 * Required PHP verison 5.4.0
 */
if ( ! version_compare(PHP_VERSION, '5.4') ) {
	die('This App requires PHP version 5.4.0 at least to run.');
}

/**
 * Display all errors when APPLICATION_ENV is development.
 */
if (getenv('APPLICATION_ENV') == 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    define('ZF_DEBUG',true);
} else {
	error_reporting(E_ALL);
    ini_set("display_errors", 0);
    define('ZF_DEBUG',false);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'vendor/autoload.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
