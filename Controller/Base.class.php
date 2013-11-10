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
    
    public static function Init($classname){
        
        $args = empty($_GET) ? $_POST : $_GET;
        
        if (empty($args)) {
            throw new ProjectException("参数为空");
        }
        
        self::$instance[$classname]->src = isset($args['src']) ? $args['src'] : '';
        
        self::$instance[$classname]->module = isset($args['module']) ? $args['module'] : '';

        self::$instance[$classname]->data = isset($args['data']) ? $args['data'] : '';
    }
}
