<?php
namespace System\Libraries;

/**
 * 发送网络请求
 * Class Request
 * @package System\Libraries
 */
class Request
{
    /**
     * 发送post请求
     * @param $url string
     * @param $data array
     * @return mixed 成功时返回请求结果，失败返回false
     */
    public static function post($url, $data)
    {
        $curl = curl_init($url);
        $opts = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
        ];

        curl_setopt_array($curl, $opts);

        return self::sendRequest($curl);
    }

    /**
     * 发送get请求
     * @param $url
     * @param array $data
     * @return mixed 成功时返回请求结果，失败返回false
     */
    public static function get($url, $data = [])
    {
        if (!empty($data)) {
            $queryStr = http_build_query($data);
            $url .= '?' . $queryStr;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return self::sendRequest($curl);
    }

    /**
     * 发送网络请求
     * @param $curl resource 发送请求所使用的资源句柄
     * @return mixed 成功时返回请求结果，失败返回false
     */
    private static function sendRequest($curl)
    {
        $res = curl_exec($curl);

        if (curl_errno($curl) !== 0) {
            Log::write('ERROR', 'send post request fail, error msg: ' . curl_error($curl));

            return false;
        }

        curl_close($curl);

        return $res;
    }
}