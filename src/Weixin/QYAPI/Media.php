<?php

/**
 * 临时素材件相关接口 3天内有效
 * @package timecheer.weixin.qyapi
 */
class Weixin_QYAPI_Media extends Weixin_QYAPI_Base {
    
    const API_MEDIA_UPLOAD = '/media/upload';
    
    const API_MEDIA_GET = '/media/get';
    
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';

    /**
     * 上传临时媒体文件
     * 传的媒体文件限制
     * 所有文件size必须大于5个字节
     * 图片（image）:2MB，支持JPG,PNG格式
     * 语音（voice）：2MB，播放长度不超过60s，支持AMR格式
     * 视频（video）：10MB，支持MP4格式
     * 普通文件（file）：20MB
     *
     * @param string $file 文件路径
     * @param string $type 文件类型
     *
     * @return 接口返回结果
     */
    public function upload($file, $type = self::TYPE_FILE) {
        if (!$file || !$type) {
            $this->setError('参数缺失');

            return false;
        }

        if (!file_exists($file)) {
            $this->setError('文件路径不正确');

            return false;
        }

        // 兼容php5.3-5.6 curl模块的上传操作
        if (version_compare(PHP_VERSION, '5.3.0') >= 0 && class_exists('\CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($file)));
        } else {
            $data = array('media' => '@' . realpath($file));
        }

        return $this->doPost(self::API_MEDIA_UPLOAD, $data, array('type' => $type));
    }

    /**
     * 根据mediaID获取媒体文件
     *
     * @param string $mediaId 由上传接口获取的媒体文件
     *
     * @return array 如果成功则返回 content是由base64编码过的文件内容 解码后为正常的文件内容.
     */
    public function get($mediaId) {

        return $this->doGet(self::API_MEDIA_GET, array('media_id' => $mediaId));
    }

}
