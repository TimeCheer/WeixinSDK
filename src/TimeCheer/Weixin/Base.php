<?php

namespace TimeCheer\Weixin;

use \TimeCheer\Weixin\Util\HTTPClient;

/**
 * 构造用于访问API的基类
 * @package timecheer.weixin
 */
class Base {
        
    protected $errorCode = null;
    protected $errorMsg = '';
    
    protected $apiPrefix = '';
    
    protected $accessToken;

    /**
     * 构造函数、配置相关参数
     * @param string $accessToken   访问接口的$accessToken
     */
    public function __construct($accessToken = '') {
        if ($accessToken) {
            $this->init($accessToken);
        }
    }

    /**
     * 配置参数
     *
     * @param string $accessToken   访问接口的$accessToken
     */
    public function init($accessToken) {
        $this->accessToken = $accessToken;
    }

    /**
     * 接口请求方法，具体接口都调用此方法进行请求
     * @param strin $api
     * @param array $params
     * @return string
     */
    public function doGet($api, array $params = array()) {
        $res = HTTPClient::get($this->apiPrefix . $api, array_merge(
            $params,
            array('access_token' => $this->accessToken)
        ));
        
        if (false === $res) {
            $this->setError(-10, '获取数据失败!');
            return false;
        }

        return $res;
    }
    
    /**
     * 接口请求方法，具体接口都调用此方法进行请求
     * @param strin $api
     * @param array $data post的数据
     * @param array $params url中构造的参数
     * @param string $dataJsonEncoded post发出数据的格式是否需要json编码 默认为false表示常规,true json
     * @return string
     */
    public function doPost($api, array $data = array(), array $params = array(), $dataJsonEncoded = false) {
        $url = $this->apiPrefix . $api . '?' . http_build_query(array_merge(
            $params,
            array('access_token' => $this->accessToken)
        ));
        
        $res = HTTPClient::post($url, $data, $dataJsonEncoded);
        
        if (false === $res) {
            $this->setError(-10, '获取数据失败!');
            return false;
        }

        return $res;
    }

    /**
     * 设置错误信息
     *
     * @param string $code 错误代码
     * @param string $msg 错误详细信息
     */
    public function setError($code, $msg = '') {
        $this->errorCode = $code;
        $this->errorMsg = $msg;
    }

    /**
     * 获取错误代码
     *
     * @return string 错误代码
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * 获取错误信息
     *
     * @return string 错误信息
     */
    public function getErrorMsg() {
        return $this->errorMsg;
    }

}
