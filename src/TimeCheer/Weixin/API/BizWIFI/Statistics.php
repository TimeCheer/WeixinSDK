<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 数据统计类
 * 
 */
class Statistics extends Base {
    
    const API_LIST = '/statistics/list';
    
    /**
     * 数据统计
     * 查询一定时间范围内的WiFi连接总人数、微信方式连Wi-Fi人数、商家主页访问人数、连网后消息发送人数、新增公众号关注人数和累计公众号关注人数
     * @param string $beginDate 起始日期时间 (必填)
     * @param sting $endDate   结束日期时间 (必填)
     * @param int  $shopId    按门店ID搜索，-1为总统计
     * @return array {
     *      "errcode": 0,
     *      "data": [
     *        {
     *          "shop_id": "-1",
     *          "statis_time": 1430409600000,
     *          "total_user": 2,
     *          "homepage_uv": 0,
     *          "new_fans": 0,
     *          "total_fans": 4,
     *          "wxconnect_user": 8,
     *          "connect_msg_user": 5
     *        },
     *        {
     *          "shop_id": "-1",
     *          "statis_time": 1430496000000,
     *          "total_user": 2,
     *          "homepage_uv": 0,
     *          "new_fans": 0,
     *          "total_fans": 4,
     *          "wxconnect_user": 4,
     *          "connect_msg_user": 3
     *        }
     *      ]
     *  }
     */
    public function query($beginDate, $endDate, $shopId = -1) {
        $data = array('begin_date' => $beginDate, 'end_date' => $endDate, 'shop_id' => $shopId);
        return $this->doPost(self::API_LIST, $data, array(), true);
    }
}
