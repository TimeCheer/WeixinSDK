<?php

namespace TimeCheer\Weixin;

/**
 * 类自动加载
 * @package timecheer.weixin
 */
class Autoloader {

    private $_dir;
    
    const PREFIX = '\\TimeCheer\Weixin\\';

    /**
     * 构造函数
     * @param string $dir 手动指定起始目录
     */
    public function __construct($dir = null) {
        if (is_null($dir)) {
            $dir = dirname(dirname(dirname(__FILE__)));
        }
        $this->_dir = $dir;
    }

    /**
     * 向PHP注册SPL autoloader
     * @param string $dir 指定加载目录
     * @return void
     */
    public static function register($dir = null) {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        
        spl_autoload_register(array(new self($dir), 'autoload'), FALSE, TRUE);
    }

    /**
     * 系统自动注册
     *
     * @param string $class 类名
     *
     * @return boolean 正常加载返回true
     */
    public function autoload($class) {
        if (0 !== strpos($class, self::PREFIX)) {
            return false;
        }

        if (file_exists($file = $this->_dir . '/' . str_replace('\\', '/', $class) . '.php')) {
            require_once $file;
            
            return true;
        }
        
        return false;
    }

}
