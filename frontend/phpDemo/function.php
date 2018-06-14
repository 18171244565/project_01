<?php

    /**
     * rsa 签名生成
     * @param array $params 参数
     * @param string $rsaKey 客户私钥
     * @return string
     */
    function getSign($params=[], $rsaKey='') {
        $signString = '';
        ksort($params);//按键名排序：正序
        foreach ($params as $key=>$val) {
            if ($signString != '') {
                $signString .= '&';
            }
            $signString .= strtoupper($key."=").$val;

        }

        $rsaKey = chunk_split($rsaKey, 64, "\n");
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n$rsaKey-----END RSA PRIVATE KEY-----\n";
        $res = openssl_get_privatekey($privateKey);
        openssl_sign($signString, $sign, $res);//加签
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /** 
	 * curl post 请求
     * @param string $url
     * @param string $params
     * @return mixed
     */
    function postJson($url='', $params='') {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json;charset=utf-8',
        ];
        $ch = curl_init();

        // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 超时时间设置
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // 设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }