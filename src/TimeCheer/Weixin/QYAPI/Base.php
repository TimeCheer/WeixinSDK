<?php

namespace TimeCheer\TimeCheer\Weixin\QYAPI;

/**
 * API基类
 * @package timecheer.weixin.qyapi
 */
class Base extends \TimeCheer\Weixin\Base {
    
    /**
     *
     * @var string 企业号的url前缀 
     */
    protected $apiPrefix = 'https://qyapi.weixin.qq.com/cgi-bin';

}
