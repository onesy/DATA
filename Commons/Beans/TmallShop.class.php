<?php

class Beans_TmallShop extends Beans_Base {

    public $shop = array(
        'shop_name' => '', // 店铺名称.
        'shop_link' => '', // 店铺链接.
        'shop_id' => 100315198,
        'shop_category' => '', // 品牌直销？代理？一般的店铺?
        'time_stamp' => '', // 如果之前采集过，则这个处理时候应该是最后更新时间，否则就是首次采集时间.
    );

}
