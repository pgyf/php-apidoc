<?php

namespace app\api\user;

/**
 * 用户插件
 * @author dogstar 20200331
 */
class User extends \core\Api {

    public function getRules() {
        return array(
            'register' => array(
                'title' => '注册',
                'method' => 'post',
                'url' => '/register',
                'desc' => '注册接口描述',
                'input' => array(
                    'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号，账号需要唯一'),
                    'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
                    'avatar' => array('name' => 'avatar', 'default' => '', 'max' => 500, 'desc' => '头像链接'),
                    'sex' => array('name' => 'sex', 'type' => 'int', 'default' => 0, 'desc' => '性别，1男2女0未知'),
                    'email' => array('name' => 'email', 'default' => '', 'max' => 50, 'desc' => '邮箱'),
                    'mobile' => array('name' => 'mobile', 'default' => '', 'max' => 20, 'desc' => '手机号'),
                ),
                'return' => array(
                    'mobile' => array('name' => 'mobile', 'type' => 'string', 'desc' => '手机号'),
                ),
            ),
            'login' => array(
                'title' => '登录',
                'method' => 'post',
                'url' => '/login',
                'desc' => '登录接口描述',
                'input' => array(
                    'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号'),
                    'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
                ),
                'return' => array(
                    'mobile' => array('name' => 'mobile', 'type' => 'string', 'desc' => '手机号'),
                ),
            ),
        );
    }

}
