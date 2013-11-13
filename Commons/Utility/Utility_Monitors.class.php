<?php
class Utility_Monitors {
    private static $callBackStack = array();
    private static $callBackFunctions = array();
    private static $callBackRedisStack = array();
    private static $callBackMemcacheStack = array();
    private static $callBackRpcStack = array();

    public static function getCallBackStack(){
        return self::$callBackStack;
    }

    public static function getCallBackRedisStack(){
        return self::$callBackRedisStack;
    }

    public static function getCallBackMemcacheStack(){
        return self::$callBackMemcacheStack;
    }

    public static function getCallBackRpcStack(){
        return self::$callBackRpcStack;
    }
    
    public static function addCallBack($className, $funcName){
        self::$callBackFunctions[] = array($className, $funcName);
    }

    public static function sqlMonitorCallback($dbConn, $func, $stage, $affectedRows) {
        if ( self::$callBackFunctions ) {
            foreach (self::$callBackFunctions as $function) {
                try {
                    call_user_func($function, $dbConn, $func, $stage, $affectedRows);
                } catch (Exception $exc) {
                    var_export($function, $return);
                    echo $exc->getTraceAsString();
                }
            }
        }
    }

    /**
     * 输出页面的sql到stack
     * @staticvar int $lastBeginTime
     * @param string $dbConn
     * @param string $func
     * @param string $stage
     * @param string $affectedRows
     */
    public static function sqlMonitorCallbackByStack ($dbConn, $func, $stage, $affectedRows) {
        static $lastBeginTime;
        if($stage == 'begin') {
            $logStr = '<font color="#FF9900">SQL:</font>'.$dbConn->getLastSql() ;
            $lastBeginTime = microtime(true);
        }
        if($stage == 'end') {
            $timeDelta = microtime(true) - $lastBeginTime;
            if(defined('SHOWMONITORS') && SHOWMONITORS){
                $ShowMonitors = DATAGlobalVars::get('ShowMonitors');
                if($ShowMonitors['Monitors'] && $ShowMonitors['Monitors']['sql']['show']){
                    if((float)$timeDelta > $ShowMonitors['Monitors']['sql']['maxTime']){
                        $logStr = "; 耗时:[<font color='red'>$timeDelta</font>]秒";
                    }else {
                        $logStr = "; 耗时:[$timeDelta]秒";
                    }
                }
            }
        }
        self::$callBackStack[] = $logStr;
    }

    public static function rpcMonitorCllbackByStack ($name, $parameters ,$res) {
        $parameter = "<font color='#99ff00'>Rpc:</font><font color='red'>[</font><font color='#12ff00'>Request:</font> \"$name\"";
        $parameter .= ' Parameters:'.self::exportArray($parameters);
        $parameter .=" <font color='#12ff00'>Response:</font> ".self::exportArray($res)."<font color='red'>]</font>";
        self::$callBackRpcStack[] = $parameter;
    }
    /**
     * 输出页面的redis到stack
     * @param string  $name
     * @param unknown_type $parameters
     */
    public static function redisMonitorCallbackByStack ($name, $parameters){
        $name = strtoupper($name);

        $AnctionName = array('MULTI','EXEC','CONNECT');//不需要记录的操作命令
        if(in_array($name, $AnctionName)){
            return ;
        }
        $parameter = "<font color='#99CC00'>Redis:</font> \"$name\"";
        
//         if (!is_array($parameters))
//             $parameter .= "  \"$parameters\"";
//         else {
//             foreach ($parameters as $v){
//                 $v = self::exportArray($v);
//                 $parameter .= "  \"$v\"";
//             }
//         }
        $parameter .= self::exportArray($parameters);
        
        if(key_exists($parameter, self::$callBackRedisStack)){
            self::$callBackRedisStack[$parameter] +=1;
        }else {
            self::$callBackRedisStack[$parameter] = 1;
        }
    }

    private static function exportArray($v){
        $re = '';
        if(is_object($v))
            $v = (array)$v;
        if(is_array($v) && $v){
            foreach ($v as $key => $val){
                $tmp = self::exportArray($val);
                if(!is_int($key)){
                    $re .= "{ $key:$tmp };";
                }else {
                    $re .= "{ $tmp };";
                }
            }
        }else {
            if($v!==0 && !$v){
                $v = 'null';
            }
            $re .= "  $v ";
        }
        return $re;
    }
    public static function memcacheMonitorCallbackByStack($key){
        $parameter = '<font color="#3399FF">Memcache: </font>'. $key;
        if(key_exists($parameter, self::$callBackMemcacheStack)){
            self::$callBackMemcacheStack[$parameter] += 1;
        }else {
            self::$callBackMemcacheStack[$parameter] = 1;
        }
    }
    /**
     * 输入sql到日志
     * @staticvar int $lastBeginTime
     * @param string $dbConn
     * @param string $func
     * @param string $stage
     * @param string $affectedRows
     */
    public static function sqlMonitorCallbackByMonologDebug($dbConn, $func, $stage, $affectedRows) {
        static $lastBeginTime;
        if($stage == 'begin')
        {
            monolog_debug("SQL/{$dbConn->getName()}", "-- $stage $func: [" . date('Y-m-d H:i:s') . "] --\n{$dbConn->getLastSql()}\n");
            $lastBeginTime = microtime(true);
        }
        if($stage == 'end')
        {
            $timeDelta = microtime(true) - $lastBeginTime;
            monolog_debug("SQL/{$dbConn->getName()}", "-- $stage $func: time: $timeDelta, affected: " . var_export($affectedRows, true) . "\n\n");
        }
    }
}