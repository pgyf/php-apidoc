<?php

namespace app\api2;

/**
 * 测试2
 * @author test
 */
class Test2 extends \core\Api {

    public function getRules() {
        return array(
            'livedetaillist' => array(
                'method' => 'post',
                'url' => '/project/livedetaillist',
                'title' => '测试接口',
                'desc' => '测试接口描述',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'header_auth' => array('name' => 'Authorization', 'require' => true, 'source' => 'header', 'desc' => 'token'),
                    'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号，账号需要唯一'),
                    'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
                ),
                'return' => array(
                    'sex' => array('name' => 'sex', 'type' => 'int', 'desc' => '性别，1男2女0未知'),
                    'email' => array('name' => 'email', 'type' => 'string', 'desc' => '邮箱'),
                    'mobile' => array('name' => 'mobile', 'type' => 'string', 'desc' => '手机号'),
                ),
            ),
            'no' => array(
                'ignore' => 1, //在文档列表不显示
            )
        );
    }
}
