<?php

//namespace Qcloud\Sms;


/**
 * 发送Util类
 *
 */
class PstnSenderUtil
{



    /**
     * 发送请求
     *
     * @param string $url      请求地址
     * @param array  $dataObj  请求内容
     * @return string 应答json字符串
     */
    public function sendCurlPost($url, $dataObj)
    {
		var_dump($url);
		var_dump(json_encode($dataObj));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

         $ret = curl_exec($curl);
        // if (false == $ret) {
            // $result = "{ \"result\":" . -2 . ",\"errorCode\":\"" . curl_error($curl) . "\"}";
        // } else {
            // $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // if (200 != $rsp) {
                // $result = "{ \"result\":" . -1 . ",\"errorCode\":\"".$rsp. " " . curl_error($curl) ."\"}";
            // } else {
                // $result = $ret;
            // }
        // }
		
        curl_close($curl);
		
        return $ret;
    }
}
