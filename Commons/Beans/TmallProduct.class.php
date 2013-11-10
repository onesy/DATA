<?php

class Beans_TmallProduct extends Beans_Base {

    private $Product_Info = array(
        'prod_t_id' => '', // 产品再淘宝的id.
        'Business' => array(
            'shop_name' => '', // 店铺名称.
            'shop_link' => '', // 店铺链接.
            'shop_id' => 100315198,
            'shop_category' => '',// 品牌直销？代理？一般的店铺?
        ),
        
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
            'payment_method' => array(
                'PBI' => 0, // Credit card payment by installments
                'AliFastP' => 0, // Ali Fast Payment By binded Savings Card
                'AliSavingsCardP' => 0, // Ali savings card Payment
                'AliOrderedHelpP' => 0, // Ordered And call other Pay it for
                'AliMobileRechargeP' => 0, // 手机充值支付.
                'AliOfflineP' => 0, // 
                'AliUserBalanceP' => 0, // 余额支付.
            ),
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
            'Packages' => array(
                'P1' => array(
                    'meal_id' => 87857998,
                    'P_price' => '29.00',
                    'save' => '93.00',
                    'P_link' => 'http://detail.taobao.com/meal_detail.htm?meal_id=87857998',
                    'P1_item_1_id' => array(),
                    'P1_item_2_id' => array(
                        'prod_t_id' => 18206507787,
                        'item_title' => '韩国安泽秀滢亮液体唇膏8.5g裸色染色唇彩秒杀包邮不掉色唇彩正品',
                        'origin_price' => '原价：28.00',
                        'item_link' => 'http://detail.tmall.com/item.htm?id=18206507787',
                    ),
                    'P1_item_3_id' => array(),
                ),
            ),
            'prod_promo_info' => array(),
        ),
    );
    
    private $Comments = array(
        'aliMallSeller' => false,
        'anony' => true,
        'appendComment' => '',
        'attributes' => '',
        'auctionSku' => '颜色分类:08#海棠红',
        'displayRateSum' => 159,
        'displayUserLink' => 'http://jianghu.taobao.com/u/NzM5MjMyMjIy/front.htm',
        'displayUserNick' => '宝宝昕914',
        'displayUserNumId' => 739232222,
        'displayUserRateLink' => '',
        'dsr' => 0,
        'fromMall' => true,
        'fromMemory' => 0,
        'id' => 24861322640,
        'rateContent' => '很满意，特别喜欢卖家的小礼物',
        'rateDate' => '2012-12-17 21:57:36',
        'reply' => '',
        'serviceRateContent' => '',
        'tamllSweetLevel' => 2,
        'tmallSweetPic' => 'tmallSweetPic',
        'useful' => true,
        'userInfo' => '',
        'userVipLevel' => 0,
        'userVipPic' => "",
    );
    
    private $TransactionRecords = array(
        'total_volume' => 1089,
        'recently_volume' => 120,
        'data' => array(
            // 未完成.
        ),
    );
    
}
