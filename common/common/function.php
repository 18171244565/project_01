<?php

//include ROOT_PATH.'PHPMailer/PHPMailerAutoload.php';
//echo ROOT_PATH.'PHPMailer/PHPMailerAutoload.php';
/**
 * eg: U(['public/login','id'=>3])
 * @param type $params
 * @return type
 */
function U($params) {
    return Yii::$app->urlManager->createUrl($params);
}

/**
 * 获取执行的sql语句
 * @return type
 */
//function getLastSql(){
//   return Yii::$app->db->createCommand()->getRawSql();
//}
/**
 * 错误信息展示
 * @param type $errors 错误的数组
 * @param type $option 验证的字段名称
 * @return type
 */
function showError($errors, $option) {
    if ($errors && array_key_exists($option, $errors)) {
        return $errors[$option][0];
    }
}

/**
 * 接收输入的值
 */
function I($param) {
    list($method, $field) = explode('.', $param);
    if ($method == 'get') {
        return Yii::$app->request->get($field);
    } else if ($method == 'post') {
        return Yii::$app->request->post($field);
    }
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

/**
 * 获取用户IP地址
 * @return type
 */
function get_client_ip() {
    return Yii::$app->request->userIP;
}

/**
 * 日志处理
 * @param type $user_name
 * @param type $action
 */
function write_record($user_name, $action) {
    $table = 'mall_admin_record'; //日志表
    $data = ['user_name' => $user_name,
        'action' => $action,
        'create_time' => time(),
        'ip_address' => ip2long(get_client_ip())
    ];
    return Yii::$app->db->createCommand()->insert($table, $data)->execute();
}

/**
 * Curl请求
 * @param type $url
 * @param type $data
 * @param type $method
 * @return type
 */
function CurlUse($url, $data = '', $method = 'GET') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //要访问的地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器  
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer 
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求  
        if ($data != '') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Post提交的数据包  
        }
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
    curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
    $tmpInfo = curl_exec($ch); // 执行操作  
    if (curl_errno($ch)) {
        echo 'Errno' . curl_error($ch).'<br>'; //捕抓异常
        echo  curl_strerror(curl_errno($ch));
    }
    curl_close($ch); // 关闭CURL会话  
    return $tmpInfo; // 返回数据 
}

/**
 * 
 * @param type $mobile 发送的手机号码
 * @param type $content 发送的手机内容
 * @return type
 */
function send_msg($mobile, $content) {

    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    $smsapi = "http://api.smsbao.com/";
    $user = "zfwzfw2007"; //短信平台帐号
    $pass = md5("1988528mn"); //短信平台密码
    //$content = "短信内容"; //要发送的短信内容
    // $phone = "*****"; //要发送短信的手机号码
    $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $mobile . "&c=" . urlencode($content);
    $result = file_get_contents($sendurl);
    return $result == 0 ? true : $statusStr[$result];
}

function send_email($to, $content) {
    $mail = Yii::$app->mailer->compose();
    $mail->setTo($to);
    $mail->setSubject("新邮件");
//$mail->setTextBody('zheshisha ');   //发布纯文字文本
    $mail->setHtmlBody($content);    //发布可以带html标签的文本
    return $mail->send() ? true : false;
//    echo $mail->send() ? 'success' : 'error';
}

/**
 * 生成订单号
 */
function GenerateOrderSn() {

    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

    $order_id_main = date('YmdHis') . rand(10000000, 99999999);

    //订单号码主体长度

    $order_id_len = strlen($order_id_main);

    $order_id_sum = 0;

    for ($i = 0; $i < $order_id_len; $i++) {

        $order_id_sum += (int) (substr($order_id_main, $i, 1));
    }

    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    return $order_id;
}

//发红包函数
function hongbao($money, $min, $max, $num) {
    header('Content-type:text/html;charset=utf-8');
    $arr = array();
    //由于红包是以分为单位所以先转换单位,1元=100分，但只需转换一次
    $money = $money * 100;
    $min = $min * 100;
    $max = $max * 100;
    //红包发放最大最小值合法性检测，防止发送死循环
    if ($money - $min * $num < 0) {
        return ['status'=>0,'msg'=> "你发放红包的金额太小不足以 发给这么多人"];
    } else {
        if ($money - $max * $num > 0) {
            return ['status'=>0,'msg'=>"你发放红包的金额太大 这些人领不完"]; 
        }
    }
    $tempnum = $num;
    for ($i = 0; $i < $tempnum; $i++) {
        $flag = 'no';
        do {
            //随机生成一个红包
            $rand = mt_rand($min, $max);
            $anum = count($arr);
            $zx = $money - array_sum($arr) - $rand - ($num - 1) * $min;
            $zd = $money - array_sum($arr) - $rand - ($num - 1) * $max;
            $all = array_sum($arr);
            if ($zx >= 0 && $zd <= 0) {
                $arr[] = $rand;
                $flag = 'yes';
                $num--;
            }
        } while ($flag == 'no');
    }
    shuffle($arr);

    return $arr;
}
/**
* 验证手机号是否正确
*/
function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('/^1[3,4,5,7,8]\d{9}$/', $mobile) ? true : false;
}
/**
 * 根据用户id获取获取用户名
 * @param type $id
 * @return type
 */
function getNameId($id){
    $db = new yii\db\Query();
    $res = $db->select('mobile')->from('inv_member')
                       ->where(['id'=>$id])
                       ->one()['mobile'];
   // echo $db->createCommand()->getRawSql();
   // var_dump($res);
    return $res;
}
