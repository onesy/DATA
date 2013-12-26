<?php
/**
 * @author sunyuw <leentingOne@gmail.com>
 * @date 2013.11.6
 * 
 * 咱们来堵一把.
 */

class Contoller_Bate extends Controller_Base {
    
    private $instance = null;
    
    public static function Instance() {
        $this->instance =  parent::Instance(__CLASS__);
        return $this->instance;
    }
}
