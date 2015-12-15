<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 自定义菜单接口，主要提供方法：
 * @package timecheer.weixin.api.mp
 */
class Menu extends Base {

    const API_CREATE = '/menu/create';
    const API_GET = '/menu/get';
    const API_DELETE = '/menu/delete';
    const API_GET_CURRENT = '/menu/get_current_selfmenu_info';

    /**
     * 创建菜单
      <pre>
      按钮结构:
      {"type":"***","name":"***","key":"***"}
      {"type":"view","name":"***","url":"***"}
      {"type":"media_id/view_limited","name":"***","media_id":"***"}
      {"name":"***","sub_button":[{},{},...]}
      </pre>
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        $params = array(
            'button' => $data,
        );
        $res = $this->doPost(self::API_CREATE, $params);

        if (isset($res['errcode']) && $res['errcode'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 删除当前使用的自定义菜单
     * 
     * @return boolean
     */
    public function delete() {

        return $this->doGet(self::API_DELETE);
    }

    /**
     * 获取(API调用设置的)自定义菜单结构
     * 
     * @return boolean|array
     */
    public function getList() {

        $res = $this->doGet(self::API_GET);

        if (!isset($res['menu']['button'])) {
            return false;
        }

        return $res['menu']['button'];
    }

    /**
     * 公众号当前使用的自定义菜单的配置
     * 
     * @return boolean|array
     */
    public function getCurrentList() {
        $res = $this->doGet(self::API_GET_CURRENT);

        if (!isset($res['selfmenu_info']['button'])) {
            return false;
        }

        return $res['selfmenu_info']['button'];
    }

}
