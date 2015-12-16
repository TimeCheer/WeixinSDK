<?php

namespace TimeCheer\Weixin\API\BizWIFI;

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
     * @param int $shopId 门店id （必填）
     * @param int $ssid  设备id （必填）
     * @param string $password  设备密码 （必填）
     */
    public function add($shopId, $ssid, $password) {
        return $this->doPost(self::API_ADD, array('shop_id' => $shopId, 'ssid' => $ssid, 'password' => $password), array(), true);
    }

    /**
     * 查询多个门店或指定门店的设备信息
     * @param int $pageIndex 分页下标，默认从1开始
     * @param int $pageSize  每页的个数，默认10个，最大20个
     * @param int $shopId   门店id
     */
    public function query($pageIndex, $pageSize, $shopId) {
        return $this->doPost(self::API_LIST, array('pageindex' => $pageIndex, 'pagesize' => $pageSize, 'shop_id' => $shopId), array(), true);
    }

    /**
     * 删除设备
     * @param string $bssid 需要删除的无线网络设备无线mac地址，格式冒号分隔，字符长度17个，并且字母小写，例如：00:1f:7a:ad:5c:a8
     * @return 
     */
    public function delete($bssid) {
        return $this->doPost(self::API_DELETE, array('bssid' => $bssid), array(), true);
    }

}
