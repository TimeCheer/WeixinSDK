<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 通讯录管理 - 用户
 * @package timecheer.weixin.qyapi
 */
class User extends Base {
    
    const API_CREATE = '/user/create';
    const API_UPDATE = '/user/update';
    const API_DELETE = '/user/delete';
    const API_BATCH_DELETE = '/user/batchdelete';
    const API_GET = '/user/get';
    const API_LIST = '/user/list';
    const API_LIST_SIMPLE = '/user/simplelist';
    const API_SEND_INVITE = '/invite/send';
    const API_GET_OPENID = '/user/convert_to_openid';
    const API_GET_USERID = '/user/convert_to_userid';

    /**
     * 添加用户 参数有点多,其实应该用结构来传 正常环境前八项是必填的
     *
     * @param string $uid     用户的企业号唯一标识
     * @param string $name       用户的名字
     * @param int|array  $department 用户所在的部门列表
     * @param array  $must       添加用户时需要添加 weixinid, mobile, email三者至少填一个! 此三者名为键位.
     * @param array  $extend     用户的其他信息 非必填 [{"name":"爱好","value":"旅游"},{"name":"卡号","value":"1234567234"}] 扩展属性需要在WEB管理端创建后才生效，否则忽略未知属性的赋值
     */
    public function add($uid, $name, $department = null, $mobile = '', $email = '', $weixinId = '', $position = '', $gender = 1, $avatarMediaId = '', array $extend = array()) {
        if (!$uid || !$name) {
            $this->setError('userid和name必填!');

            return false;
        }

        if (!empty($mobile) || empty($email) || empty($weixinId)) {
            $this->setError('weixinid, mobile, email三者至少填一个!');

            return false;
        }
        
        if (is_int($department)) {
            $department = array($department);
        }

        $data = array(
            'userid' => $uid,
            'name' => $name
        );
        if ($department) {
            $data['department'] = $department;
        }
        if ($mobile) {
            $data['mobile'] = $mobile;
        }
        if ($email) {
            $data['email'] = $email;
        }
        if ($weixinId) {
            $data['weixinid'] = $weixinId;
        }
        if ($position) {
            $data['position'] = $position;
        }
        if ($gender) {
            $data['gender'] = $gender;
        }
        if ($avatarMediaId) {
            $data['avatar_mediaid'] = $avatarMediaId;
        }
        
        if ($extend) {
            $data['extattr']['attrs'] = $extend;
        }

        return $this->doPost(self::API_CREATE, $data);
    }

    /**
     * 更新 值为null时不更新相应字段
     * @param string $uid
     * @param string $name
     * @param array $department
     * @param string $mobile
     * @param string $email
     * @param string $weixinId
     * @param string $position
     * @param int $gender
     * @param boolean $enable
     * @param string $avatarMediaId
     * @param array $extend
     * @return boolean
     */
    public function update($uid, $name, $department = null, $mobile = null, $email = null, $weixinId = null, $position = null, $gender = null, $enable = null, $avatarMediaId = null, array $extend = null) {
        if (!$uid || !$name) {
            $this->setError('userid和name必填!');

            return false;
        }

        if (!empty($mobile) || empty($email) || empty($weixinId)) {
            $this->setError('weixinid, mobile, email三者至少填一个!');

            return false;
        }
        
        if (is_int($department)) {
            $department = array($department);
        }

        $data = array(
            'userid' => $uid,
            'name' => $name
        );
        if ($department !== null) {
            $data['department'] = $department;
        }
        if ($mobile !== null) {
            $data['mobile'] = $mobile;
        }
        if ($email !== null) {
            $data['email'] = $email;
        }
        if ($weixinId !== null) {
            $data['weixinid'] = $weixinId;
        }
        if ($position !== null) {
            $data['position'] = $position;
        }
        if ($gender !== null) {
            $data['gender'] = $gender;
        }
        if ($enable !== null) {
            $data['enable'] = ($enable == 1) ? 1 : 0;
        }
        if ($avatarMediaId !== null) {
            $data['avatar_mediaid'] = $avatarMediaId;
        }
        
        if ($extend !== null) {
            $data['extattr']['attrs'] = $extend;
        }

        return $this->doPost(self::API_UPDATE, $data);
    }

    /**
     * 删除成员
     *
     * @param string $userId 用户的企业号唯一标识  必填
     */
    public function delete($userId) {
        if (!$userId) {
            $this->setError('userid');

            return false;
        }

        return $this->doGet(self::API_DELETE, array(
            'userid' => $userId,
        ));
    }

    /**
     * 批量删除成员
     *
     * @param array $users 该数组key 为用户id组成的删除列表  必填
     */
    public function batchDelete($users) {
        if (!$users) {
            $this->setError('userList');

            return false;
        }

        return $this->doPost(self::API_BATCH_DELETE, array(
            'useridlist' => $users
        ));
    }

    /**
     * 邀请指定ID用户关注
     *
     * @param string $userId 用户在微信端的userid.
     *
     * @return array 接口返回信息
     */
    public function invite($userId) {
        $userId = trim($userId);
        if (false == $userId) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doPost(self::API_SEND_INVITE, array(
            'userid' => $userId,
        ));
    }

    /**
     * 根据用户ID获取用户信息
     *
     * @param string $userId 用户在微信端的userid.
     *
     * @return array 用户信息
     */
    public function get($userId) {
        $userId = trim($userId);
        if (false == $userId) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doGet(self::API_GET, array(
            'userid' => $userId,
        ));
    }

    /**
     * 根据部门ID获取部门成员列表
     *
     * @param int $departmentId 协议换回的code
     * @param int $fetchChild   1/0：是否递归获取子部门下面的成员
     * @param int $status       0获取全部成员，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     *
     * @return array 用户列表
     */
    public function querySimpleByDept($departmentId, $fetchChild = 1, $status = 0) {
        if (false == $departmentId) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doGet(self::API_LIST_SIMPLE, array(
            'department_id' => $departmentId,
            'fetch_child' => $fetchChild,
            'status' => $status,
        ));
    }

    /**
     * 根据部门ID获取部门成员列表(详情)
     *
     * @param int $departmentId 协议换回的code
     * @param int $fetchChild   1/0：是否递归获取子部门下面的成员
     * @param int $status       0获取全部成员，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     *
     * @return array 用户列表
     */
    public function queryByDept($departmentId, $fetchChild = 0, $status = 0) {
        if (false == $departmentId) {
            $this->setError('参数错误');

            return false;
        }

        return $this->doGet(self::API_LIST, array(
            'department_id' => $departmentId,
            'fetch_child' => $fetchChild,
            'status' => $status,
        ));
    }
    
    public function getOpenid($uid, $agentId = null) {
        return $this->doGet(self::API_GET_OPENID, array('userid' => $uid, 'agentid' => $agentId));
    }
    
    public function getUserid($openid) {
        return $this->doGet(self::API_GET_USERID, array('openid' => $openid));
    }

}
