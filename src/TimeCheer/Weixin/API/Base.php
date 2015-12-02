<?php

namespace TimeCheer\Weixin\API;

/**
 * OAuth2 相关资源接口
 * @package timecheer.weixin.api
 */
class Base extends \TimeCheer\Weixin\Base {
    /**
     *
     * @var string oauth2接口地址前缀 
     */
    protected $apiPrefix = 'https://api.weixin.qq.com';
}