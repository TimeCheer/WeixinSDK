<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 应用管理相关接口
 * @package timecheer.weixin.qyapi
 */
class Agent extends Base {
    
    const API_AGENT_GET = '/agent/get';
    
    const API_AGENT_SET = '/agent/set';
    
    const API_AGENT_LIST = '/agent/list';

    /**
     * 根据应用ID 获取应用信息
     *
     * @param int $agentid 应用id
     *
     * @return array
     */
    public function doGet($agentid) {
        if (!is_numeric($agentid)) {
            $this->setError('agentid 错误!');

            return false;
        }

        return $this->doGet(self::API_AGENT_GET, array('agentid' => $agentid));
    }

    /**
     * 根据应用ID s设置应用信息
     *
     * @param int   $agentid 应用id
     * @param array $data    想要设置的信息
     *
     * @return array
     */
    public function set($agentid, $data) {
        if (!is_numeric($agentid)) {
            $this->setError('agentid 错误!');

            return false;
        }

        return $this->doPost(self::API_AGENT_SET, $data, array('agentid' => $agentid));
    }

    /**
     * 企业号应用的基本信息，包括头像、昵称、帐号类型、认证类型、可见范围等信息
     *
     * @return array
     */
    public function getAppList() {

        return $this->doGet(self::API_AGENT_LIST);
    }

}
