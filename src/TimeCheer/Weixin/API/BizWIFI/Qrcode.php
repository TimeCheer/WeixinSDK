<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 二维码获取接口
 * @link http://mp.weixin.qq.com/wiki/12/87b34a7f55b33b534bdff6c2952610a0.html
 */
class Qrcode extends Base {
    
    const API_GET = '/qrcode/get';
    
    /**
     * 获取物料二维码
     * @param int $shopId 门店id (必填）
     * @param int $imgId  二维码样式编号 0-纯二维码 1-二维码物料 (必填）
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *        "qrcode_url": ""
     *      }
     *  }
     */
    public function get($shopId, $imgId) {
        return $this->doPost(self::API_GET, array('shop_id' => (int) $shopId, 'img_id' => (int) $imgId), array(), true);
    }
    
}
