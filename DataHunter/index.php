<?php
define('DEBUG', true);
define('DATA_ROOT', __DIR__);
define('FRAMEWORK_ROOT', __DIR__ . '/' . 'frameworks' . '/');
global $config;
$common_config = include_once 'ConfigCommon.inc.php';
$config_inc = include_once 'Config.inc.php';
$debug_config = array();
if (defined(DEBUG) && DEBUG) {
    global $debug_config ;
    $debug_config = include_once 'ConfigDebug.inc.php';
}
$config = array_merge($common_config, $config_inc);
$config = array_merge($config, $debug_config);
include FRAMEWORK_ROOT . 'DATAFrameworkLoader.class.php';

/*
$data = $_GET;
// echo json_encode($data);
// echo "alert(" .json_encode($data). ")";
callback($data);
function callback($parameters) {
    $rtn = array(
	'callback_name' => $parameters['callback'],
	'data' => $parameters['test'],
    );
    echo 'alert(' . json_encode($rtn) .');';
}
 * 
 */
// http://z0.tuanimg.com/v1/2012/javascripts/utm_cookie.min.js
