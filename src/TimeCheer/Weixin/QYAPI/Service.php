<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 通讯录管理 - 标签
 * @package timecheer.weixin.qyapi
 */
class Service extends Base {
    
    const API_GET_PROVIDER_TOKEN = '/service/get_provider_token';
    const API_GET_LOGIN_INFO = '/service/get_login_info';
    
    /**
     * 获取应用提供商凭证 7200
     * @param string $corpId 企业号（提供商）的corpid
     * @param string $providerSecret 提供商的secret，在提供商管理页面可见
     * @return string
     */
    public function getProviderToken($corpId, $providerSecret) {
        return $this->doPost(self::API_GET_PROVIDER_TOKEN, array(
            'corpid' => $corpId,
            'provider_secret' => $providerSecret
        ));
    }
    
    public function getLoginInfo($providerToken, $authorizationCode) {
        return $this->doPost(self::API_GET_LOGIN_INFO, array('auth_code' => $authorizationCode), array('provider_access_token' => $providerToken));
    }
}