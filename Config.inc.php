<?php
define('DATA_ROOT', __DIR__);
define('FRAMEWORK_ROOT', __DIR__ . '/' . 'frameworks' . '/');

include_once FRAMEWORK_ROOT . 'DATAFrameworkLoader.class.php';
global $FRAMEWORK_CONFIG;

$FRAMEWORK_CONFIG['framework_file_necessary'] = array(
    'DATACodeDefine.class.php', 
    'DATAFramework.class.php', 
    'DATAFrameworkLoader.class.php',
    );