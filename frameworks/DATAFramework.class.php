<?php

function DATAGetRequestInt($r,$default=0){
    return isset($_REQUEST[$r])?intval($_REQUEST[$r]):$default;
}
function DATAGetRequestFloat($r,$default=0){
    return isset($_REQUEST[$r])?floatval($_REQUEST[$r]):$default;
}
function DATAGetRequest($r,$default=null){
    return isset($_REQUEST[$r])?$_REQUEST[$r]:$default;
}

function DATAGetPostInt($r,$default=0){
    return isset($_POST[$r])?intval($_POST[$r]):$default;
}
function DATAGetPostFloat($r,$default=0){
    return isset($_POST[$r])?floatval($_POST[$r]):$default;
}
function DATAGetPost($r,$default=null){
    return isset($_POST[$r])?$_POST[$r]:$default;
}

function DATAGetGetInt($r,$default=0){
    return isset($_GET[$r])?intval($_GET[$r]):$default;
}
function DATAGetGetFloat($r,$default=0){
    return isset($_GET[$r])?floatval($_GET[$r]):$default;
}
function DATAGetGet($r,$default=null){
    return isset($_GET[$r])?$_GET[$r]:$default;
}

function DATAGetSessionInt($r,$default=0){
    return isset($_SESSION[$r])?intval($_SESSION[$r]):$default;
}
function DATAGetSessionFloat($r,$default=0){
    return isset($_SESSION[$r])?floatval($_SESSION[$r]):$default;
}
function DATAGetSession($r,$default=null){
    return isset($_SESSION[$r])?$_SESSION[$r]:$default;
}

function DATAGetCookie($n, $def = null){
    return isset($_COOKIE[$n]) ? $_COOKIE[$n] : $def;
}

class DATAUtility
{
    /**
     *
     * @param array $a
     * @param array $b
     * @return array 保留a的内容的前提下，把只存在于b的内容复制到a中
     */
    static public function ArrayAddRecursive($a, $b)
    {
        foreach ($a as $key => & $v)
        {
            if(is_array($v) && isset($b[$key]))
            {
                $v = self::ArrayAddRecursive($v, $b[$key]);
            }
        }
        $a = $a + $b;
        return $a;
    }

    static public function ArraySubAddByKey($a, $b, $key)
    {
        $b = self::ArrayReindex($b, $key);
        foreach( $a as $k => $v )
        {
            if( isset($b[$v[$key]]) )
                $a[$k] = $v + $b[$v[$key]];
        }
        return $a;
    }

    static public function ArrayValueDefault($a)
    {
        $keys = func_get_args();
        array_shift($keys);
        $def = array_pop($keys);
        foreach($keys as $k)
        {
            if(!isset($a[$k]))
                return $def;
            $a = $a[$k];
        }
        return $a;
    }

    static public function ArrayValue($a)
    {
        $keys = func_get_args();
        array_shift($keys);
        foreach($keys as $k)
        {
            if(!isset($a[$k]))
                return null;
            $a = $a[$k];
        }
        return $a;
    }

    static public function ArraySub($a, $keys)
    {
        $r = array();
        foreach($keys as $k=>$v)
        {
            if(is_int($k))
            {
                if(isset($a[$v]))
                    $r[$v] = $a[$v];
            }
            else
            {
                $r[$k] = isset($a[$k]) ? $a[$k] : $v;
            }
        }
        return $r;
    }


    static public function ArrayColumnValues($ary, $k)
    {
        $a = array();
        foreach($ary as $row)
            $a[] = $row[$k];
        return $a;
    }

    static public function ArrayColumnGroup($ary, $k)
    {
        $a = array();
        foreach($ary as $row)
            $a[$row[$k]][] = $row;
        return $a;
    }

    static public function ArrayColumnJsonEncode($ary, $k)
    {
        foreach($ary as $ak=>$av)
        {
            $ary[$ak][$k] = json_encode($ary[$ak][$k]);
        }
        return $ary;
    }

    static public function ArrayColumnJsonDecode($ary, $k, $assoc = false)
    {
        foreach($ary as $ak=>$av)
        {
            $ary[$ak][$k] = json_decode($ary[$ak][$k], $assoc);
        }
        return $ary;
    }

