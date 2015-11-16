<?php

/**
 * PC Web上 用户使用微信企业号登录
 * @package timecheer.weixin.qy
 */
class Weixin_QY_OAuth2 {
    
    const URL = 'https://qy.weixin.qq.com/cgi-bin/loginpage';
    
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
        
        $url = self::URL . '?' . http_build_query($params);

        return $url;
    }

}
