<?php
/**
 * 请在下面放置任何您需要的应用配置
 *
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author dogstar <chanzonghuang@gmail.com> 2017-07-13
 */

return array(

    //项目名
    'api_name' => '接口文档',
    
    //接口密码
    'api_pwd'  => '123456',
    
    /**
     * 接口base url
     */
//    'apiBaseUrl' => array(
//        'api' => 'http://www.test.com',
//        'api2' => 'http://www.test2.com',
//    ),
    
    'apiList' => array(
        'api' => array(
            'name' => '项目1',
            'base_url' => 'http://www.test.com',
        ),
        'api2' => array(
            'name' => '项目2',
            'base_url' => 'https://live.imooc.com',
        )
    ),
    
    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
          //api项目
//        'api' => array(
//            'sign' => array('name' => 'sign', 'require' => true),
//        ),
//        //api2项目
//        'api2' => array(
//            'sign' => array('name' => 'sign', 'require' => true),
//        ),
    ),
    
);
