<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 微信 发送消息的相关接口.
 * 注意本类采用链式操作 ->setToUser()->setNews()->send();
 * @package timecheer.weixin.qyapi
 */
class Message extends Base {
    
    const API_MESSAGE_SEND = '/message/send';

    private $_touserData = array();
    private $_topartyData = array();
    private $_totagData = array();
    private $_messageData = array();
    private $_safe = 0;
    private $_messageType = '';

    /**
     * 设置需要接收消息的用户列表
     *
     * @param array/string $users 用户userid列表 array 或者 单个用户的userid string
     *
     * @return Weixin_QYAPI_Message
     */
    public function setToUser($users) {
        $users = $this->toString($users);
        $this->_touserData = $users;

        return $this;
    }

    /**
     * 设置需要接收消息的部门列表
     *
     * @param array/string $partys 部门ID列表 array 或者 单个部门的ID string
     *
     * @return Weixin_QYAPI_Message
     */
    public function setToParty($partys) {
        $partys = $this->toString($partys);
        $this->_topartyData = $partys;

        return $this;
    }

    /**
     * 设置需要接收消息的标签列表
     *
     * @param array/string $tags 标签ID列表 array 或者 单个标签的ID string
     *
     * @return Weixin_QYAPI_Message
     */
    public function setToTag($tags) {
        $tags = $this->toString($tags);
        $this->_totagData = $tags;

        return $this;
    }

    /**
     * 设置安全消息
     *
     * @param bool $flag true : 安全消息 false : 非安全消息
     *
     * @return Weixin_QYAPI_Message
     */
    public function setIsSafe($flag = true) {
        $this->_safe = $flag ? 1 : 0;

        return $this;
    }

    /**
     * 设置text消息
     *
     * @param string $content 文本消息内容
     *
     * @return Weixin_QYAPI_Message
     */
    public function setText($content) {
        $data = array(
            'content' => $content,
        );

        $this->_messageType = 'text';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 设置news消息
     *
     * @param 注意此方法参数特殊:
     * 传递方法
     * news($data, $data, $data....);每多传递一个实参, 则news消息多一条, 最多传递十个.或者第一个参数也可以是个多维数组
     * $data格式 array(
     *     'title'      => title,
     *     'description'=> description,
     *     'url'        => url,
     *     'picurl'     => picurl.
     * )
     *
     * @return Weixin_QYAPI_Message
     */
    public function setNews() {
        $data = array();

        $args = func_get_args();
        $num = func_num_args();
        if ($num > 10 || $num < 1) {
            $this->setError('news 参数错误!');

            return false;
        }

        foreach ($args as $article) {

            if (count($article) != count($article, 1)) {
                foreach ($article as $art) {
                    $data['articles'][] = $art;
                }
            } else {
                $data['articles'][] = $article;
            }
        }

        $this->_messageType = 'news';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 设置image消息
     *
     * @param string $mediaId 由上传接口得到的媒体ID
     *
     * @return Weixin_QYAPI_Message
     */
    public function setImage($mediaId) {
        $data = array(
            'media_id' => $mediaId,
        );

        $this->_messageType = 'image';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 设置file消息
     *
     * @param string $mediaId 由上传接口得到的媒体ID
     *
     * @return Weixin_QYAPI_Message
     */
    public function setFile($mediaId) {
        $data = array(
            'media_id' => $mediaId,
        );

        $this->_messageType = 'file';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 设置voice消息
     *
     * @param string $mediaId 由上传接口得到的媒体ID
     *
     * @return Weixin_QYAPI_Message
     */
    public function setVoice($mediaId) {
        $data = array(
            'media_id' => $mediaId,
        );

        $this->_messageType = 'voice';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 设置video消息
     *
     * @param string $mediaId     由上传接口得到的媒体ID
     * @param string $title       视频标题
     * @param string $description 视频简介
     *
     * @return Weixin_QYAPI_Message
     */
    public function setVideo($mediaId, $title = '', $description = '') {
        $data = array(
            'media_id' => $mediaId,
        );

        $title && $data['title'] = $title;
        $description && $data['description'] = $description;

        $this->_messageType = 'video';
        $this->_messageData = $data;

        return $this;
    }

    /**
     * 发送消息
     *
     * @param int $agentId 应用ID
     *
     * @return 接口返回结果
     */
    public function send($agentId) {
        if (!is_numeric($agentId)) {
            $this->setError('应用ID未设置!');

            return false;
        }

        if (!$this->_touserData && !$this->_topartyData && !$this->_totagData) {
            $this->setError('接收消息的用户,部门和标签, 不能同时为空!');

            return false;
        }

        $data = array();
        $this->_touserData && $data['touser'] = $this->_touserData;
        $this->_topartyData && $data['toparty'] = $this->_topartyData;
        $this->_totagData && $data['totag'] = $this->_totagData;

        $types = array('image', 'file', 'text', 'news', 'voice', 'video', 'mpnews');
        if (!$this->_messageType || !in_array($this->_messageType, $types)) {
            $this->setError('消息类型未设置或设置不正确!');

            return false;
        }
        $data['msgtype'] = $this->_messageType;

        if (empty($this->_messageData)) {
            $this->setError('发送的数据不允许为空!');

            return false;
        }

        $data[$this->_messageType] = $this->_messageData;
        $data['agentid'] = $agentId;
        $data['safe'] = $this->_safe;

        // 清空数据;
        $this->_touserData = array();
        $this->_topartyData = array();
        $this->_totagData = array();
        $this->_messageData = array();
        $this->_safe = 0;
        $this->_messageType = '';

        return $this->request(self::API_MESSAGE_SEND, $data);
    }

    /**
     * 串行化
     *
     * @param array $arr 待转换的数据
     *
     * @return string
     */
    public function toString($arr) {
        if (!is_array($arr)) {
            return $arr;
        }

        return implode('|', $arr);
    }

}
