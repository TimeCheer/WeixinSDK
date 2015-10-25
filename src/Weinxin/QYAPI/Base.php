<?php

/**
 * API基类
 */
class Weixin_QYAPI_Base {
    
    const API_PREFIX = 'https://qyapi.weixin.qq.com/cgi-bin';

    protected $corpId;
    protected $corpSecret;
    
    protected $errorCode;
    protected $errorMsg;

    /**
     * 构造函数、配置企业号相关参数
     * @param string $corpId 企业号corp_id
     * @param string $corpSecret 企业号corp_secrect
     */
    public function __construct($corpId, $corpSecret) {
        $this->init($corpId, $corpSecret);
    }

    /**
     * 配置企业号相关参数
     *
     * @param string $corpId      企业号corp_id
     * @param string $corpSecret  企业号corp_secrect
     */
    public function init($corpId, $corpSecret) {
        $this->corpId = $corpId;
        $this->corpSecret = $corpSecret;
    }

    public function getCorpId() {
        return $this->corpId;
    }

    public function getCorpSecret() {
        return $this->corpSecret;
    }

    /**
     * 设置错误信息
     *
     * @param string $code 错误代码
     * @param string $msg 错误详细信息
     */
    public function setError($code, $msg = null) {
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

    /**
     * 接口请求方法，具体接口都调用此方法进行请求
     * @param strin $api
     * @param array $params
     */
    public function request($api, array $params = array()) {
        $apiUrl = rtrim(self::WEIXIN_BASE_API . '/' . $module . '/' . $node, '/');
    }

}
