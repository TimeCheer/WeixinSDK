<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 数据统计类
 */
class Statistics extends Base {
    
    const API_LIST = '/statistics/list';
    
    /**
     * 数据统计
     * 查询一定时间范围内的WiFi连接总人数、微信方式连Wi-Fi人数、商家主页访问人数、连网后消息发送人数、新增公众号关注人数和累计公众号关注人数
     * @param time $beginDate 起始日期时间，格式yyyy-mm-dd，最长时间跨度为30天 (必填)
     * @param time $endDate   结束日期时间戳，格式yyyy-mm-dd，最长时间跨度为30天 (必填)
     * @param int  $shopId    按门店ID搜索，-1为总统计
     */
    public function query($beginDate, $endDate, $shopId) {
        $data = array('begin_date' => $beginDate, 'end_date' => $endDate);
        if(!empty($shopId)) {
            $data['shop_id'] = $shopId;
        }
        return $this->doPost(self::API_LIST, $data, array(), true);
        //return $this->doPost(self::API_STATISTICS, array('begin_date' => $begin_date, 'end_date' => $end_date, 'shop_id' => $shop_id), array(), true);
    }
}
