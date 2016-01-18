<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 微信首屏顶部常驻入口的文案设置
 * @link http://mp.weixin.qq.com/wiki/19/33e17d30a3b5213cbb5f5ace4e1988ab.html
 */
class Bar extends Base {
    
    const API_SET = '/bar/set';
    
    /**
     * 设置顶部常驻入口文案
     * @param int $shopId 门店id
     * @param int $barType 顶部常驻入口上显示的文本内容：0--欢迎光临+公众号名称；1--欢迎光临+门店名称；2--已连接+公众号名称+WiFi；3--已连接+门店名称+Wi-Fi
     * return bool
     */
    public function set($shopId, $barType = 0) {
        return $this->doPost(self::API_SET, array('shop_id' => (int) $shopId, 'bar_type' => (int) $barType), array(), true);
    }
}
