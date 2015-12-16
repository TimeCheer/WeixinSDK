<?php

namespace TimeCheer\Weixin\API\BIZWIFI;

/**
 * 商家主页管理相关接口
 */
class Homepage extends Base {
    
    const API_SET = '/homepage/set';
    const API_GET = '/homepage/get';
    
    /**
     * 设置商家主页
     * @param int $shop_id 门店id (必填)
     * @param int $template_id 模板id 0-默认模板 1-自定义url (必填)
     * @param $struct 模板结构，当template_id为0时可以不填
     * @param $url 自定义链接，当template_id为1时必填
     */
    public function set($shop_id, $template_id = 0, $struct, $url) {
        $data = array('shop_id' => $shop_id, 'template_id' => $template_id);
        if ($template_id == 1 && !empty($url)) {
            $data['url'] = $url;
        }
        $data = array();
        return $this->doPost(self::API_SET, $data, array(), true);
        //return $this->doPost(self::API_SET, array('shop_id' => $shop_id, 'template_id' => $template_id), array(), true);
    }

    /**
     * 查询商家主页
     * @param int $shop_id 查询的门店的id (必填)
     * @return shop_id template_id url
     */
    public function get($shop_id) {
        return $this->doPost(self::API_GET, array('shop_id' => $shop_id), array(), true);
    }
    
}
