<?php

/**
 * 
 */
class Weixin_QYAPI_OAuth2 extends Weixin_QYAPI_Base {
    
    const OAUTH2_URL = 'https://qy.weixin.qq.com/cgi-bin/loginpage';
    
    /**
     * 创建OAuth协议的链接
     *
     * @param string $redirectUri 协议的回调地址
     * @param string $state       可携带的参数, 选填.
     *
     * @return string 协议地址
     */
    public function createUrl($corpId, $redirectUri, $state = '') {
        if (!$corpId || !$redirectUri) {
            $this->setError('参数错误!');

            return false;
        }

        $params = array(
            'corp_id' => $corpId,
            'redirect_uri' => urlencode($redirectUri),
            'state' => $state
        );
        
        $url = self::OAUTH2_URL . '?' . http_build_query($params);

        return $url;
    }

}
