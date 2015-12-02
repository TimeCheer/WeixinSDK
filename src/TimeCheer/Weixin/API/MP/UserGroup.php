<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 对公众平台的分组进行查询、创建、修改、删除等操作，也可以使用接口在需要时移动用户到某个分组
 * @link http://mp.weixin.qq.com/wiki/5/0d8acdd6d4433c877fbea938a2f133cd.html
 * @package timecheer.weixin.mp
 */
class UserGroup extends Base {
    
    const API_CREATE = '/groups/create';
    const API_LIST = '/groups/get';
    const API_GETID = '/groups/getid';
    const API_UPDATE = '/groups/update';
    const API_DELETE = '/groups/delete';
    
    const API_MOVE_USER = '/groups/members/udpate';
    const API_MOVE_USERS = '/groups/members/batchudpate';
    
    /**
     * 创建分组 最多支持创建100个分组
     * @param string $name
     * @return int
     */
    public function create($name) {
        $data = array(
            'group' => array(
                'name' => $name,
            ),
        );
        
        return $this->doPost(self::API_CREATE, $data);
    }
    
    /**
     * 查询所有分组
     * @return array
     */
    public function getAll() {
        return $this->doGet(self::API_LIST);
    }
    
    /**
     * 查询用户所在分组
     * @param string $openId
     * @return int group id
     */
    public function getIdByOpenId($openId) {
        return $this->doPost(self::API_GETID, array('openid' => $openId));
    }
    
    /**
     * 修改分组名
     * @param int $id
     * @param array $name
     * @return bool
     */
    public function update($id, $name) {
        return $this->doPost(self::API_UPDATE, array(
            'group' => array('id' => $id, 'name' => $name)
        ));
    }
    
    /**
     * 移动用户分组
     * @param int $toGroupId 分组id
     * @param string $openId 
     * @return bool 
     */
    public function moveUser($toGroupId, $openId) {
        return $this->doPost(self::API_MOVE_USER, array(
            'openid' => $openId, 
            'to_groupid' => $toGroupId
        ));
    }
    
    /**
     * 批量移动用户分组
     * @param int $toGroupId
     * @param array $openIds
     * @return bool
     */
    public function moveUsers($toGroupId, $openIds) {
        return $this->doPost(self::API_MOVE_USERS, array(
            'openid_list' => $openIds, 
            'to_groupid' => $toGroupId
        ));
    }
    
    /**
     * 删除分组
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        return $this->doPost(self::API_DELETE, array(
            'group' => array('id' => $id)
        ));
    }
}