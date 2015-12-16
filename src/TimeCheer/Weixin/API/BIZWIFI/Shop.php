<?php

namespace TimeCheer\Weixin\API\BIZWIFI;

/**
 * WiFi门店管理
 */
class Shop extends Base {
    
    const API_LIST = '/shop/list';
    const API_GET = '/shop/get';
    
    /**
     * 获取WiFi门店列表
     * 微信连WiFi下的所有接口中的shop_id，必需先通过此接口获取
     * @param int $pageindex 分页下标，默认从1开始
     * @param int $pagesize  每页的个数，默认10个，最大20个
     */
    public function query($pageindex = 1, $pagesize = 10) {
        return $this->doPost(self::API_LIST, array('pageindex' => $pageindex, 'pagesize' => $pagesize), array(), true);
    }
    
    /**
     * 查询某门店的WiFi信息
     * @param int $shop_id 门店id
     */
    public function get($shop_id) {
        return $this->doPost(self::API_GET, array('shop_id' => $shop_id), array(), true);
    }
}
