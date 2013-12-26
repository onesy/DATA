<?php
/**
 * @author sunyuw <leentingOne@gmail.com>
 * @date 2013.11.6
 */
class Controller_Base {
    
    private static $instance = array();

    public static function Instance($classname) {
        if ( ! self::$instance[$classname] instanceof $classname) {
            self::$instance[$classname] = new $classname;
        }
        self::Init($classname);
        return self::$instance[$classname];
    }
    
    public static function Init($classname) {
        
        $args = DATASystem::GetRepuestAll();
        
        $cookies = DATASystem::GetCookieAll();
        
        if (empty($args)) {
            throw new ProjectException("参数为空");
        }
        
        self::$instance[$classname]->src = isset($args['src']) ? $args['src'] : '';
        
        self::$instance[$classname]->module = isset($args['module']) ? $args['module'] : '';

        self::$instance[$classname]->data = isset($args['data']) ? $args['data'] : '';
        
        self::$instance[$classname]->referer_site = isset($args['referer_site']) ? $args['referer_site'] : '';
        
        self::$instance[$classname]->from = isset($args['from']) ? $args['from'] : '';
        
        self::$instance[$classname]->uid = isset($cookies['uid']) ? $cookies['uid'] : '';
        
        self::$instance[$classname]->token = isset($cookies['token']) ? $cookies['token'] : '';
        
        self::$instance[$classname]->session_id = isset($cookies['PHPSESSID']) ? $cookies['PHPSESSID'] : '';
        
        self::$instance[$classname]->site = isset($cookies['current_site']) ? $cookies['current_site'] : 'cd';
    }
}
