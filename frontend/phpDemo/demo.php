<?php

header('content-type:text/html;charset=utf-8');

include_once  "Encrypt.php";
include_once  "function.php";

/**
 * 在 RSA 的签名时， 需要 RSA 私钥参与签名。客户把生成出的 RSA 公钥给 253 认证平台，
 * 253 认证平台则提供 3DES 密钥给客户。 因此， 在签名时， 合作方使用的 RSA 密钥是自己
 * 的私钥及 253 认证平台的 3DES 密钥， 如不提供， 则使用 253 认证平台默认提供的 RSA 私
 * 钥和 3DES 密钥。
 * 注： 此密钥交换可以通过线上或线下交换， 交换后合作方把 253 认证平台的密钥配置应
 * 用中即可。
 */
 
// 3des密钥 (默认提供)
$desKey = "8523@@abcd8523@@abcd##&&";

// rsa客户私钥 (默认提供)
$rsaKey = "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCJVydvlZdCNeJTHowjyulYSpFxZ+CpFfEt4FfJzfptzVc0wjwx/JlVV2uN0hM7qHBWiGonjhAVZX8mcebXXn4jxUJRe7+ieDc4OoCuCEePlIvFtNHAvVi9UmyzLzcfmXHfVkrIykjQvBUkOoeeeyfE8Gi+TDPv9Lg5B1sNA7hsndSDFAEGP5eK7lSnCQBU8Ccu59ySggQvz2ANdIaWA0QURqIYYuKharaHvKEqWE/WKqThabQDCOtQagBhdynjW+wPqoryTZswccEentGdmqhqFJaGiO30EHtIAyRxE6euW2u0t89iihLIxB8sdb8/gSEva/yzR0wKaIK9G6sGyotpAgMBAAECggEALLSvBJaIHyhVHMNj0L7bSD81qtmqer/Guy08xlcDPrzJt0XGvGrCKtKDEy4fzpqcvr4299s5hw173zLSdqaunsw2Mzn5/lPtfaMlggD18lnjSZ77bCb2fOIYuhcTdXjIZW+8djHKlA+1Pg7DWKY0Itoy7kb13RUm5oFrdQgR/2DAe/iKK4NbFdiGufKEbyyeCb0xZfoC8qHY9dLWdbPgxnRcfSAeb7QRrU/OLmifGVE2lM8Z9nc55nLm6UiVj82hW40mJwl/4ivRxfw5iyE+xJm6EaNEoQMy0Rc0zJECxps/yEhfeK90fNBQd+B7Oq+rlav+uwO8U6FIk+c3HZmaAQKBgQDkRMsinL2T36UCPA9LBk0+nFovuI4p94kqnwqw/4mM5togAf5b6KnB/ZWnJru8+iDVgOp/38wLNP7DB4qQav1eYNTIyuI8oR/Xp6zHKNxDKhwNIOzozYEBqDMRNxM8k3VkdohFHTIL8ykyMs3wXJBpwfuTgN3d0ioeYZU0IYSYKQKBgQCaBnizKa8/c5w2XiTwuUsc0SfXB64rEcGQQ8FTBO7hL6Rq7uqxkILTYOnwEDnm6+w+KZNqKu16UDvuO1d/v8e4nhCNBuQdwDNGsklS6K4ZuPmMdu8Fr/DPh7dVAJhTG/pvmic9K0Geyh+VmXyR+LW4aEvLJHAicjWU1gaQ80HBQQKBgQCyydsdIg0ufDXe+TG1PptT1dyhkfjvj+1Ej8ss9QlEbjAcb9NNI3+K7NbBVAopqvP6pf2F6MEFah28nfR+xv3qZQdkudvXRxAMtk0StMNIa/wKoGZOtV888AQHkM6lXI3PATQchhCD4ZG7uqUohSerXf9w+bdNHWZV43KcoUAceQKBgGCIQcl4DJ+l43enlVtRpiPPajq4U44muLuj21wesWBsrY1fY7QZsASurq+IW+HAZvWmtP9LHD8WXhk3E+W62n94gUMB2KJUvU5HmvDdZ5AzgCNqvu8/j5thoaMillUwKcscQA90NtJAN39ZDNunlqyWoToWAjl0fuRjJwZdjw6BAoGBAJazPEVB6ZVq6WKl9RbtbQ9eWpxZNE65ONHO5IrpUHofZVy//RR6wobQRH6TqVHC6/nWl64eKT/fEnbVxd4kXuu4soBGEgNvYYb6dpqvZ74u6Ar6RKgpnxzxbw83gam9hFjU3izDA8LqrJe1y6umDhfdRYvTIBvc0b2yhugNOwyK";

// 银行卡鉴权认证(三要素、 四要素)API请求地址  注：请根据对应api产品进行修改
$url = 'https://kh_bd.253.com/openApi/bankAuth';

// 业务参数 注:请根据对应api产品进行修改
$params = [
    'userName' => '', // 姓名
    'idno'     => '', // 身份证号码
    'mobile'   => '', // 银行预留手机号
    'cardno'   => '', // 银行卡号
];

// 准备 paramString
$des = new Des($desKey);
$paramString = $des->encrypt(json_encode($params));

// 准备 sign
$requestParams = [
    'apiName'  => '', // api帐号 登录平台在对应的API产品详情页获取，平台地址（https://data.253.com）
    'password' => '', // api密码 登录平台在对应的API产品详情页获取，平台地址（https://data.253.com）
    'order_no' => time().mt_rand(1000000,9999999), // 业务唯一流水号,请根据自己的业务需要进行调整
    'paramString' => $paramString,
];
$sign = getSign($requestParams, $rsaKey);
$requestParams['sign'] = $sign;

// 开始请求
$result = postJson($url,$requestParams);

// 打印请求结果
var_dump($result);
exit;