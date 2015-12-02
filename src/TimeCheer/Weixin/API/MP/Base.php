<?php

namespace TimeCheer\Weixin\API\MP;

/**
 * MP平台的访问基类
 * @package timecheer.weixin.api.mp
 */
class Base extends \TimeCheer\Weixin\Base {
    /**
     * @var string MP API URL PREFIX
     */
    protected $apiPrefix = 'https://api.weixin.qq.com/cgi-bin';
}