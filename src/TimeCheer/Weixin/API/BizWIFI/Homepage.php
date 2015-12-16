<?php

namespace TimeCheer\Weixin\API\BizWIFI;

/**
 * 商家主页管理相关接口
 * @link http://mp.weixin.qq.com/wiki/19/33e17d30a3b5213cbb5f5ace4e1988ab.html
 */
class Homepage extends Base {
    
    const API_SET = '/homepage/set';
    const API_GET = '/homepage/get';
    
    /**
     * 设置商家主页
     * @param int $shopId 门店id (必填)
     * @param int $templateId 模板id 0-默认模板 1-自定义url (必填)
     * @param $struct 模板结构，当template_id为0时可以不填
     * @param $url 自定义链接，当template_id为1时必填
     * @return bool
     */
    public function set($shopId, $templateId = 0, $struct, $url) {
        $data = array('shop_id' => $shopId, 'template_id' => $templateId);
        if ($templateId == 1 && !empty($url)) {
            $data['url'] = $url;
        }
        $data = array();
        return $this->doPost(self::API_SET, $data, array(), true);
        //return $this->doPost(self::API_SET, array('shop_id' => $shop_id, 'template_id' => $template_id), array(), true);
    }

    /**
     * 查询商家主页
     * @param int $shopId 查询的门店的id (必填)
     * @return array {
     *      "errcode": 0,
     *      "data": {
     *        "shop_id": 429620,
     *        "template_id": 1,
     *        "url": " http://wifi.weixin.qq.com/"
     *      }
     *  }
     */
    public function get($shopId) {
        return $this->doPost(self::API_GET, array('shop_id' => $shopId), array(), true);
    }
    
}
