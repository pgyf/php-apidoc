<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core;

/**
 * Description of Util
 *
 * @author 最初的梦想
 */
class Util {

    /**
     * 是否base64
     * @param type $str
     * @return boolean
     */
    public static function base64Decode($str) {
        if (!empty($str)) {
            $decode = base64_decode($str);
            if ($str == base64_encode($decode)) {
                return $decode;
            }
        }
        return $str;
    }

    /**
     * 递归合并数组  如果键有相同 后覆盖前
     * @param array $args
     * @return array
     */
    public static function arrayMerge(...$args) {
        $res = array_shift($args);
        while (!empty($args)) {
            foreach (array_shift($args) as $k => $v) {
                if (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }
        return $res;
    }

}
