<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 门店相关接口
 */
class Poi extends Base {

    const API_UPLOAD_IMAGE = '/media/uploading';
    const API_ADD = '/poi/addpoi';
    const API_GET = '/poi/getpoi';
    const API_LIST = '/poi/getpoilist';
    const API_UPDATE = '/poi/updatepoi';
    const API_DELETE = '/poi/delpoi';
    const API_CATEGORY = '/poi/getwxcategory';

    /**
     * 上传图片，为创建门店做准备
     */
    public function uploadImage() {
        return $this->doPost(self::API_UPLOAD_IMAGE);
    }

    /**
     * 创建门店
     * @param string $information 门店的信息
     */
    public function add($information) {
        return $this->doPost(self::API_ADD, $information, array(), true);
    }

    /**
     * 查询门店详细信息
     * @param int $poiId 门店id
     */
    public function get($poiId) {
        return $this->doPost(self::API_GET, array('poi_id' => $poiId), array(), true);
    }

    /**
     * 查询门店列表
     * $param int $begin 开始位置，0 即为从第一条开始查询 (必填)
     * @param int $limit 返回数据条数，最大允许50，默认为20 (必填)
     */
    public function query($begin, $limit = 20) {
        return $this->doPost(self::API_LIST, array('begin' => $begin, 'limit' => $limit), array(), true);
    }

    /**
     * 修改门店服务信息
     * @param int $poiId 门店id
     * @param array $details 门店修改信息
     */
    public function update($poiId, $details) {
        return $this->doPost(self::API_UPDATE, array('poi_id' => $poiId, 'details' => $details));
    }

    /**
     * 删除门店
     * @param int $poiId 门店id
     */
    public function delete($poiId) {
        return $this->doPost(self::API_DELETE, array('poi_id' => $poiId));
    }

    /**
     * 门店类目标
     */
    public function category() {
        return $this->doGet(self::API_CATEGORY);
    }

}
