<?php

namespace app\api\examples;

/**
 * 屏蔽的类
 * @ignore
 * @desc 主要用于说明，当使用了下面这个ignore注解时，则不会显示在接口列表文档上
 */
class Nothing extends \core\Api {

    public function getRules() {
        return array(
            'foo' => array(
                'ignore' => 1, //屏蔽的接口
                'title' => 'foo',
                'method' => 'post',
                'url' => '/go',
                'desc' => '上传接口描述',
            )
        );
    }

}
