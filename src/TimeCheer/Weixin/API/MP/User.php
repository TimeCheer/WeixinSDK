<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 获取粉丝用户基础信息
 * @package timecheer.weixin.api.mp
 */
class User extends Base {
    
    const API_LIST = '/user/get';
    
    const API_INFO = '/user/info';
    
    const API_INFOS = '/user/info/batchget';
    
    const API_UPDATE_REMARK = '/user/info/updateremark';
    
    /**
     * 来获取帐号的关注者列表,一次拉取调用最多拉取10000个关注者的OpenID
     * @link http://mp.weixin.qq.com/wiki/11/434109e8de46b3968639217bbcb16c2f.html
     * @param string $nextOpenId 上一次调用得到的OPENID，不填默认从头开始拉取
     * @return array
     */
    public function getAll($nextOpenId = '') {
        $data = array();
        if ($nextOpenId) {
            $data['next_openid'] = $nextOpenId;
        }

        return $this->doGet(self::API_LIST, $data);
    }
    
    /**
     * 通过OpenID来获取用户基本信息
     * @link http://mp.weixin.qq.com/wiki/17/c807ee0f10ce36226637cebf428a0f6d.html
     * @param string $openId
     * @return array
     */
    public function getInfo($openId) {
        return $this->doGet(self::API_INFO, array('openid' => $openId));
    }
    
    /**
     * 通过多个OpenID批量获取用户基本信息
     * @link http://mp.weixin.qq.com/wiki/17/c807ee0f10ce36226637cebf428a0f6d.html
     * @param array $openIds
     */
    public function getAllInfo($openIds) {
        $data = array();
        foreach ($openIds as $openid) {
            $data[] = array('openid' => $openid, 'lang' => 'zh-CN');
        }
        
        return $this->doPost(self::API_INFOS, array('user_list' => $data));
    }
    
    /**
     * 设置备注名 该接口暂时开放给微信认证的服务号
     * @param string $openId
     * @param string $remark
     * @return bool
     */
    public function updateRemark($openId, $remark) {
        return $this->doPost(self::API_UPDATE_REMARK, array(
            'openid' => $openId, 
            'remark' => $remark
        ));
    }
}