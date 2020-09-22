<?php
namespace app\api;


/**
 * 默认接口服务类
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */
class Site extends \core\Api {
    public function getRules() {
        return array(
            'index' => array(
                'title' => '测试接口',
                'url' => '/test',
                'desc' => '测试接口描述',
                'input' => array(
                    'username'  => array('name' => 'username', 'default' => 'test', 'desc' => '用户名'),
                ),
                'return' => array(
                    'mobile' => array('name' => 'mobile', 'type' => 'string', 'desc' => '手机号'),
                ),
            ),
        );
    }
}
