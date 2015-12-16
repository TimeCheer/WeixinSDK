<?php

namespace TimeCheer\Weixin\API\BIZWIFI;

/**
 * 二维码 及 公众号连网URL 获取接口
 */
class Qrcode extends Base {
    
    const API_GET = '/qrcode/get';
    
    /**
     * 获取物料二维码
     * @param int $shop_id 门店id (必填）
     * @param int $img_id  二维码样式编号 0-纯二维码 1-二维码物料 (必填）
     * @return url 二维码图片url
     */
    public function get($shop_id, $img_id) {
        return $this->doPost(self::API_GET, array('shop_id' => $shop_id, 'img_id' => $img_id), array(), true);
    }
    
}
