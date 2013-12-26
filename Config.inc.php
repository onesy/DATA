<?php
/**
 * domain => path for index.
 */
return array(
    'domain_list' => array(
        'zhua.data.com' => __DIR__ . DIRECTORY_SEPARATOR . 'PlanY' . DIRECTORY_SEPARATOR . 'index.php'
    ),
    /**
     * IP 访问限制.
     */
    'ip_list' => array(
        'zhua.data.com' => array(
            'forbidden' => array(
                
            ),
            /*
            'allowed' => array(
                
            ),
             * 
             */
        ),
    ),
    'model' => array(
        'topology' => 'direct'
    ),
);