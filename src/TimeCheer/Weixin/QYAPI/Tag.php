<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 通讯录管理 - 标签
 * @package timecheer.weixin.qyapi
 */
class Tag extends Base {
    
    const API_CREATE = '/tag/create';
    const API_UPDATE = '/tag/update';
    const API_DELETE = '/tag/delete';
    const API_GET_TAG_USERS = '/tag/get';
    const API_LIST = '/tag/list';
    const API_ADD_TAG_USERS = '/tag/addtagusers';
    const API_DEL_TAG_USERS = '/tag/deltagusers';

    /**
     * 创建标签
     *
     * @param string $name 标签名称，长度为1~64个字节，标签名不可与其他标签重名。   必填
     * @param int    $id   标签id 非必填
     */
    public function add($name, $id = null) {
        if (!$name) {
            $this->setError('tagname');

            return false;
        }
        $data['tagname'] = $name;
        if ($id !== null) {
            $data['tagid'] = $id;
        }

        return $this->doPost(self::API_CREATE, $data);
    }

    /**
     * 更新标签名字
     *
     * @param string $name 标签名称，长度为1~64个字节，标签不可与其他标签重名。    必填
     * @param int    $id   标签id 必填
     */
    public function update($name, $id = null) {
        if (!$name || !$id) {
            $this->setError('tagname || tagid');

            return false;
        }
        $data['tagname'] = $name;
        if ($id !== null) {
            $data['tagid'] = $id;
        }

        return $this->doPost(self::API_UPDATE, $data);
    }

    /**
     * 删除标签
     *
     * @param int $id 标签id 必填
     */
    public function delete($id) {
        if (!$id) {
            $this->setError('tagid');

            return false;
        }

        return $this->doGet(self::API_DELETE, array(
            'tagid' => $id,
        ));
    }

    /**
     * 获取标签成员
     *
     * @param int $id 标签id 必填
     */
    public function getTagUsers($id) {
        if (!$id) {
            $this->setError('tagid');

            return false;
        }

        return $this->doGet(self::API_GET_TAG_USERS, array(
            'tagid' => $id,
        ));
    }

    /**
     * 增加标签成员
     *
     * @param int   $id     标签id 必填
     * @param array $users  企业成员ID列表，注意：userlist、partylist不能同时为空
     * @param array $depts 企业部门ID列表，注意：userlist、partylist不能同时为空
     */
    public function addTagUsers($id, array $users, $depts = null) {
        if (!$id) {
            $this->setError('tagid');

            return false;
        }

        if (!$users && !$depts) {
            $this->setError('users,$depts');

            return false;
        }
        
        $data = array(
            'tagid' => $id
        );
        if (!empty($users)) {
            $data['userlist'] = $users;
        }

        if (!empty($depts)) {
            if (is_int($depts)) {
                $depts = array($depts);
            }
            $data['partylist'] = $depts;
        }

        return $this->doPost(self::API_ADD_TAG_USERS, $data);
    }

    /**
     * 删除标签成员
     *
     * @param int   $id     标签id 必填
     * @param array $users  企业成员ID列表，注意：userlist、partylist不能同时为空
     * @param array $depts 企业部门ID列表，注意：userlist、partylist不能同时为空
     */
    public function delTagUsers($id, array $users, $depts = '') {
        if (!$id) {
            $this->setError('tagid');

            return false;
        }

        if (!$users && !$depts) {
            $this->setError('userlist,partylist至少填一项');

            return false;
        }
        
        $data = array(
            'tagid' => $id
        );
        if (!empty($users)) {
            $data['userlist'] = $users;
        }

        if (!empty($depts)) {
            if (is_int($depts)) {
                $depts = array($depts);
            }
            $data['partylist'] = $depts;
        }

        return $this->doPost(self::API_DEL_TAG_USERS, $data);
    }

    /**
     * 获取标签列表
     */
    public function query() {
        return $this->doGet(self::API_LIST);
    }

}
