<?php

class Beans_TmallPayment extends Beans_Base {

    public $payment_method = array(
        'PBI' => 0x1, // Credit card payment by installments
        'AliFastP' => 0x10, // Ali Fast Payment By binded Savings Card
        'AliSavingsCardP' => 0x100, // Ali savings card Payment
        'AliOrderedHelpP' => 0x1000, // Ordered And call other Pay it for
        'AliMobileRechargeP' => 0x10000, // 手机充值支付.
        'AliOfflineP' => 0x100000, // 
        'AliUserBalanceP' => 0x1000000, // 余额支付.
    );

}