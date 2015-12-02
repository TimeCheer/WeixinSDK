<?php

namespace TimeCheer\TimeCheer\Weixin\QYAPI;

/**
 * AccessToken是企业号的全局唯一票据，调用接口时需携带AccessToken。
 * @usage 
 * $api = new \TimeCheer\Weixin\QYAPI\AccessToekn();
 * $token = $api->get($corpId, $corpSecret);
 * @package timecheer.weixin.qyapi
 */
class AccessToekn {
    
    const API_GET_TOKEN = '/gettoken';
    
    protected $corpId = '';
    protected $corpSecret = '';
    
    protected $errorCode;
    protected $errorMsg;
    
    /**
     * 构造函数、配置企业号相关参数
     * @param string $corpId 企业号corp_id
     * @param string $corpSecret 企业号corp_secrect
     */
    public function __construct($corpId = '', $corpSecret = '') {
        $this->init($corpId, $corpSecret);
    }
    
    /**
     * 配置企业号相关参数
     *
     * @param string $corpId      企业号corp_id
     * @param string $corpSecret  企业号corp_secrect
     */
    public function init($corpId, $corpSecret) {
        $this->setCorpId($corpId);
        $this->setCorpSecret($corpSecret);
    }
    
    public function setCorpId($corpId) {
        if ($corpId) {
            $this->corpId = $corpId;
        }
    }

    public function setCorpSecret($corpSecret) {
        if ($corpSecret) {
            $this->corpSecret = $corpSecret;
        }
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
     * AccessToken需要用CorpID和Secret来换取，不同的Secret会返回不同的AccessToken。
     * 正常情况下AccessToken有效期为7200秒，有效期内重复获取返回相同结果；
     * 有效期内有接口交互（包括获取AccessToken的接口），会自动续期
     * @return string|boolean
     */
    public function get($corpId = '', $corpSecret = '') {
        $this->init($corpId, $corpSecret);

        $res = $this->request(self::API_GET_TOKEN, array(
            'corpid' => $this->corpId,
            'corpsecret' => $this->corpSecrect,
        ));

        if(empty($res['access_token'])) {
            $this->setError(-11, '无效AccessToken!');
            return false;
        }

        return $res['access_token'];
    }
    
    public function request($api, $params = array()) {
        $res = \TimeCheer\Weixin\Util\HTTPClient::get($api, $params);
        
        if (false === $res) {
            $this->setError(-10, '接口请求失败!');
            return false;
        }
        
        return $res;
    }
}