<?php

namespace TimeCheer\Weixin\API\BIZWIFI;

/**
 * 公众号联网的url获取
 */
class ConnectUrl extends Base {
    const API_GET = '/account/get_connecturl';
    
    /**
     * 获取公众号连网URL
     * @return connect_url
     */
    public function get() {
        return $this->doPost(self::API_GET, array(), array(), true);
    }
}
