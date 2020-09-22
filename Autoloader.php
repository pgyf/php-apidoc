<?php
/**
 * Description of autoload
 *
 * @author Administrator
 */
class Autoloader {

    public static $classMap = array();
    public static $aliases = array(
        '@app' => __DIR__ . '/src/app',
        '@core' => __DIR__ . '/src/core',
    );

    public static function getAlias($alias, $throwException = true) {
        if (strncmp($alias, '@', 1)) {
            // not an alias
            return $alias;
        }
        $pos = strpos($alias, '/');
        $root = $pos === false ? $alias : substr($alias, 0, $pos);
        if (isset(static::$aliases[$root])) {
            if (is_string(static::$aliases[$root])) {
                return $pos === false ? static::$aliases[$root] : static::$aliases[$root] . substr($alias, $pos);
            }
            foreach (static::$aliases[$root] as $name => $path) {
                if (strpos($alias . '/', $name . '/') === 0) {
                    return $path . substr($alias, strlen($name));
                }
            }
        }
        if ($throwException) {
            throw new \InvalidArgumentException("Invalid path alias: $alias");
        }
        return false;
    }

    public static function autoload($className) {
        // 自动加载类
        if (isset(static::$classMap[$className])) {
            // 如果 $classMap 中存在该类，就直接使用
            $classFile = static::$classMap[$className];
            // 如果第一个字符串为'@'，就意味着对应的文件地址是别名，就将它转化成真实的文件地址
            if ($classFile[0] === '@') {
                $classFile = static::getAlias($classFile);
            }
        } elseif (strpos($className, '\\') !== false) {
            // 如果存在'\\',就意味着含有 namespace,可以拼成别名，再根据别名获取真实的文件地址
            $classFile = static::getAlias('@' . str_replace('\\', '/', $className) . '.php', false);
            // 没取到真是文件地址或者获取的地址不是一个文件，就返回空
            if ($classFile === false || !is_file($classFile)) {
                return;
            }
        } else {
            return;
        }
        // 引入该类的文件
        include($classFile);

        // 如果是调试模式，而且 $className 即不是类，不是接口，也不是 trait，就抛出异常
        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new \Exception("Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }

}