<?php

namespace app\api\examples;

/**
 * 文件上传示例
 * 
 * 测试页面： http://localhost/upload.html
 *
 * @author dogstar 20170611
 */
class Upload extends \core\Api {

    public function getRules() {
        return array(
            'go' => array(
                'title' => '上传',
                'method' => 'post',
                'url' => '/go',
                'desc' => '上传接口描述',
                'input' => array(
                    'file' => array(
                        'name' => 'file', // 客户端上传的文件字段
                        'type' => 'file',
                        'require' => true,
                        'max' => 2097152, // 最大允许上传2M = 2 * 1024 * 1024, 
                        'range' => array('image/jpeg', 'image/png'), // 允许的文件格式
                        'ext' => 'jpeg,jpg,png', // 允许的文件扩展名 
                        'desc' => '待上传的图片文件',
                    ),
                ),
                'return' => array(
                    'file_url' => array('name' => 'file_url', 'type' => 'string', 'desc' => '文件地址'),
                ),
            ),
        );
    }

}
