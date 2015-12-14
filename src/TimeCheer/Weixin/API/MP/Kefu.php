<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 客服管理接口
 * @package timecheer.weixin.api.mp
 */
class Kefu extends Base {
    
    const API_ADD = '/kfaccount/add';
    const API_UPDATE = '/kfaccount/update';
    const API_DELETE = '/kfaccount/del';
    const API_LIST = '/getkflist';
    const API_LIST_ONLINE = '/getonlinekflist';
    
    public $_err_msg = array(
        '0' => '成功', //(no error)
        '61451' => '参数错误', //(invalid parameter)
        '61452' => '无效客服账号', //(invalid kf_account)
        '61453' => '账号已存在', //(kf_account exsited)
        '61454' => '账号名长度超过限制(前缀10个英文字符)', //(invalid kf_acount length)
        '61455' => '账号名包含非法字符(英文+数字)', //(illegal character in kf_account)
        '61456' => '账号个数超过限制(100个客服账号)', //(kf_account count exceeded)
        '61457' => '无效头像文件类型', //(invalid file type)
    );

    /**
     * 添加客户帐号
     * 
     * @param string $kf_acount 完整客服账号，格式为：账号前缀@公众号微信号
     * @param string $nickname 客服昵称，最长6个汉字或12个英文字符
     * @param string $password 客服账号登录密码，格式为密码明文的32位加密MD5值
     * @return boolean
     */
    public function add($kf_acount, $nickname, $password) {
        $params = array(
            'kf_account' => $kf_acount,
            'nickname' => $nickname,
            'password' => $password,
        );
        $res = $this->doPost(self::API_ADD, $params);

        if (isset($res['errcode']) && $res['errcode'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 设置客户信息
     * 
     * @param string $kf_acount 完整客服账号，格式为：账号前缀@公众号微信号
     * @param string $nickname 客服昵称，最长6个汉字或12个英文字符
     * @param string $password 客服账号登录密码，格式为密码明文的32位加密MD5值
     * @return boolean
     */
    public function update($kf_acount, $nickname, $password) {
        $params = array(
            'kf_account' => $kf_acount,
            'nickname' => $nickname,
            'password' => $password,
        );
        $res = $this->doPost(self::API_UPDATE, $params);

        if (isset($res['errcode']) && $res['errcode'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 给客服帐号上传头像
     * 
     * @param string $media 头像图片
     * @param string $kf_account 完整客服账号，格式为：账号前缀@公众号微信号
     * @return boolean
     */
    public function uploadHeadImg($media, $kf_account) {
        $params = array(
            'media' => '@' . $media,
        );
        $res = $this->doPost(self::API_UPDATE, $params, array('kf_account' => $kf_account));

        if (isset($res['errcode']) && $res['errcode'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 删除客户帐号
     */
    public function delete($kf_account) {

        $res = $this->doGet(self::API_DELETE, array('kf_account' => $kf_account));

        if (isset($res['errcode']) && $res['errcode'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 获取客服基本信息
     * 
     * @return boolean|array array(array('kf_account'=>'***', 'kf_headimgurl'=>'***', 'kf_id'=>'1001', 'kf_nick'=>'***'),...)
     */
    public function getKFList() {

        $res = $this->doGet(self::API_LIST);

        if (!isset($res['kf_list'])) {
            return false;
        }

        return $res['kf_list'];
    }

    /**
     * 获取在线客户接待状态
     * 
     * @return boolean|array array(array('kf_account'=>'***', 'status'=>1, 'kf_id'=>'1001', 'auto_accept'=>0, 'accepted_case'=>1),...)
     */
    public function getOnlineKFList() {

        $res = $this->doGet(self::API_LIST_ONLINE);

        if (!isset($res['kf_online_list'])) {
            return false;
        }

        return $res['kf_online_list'];
    }
}