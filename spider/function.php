<?php
function http_request(string $url, $data = [], array $header = [])
{
    $ret = '';
    //1.初始化
    $ch = curl_init();
    $timeout = 5;
    //2.设置请求地址
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置一下执行成功后不直接返回客户端
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //设置超时时间，单位：秒
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    //不进行证书检测
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //伪造一个请求的浏览器型号
    curl_setopt($ch, CURLOPT_USERAGENT, 'msie');
    //表示有请求体，是POST提交
    if (!empty($data)) {
        //指明是一个POST请求
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if (is_string($data)) {
            //设置头信息，告诉接收者我们发送的数据类型
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
    }
    // 3.执行
    $ret = curl_exec($ch);
    //请求的错误码，0表示正确，大于0表示请求失败
    if (curl_errno($ch) > 0) {
        echo curl_errno($ch);
        exit;
    }
    //4.关闭请求资源
    curl_close($ch);
    return $ret;
}