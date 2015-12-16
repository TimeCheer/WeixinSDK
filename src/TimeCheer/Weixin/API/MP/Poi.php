<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 门店相关接口
 * @link http://mp.weixin.qq.com/wiki/12/217643570209ee782f1a3bc54024b724.html
 */
class Poi extends Base {

    const API_UPLOAD_IMAGE = '/media/uploadimg';
    const API_ADD = '/poi/addpoi';
    const API_GET = '/poi/getpoi';
    const API_LIST = '/poi/getpoilist';
    const API_UPDATE = '/poi/updatepoi';
    const API_DELETE = '/poi/delpoi';
    const API_CATEGORY = '/poi/getwxcategory';

    /**
     * 上传图片，为创建门店做准备
     * @param  string $url
     * @return string "url":http://
     */
    public function uploadImage($url) {
        return $this->doPost(self::API_UPLOAD_IMAGE);
    }

    /**
     * 创建门店
     * @param  array $information 门店的信息
     * @return array {
     *      "errcode":0,
     *      "errmsg":"ok"
     * }
     */
    public function add($information) {
        return $this->doPost(self::API_ADD, $information, array(), true);
    }

    /**
     * 查询门店详细信息
     * @param int $poiId 门店id
     * @return araay {
     *      "errcode":0,
     *      "errmsg":"ok",
     *      "business ":{
     *          "base_info":{
     *              "sid":"001",
     *              "business_name":"麦当劳",
     *              "branch_name":"艺苑路店",
     *              "province":"广东省",
     *              "city":"广州市",
     *              "address":"海珠区艺苑路11 号",
     *              "telephone":"020-12345678",
     *              "categories":["美食,小吃快餐"],
     *              "offset_type":1,
     *              "longitude":115.32375,
     *              "latitude":25.097486,
     *              "photo_list":[{"photo_url":"https:// XXX.com"} ， {"photo_url":"https://XXX.com"}],
     *              "recommend":"麦辣鸡腿堡套餐，麦乐鸡，全家桶",
     *              "special":"免费wifi，外卖服务",
     *              "introduction":"麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国，在世界上大",
     *              "open_time":"8:00-20:00",
     *              "avg_price":35
     *              "available_state":3
     *              "update_status":0
     *          }
     *      }
     * }
     */
    public function get($poiId) {
        return $this->doPost(self::API_GET, array('poi_id' => $poiId), array(), true);
    }

    /**
     * 查询门店列表
     * $param int $begin 开始位置，0 即为从第一条开始查询 (必填)
     * @param int $limit 返回数据条数，最大允许50，默认为20 (必填)
     * @return array{
     *      "errcode":
     *      "errmsg":
     *      "business_list":[
     *          {"base_info":{
     *          "sid":"101",
     *          "business_name":"麦当劳",
     *          "branch_name":"艺苑路店",
     *          "address":"艺苑路11号",
     *          "telephone":"020-12345678",
     *          "categories":["美食,快餐小吃"],
     *          "city":"广州市",
     *          "province":"广东省",
     *          "offset_type":1,
     *          "longitude":115.32375,
     *          "latitude":25.097486,
     *          "photo_list":[{"photo_url":"http: ...."}],
     *          "introduction":"麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国",
     *          "recommend":"麦辣鸡腿堡套餐，麦乐鸡，全家桶",
     *          "special":"免费wifi，外卖服务",
     *          "open_time":"8:00-20:00",
     *          "avg_price":35,
     *          "poi_id":"285633617",
     *          "available_state":3,
     *          "district":"海珠区",
     *          "update_status":0
     *        }},......
     *      ]
     *      "total_count":"3",
     * }
     */
    public function query($begin, $limit = 20) {
        return $this->doPost(self::API_LIST, array('begin' => $begin, 'limit' => $limit), array(), true);
    }

    /**
     * 修改门店服务信息
     * @param int $poiId 门店id
     * @param array $details 门店修改信息
     * @return array{
     *      "errcode":0,
     *      "errmsg":"ok"
     * }
     */
    public function update($poiId, $details) {
        return $this->doPost(self::API_UPDATE, array('poi_id' => $poiId, 'details' => $details));
    }

    /**
     * 删除门店
     * @param int $poiId 门店id
     * @return array{
     *      "errcode":0,
     *      "errmsg":"ok"
     * }
     */
    public function delete($poiId) {
        return $this->doPost(self::API_DELETE, array('poi_id' => $poiId));
    }

    /**
     * 门店类目标
     * @return string $categofy_list
     */
    public function category() {
        return $this->doGet(self::API_CATEGORY);
    }

}
