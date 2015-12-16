<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * Wi-Fi设备管理相关接口
 */
class Device extends Base {

    const API_ADD = '/device/add';
    const API_LIST = '/device/list';
    const API_DELETE = '/device/delete';
    
    /**
     * 添加密码型设备
     * 本接口只支持添加密码型设备。
     * 多台设备必须使用相同的 ssid 和 密码
     * @param int $shop_id 门店id （必填）
     * @param int $ssid  设备id （必填）
     * @param string $password  设备密码 （必填）
     */
    public function deviceAdd($shop_id, $ssid, $password) {
        return $this->doPost(self::API_ADD, array('shop_id' => $shop_id, 'ssid' => $ssid, 'password' => $password), array(), true);
    }

    /**
     * 查询多个门店或指定门店的设备信息
     * @param int $pageindex 分页下标，默认从1开始
     * @param int $pagesize  每页的个数，默认10个，最大20个
     * @param int $shop_id   门店id
     */
    public function deviceList($pageindex, $pagesize, $shop_id) {
        return $this->doPost(self::API_LIST, array('pageindex' => $pageindex, 'pagesize' => $pagesize, 'shop_id' => $shop_id), array(), true);
    }

    /**
     * 删除设备
     * @param string $bssid 需要删除的无线网络设备无线mac地址，格式冒号分隔，字符长度17个，并且字母小写，例如：00:1f:7a:ad:5c:a8
     * @return 
     */
    public function deviceDelete($bssid) {
        return $this->doPost(self::API_DELETE, array('bssid' => $bssid), array(), true);
    }

}
