<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 客服消息处理
 * @package timecheer.weixin.api.mp
 */
class Message extends Base {
    
    const API_SEND = '/message/custom/send';
    
    const TYPE_NEWS = 'news';
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VODEO = 'video';
    const TYPE_MUSIC = 'music';
    const TYPE_MPNEWS = 'mpnews';//微信图文素材
    const TYPE_WXCARD = 'wxcard';//卡券
    
    /**
     * mp开头的指群发
     * @return array
     */
    public function getMsgTypes() {
        return array(
            self::TYPE_NEWS,
            self::TYPE_TEXT,
            self::TYPE_IMAGE,
            self::TYPE_VOICE,
            self::TYPE_VODEO,
            self::TYPE_MUSIC,
            self::TYPE_MPNEWS,
            self::TYPE_WXCARD
        );
    }

    /**
     * 根据OpenID发单条
     * 
     * @param string|array $media
     * @param string $msgtype 'news', 'mpnews', 'text', 'image', 'voice', 'video','wxcard'
     * @param array|string $openids
     * @return boolean
     */
    public function sendOneByOpenid($openids, $media, $msgtype = 'mpnews') {
        if (empty($openids)) {
            return false;
        }

        $params = array(
            'touser' => $openids,
            'msgtype' => $msgtype
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
            case 'news':
                $params[$msgtype]['articles'] = $media;
                break;
            default:
                break;
        }

        $res = $this->httpRequest($this->url . 'custom/send?' . http_build_query($this->getParams()), $params, 'post');
        //\Think\Log::write($res, \Think\Log::DEBUG, null);

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return $res;
        }

        return false;
    }

    /**
     * 发送消息给指定用户，在手机端预览消息的样式和排版
     * 
     * @param string|array $media
     * @param string $msgtype 'mpnews', 'text', 'image', 'voice', 'mpvideo','wxcard'
     * @param string $openid
     * @param string $send_type openid/wechatname
     * @return boolean|array
     */
    public function preview($media, $msgtype, $openid, $send_type = 'openid') {
        $params = array(
            ($send_type == 'openid' ? 'touser' : 'towxname') => $openid,
            'msgtype' => $msgtype,
            $msgtype => array('media_id' => $media)
        );
        switch ($msgtype) {
            case 'wxcard':
                $params[$msgtype] = array('card_id' => $media['card_id'], 'card_ext' => $media['card_ext']);
                break;
            case 'text':
                $params[$msgtype] = array('content' => $media);
                break;
            default:
                break;
        }
        $res = $this->httpRequest($this->url . 'mass/delete?' . http_build_query($this->getParams()), $params, 'post');

        if (isset($res['errcode']) && $res['errcode'] == 0) {
            return $res;
        }

        return false;
    }
}
