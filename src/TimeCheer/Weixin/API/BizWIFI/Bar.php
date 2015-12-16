<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 微信首屏顶部常驻入口的文案设置
 */
class Bar extends Base {
    
    const API_SET = '/bar/set';
    
    /**
     * 设置顶部常驻入口文案
     * @param int $shopId 门店id
     * @param int $barType 顶部常驻入口上显示的文本内容：0--欢迎光临+公众号名称；1--欢迎光临+门店名称；2--已连接+公众号名称+WiFi；3--已连接+门店名称+Wi-Fi
     */
    public function set($shopId, $barType = 0) {
        return $this->doPost(self::API_SET, array('shop_id' => $shopId, 'bar_type' => $barType), array(), true);
    }
}
