<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * WiFi门店管理
 * @link http://mp.weixin.qq.com/wiki/10/57630b0f7d41a88685b34c55096660e2.html
 */
class Shop extends Base {
    
    const API_LIST = '/shop/list';
    const API_GET = '/shop/get';
    const API_CLEAN = '/shop/clean';
    
    /**
     * 获取WiFi门店列表
     * 微信连WiFi下的所有接口中的shop_id，必需先通过此接口获取
     * @param int $pageIndex 分页下标，默认从1开始
     * @param int $pageSize  每页的个数，默认10个，最大20个
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *        "totalcount": 16,
     *        "pageindex": 1,
     *        "pagecount": 8,
     *        "records": [
     *          {
     *            "shop_id": 429620,
     *            "shop_name": "南山店",
     *            "ssid": null,
     *            "protocol_type": 0,
     *            "sid": ""
     *          },
     *          {
     *            "shop_id": 7921527,
     *            "shop_name": "宝安店",
     *            "ssid": null,
     *            "protocol_type": 0,
     *            "sid": ""
     *          }
     *        ]
     *      }
     *  }
     */
    public function query($pageIndex = 1, $pageSize = 10) {
        return $this->doPost(self::API_LIST, array('pageindex' => (int) $pageIndex, 'pagesize' => (int) $pageSize), array(), true);
    }
    
    /**
     * 查询某门店的WiFi信息
     * @param int $shopId 门店id
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *        "shop_name": "南山店",
     *        "ssid": "WX4123",
     *        "password": "123456789",
     *        "protocol_type": 4,
     *        "ap_count": 2,
     *        "template_id": 1,
     *        "homepage_url": "http://www.weixin.qq.com/",
     *        "bar_type": 1
     *      }
     *  }
     */
    public function get($shopId) {        
        return $this->doPost(self::API_GET, array('shop_id' => (int) $shopId), array(), true);
    }
    
    /**
     * 清空门店网络及设备
     * @param int $shopId
     * @return array{ "errcode": 0}
     */
    public function clean($shopId) {
        return $this->doPost(self::API_CLEAN, array('shop_id' => (int) $shopId),array(), true);
    }
}
