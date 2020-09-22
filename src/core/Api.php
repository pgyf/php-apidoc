<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core;

use PhalApi\DependenceInjection;

/**
 * Api 接口服务基类
 * @exception 401 表示客户端未登录
 * @author 最初的梦想
 */
class Api extends \PhalApi\Api {

    
    /**
     * 从请求中获取项目名
     */
    public function getAppName($appName = '') {
        if(empty($appName)){
            $appName = $this->getAppDicName();
        }
        $key = 'app.apiList.' . $appName. '.name';
        return \PhalApi\DI()->config->get($key, '');
    }
    
    /**
     * 从请求中获取项目目录名
     */
    private function getAppDicName() {
        $appName = '';
        if (!empty($service = $_GET['service'])) {
            $serviceArr = explode('.', $service);
            if (!empty($serviceArr)) {
                $service = $serviceArr[0];
            }
            $serviceArr = explode('_', $service);
            if (!empty($serviceArr) && count($serviceArr) > 0) {
                $appName = $serviceArr[1];
            }
        }
        return $appName;
    }

    /**
     * 获取baseurl
     * @param string $appName
     * @return string
     */
    public function getBaseUrl($appName = '') {
        if(empty($appName)){
            $appName = $this->getAppDicName();
        }
        $key = 'app.apiList.' . $appName. '.base_url';
        return \PhalApi\DI()->config->get($key, '');
    }

    /**
     * apiurl
     * @return string
     */
    public function getApiUrl($url = '') {
        $baseUrl = $this->getBaseUrl();
        if(!empty($baseUrl)){
            $url = trim($baseUrl, '/') . '/' . $url; 
        }
        return $url;
    }
    
    
    /**
     * 获取应用参数设置的规则
     *
     * 默认情况下读取app.apiCommonRules配置，可根据需要进行重载
     * 
     * @return array
     */
    protected function getApiCommonRules() {
        $key = 'app.apiCommonRules.' . $this->getAppDicName();
//        if (!empty($service = $_GET['service'])) {
//            $serviceArr = explode('.', $service);
//            if (!empty($serviceArr)) {
//                $service = $serviceArr[0];
//            }
//            $serviceArr = explode('_', $service);
//            if (!empty($serviceArr) && count($serviceArr) > 0) {
//                $key .= '.' . $serviceArr[1];
//            }
//        }
        return \PhalApi\DI()->config->get($key, array());
    }
    
    
    /**
     * 取接口参数规则
     *
     * 主要包括有：
     * - 1、[固定]系统级的service参数
     * - 2、应用级统一接口参数规则，在app.apiCommonRules中配置
     * - 3、接口级通常参数规则，在子类的*中配置
     * - 4、接口级当前操作参数规则
     *
     * <b>当规则有冲突时，以后面为准。另外，被请求的函数名和配置的下标都转成小写再进行匹配。</b>
     *
     * @uses Api::getRules()
     * @return array
     */
    public function getApiRules() {
        $rules = array();

        $allRules = $this->getRules();
        if (!is_array($allRules)) {
            $allRules = array();
        }
        $allRules = array_change_key_case($allRules, CASE_LOWER);
        $isAction = false;
        $action = strtolower(\PhalApi\DI()->request->getServiceAction()); 
        if (isset($allRules[$action]) && is_array($allRules[$action])) {
            $isAction = true;
            $rules = $allRules[$action];
        }

        if (isset($allRules['*'])) {
            $rules = array_merge($allRules['*'], $rules);
        }

        $apiCommonRules = $this->getApiCommonRules();
        if (!empty($apiCommonRules) && is_array($apiCommonRules)) {
            // fixed issue #22
            if ($this->isServiceWhitelist()) {
                foreach ($apiCommonRules as &$ruleRef) {
                    $ruleRef['require'] = false;
                }
            }
            if($isAction){
                if(isset($rules['input'])){
                    $rules['input'] = array_merge($apiCommonRules, $rules['input']);
                }
                else{
                    $rules['input'] = $apiCommonRules;
                }
            }
        }

        // 过滤置为空的参数规则 @dogstar 20191215
        foreach ($rules as $key => $rule) {
            if ($rule === NULL || $rule === FALSE) {
                unset($rules[$key]);
            }
        }
        return $rules;
    }
    

}
