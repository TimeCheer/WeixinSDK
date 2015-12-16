<?php

namespace TimeCheer\Weixin\API\BizWIFI;

class OpenPlugin extends Base {
    
    const API_OPEN = '/openplugin/token';

    /**
     * 开通插件获取wifi_token
     * @param string $callbackUrl 回调URL，开通插件成功后的跳转页面
     */
    public function Token($callbackUrl) {
        return $this->doPost(self::API_OPEN, array('callback_url' => $callbackUrl), array(), true);
    }

}
