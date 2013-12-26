<?php

class DATASystem
{
    static public $ErrorLogHandler;
    static public $ErrorLogIgnoreExportFunctionPatterns = array();
    static public $ErrorLogVarExport = array('DATASystem', 'VarExportScalarAndArray');

    static public function IsRequestMethodPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    static public function GetRequestInt($r,$default=0){
        return isset($_REQUEST[$r])?intval($_REQUEST[$r]):$default;
    }
    static public function GetRequestFloat($r,$default=0){
        return isset($_REQUEST[$r])?floatval($_REQUEST[$r]):$default;
    }
    static public function GetRequest($r,$default=null){
        return isset($_REQUEST[$r])?$_REQUEST[$r]:$default;
    }
    
    static public function GetGetAll($default = null){
        return isset($_GET) ? $_GET : $default;
    }
    
    static public function GetPostAll($default = null) {
        return isset($_POST) ? $_POST : $default;
    }
    
    static public function GetRepuestAll($default = null) {
        return isset($_REQUEST) ? $_REQUEST : $default;
    }
    
    static public function GetCookieAll($default = null) {
        return isset($_COOKIE) ? $_COOKIE : $default;
    }

    static public function GetPostInt($r,$default=0){
        return isset($_POST[$r])?intval($_POST[$r]):$default;
    }
    static public function GetPostFloat($r,$default=0){
        return isset($_POST[$r])?floatval($_POST[$r]):$default;
    }
    static public function GetPost($r,$default=null){
        return isset($_POST[$r])?$_POST[$r]:$default;
    }

    static public function GetGetInt($r,$default=0){
        return isset($_GET[$r])?intval($_GET[$r]):$default;
    }
    static public function GetGetFloat($r,$default=0){
        return isset($_GET[$r])?floatval($_GET[$r]):$default;
    }
    static public function GetGet($r,$default=null){
        return isset($_GET[$r])?$_GET[$r]:$default;
    }

    static public function GetSessionInt($r,$default=0){
        return isset($_SESSION[$r])?intval($_SESSION[$r]):$default;
    }
    static public function GetSessionFloat($r,$default=0){
        return isset($_SESSION[$r])?floatval($_SESSION[$r]):$default;
    }
    static public function GetSession($r,$default=null){
        return isset($_SESSION[$r])?$_SESSION[$r]:$default;
    }

    static public function GetCookie($n, $def = null){
        return isset($_COOKIE[$n]) ? $_COOKIE[$n] : $def;
    }

    static public function Redirect($url, $code = 302)
    {
        header('Location: ' . $url, true, $code);
    }
    static public function RedirectExit($url, $code = 302)
    {
        self::Redirect($url, $code);
        exit();
    }

    static public function RequireOnceProjectFile($fn)
    {
        require_once DATA_PROJECT_ROOT . $fn;
    }

    static public function RequireOnceAppFile($fn)
    {
        require_once DATA_APP_ROOT . $fn;
    }

    static public function IsHttpUserAgentSpider()
    {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $is_spider = strpos($agent, 'Googlebot') !== false
        || strpos($agent, 'Baiduspider') !== false
        || strpos($agent, 'Sosospider') !== false
        || strpos($agent, 'Sogou web spider') !== false
        || strpos($agent, 'Yahoo! Slurp') !== false
        || strpos($agent, 'msnbot') !== false
        || strpos($agent, 'Huaweisymantecspider') !== false
        || strpos($agent, 'ia_archiver') !== false  //alexa
        ;

        return $is_spider;
    }

    static public function IsHttpUserAgentContains($s)
    {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        return strpos($agent, $s) !== false;
    }

    static public function GetRemoteIpWithProxy()
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        if(isset($_SERVER['REMOTE_ADDR']))
            return  $_SERVER['REMOTE_ADDR'];
        return '';
    }
    static public function GetRemoteIp()
    {
        if(isset($_SERVER['REMOTE_ADDR']))
            return  $_SERVER['REMOTE_ADDR'];
        return '';
    }

    static public function SetHeaderContentTypeCharset($type, $charset)
    {
        header("Content-type: {$type}; charset={$charset}", true);
    }

    static public function GetHttpProxyForwardedIP()
    {
        $headers = array(
                'HTTP_VIA',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_FORWARDED',
                'HTTP_CLIENT_IP',
                'HTTP_FORWARDED_FOR_IP',
                'VIA',
                'X_FORWARDED_FOR',
                'FORWARDED_FOR',
                'X_FORWARDED',
                'FORWARDED',
                'CLIENT_IP',
                'FORWARDED_FOR_IP',
        );
        $ips = array();
        foreach($headers as $header)
        {
            if(isset($_SERVER[$header]))
                $ips[] = $_SERVER[$header];
        }
        return join(',', $ips);
    }

    //only export scalar and array. return the class name if meets an object
    static public function VarExportScalarAndArrayRecursive(& $v, $depth = 0)
    {
        $leftPadding = str_repeat('  ', $depth);
        if(is_array($v))
        {
            $mark = '__DATA_array_recursive_mark';
            if(isset($v[$mark]))
                return '*RECURSION*';

            $result = "array {\n";
            $v[$mark] = 1;
            foreach($v as $k=>&$e)
            {
                if($k !== $mark)
                {
                    $ks = is_string($k) ? ('"' . addslashes($k) . '"') : $k;
                    $result .= $leftPadding . "  $ks => " . self::VarExportScalarAndArrayRecursive($e, $depth + 1) . ",\n";
                }
            }
            unset($v[$mark]);
            $result .= $leftPadding . "}";
            return $result;
        }
        else if(is_object($v))
        {
            return get_class($v);
        }
        return var_export($v, true);
    }
    static public function VarExportScalarAndArray($v)
    {
        return self::VarExportScalarAndArrayRecursive($v);
    }

    static public function SafeUntaint( & $s)
    {
        static $hasUntaint = null;
        if($hasUntaint === null)
            $hasUntaint = function_exists('untaint');
        if($hasUntaint)
            untaint($s);
    }
}