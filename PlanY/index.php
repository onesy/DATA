<?php
global $config;
include 'Config/Constant.inc.php';
$common_config = include_once 'Config/Common.inc.php';
$config_inc = include_once 'Config/Config.inc.php';

$debug_config = array();
if (defined(DEBUG) && DEBUG) {
    $debug_config = include_once 'Config/Debug.inc.php';
}
$config = array_merge($common_config, $config_inc);
$config = array_merge($config, $debug_config);
include FRAMEWORK_ROOT . 'DATAFrameworkLoader.class.php';

/**
 * 初始化框架.以及装载函数.
 */
DATAFrameworkClassLoader::Initialize($config);
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
