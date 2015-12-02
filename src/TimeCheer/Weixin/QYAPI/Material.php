<?php

namespace TimeCheer\Weixin\QYAPI;

/**
 * 永久素材件相关接口
 * @package timecheer.weixin.qyapi
 */
class Material extends Base {
    
    const API_ADD_MPNEWS = '/material/add_mpnews';
    const API_ADD_NORMAL = '/material/add_material';
    const API_DELETE = '/material/del';
    const API_UPDATE_MPNEWS = '/material/update_mpnews';
    const API_GET_COUNT = '/material/get_count';
    const API_GET = '/material/get';
    const API_GET_LIST = '/material/batchget';
    
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VEDIO = 'video';
    const TYPE_FILE = 'file';
    const TYPE_MPNEWS = 'mpnews';
    
    /**
     * 上传永久素材
     * @param int $agentId
     * @param string $media form-data中媒体文件标识，有filename、filelength、content-type等信息
     * @param string $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
     */
    public function add($agentId, $media, $type = self::TYPE_IMAGE) {
        if (!file_exists($media)) {
            $this->setError('文件路径不正确');

            return false;
        }

        // 兼容php5.3-5.6 curl模块的上传操作
        if (version_compare(PHP_VERSION, '5.3.0') >= 0 && class_exists('\CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($file)));
        } else {
            $data = array('media' => '@' . realpath($file));
        }
        
        return $this->doPost(self::API_ADD_NORMAL, $data, array('agentid' => $agentId, 'type' => $type));
    }
    
    /**
     * 上传图文消息素材
     * @param int $agentId 企业应用的id 可在应用的设置页面查看
     * @param array $articles 图文消息，一个图文消息支持1到10个图文,每条图文消息的结构为:
     * "title": "Title01", "thumb_media_id": "2-G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0", "author": "zs", "content_source_url": "", "content": "Content001", "digest": "airticle01", "show_cover_pic": "0"
     */
    public function addMPNews($agentId, array $articles) {
        $data = array(
            'agentid' => $agentId,
            'mpnews' => array(
                'articles' => $articles
            )
        );
        
        return $this->doPost(self::API_ADD_MPNEWS, $data);
    }
    
    /**
     * 修改永久图文素材
     * @param int $agentId
     * @param string $mediaId
     * @param array $articles
     * @return type
     */
    public function updateMPNews($agentId, $mediaId, array $articles) {
        $data = array(
            'agentid' => $agentId,
            'media_id' => $mediaId,
            'mpnews' => array(
                'articles' => $articles
            )
        );
        
        return $this->doPost(self::API_UPDATE_MPNEWS, $data);
    }
    
    /**
     * 通过media_id获取上传的图文消息、图片、语音、文件、视频素材
     * @param int $agentId
     * @param string $mediaId
     * @return type
     */
    public function get($agentId, $mediaId) {
        return $this->doGet(self::API_GET, array(
            'agentid' => $agentId,
            'media_id' => $mediaId
        ));
    }
    
    /**
     * 获取应用素材总数以及每种类型素材的数目
     * @param int $agentId
     * @return type
     */
    public function getCount($agentId) {
        return $this->doGet(self::API_GET_COUNT, array(
            'agentid' => $agentId
        ));
    }
    
    /**
     * 
     * @param int $agentId
     * @param string $type 素材类型，可以为图文(mpnews)、图片（image）、音频（voice）、视频（video）、文件（file）
     * @param int $offset 从该类型素材的该偏移位置开始返回，0表示从第一个素材 返回
     * @param int $count 返回素材的数量，取值在1到50之间
     */
    public function query($agentId, $type, $offset, $count) {
        return $this->doPost(self::API_GET_LIST, array(
            'agentid' => $agentId,
            'type' => $type,
            'offset' => $offset,
            'count' => $count
        ));
    }
    
    /**
     * 通过media_id删除上传的图文消息、图片、语音、文件、视频素材
     * @param int $agentId
     * @param string $mediaId
     * @return type
     */
    public function delete($agentId, $mediaId) {
        return $this->doGet(self::API_DELETE, array('agentid' => $agentId, 'media_id' => $mediaId));
    }
}
