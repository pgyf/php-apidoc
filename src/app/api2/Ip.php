<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api2;

/**
 * IP查询
 * @author 最初的梦想
 */
class Ip extends \core\Api {
    
   public function getRules() {
        return array(
            'getIp' => array(
                'title' => 'ip查询接口',
                'desc' => 'ip查询接口描述',
                'url' => '/service/getIpInfo2.php',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'ip' => array('name' => 'ip', 'require' => true, 'min' => 1, 'max' => 16, 'desc' => 'ip'),
                ),
            ),
        );
    }
}
