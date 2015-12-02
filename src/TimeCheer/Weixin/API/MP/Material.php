<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 永久素材相关接口 包含临时素材操作
 * @package timecheer.weixin.api.mp
 */
class Material extends Base {
    
    const API_GET = '/material/get_material';
    const API_ADD = '/material/add_material';
    const API_ADD_NEWS = '/material/add_news';
    const API_UPLOAD_NEWS_IMG = '/media/uploadimg';
    const API_DELETE = '/material/del_material';
    const API_UPDATE_NEWS = '/material/update_news';
    const API_COUNT = '/material/get_materialcount';
    const API_LIST = '/material/batchget_material';
    
    const API_UPLOAD_TMP = '/media/upload';
    const API_DOWNLOAD_TMP = '/media/get';
    
    const API_UPLOAD_NEWS = '/media/uploadnews';
    
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VEDIO = 'video';
    const TYPE_THUMB = 'thumb';
    const TYPE_NEWS = 'news';
    
    /**
     * 获取永久素材
     * @param string $mediaId
     * @return array
     */
    public function get($mediaId) {
        return $this->doPost(self::API_GET, array('media_id' => $mediaId), array(), true);
    }
    
    /**
     * 新增除图文素材外的其他类型永久素材
     * @param array $media
     * @param string $type
     * @param array $videoDescription 视频素材需要POST另一个表单
     * @return array array('media_id' => '', 'url' => '视频素材返回url')
     */
    public function add($media, $type = self::TYPE_IMAGE, $videoDescription = array()) {
        if (!file_exists($media)) {
            $this->setError('文件路径不正确');

            return false;
        }

        // 兼容php5.3-5.6 curl模块的上传操作
        if (version_compare(PHP_VERSION, '5.3.0') >= 0 && class_exists('CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($media)));
        } else {
            $data = array('media' => '@' . realpath($media));
        }
        $data['type'] = $type;
        if ($type == self::TYPE_VEDIO) {
            $data['description'] = json_encode($videoDescription);
        }
        
        return $this->doPost(self::API_ADD, $data);
    }
    
    /**
     * 添加图文素材
     * 永久素材的数量是有上限的，请谨慎新增。图文消息素材和图片素材的上限为5000，其他类型为1000
     * 素材的格式大小等要求与公众平台官网一致。
     * 具体是，图片大小不超过2M，支持bmp/png/jpeg/jpg/gif格式，
     * 语音大小不超过5M，长度不超过60秒，支持mp3/wma/wav/amr格式
     * 
     * 在图文消息的具体内容中，将过滤外部的图片链接，
     * 开发者可以通过$this->uploadNewsImage接口上传图片得到URL，放到图文内容中使用
     * @param array $articles 多图文列表
     * @return string media_id
     */
    public function addNews($articles) {
        return $this->doPost(self::API_ADD_NEWS, array('articles' => $articles));
    }
    
    /**
     * 上传图文消息内的图片
     * 订阅号与服务号认证后均可用
     * @param array $media
     * @return string 返回图片在微信服务器的url
     */
    public function uploadNewsImage($media) {
        if (!file_exists($media)) {
            $this->setError('文件路径不正确');

            return false;
        }

        // 兼容php5.3-5.6 curl模块的上传操作
        if (version_compare(PHP_VERSION, '5.5.0') >= 0 && class_exists('CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($media)));
        } else {
            $data = array('media' => '@' . realpath($media));
        }
        
        return $this->doPost(self::API_UPLOAD_NEWS_IMG, $data);
    }
    
    /**
     * 删除不再需要的永久素材
     * @param string $mediaId
     * @return bool
     */
    public function del($mediaId) {
        return $this->doPost(self::API_DELETE, array('media_id' => $mediaId));
    }
    
    /**
     * 对永久图文素材进行修改 一次修改多图文中的一篇
     * @param string $mediaId
     * @param array $article
     * @param int $index 要更新的文章在图文消息中的位置 多图文消息时，此字段才有意义）第一篇为0
     * @return bool
     */
    public function updateNews($mediaId, $article, $index = 0) {
        return $this->doPost(self::API_UPDATE_NEWS, array('media_id' => $mediaId, 'index' => $index, 'articles' => $article));
    }
    
    /**
     * 获取素材总数
     * @return array {
     *   "voice_count":COUNT,
     *   "video_count":COUNT,
     *   "image_count":COUNT,
     *   "news_count":COUNT
     * }
     */
    public function getCount() {
        return $this->doGet(self::API_COUNT);
    }
    
    /**
     * 分类型获取永久素材的列表
     * @param string $type 图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param int $offset 0表示从第一个素材 返回
     * @param int $count 返回素材的数量，取值在1到20之间
     * @return array
     */
    public function getAll($type = self::TYPE_IMAGE, $offset = 0, $count = 20) {
        return $this->doPost(self::API_LIST, array('type' => $type, 'offset' => $offset, 'count' => $count));
    }
    
    /**
     * 上传临时素材
     * @param array $media
     * @param string $type 图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     */
    public function uploadTmp($media, $type = self::TYPE_IMAGE) {
        if (!file_exists($media)) {
            $this->setError('文件路径不正确');

            return false;
        }

        // 兼容php5.5以上 curl模块的上传操作
        if (version_compare(PHP_VERSION, '5.3.0') >= 0 && class_exists('CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($media)));
        } else {
            $data = array('media' => '@' . realpath($media));
        }
        $data['type'] = $type;
        
        return $this->doPost(self::API_UPLOAD_TMP, $data);
    }
    
    /**
     * 临时素材下载。请注意，由于视频文件不支持https下载,该方法暂不能下载视频
     * @param string $mediaId
     * @return mixed
     */
    public function downloadTmp($mediaId) {
        return $this->doGet(self::API_DOWNLOAD_TMP, array('media_id' => $mediaId));
    }
    
    /**
     * 用于群发 上传图文消息素材【订阅号与服务号认证后均可用】
     * @link http://mp.weixin.qq.com/wiki/14/0c53fac3bdec3906aaa36987b91d64ea.html#.E4.B8.8A.E4.BC.A0.E5.9B.BE.E6.96.87.E6.B6.88.E6.81.AF.E7.B4.A0.E6.9D.90.E3.80.90.E8.AE.A2.E9.98.85.E5.8F.B7.E4.B8.8E.E6.9C.8D.E5.8A.A1.E5.8F.B7.E8.AE.A4.E8.AF.81.E5.90.8E.E5.9D.87.E5.8F.AF.E7.94.A8.E3.80.91
     * @param array $articles
     */
    public function uploadNews($articles) {
        return $this->doPost(self::API_UPLOAD_NEWS, array('articles' => $articles));
    }
}