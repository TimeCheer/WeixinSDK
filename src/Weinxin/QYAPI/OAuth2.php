<?php

/**
 * 
 */
class Weixin_QYAPI_OAuth2 extends Weixin_QYAPI_Base {
    
    /**
     * 创建微信OAuth协议的链接
     *
     * @param string $redirectUri 协议的回调地址
     * @param string $state       可携带的参数, 选填.
     *
     * @return string 协议地址
     */
    public function createOAuthUrl($redirectUri, $state = '') {
        if (!$redirectUri) {
            $this->setError('参数错误!');

            return false;
        }

        $host = isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : '';
        $api = 'https://open.weixin.qq.com/connect/oauth2/authorize';

        $state = $state ? $state = base64_encode($state) : '';

        $url = array();
        $url['appid'] = Api::getCorpId();
        $url['redirect_uri'] = $host . $redirectUri;
        $url['response_type'] = 'code';
        $url['scope'] = 'snsapi_base';
        $url['state'] = $state;
        $url = http_build_query($url);

        $url .= '#wechat_redirect';
        $url = $api . '?' . $url;

        return $url;
    }

    /**
     * 发起OAuth认证请求
     */
    public function request($redirectUri, $state = '') {
        $code = I('get.code', false, 'trim');
        if ($code) {
            return;
        }

        $url = $this->createOAuthUrl($redirectUri, $state);
        header('Location:' . $url);
        exit;
    }

    /**
     * 获取OAuth回调的信息
     *
     * @return array 回调信息.
     */
    public function receive() {
        $code = I('get.code', false, 'trim');

        if (!$code) {
            $this->setError('非法参数');

            return false;
        }

        $res = $this->getIdByCode($code);

        if (false == $res || !$res['UserId']) {
            $this->setError('对不起,您尚不是本站用户.');

            return false;
        }

        $arr = array();
        $arr['userid'] = $res['UserId'];
        $arr['state'] = I('get.state', '', 'trim,base64_decode');
        $arr['code'] = $code;

        return $arr;
    }
}
