<?php
/**
 * 站点engine.
 */
class DATASiteEngine
{
    // www.data.com => array(1=> 'com' ,2=> 'data', 3 => 'www')
    public static $domain_parts = array();
    
    public static $web_root = '';
    
    public static $route_map = array();
    
    public static $route_paths = array();
    
    public static $view_controllers = array();
    
    public static $default_path = 'index';
    
    public static function setDomainParts($req_domain) {
        $req_domain_parts = explode('.', $req_domain);
        self::$domain_parts = array_reverse($req_domain_parts);
    }
    
    public static function getDomainParts() {
        return self::$domain_parts;
    }
    
    public static function setWebRoot($web_root) {
        self::$web_root = $web_root;
    }
    
    public static function getWebRoot() {
        return self::$web_root;
    }
    
    public static function setRouteMap($route_map) {
        self::$route_map = $route_map;
    }
    
    public static function getRouteMap() {
        return self::$route_map;
    }
    
    public static function setRoutePaths($req_path) {
        self::$route_paths = explode('/', $req_path);
    }
    
    public static function getRoutePaths() {
        return self::$route_paths;
    }
    
    public static function Init($config = array()) {
        if (isset($config['site_domain'])) {
            self::setDomainParts($config['site_domain']);
        }
        if (isset($config['web_root'])) {
            self::setWebRoot($config['web_root']);
        }
        if (isset($config['route_map'])) {
            self::setWebRoot($config['route_map']);
        }
    }
}
