<?php

namespace TimeCheer\Weixin\API\MP;
/**
 * 门店相关接口
 */
class Outlet extends Base{
    const UPLOAD_IMAGE = '/media/uploading';
    const CREATE_OUTLET = '/poi/addpoi';
    const OUTLET_DETAILS = '/poi/getpoi';
    const OUTLET_LIST = '/poi/getpoilist';
    const OUTLET_UPDATE = '/poi/updatepoi';
    const OUTLET_DELETE = '/poi/delpoi';
    const OUTLET_CATEGORY = '/poi/getwxcategory';
    
    /**
     * 上传图片，为创建门店做准备
     * @param 
     */
    public function uploadImage(){
        return $this->doPost(self::UPLOAD_IMAGE,array(),array(),false);
    }
    
    /**
     * 创建门店
     * @param
     */
    public function createOutlet($information){
        return $this->doPost(self::CREATE_OUTLET,$information,array(),true);
    }
    
    /**
     * 查询门店详细信息
     * @param
     */
    public function outletDetails($poi_id){
        return $this->doPost(self::OUTLET_DETAILS,array('poi_id'=>$poi_id),array(),true);
    }
    
    /**
     * 查询门店列表
     * @param
     */
    public function outletList(){
        return $this->doPost(self::OUTLET_LIST,array(),array(),true);
    }
    
    /**
     * 修改门店服务信息
     * @param int $poi_id 门店id
     * @param array $details 门店修改信息
     */   
    public function outletUpdate($poi_id,$details){
        return $this->doPost(self::OUTLET_UPDATE,array('poi_id'=>$poi_id,'details'=>$details));
    }
    
    /**
     * 删除门店
     * @param int $poi_id 门店id
     */
    public function outletDelete($poi_id){
        return $this->doPost(self::OUTLET_DELETE,array('poi_id'=>$poi_id));
    }
    
    /**
     * 门店类目标
     */
    public function outletCategory(){
        return $this->doGet(self::OUTLET_CATEGORY);
    }
}