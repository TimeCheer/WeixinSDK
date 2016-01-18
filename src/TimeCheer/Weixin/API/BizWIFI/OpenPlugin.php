<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 开通微信连Wi-Fi插件
 * @link http://mp.weixin.qq.com/wiki/10/752f8840b9c3e6e088bd406fbb1ce4ae.html
 */

class OpenPlugin extends Base {
    
    const API_OPEN = '/openplugin/token';

    /**
     * 开通插件获取wifi_token
     * @param string $callbackUrl 回调URL，开通插件成功后的跳转页面
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *         "is_open": true,
     *         "wifi_token": ""
     *      }
     *  }
     */
    public function token($callbackUrl) {
        return $this->doPost(self::API_OPEN, array('callback_url' => $callbackUrl), array(), true);
    }

}
