<?php

/**
 * AccessToken是企业号的全局唯一票据，调用接口时需携带AccessToken。
 * 
 */
class Weixin_QYAPI_AccessToekn extends Weixin_QYAPI_Base {
    
    const API_GET_TOKEN = '/gettoken';
    
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
    
    /**
     * AccessToken需要用CorpID和Secret来换取，不同的Secret会返回不同的AccessToken。正常情况下AccessToken有效期为7200秒，有效期内重复获取返回相同结果；有效期内有接口交互（包括获取AccessToken的接口），会自动续期
     * @return type
     */
    public function get() {
        $queryStr = array(
            'corpid' => $this->corpId,
            'corpsecret' => $this->corpSecrect,
        );

        $res = self::_get(self::API_GET_TOKEN, '', $queryStr);
        if (false === $res) {
            $this->setError(-10, '获取AccessToken失败!');
            return false;
        }

        $token = $res['access_token'];


        return $token;
    }
}