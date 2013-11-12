<?php
/**
 * @author sunyuw <leentingOne@gmail.com>
 * @date 2013.11.6
 * 
 * 处理折800的数据.
 */
class Controller_Zhe800 extends Controller_Base {
    
    private $instance = null;
    
    public static function Instance() {
        $this->instance =  parent::Instance(__CLASS__);
        return $this->instance;
    }
    
    /**
     * 来自主页的数据.
     */
    public function index(){
        $datas = $this->data;
        foreach ($datas as $data) {
            
        }
    }
}