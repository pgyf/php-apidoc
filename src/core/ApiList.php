<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core;


use PhalApi\Helper\ApiOnline;

defined('D_S') || define('D_S', DIRECTORY_SEPARATOR);

/**
 * ApiList - 在线接口列表文档 - 辅助类
 *
 * @package     PhalApi\Helper
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author      dogstar <chanzonghuang@gmail.com> 2017-11-22
 */
class ApiList extends ApiOnline
{

    public function render($tplPath = NULL) {
        parent::render($tplPath);

        //$psr4= ['app\\' => 'src/app'];
        $srcPath = 'src/app';

        // 待排除的方法
        //$allPhalApiApiMethods = get_class_methods('\\PhalApi\\Api');
        $allApiNames = array();
        $allApiS = array();
        $errorMessage = '';
        //多个项目
        $appList = listDir(API_ROOT . D_S . $srcPath, false);
        
        foreach ($appList as $appPath) {
            if (!is_string($appPath) || strpos($appPath, 'src') === FALSE) {
                continue;
            }
            $appName = basename($appPath);
            $namespace = 'app\\' . $appName;
            $allApiS[$namespace] = array();
            $files = listDir($appPath, true);
            $filePrefix = rtrim($appPath, D_S) . D_S;
            foreach ($files as $aFile) {
                $subValue = strstr($aFile, $filePrefix);
                $apiClassPath = str_replace(array($filePrefix, '.php'), array('', ''), $subValue);
                $apiClassShortName = str_replace(D_S, '_', $apiClassPath);
                $apiClassName = '\\' . $namespace . '\\' . str_replace('_', '\\', $apiClassShortName);
                if (!class_exists($apiClassName)) {
                    continue;
                }

                //  左菜单的标题
                $ref = new \ReflectionClass($apiClassName);
                $title = "//请检测接口服务注释($apiClassName)";
                $desc = '//请使用@desc 注释';
                $isClassIgnore = false; // 是否屏蔽此接口类
                $docComment = $ref->getDocComment();
                if ($docComment !== false) {
                    $docCommentArr = explode("\n", $docComment);
                    $comment = trim($docCommentArr[1]);
                    $title = trim(substr($comment, strpos($comment, '*') + 1));
                    foreach ($docCommentArr as $comment) {
                        $pos = stripos($comment, '@desc');
                        if ($pos !== false) {
                            $desc = substr($comment, $pos + 5);
                        }

                        if (stripos($comment, '@ignore') !== false) {
                            $isClassIgnore = true;
                        }
                    }
                }

                if ($isClassIgnore) {
                    continue;
                }

                $allApiS[$namespace][$apiClassShortName]['title'] = $title;
                $allApiS[$namespace][$apiClassShortName]['desc'] = $desc;
                $allApiS[$namespace][$apiClassShortName]['methods'] = array();
               
                $api = new $apiClassName();
                $methods = $api->getRules();  //array_diff(get_class_methods($apiClassName), $allPhalApiApiMethods);
                $baseUrl = $api->getBaseUrl($appName);
                //项目名
                $allApiNames[$namespace] = $api->getAppName($appName);
                foreach ($methods as $mkey => $mValue) {
                    $title = '请检测title字段';
                    $desc = '请使用desc字段描述';
                    $apiUrl = '';
                    if(!empty($mValue['ignore'])){
                        continue;
                    }
                    if(isset($mValue['url'])){
                        $apiUrl = $mValue['url'];
                    }
                    if(isset($mValue['title'])){
                        $title = $mValue['title'];
                    }
                    if(isset($mValue['desc'])){
                        $desc = $mValue['desc'];
                    }
                    $apiUrl = trim($baseUrl, '/') . '/' . trim($apiUrl, '/');         
                    $service = trim($namespace, '\\') . '.' . $apiClassShortName . '.' . ucfirst($mkey);
                    $allApiS[$namespace][$apiClassShortName]['methods'][$service] = array(
                        'service' => $service,
                        'title' => $title,
                        'desc' => $desc,
                        'url' => $apiUrl,
                    );
                }
            }
        }
        // 主题风格，fold = 折叠，expand = 展开
        $theme = isset($_GET['type']) ? $_GET['type'] : 'fold';
        if (!in_array($theme, array('fold', 'expand'))) {
            $theme = 'fold';
        }
        // 搜索时，强制采用展开主题
        if (!empty($_GET['keyword'])) {
            $theme = 'expand';
        }

        //echo json_encode($allApiS) ;
        // 字典排列与过滤
        foreach ($allApiS as $namespace => &$subAllApiS) {
            ksort($subAllApiS);
            if (empty($subAllApiS)) {
                unset($allApiS[$namespace]);
            }
        }
        unset($subAllApiS);

        $projectName = $this->projectName;

        $tplPath = !empty($tplPath) ? $tplPath : dirname(__FILE__) . '/api_list_tpl.php';
        include $tplPath;
    }

    public function makeApiServiceLink($service, $theme = '') {
        $concator = strpos($this->getUri(), '?') ? '&' : '?';
        return $this->getUri() . $concator . 'service=' . $service . '&detail=1' . '&type=' . $theme;
    }

    public function getUri() {
        return $uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
    }

    public function makeThemeButton($theme) {
        $curUrl = $_SERVER['SCRIPT_NAME'];
        if ($theme == 'fold') {
            echo '<div style="float: right"><a href="' . $curUrl . '?type=expand">'.\PhalApi\T('Expand All').'</a></div>';
        } else {
            echo '<div style="float: right"><a href="' . $curUrl . '?type=fold">'.\PhalApi\T('Fold All').'</a></div>';
        }
    }

}

function listDir($dir, $recursion = true) {
    $dir .= substr($dir, -1) == D_S ? '' : D_S;
    $dirInfo = array();
    foreach (glob($dir . '*') as $v) {
        if (is_dir($v) && $recursion) {
            $dirInfo = array_merge($dirInfo, listDir($v, $recursion));
        } else {
            $dirInfo[] = $v;
        }
    }
    return $dirInfo;
}

function saveHtml($webRoot, $name, $string) {
    $dir = $webRoot . D_S . 'docs';
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    $handle = fopen($dir . DIRECTORY_SEPARATOR . $name . '.html', 'wb');
    fwrite($handle, $string);
    fclose($handle);
}

