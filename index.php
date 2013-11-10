<?php
include_once 'Config.inc.php';
$data = $_GET;
// echo json_encode($data);
// echo "alert(" .json_encode($data). ")";
callback($data);
function callback($parameters) {
    $rtn = array(
	'callback_name' => $parameters['callback'],
	'data' => $parameters['test'],
    );
    echo 'alert(' . json_encode($rtn) .');';
}
// http://z0.tuanimg.com/v1/2012/javascripts/utm_cookie.min.js
/**
 * 抓到的数据格式.
 * // 在主页抓取的数据的格式.
 * array(
 *     // 从哪里抓的数据.
 *      'src'='zhe800',
 *      // 抓取数据的模块.
 *      'module' => 'zhe800_index_spider',
 *     // 数据
 *      'data' => array(
 *          '1' => array(
 *                  'src_id' => '122175', 
 *                  'page_number' => '',//页数
 *                  'No' => ''//抓的时候的序号.
 *                  'time' => '1384099140000', 
 *                  'img_link' => '',
 *                  'name' => '商品名称',
 *                  'short_name' => '商品名称',
 *                  'desc' => '商品描述',
 *                  'oringin_price' => '价格的字符串，可能带钱币符号.',
 *                  'discount_price' => '折扣后的售卖价格，可能包含钱币符号',
 *                  'discount_rate' => '折扣率',
 *                  'buy_link' => '购买之前的链接',
 *                  'special_points' => array(
 *                      'delivery_fee' => '0' // 包邮.
 *                      'retrun_coins' => '0' // 返点.
 *                   ),// 特性，
 *           ),
 *     )
 * );
 */
?>