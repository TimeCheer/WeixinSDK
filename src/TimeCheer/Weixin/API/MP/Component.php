<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * 第三方平台相关操作和接口
 */
class Component extends Base {
    
    protected $apiPrefix = 'https://mp.weixin.qq.com/cgi-bin';

    public function __construct($accessToken = '') {
        parent::__construct();
    }
    
    public function jumpToLoginPage() {
        
    }
}

