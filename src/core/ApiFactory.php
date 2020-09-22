<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core;

use PhalApi\DependenceInjection;
use PhalApi\Exception\BadRequestException;
use PhalApi\Exception\InternalServerErrorException;

/**
 * Description of ApiFactory
 *
 * @author 最初的梦想
 */
class ApiFactory extends \PhalApi\ApiFactory{
    /**
     * 创建服务器
     * 根据客户端提供的接口服务名称和需要调用的方法进行创建工作，如果创建失败，则抛出相应的自定义异常
     *
     * 创建过程主要如下：
     * - 1、 是否缺少控制器名称和需要调用的方法
     * - 2、 控制器文件是否存在，并且控制器是否存在
     * - 3、 方法是否可调用
     * - 4、 控制器是否初始化成功
     *
     * @param boolen $isInitialize 是否在创建后进行初始化
     * @param string $_REQUEST['service'] 接口服务名称，格式：XXX.XXX
     * @return \PhalApi\Api 自定义的控制器
     *
     * @uses \PhalApi\Api::init()
     * @throws BadRequestException 非法请求下返回400
     */
    static function generateService($isInitialize = TRUE) {
        $di         = DependenceInjection::one();
        $service    = $di->request->getService();
        $namespace  = $di->request->getNamespace();
        $api        = $di->request->getServiceApi();
        $action     = $di->request->getServiceAction();
        if (empty($api) || empty($action)) {
            throw new BadRequestException(
                \PhalApi\T('service ({service}) illegal', array('service' => $service))
            );
        }

        $apiClass = '\\' . str_replace('_', '\\', $namespace) 
            . '\\' . str_replace('_', '\\', ucfirst($api));

        if (!class_exists($apiClass)) {
            throw new BadRequestException(
                \PhalApi\T('no such service as {service}', array('service' => $service)), 4
            );
        }

        $api = new $apiClass();

        if (!is_subclass_of($api, '\\PhalApi\\Api')) {
            throw new InternalServerErrorException(
                \PhalApi\T('{class} should be subclass of \\PhalApi\\Api', array('class' => $apiClass))
            );
        }

//        if (!method_exists($api, $action) || !is_callable(array($api, $action))) {
//            throw new BadRequestException(
//                \PhalApi\T('no such service as {service}', array('service' => $service)), 4
//            );
//        }

        if ($isInitialize) {
            $api->init();
        }

        return $api;
    }
}
