<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 二维码 及 公众号连网URL 获取接口
 */
class Qrcode extends Base {
    
    const API_GET = '/qrcode/get';
    
    /**
     * 获取物料二维码
     * @param int $shopId 门店id (必填）
     * @param int $imgId  二维码样式编号 0-纯二维码 1-二维码物料 (必填）
     * @return url 二维码图片url
     */
    public function get($shopId, $imgId) {
        return $this->doPost(self::API_GET, array('shop_id' => $shopId, 'img_id' => $imgId), array(), true);
    }
    
}
