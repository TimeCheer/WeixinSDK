<?php

namespace TimeCheer\Weixin\API\SNS;

/**
 * OAuth2相关接口
 * @package timecheer.weixin.api.sns
 */
class OAuth2 extends Base {
    
    const API_TOKEN = '/sns/oauth2/access_token';
    
    const API_REFRESH_TOKEN = '/sns/oauth2/refresh_token';
    
    const API_USER = '/sns/userinfo';
    
    /**
     * 通过接口换取access token
     * @param string $appId
     * @param string $appSecret
     * @param string $code
     * @return array 
     */
    public function accessToken($appId, $appSecret, $code) {
        return $this->doGet(self::API_TOKEN, array(
            'appid' => $appId,
            'secret' => $appSecret,
            'grant_type' => 'authorization_code',
            'code' => $code
        ));
    }
    
    /**
     * 刷新access_token
     * @param string $appId
     * @param string $refreshToken
     * @return array
     */
    public function refreshAccessToken($appId, $refreshToken) {
        return $this->doGet(self::API_REFRESH_TOKEN, array(
            'appid' => $appId,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ));
    }
    
    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function getUser($accessToken, $openId) {
        return $this->doGet(self::API_USER, array(
            'access_token' => $accessToken,
            'openid' => $openId,
            'lang' => 'zh_CN'
        ));
    }
}