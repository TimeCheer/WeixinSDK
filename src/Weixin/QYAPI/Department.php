<?php

/**
 * 通讯录管理 - 部门
 * @package timecheer.weixin.qyapi
 */
class Weixin_QYAPI_Department extends Weixin_QYAPI_Base {
    
    const API_CREATE = '/department/create';
    const API_UPDATE = '/department/update';
    const API_DELETE = '/department/delete';
    const API_LIST = '/department/list';

    /**
     * 创建部门
     *
     * @param string $name     部门名称   必填 长度限制为1~64个字节，字符不能包括\:*?"<>｜
     * @param int    $parentId 父亲部门id。根部门id为1  必填
     * @param int    $order    在父部门中的次序值。order值小的排序靠前。  非必填
     * @param int    $id       部门id，整型。指定时必须大于1，不指定时则自动生成 。  非必填
     *
     * @return array
     */
    public function create($name, $parentId = 1, $order = 0, $id = 0) {
        if (!$name || !$parentId) {
            $this->setError('name or parentid错误!');

            return false;
        }

        $data = array(
            'name' => $name,
            'parentid' => $parentId
        );
        if (!empty($order)) {
            $data['order'] = $order;
        }
        if (!empty($id)) {
            $data['id'] = $id;
        }

        return $this->doPost(self::API_CREATE, $data);
    }

    /**
     *  更新部门
     *
     * @param int $id       部门id    必填
     * @param int $name     部门名称 。  非必填
     * @param int $parentId 父亲部门id。根部门id为1  必填
     * @param int $order    在父部门中的次序值。order值小的排序靠前。  非必填
     */
    public function update($id, $name = '', $parentId = null, $order = null) {
        if (!$id) {
            $this->setError('id错误!');

            return false;
        }
        
        $data = array(
            'id' => $id,
            'name' => $name,
            'parentid' => $parentId,
            'order' => $order
        );

        return $this->_post(self::API_UPDATE, $data);
    }

    /**
     *  删除部门
     *
     * @param int $id 部门id   必填
     */
    public function delete($id) {
        if (!$id) {
            $this->setError('id错误!');

            return false;
        }

        return $this->doGet(self::API_DELETE, array(
            'id' => $id,
        ));
    }

    /**
     * 获取部门列表
     *
     * @param int $id 部门id，整型.获取制定部门下的 。  非必填
     *
     * @return array
     */
    public function query($id = null) {
        $params = array();
        if ($id) {
            $params = array('id' => $id);
        }

        return $this->doGet(self::API_LIST, $params);
    }

}
