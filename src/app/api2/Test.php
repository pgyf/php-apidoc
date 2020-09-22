<?php

namespace app\api2;

/**
 * 测试
 * @author test
 */
class Test extends \core\Api {

    /**
     * 获取baseurl
     * @param string $appName
     * @return string
     */
    public function getBaseUrl($appName = '') {
        $baseUrl = parent::getBaseUrl($appName);
        return $baseUrl . '/test';
    }

    public function getRules() {
        return array(
            'test' => array(
                'method' => 'post',
                'url' => '/test',
                'title' => '测试接口',
                'desc' => '测试接口描述',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号，账号需要唯一'),
                    'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
                    'avatar' => array('name' => 'avatar', 'default' => '', 'max' => 500, 'desc' => '头像链接'),
                    'sex' => array('name' => 'sex', 'type' => 'int', 'default' => 0, 'desc' => '性别，1男2女0未知'),
                    //在文档不显示 is_doc_hide
                    'email' => array('is_doc_hide' => 1, 'name' => 'email', 'default' => '', 'max' => 50, 'desc' => '邮箱'),
                    'mobile' => array('name' => 'mobile', 'default' => '', 'max' => 20, 'desc' => '手机号'),
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

//    /**
//     * 测试
//     * @desc 测试接口
//     * @api_url api/test
//     * @return int user_id 新账号的ID
//     */
//    public function test() {
//        return array('user_id' => 111);
//    }
}
