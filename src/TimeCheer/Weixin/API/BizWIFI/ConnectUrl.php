<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 公众号联网的url获取
 * @link http://mp.weixin.qq.com/wiki/12/87b34a7f55b33b534bdff6c2952610a0.html
 */
class ConnectUrl extends Base {
    const API_GET = '/account/get_connecturl';
    
    /**
     * 获取公众号连网URL
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *        "connect_url": ""
     *      }
     *  }
     */
    public function get() {
        return $this->doPost(self::API_GET, array(), array(), true); 
    }
}
