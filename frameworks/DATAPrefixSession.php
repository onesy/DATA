<?php

class DATAPrefixSession{

    private $keyPrefix;

    public function __construct($keyPrefix = null){
        $this->setKeyPrefix($keyPrefix);
    }

    public function setKeyPrefix($keyPrefix)
    {
        $this->keyPrefix = $keyPrefix;
    }

    public function set($key, $val)
    {
        $_SESSION[$this->keyPrefix.$key] = $val;
    }

    public function get($key, $default = null)
    {
        return isset($_SESSION[$this->keyPrefix.$key])?$_SESSION[$this->keyPrefix.$key]:$default;
    }

    public function delete($key)
    {
        unset($_SESSION[$this->keyPrefix.$key]);
    }

    /**
     * @static
     * @param $keyPrefix
     * @return DATAPrefixSession
     */
    static public function GetInstance($keyPrefix = null){
        return new DATAPrefixSession($keyPrefix);
    }
}
