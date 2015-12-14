<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 批量发送消息接口
 * @package timecheer.weixin.mp
 */
class Mass extends Base {
    
    const API_GET = '/mass/get';
    const API_SEND = '/mass/send';
    const API_SEND_ALL = '/mass/getall';
    const API_DELETE = '/mass/delete';

    /**
     * 查询群发消息发送状态
     * 
     * @param int $msg_id
     * @return string|boolean SEND_SUCCESS表示发送成功
     */
    public function get($msg_id) {
        $params = array(
            'msg_id' => $msg_id,
        );
        $res = $this->doPost(self::API_GET, $params);

        return !empty($res['msg_status']) ? $res['msg_status'] : false;
    }

    /**
     * 发送消息
     * 
     * @param string|array $data
     * @param boolean $is_all send/sendall
     * @return boolean
     */
    public function send($data, $is_all = false) {
        if (is_array($data)) {
            $data = json_encode($data);
        } else if (!json_decode($data)) {
            return false;
        }
        $res = $this->httpRequest($is_all ? self::API_SEND_ALL : self::API_SEND, $data);

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return $res;
        }

        return false;
    }

    /**
     * 删除群发
     * <pre>
     * 1、只有已经发送成功的消息才能删除
     * 2、删除消息是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。
     * 3、删除群发消息只能删除图文消息和视频消息，其他类型的消息一经发送，无法删除。
     * 4、如果多次群发发送的是一个图文消息，那么删除其中一次群发，就会删除掉这个图文消息也，导致所有群发都失效
     * </pre>
     * @param int $msg_id 发送出去的消息ID
     * @return boolean
     */
    public function delete($msg_id) {
        $params = array(
            'msg_id' => $msg_id,
        );
        $res = $this->httpRequest($this->url . 'mass/delete?' . http_build_query($this->getParams()), $params, 'post');

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return true;
        }

        return false;
    }

    /**
     * 根据分组进行群发【订阅号与服务号认证后均可用】
     * 
     * @param string $media_id
     * @param string $msgtype 'mpnews', 'text', 'image', 'voice', 'mpvideo','wxcard'
     * @param boolean $is_to_all
     * @param int $group_id
     * @return false|array
     */
    public function sendByGroup($media_id, $msgtype = 'mpnews', $is_to_all = TRUE, $group_id = 0) {
        $params = array(
            'filter' => array('is_to_all' => ($is_to_all ? true : false)),
            $msgtype => array('media_id' => $media_id),
            'msgtype' => $msgtype
        );
        if (!$is_to_all) {
            if (!is_numeric($group_id) || $group_id < 0) {
                return false;
            }
            $params['filter']['group_id'] = $group_id;
        }

        $res = $this->httpRequest($this->url . 'mass/sendall?' . http_build_query($this->getParams()), $params, 'post');

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return $res;
        }

        return false;
    }

    /**
     * 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
     * 
     * @param string|array $media
     * @param string $msgtype 'news', 'mpnews', 'text', 'image', 'voice', 'video','wxcard'
     * @param array|string $openids
     * @return false|array
     */
    public function sendByOpenid($media, $msgtype = 'mpnews', $openids = null) {
        if (empty($openids)) {
            return false;
        }
        if (!is_array($openids)) {
            $openids = explode(',', $openids);
        } else {
            $openids = array_values($openids);
        }

        $params = array(
            'touser' => $openids,
            'msgtype' => $msgtype,
            $msgtype => array('media_id' => $media)
        );
        switch ($msgtype) {
            case 'wxcard':
                $params[$msgtype] = array('card_id' => $media);
                break;
            case 'text':
                $params[$msgtype] = array('content' => $media);
                break;
            case 'video':
                $params[$msgtype]['title'] = $media['title'];
                $params[$msgtype]['description'] = $media['description'];
                break;
            default:
                break;
        }

        $res = $this->httpRequest($this->url . 'mass/send?' . http_build_query($this->getParams()), $params, 'post');

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return $res;
        }

        return false;
    }

}
