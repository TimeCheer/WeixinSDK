<?php

/**
 * 用户在Web页面上OAuth2授权
 * 网页授权流程分为四步：
 * 
 * 1、引导用户进入授权页面同意授权，获取code
 * 2、通过code换取网页授权access_token（与基础支持中的access_token不同）
 * 3、如果需要，开发者可以刷新网页授权access_token，避免过期
 * 4、通过网页授权access_token和openid获取用户基本信息（支持UnionID机制）
 * 
 * @package timecheer.weixin.open
 */
class Weixin_Open_OAuth2 extends Weixin_Open_Base {
    
    const API_AUTHORIZE = '/connect/oauth2/authorize';
    
    const SCOPE_BASE = 'snsapi_base';
    
    const SCOPE_INFO = 'snsapi_userinfo';
    
    /**
     * 拼接授权跳转页面的URL
     * @param string $appId
     * @param string $redirectURI
     * @param bool $scopeInfo 是否要取用户详情
     * @param string $state
     * @return string
     */
    public function authorizeUrl($appId, $redirectURI, $scopeInfo = false, $state = '') {
        return $this->apiPrefix . '/' . self::API_AUTHORIZE 
                . '?' . http_build_query(array(
                    'appid' => $appId, 
                    'redirect_uri' => $redirectURI, 
                    'scope' => $scopeInfo ? self::SCOPE_INFO : self::SCOPE_BASE, 
                    'response_type' => 'code', 
                    'state' => $state
                ));
    }
}