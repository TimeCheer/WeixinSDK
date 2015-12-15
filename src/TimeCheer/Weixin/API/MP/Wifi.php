<?php

namespace \TimeCheer\Weixin\API\MP;

/**
 * 微信连Wi-Fi相关接口
 */

class Wifi extends Base {
    /**
     * @var string MP API URL PREFIX
     */
    protected $apiPrefix = 'https://api.weixin.qq.com/bizwifi';
    
    const WIFI_OPEN = '/openplugin/token';
    const WIFI_SHOP_LIST = '/shop/list';
    const WIFI_SHOP_DETAILS = '/shop/get';
    const WIFI_DEVICE_ADD = '/device/add';
    const WIFI_DEVICE_LIST = '/device/list';
    const WIFI_DEVICE_DELETE = '/device/delete';
    const WIFI_QRCODE_GET = '/qrcode/get';
    const WIFI_CONNECTURL_GET = '/account/get_connecturl';
    const WIFI_HOMEPAGE_SET = '/homepage/set';
    const WIFI_HOMEPAGE_GET = '/homepage/get';
    const WIFI_BAR_SET = '/bar/set';
    const WIFI_STATISTICS = '/statistics/list';
    
    /**
     * 获取开插件wifi_token
     */
    public function openPlugin($callback_url){
        return $this->doPost(self::WIFI_OPEN,array('callback_url'=>$callback_url),array(),true);
    }
    
    /**
     * 获取WiFi门店列表
     * 微信连WiFi下的所有接口中的shop_id，必需先通过此接口获取。
     * @param int $pageindex 分页下标，默认从1开始
     * @param int $pagesize  每页的个数，默认10个，最大20个
     */
    public function shopList($pageindex,$pagesize){
        return $this->doPost(self::WIFI_SHOP_LIST,array('pageindex'=>$pageindex,'pagesize'=>$pagesize),array(),true);
    }
    
    /**
     * 查询门店的WiFi信息
     * @param int $shop_id 门店id
     */
    public function shopDetails($shop_id){
        return $this->doPost(self::WIFI_SHOP_DETAILS,array('shop_id'=>$shop_id),array(),true);
    }
    
    /**
     * 添加密码型设备
     * 本接口只支持添加密码型设备。
     * 多台设备必须使用相同的 ssid 和 密码
     * @param int $shop_id 门店id （必填）
     * @param int $ssid  设备id （必填）
     * @param string $password  设备密码 （必填）
     */
    public function deviceAdd($shop_id,$ssid,$password){
        return $this->doPost(self::WIFI_DEVICE_ADD,array('shop_id'=>$shop_id,'ssid'=>$ssid,'password'=>$password),array(),true);
    }
    
    /**
     * 查询多个门店或指定门店的设备信息
     * @param int $pageindex 分页下标，默认从1开始
     * @param int $pagesize  每页的个数，默认10个，最大20个
     * @param int $shop_id   门店id
     */
    public function deviceList($pageindex,$pagesize,$shop_id){
        return $this->doPost(self::WIFI_DEVICE_LIST,array('pageindex'=>$pageindex,'pagesize'=>$pagesize,'shop_id'=>$shop_id),array(),true);
    }
    
    /**
     * 删除设备
     * @param string $bssid 需要删除的无线网络设备无线mac地址，格式冒号分隔，字符长度17个，并且字母小写，例如：00:1f:7a:ad:5c:a8
     * @return 
     */
    public function deviceDelete($bssid){
        return $this->doPost(self::WIFI_DEVICE_DELETE,array('bssid'=>$bssid),array(),true);
    }
    /**
     * 获取物料二维码
     * @param int $shop_id 门店id (必填）
     * @param int 3img_id  二维码样式编号 0-纯二维码 1-二维码物料 (必填）
     * @return url 二维码图片url
     */
    public function qrcodeGet($shop_id,$img_id){
        return $this->doPost(self::WIFI_QRCODE_GET,array('shop_id'=>$shop_id,'img_id'=>$img_id),array(),true);
    }
    
    /**
     * 获取公众号连网URL
     * @return connect_url
     */
    public function connectUrl(){
        return $this->doPost(self::WIFI_CONNECTURL_GET,array(),array(),true);
    }
    
    /**
     * 设置商家主页
     * @param int $shop_id 门店id (必填)
     * @param int $template_id 模板id 0-默认模板 1-自定义url (必填)
     * @param $struct 模板结构，当template_id为0时可以不填
     * @param $url 自定义链接，当template_id为1时必填
     */
    public function setHomepage($shop_id,$template_id=0,$struct,$url){
        if($template_id ==1){
            
        }
        return $this->doPost(self::WIFI_HOMEPAGE_SET,array('shop_id'=>$shop_id,'template_id'=>$template_id),array(),true);
    }
    
    /**
     * 查询商家主页
     * @param int $shop_id 查询的门店的id (必填)
     * @return shop_id template_id url
     */
    public function getHomepage($shop_id){
        return $this->doPost(self::WIFI_HOMEPAGE_GET,array('shop_id'=>$shop_id),array(),true);
    }
    
    /**
     * 设置顶部常驻入口文案
     * @param int $shop_id 门店id
     * @param int $bar_type 顶部常驻入口上显示的文本内容：0--欢迎光临+公众号名称；1--欢迎光临+门店名称；2--已连接+公众号名称+WiFi；3--已连接+门店名称+Wi-Fi
     */
    public function setText($shop_id,$bar_type=0){
        return $this->doPost(self::WIFI_BAR_SET,array($shop_id,$bar_type),array(),true);
    }
    
    /**
     * 数据统计
     * @param time $begin_date 起始日期时间，格式yyyy-mm-dd，最长时间跨度为30天
     * @param time $end_date   结束日期时间戳，格式yyyy-mm-dd，最长时间跨度为30天
     * @param int  $shop_id    按门店ID搜索，-1为总统计
     */
    public function statistics($begin_date,$end_date,$shop_id){
        return $this->doPost(self::WIFI_STATISTICS,array('begin_date'=>$begin_date,'end_date'=>$end_date,'shop_id'=>$shop_id),array(),true);
    }
    
    /**
     * 
     */
}