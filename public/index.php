<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
            
function dd($stuff) {
    $backtrace = debug_backtrace();
    echo '<b>Breakpoint on:</b> ' . $backtrace[1]['function'] . ' <b>in file</b> ' . (isset($backtrace[1]['file']) ? $backtrace[1]['file'] : '') . ' <b>@ line</b> ' . (isset($backtrace[1]['line']) ? $backtrace[1]['line'] : '') . ':';
	echo '<pre>';
	if(is_array($stuff)) {
		print_r($stuff);
	} else {
		if(is_object($stuff)) {
			var_dump($stuff);
		} else {
			echo $stuff;
		}
	}
	die();
}