    static public function ArrayColumnClear($ary, $k)
    {
        foreach($ary as $i=>$t)
        {
            unset($t[$k]);
            $ary[$i] = $t;
        }
        return $ary;
    }

    static public function ArrayColumnKeep($ary, $keys)
    {
        $a = array();
        foreach($ary as $i=>$t)
        {
            $item = array();
            foreach($keys as $k)
                $items[$k] = $t[$k];
            $a[$i] = $item;
        }
        return $a;
    }

    static public function ArrayColumnCount($ary, $k)
    {
        $result = array();
        foreach($ary as $i=>$t)
        {
            $v = $t[$k];
            $result[$v] = isset($result[$v]) ? ($result[$v] + 1) : 1;
        }
        return $result;
    }

    static public function ArrayColumnSearch($ary, $k, $v, $returnkey = null, $strict = false)
    {
        if($strict)
        {
            foreach($ary as $i=>$t)
            {
                if(isset($t[$k]) && $t[$k] === $v)
                {
                    if($returnkey === null)
                        return $i;
                    return $t[$returnkey];
                }
            }
        }
        else
        {
            foreach($ary as $i=>$t)
            {
                if(isset($t[$k]) && $t[$k] == $v)
                {
                    if($returnkey === null)
                        return $i;
                    return $t[$returnkey];

                }
            }
        }
        return false;
    }

    static public function ArrayReindex($ary, $key = null)
    {
        $a = array();
        if($key === null)
        {
            foreach($ary as $v)
                $a[] = $v;
        }
        else
        {
            foreach($ary as $v)
                $a[$v[$key]] = $v;
        }
        return $a;
    }

    static public function ExplodeLines($s, $columnNames = array())
    {
        $lineSeperator = "\n";
        if(strpos($s, $lineSeperator) === false)
            $lineSeperator = "\r";

        $columnSeperator = "\t";
        if(strpos($s, $columnSeperator) === false)
            $columnSeperator = ",";

        $lines = explode($lineSeperator, $s);
        $result = array();
        foreach($lines as $line)
        {
            $line = trim($line);
            $cells = explode($columnSeperator, $line);
            $resultRow = array();
            foreach($cells as $i=>$value)
            {
                $k = empty($columnNames[$i]) ? $i : $columnNames[$i];
                $resultRow[$k] = $value;
            }
            if($resultRow)
                $result[] = $resultRow;
        }
        return $result;
    }

    static public function PregValues($re, $string, $key = null)
    {
        if( preg_match_all($re, $string, $matches) === false)
            return false;

        if(is_null($key))
        {
            if(count($matches) == 1)
                return $matches[0];

            if(count($matches) == 2 && isset($matches[1]))
                return $matches[1];
        }
        else
        {
            if(isset($matches[$key]))
                return $matches[$key];
        }
        return false;
    }
    static public function RandomString($len, $chars = null)
    {
        $t = '';
        if( ! $chars)
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        $min = 0;
        $max = strlen($chars) - 1;

        for($i = 0; $i < $len; $i ++)
            $t .= $chars[mt_rand($min, $max)];
        return $t;
    }


    static public function Format($s, $a)
    {
        return preg_replace('/\{%(\w+)([^}]*)\}/e', '$a["\1"]\2', $s);
    }
    static public function IsValidName($s)
    {
        return preg_match('/^\w+$/', $s) != 0;
    }

    static public function IsValidCodeSymbol($s)
    {
        return preg_match('/^\w+$/', $s) != 0;
    }
    static public function IsValidEMail($s)
    {
        return preg_match('/^[^@]+@[^@]+\.[^@]+$/', $s) != 0;
    }

    static public function IsValidDate($s)
    {
        return preg_match('/^\d+-\d+-\d+$/', $s) != 0;
    }

    static public function IsValidDatetime($s)
    {
        return preg_match('/^\d+-\d+-\d+ \d+:\d+:\d+$/', $s) != 0 || IsValidDate($s);
    }

    static public function IsValidDateLongFormat($s)
    {
        return preg_match('/^\d\d\d\d-\d\d-\d\d$/', $s);
    }

    static public function IsValidTime($s)
    {
        return preg_match('/^(\d+:)*\d+$/', $s) != 0;
    }

    static public function IsValidMobilePhone($s)
    {
        return strlen($s) >= 11;
    }
}
