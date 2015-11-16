<?php

/**
 * 应用创建菜单
 * @package timecheer.weixin.qyapi
 */
class Weixin_QYAPI_Menu extends Weixin_QYAPI_Base {
    
    const API_MENU_CREATE = '/menu/create';
    const API_MENU_DELETE = '/menu/delete';
    const API_MENU_GET = '/menu/get';

    /**
     * 创建菜单
     *
     * @param  array      $button  菜单的数据
     * @param  int        $agentId 应用ID
     */
    public function create(array $button, $agentId) {
        if (empty($button) || empty($agentId)) {
            $this->setError('参数错误');

            return false;
        }

        $data = array(
            'button' => $button
        );

        return $this->doPost(self::API_MENU_CREATE, $data, array('agentid' => $agentId));
    }

    /**
     * 删除应用菜单
     *
     * @param  int     $agentId 应用id
     */
    public function delete($agentId) {
        if (empty($agentId)) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doGet(self::API_MENU_DELETE, array('agentid' => $agentId));
    }

    /**
     * 获取应用菜单列表
     *
     * @param  int     $agentId 应用id
     * 
     * @return array
     */
    public function doGet($agentId) {
        if (empty($agentId)) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doGet(self::API_MENU_GET, array('agentid' => $agentId));
    }

}
