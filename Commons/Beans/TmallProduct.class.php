<?php

class Beans_TmallProduct extends Beans_Base {

    private $Product_Info = array(
        'prod_t_id' => '', // 产品再淘宝的id.
        'shop_id' => 100315198,
        
        'prod_t_id_value' => array(
            'src_catch_url' => '',// 抓取的时候的url
            'prod_t_id' => '', // 产品再淘宝 de id.
            'prod_title' => '',
            'prod_title_add_info' => '',
            'production_info' => array(
                'brand_name' => 'ANSHiS/安泽秀',
                't_brand_id' => 3358647,
                't_category_id' => 50010808,
                't_item_id' => 17625351232,
            ),
            'origin_price' => '',
            'discount_price' => '',
            'score' => '',
            'collection_count' => '', // 商品收藏数.
            'month_sales' => '',
            'comment_count' => '',
            'stock' => '',
            'Integration_return_category' => '',// 返点类型
            'Integration_return' => '',// 返点
            'payment_method' => 0x1,
            'Pledge' => array( // 服务承诺.
                'Commodity' => array(
                    'all' => '按时发货',
                ),
                'Refund' => array(
                    'T3' => '极速退款',
                ),
                'ReturnOfGoods' => array(
                    'T1' => '退货保障卡',
                ),
            ),
            // http://detail.tmall.com/item.htm?id=18206507787
            
            'prod_promo_info' => array(),
        ),
    );
    
    public function InitBeans(String $production_json) {
        
    }
}
