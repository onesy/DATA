<?php
$config = include 'Config.inc.php';

if ($config['model']['topology'] == 'direct'){
    $host_key = 'HTTP_HOST';
} else {
    $host_key = 'REMOTE_HOST';
}

if (isset($_SERVER[$host_key]) && isset($config['domain_list'][$_SERVER[$host_key]])) {
    $redirect_index = $config['domain_list'][$_SERVER[$host_key]];
} else {
    throw new Exception('服务器无法找到该域名对应的服务项.请联系管理员', 00000000);
}

if (isset($_SERVER['REMOTE_ADDR']) && isset($config['ip_list'][$_SERVER['REMOTE_ADDR']])) {
    $is_allowed = false;
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    // 设置了黑白名单.黑白名单只能设置一个.
    if (isset($config['ip_list'][$_SERVER[$host_key]]['forbidden'])) {
        $forbidden = $config['ip_list'][$_SERVER[$host_key]]['forbidden'];
        if(! in_array($remote_ip, $forbidden)) {
            $is_allowed = true;
        }
    } else if (isset($config['ip_list'][$_SERVER[$host_key]]['allowed'])) {
        $allowed = $config['ip_list'][$_SERVER[$host_key]]['allowed'];
        if (in_array($remote_ip, $allowed)) {
            $is_allowed = true;
        }
    }
    if (! $is_allowed) {
        header('HTTP/1.0 403 Forbidden');
        die;
    }
}

if ($real_path = realpath($redirect_index)) {
    include $real_path;
} else {
    header("Status: 404 Not Found");
    die;
}
