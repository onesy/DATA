<?php
class JMMemcache
{
    private $keyPrefix;
    private $memcache;
    private $smartForceRefresh;

    public function __construct($address, $port, $keyPrefix) {
        $this->memcache = new Memcache();
        $this->memcache->pconnect($address, $port);
        $this->keyPrefix = $keyPrefix;
        $this->smartForceRefresh = false;
    }

    protected function makeRealKey($key)
    {
        if(is_array($key))
            $key = http_build_query ($key);
        if(strlen($key) > 250)
            JMSystemErrorLog (JM_LOG_WARNING, 'memcache', "Key [$key] is longer than 250");
        return $this->keyPrefix . $key;
    }

    public function get($key) {
        $this->monitors('GET', $key);
        return $this->memcache->get($this->makeRealKey($key));
    }
    
    /**
     * debug 模式查看memcache动作
     */
    private function monitors($action, $key){
        if(defined('SHOWMONITORS') && SHOWMONITORS){
            $showMonitors = JMRegistry::get('ShowMonitors');
            if(isset($showMonitors['Monitors']) && $showMonitors['Monitors']['memcache']['show']){
                Utility_Monitors::memcacheMonitorCallbackByStack("\"$action\" ".$key);
            }
        }
    }

    public function setKeyPrefix($keyPrefix) {
        $this->keyPrefix = $keyPrefix;
    }

    public function setSmartForceRefresh($enabled) {
        $this->smartForceRefresh = $enabled;
    }

    static public function GetForceRefreshKey() {
        if(defined('JM_FORCE_REFRESH_VAR_NAME'))
            return JMSystem::GetRequest(JM_FORCE_REFRESH_VAR_NAME);
        return null;
    }

    public function shouldSmartForceRefresh($key = null) {
        $doForceRefresh = false;
        $forceRefreshKey = JMMemcache::GetForceRefreshKey();
        if($this->smartForceRefresh) {
            $doForceRefresh = true;
        }
        else if($forceRefreshKey) {
            if($forceRefreshKey == 1 || ($key && $forceRefreshKey == $key))
                $doForceRefresh = true;
        }
        return $doForceRefresh;
    }

    public function smartGet($key, $ttl, $function, $params = array()) {
        $this->monitors('SMARTGET', $key);
        $realKey = $this->makeRealKey($key);

        if($this->shouldSmartForceRefresh($key))
            $value = false;
        else
            $value = $this->memcache->get($realKey);

        if ($value === false) {
            $value = call_user_func_array($function, $params);
            $this->memcache->set($realKey, $value, 0, $ttl);
        }
        return $value;
    }

    public function set($key, $value, $ttl) {
        $this->monitors('SET', $key);
        $done = $this->memcache->set($this->makeRealKey($key), $value, 0, $ttl);
        return $done;
    }

    public function delete($key) {
        $this->monitors('DELETE', $key);
        return $this->memcache->delete($this->makeRealKey($key));
    }

    public function increase($key, $value, $ttl) {
        $this->monitors('INCREASE', $key);
        return $this->memcache->increment($this->makeRealKey($key), $value, $ttl);
    }

    public function decrease($key, $value, $ttl) {
        $this->monitors('DECREASE', $key);
        return $this->memcache->decrement($this->makeRealKey($key), $value, $ttl);
    }

    public function clear() {
        $this->monitors('CLEAR', $key);
        $this->memcache->flush();
    }

    static public function GetInstance($serverName = 'default', $keyPrefix = '') {
        $config = JMRegistry::get('serverConfig');
        return new JMMemcache(
                $config['MemcachedServer'][$serverName]['host'],
                $config['MemcachedServer'][$serverName]['port'],
                $keyPrefix
        );
    }
}