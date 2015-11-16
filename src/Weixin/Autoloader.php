<?php

class Weinxin_Autoloader {
    /**
     * 自动加载方法.
     *
     * @author Cui
     *
     * @date   2015-07-29
     *
     * @param string $class 类名
     * @param array  $param 参数
     */
    public static function autoload($class) {
        static $_map;
        if (!isset($_map[$class])) {
            $class = str_replace(__NAMESPACE__, '', $class);
            $file = (__DIR__ . $class . '.class.php');
            if (!file_exists($file)) {
                return false;
            }

            include $file;

            $_map[$class] = $file;
        }
    }
}