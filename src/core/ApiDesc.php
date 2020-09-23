<?php

namespace core;

use PhalApi\Helper\ApiOnline;
use PhalApi\Exception;
use core\ApiFactory;
use core\Util;

/**
 * Description of ApiDesc
 *
 * @author 最初的梦想
 */
class ApiDesc extends ApiOnline {

    public function render($tplPath = NULL) {
        parent::render($tplPath);

        $service = \PhalApi\DI()->request->getService();
        $namespace = \PhalApi\DI()->request->getNamespace();
        $api = \PhalApi\DI()->request->getServiceApi();
        $action = \PhalApi\DI()->request->getServiceAction();

        $namespace = str_replace('_', '\\', $namespace); // 支持多级命名空间，扩展类库接口需要用到 @dogstar 20200114
        $className = '\\' . $namespace . '\\' . str_replace('_', '\\', ucfirst($api));
        $rules = array();
        $returns = array();
        $description = '请使用title字段';
        $descComment = '请使用desc字段';
        $exceptions = array();
        $apiMethod = 'get';
        $apiUrl = '';
        $baseUrl = '';
        $projectName = $this->projectName;

        try {
            $pai = ApiFactory::generateService(FALSE);
            $rules = $pai->getApiRules();
            $apiUrl = $baseUrl = $pai->getBaseUrl();
        } catch (Exception $ex) {
            $service .= ' - ' . $ex->getMessage();
            var_dump($service);
            exit;
            include dirname(__FILE__) . '/api_desc_tpl.php';
            return;
        }


        // 整合需要的类注释，包括父类注释
        $rClass = new \ReflectionClass($className);
        $classDocComment = $rClass->getDocComment();
        while ($parent = $rClass->getParentClass()) {
            if ($parent->getName() == '\\PhalApi\\Api') {
                break;
            }
            $classDocComment = $parent->getDocComment() . "\n" . $classDocComment;
            $rClass = $parent;
        }
        $needClassDocComment = '';
        foreach (explode("\n", $classDocComment) as $comment) {
            if ($pos = stripos($comment, '@exception') !== FALSE) {
                $exArr = explode(' ', trim(substr($comment, $pos + 10 + 2)));
                $exceptions[$exArr[0]] = $exArr[1];
            }
        }

        // 方法注释
        if (isset($rules['method'])) {
            $apiMethod = $rules['method'];    
            unset($rules['method']);
        }
        if (isset($rules['url'])) {
            $apiUrl = trim($baseUrl, '/') . '/' . trim($rules['url'], '/');    
            unset($rules['url']);
        }
        else if(!is_int($action)){
            $apiUrl = trim($baseUrl, '/') . '/' . trim($action, '/');    
        }
        if (isset($rules['return'])) {
            $returns = $rules['return'];
            unset($rules['return']);
        }
        if (isset($rules['title'])) {
            $description = $rules['title'];
            unset($rules['title']);
        }
        if (isset($rules['desc'])) {
            $descComment = $rules['desc'];
            unset($rules['desc']);
        }
        if (isset($rules['exceptions'])) {
            $exceptions = Util::arrayMerge($exceptions, $rules['exceptions']);
            unset($rules['exceptions']);
        }
        
        if (isset($rules['input'])) {
            $rules = $rules['input'];
        }
        else{
            $rules = [];
        }
        $tplPath = !empty($tplPath) ? $tplPath : dirname(__FILE__) . '/api_desc_tpl.php';
        include $tplPath;
    }

}
