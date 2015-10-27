<?php

class Weixin_HTTPClient {
    
    
    /**
     * 设置post操作的get参数
     * @param string $name  参数名
     * @param string $value 值
     */
    public static function setPostQueryStr($name, $value) {
        self::$postQueryStr[$name] = $value;
    }

    /**
     * 用get的方式访问接口.
     *
     *
     * @param string $url   指定接口模块
     * @param array  $data 查询字符串
     * @param array  $header   http头部附加信息
     *
     * @return array 错误时返回false
     */
    public static function get($url, $data = array(), $header = array()) {
        $apiUrl = $url . '?' . http_build_query($data);

        $header[] = 'BizMP-Version:2.0';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $header = '';
        $body = $res;
        if ($httpcode == 200) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            $header = self::parseHeaders($header);
        }

        $result['info'] = $body;
        $result['header'] = $header;
        $result['status'] = $httpcode;

        return self::packData($result);
    }

    /**
     * 用post的方式访问接口
     *
     * @param string $url       指定url
     * @param array  $data       要发送的数据
     * @param bool   $jsonEncode 是否转换为jsons数据
     *
     * @return array 错误时返回false;
     */
    public static function post($url, $data, $jsonEncode = true) {

        if ($jsonEncode) {
            if (is_array($data)) {
                if (!defined('JSON_UNESCAPED_UNICODE')) {
                    // 解决php 5.3版本 json转码时 中文编码问题.
                    $data = json_encode($data);
                    $data = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $data);
                } else {
                    $data = json_encode($data, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);

        // 对上传操作做的特殊判断
        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = trim(curl_exec($ch));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $header = '';
        $body = $res;
        if ($httpcode == 200) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            $header = self::parseHeaders($header);
        }

        $result['info'] = $body;
        $result['header'] = $header;
        $result['status'] = $httpcode;

        return self::packData($result);
    }

    /**
     * 对接口返回的数据进行验证和组装
     *
     * @param array $apiReturnData 由_post|| _get方法返回的数据.
     *
     * @return array
     */
    private static function packData($apiReturnData) {
        if ($apiReturnData['status'] != 200) {
            self::setError('微信接口服务器连接失败.');

            return false;
        }

        $status = $apiReturnData['status'];
        $info = $apiReturnData['info'];
        $header = $apiReturnData['header'];
        $apiReturnData = json_decode($info, true);

        $log = array();
        $log['httpcode'] = $status;
        $log['response'] = $info;

        if ($status != 200 && !$apiReturnData) {
            self::setError($info);

            return false;
        }

        // 获取文件的特殊设置.
        if (!$apiReturnData) {
            $log['response'] = array();
            $apiReturnData = array();
            $apiReturnData['content'] = base64_encode($info);
            $apiReturnData['type'] = $header['Content-Type'];
            $apiReturnData['size'] = $header['Content-Length'];

            if (isset($header['Content-disposition'])) {
                $res = preg_match('/".+"/', $header['Content-disposition'], $matchArr);

                if ($res && $matchArr) {
                    $apiReturnData['filename'] = reset($matchArr);
                    $log['response']['filename'] = $apiReturnData['filename'];
                }
            }

            $log['response']['type'] = $apiReturnData['type'];
            $log['response']['size'] = $apiReturnData['size'];
        }

        if (isset($apiReturnData['errcode']) && $apiReturnData['errcode'] != 0) {
            self::setError('错误码:' . $apiReturnData['errcode'] . ', 错误信息:' . $apiReturnData['errmsg']);

            return false;
        }

        if (isset($apiReturnData['errcode'])) {
            unset($apiReturnData['errcode']);
        }

        if (count($apiReturnData) > 1 && isset($apiReturnData['errmsg'])) {
            unset($apiReturnData['errmsg']);
        }

        if (count($apiReturnData) == 1) {
            $apiReturnData = reset($apiReturnData);
        }

        return $apiReturnData;
    }

    /**
     * 解析头部信息
     *
     * @param array $raw_headers http header
     *
     * @return array
     */
    public static function parseHeaders($raw_headers) {
        if (function_exists('http_parse_headers')) {
            return http_parse_headers($raw_headers);
        }

        $headers = array();
        $key = '';

        foreach (explode("\n", $raw_headers) as $i => $h) {
            $h = explode(':', $h, 2);

            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } elseif (is_array($headers[$h[0]])) {
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
                } else {
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
                }

                $key = $h[0];
            } else {
                if (substr($h[0], 0, 1) == "\t") {
                    $headers[$key] .= "\r\n\t" . trim($h[0]);
                } elseif (!$key) {
                    $headers[0] = trim($h[0]);
                }
                trim($h[0]);
            }
        }

        return $headers;
    }

}
