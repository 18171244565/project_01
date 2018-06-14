<?php


namespace frontend\controllers;


use common\models\FaceOrder;
use common\models\Member;
use common\models\Message;
use common\models\MoneyLog;
use common\models\Notice;
use common\models\Config;
use common\models\Order;
use frontend\phpDemo;
use frontend\models\ShoppingAuth;
use yii\helpers\Json;
use yii\helpers\Url;

class MemberController extends BaseController
{
    public function init()
    {
        parent::init();

    }

    // 个人中心
    public function actionIndex()
    {
        $data = $this->getUserInfo();

        $messageTotal = Message::find()->where(['member_id' => $this->uid, 'is_look' => Message::STATUS_NO_LOOK])->count();
        $member = new Member();

        return $this->render('mine', [
            'data' => $data,
            'active' => 5,
            's' => $member->getFreezeMoney($this->uid),
            'messageTotal' => $messageTotal
        ]);
    }

    // 签名送
    public function actionSign()
    {
        if (\Yii::$app->request->isAjax) {
            $uid = $this->uid;
            // 今日时间戳
            $time = mktime(0, 0, 0);
            $sql = "SELECT * FROM inv_sign_log WHERE `member_id`='{$uid}' AND `create_time`='{$time}'";
            $data = \Yii::$app->db->createCommand($sql)->queryOne();
            if ($data) {
                $message = '今日已签到';
            } else {
                $config = new Config();
                $money = $config->getConfigByKey('sign');
                if ($money > 0) {
                    $sql = "INSERT INTO `inv_sign_log` (money,member_id,create_time) VALUES ('{$money}', '{$uid}', '{$time}')";
                    \Yii::$app->db->createCommand($sql)->execute();
                    $moneyLog = new MoneyLog();
                    $message = $remark = '签到成功';
                    $moneyLog->moneyChange($uid, 7, $money, $remark);
                    $this->clearUserInfo();
                } else {
                    $message = '签到未开启';
                }
            }
            echo Json::encode(['code' => 0, 'message' => $message]);
            exit();
        }
    }

    // 个人信息
    public function actionMessage()
    {
        $member = new Member();
        $data = $this->getUserInfo();

        return $this->render('message', [
            'data' => $data,
            'member' => $member,
        ]);
    }

    public function actionNotice()
    {
        $list = Message::find()->where(['member_id' => $this->uid, 'is_look' => Message::STATUS_NO_LOOK])->all();

        return $this->render('notice', [
            'list' => $list
        ]);
    }

    public function actionSetMessage()
    {
        $message = new Message();
        $message->setAllMessageToLooked($this->uid);
    }

    // 实名认证信息填写
    public function actionAu()
    {
        $data = $this->getUserInfo();
        return $this->render('au', [
            'data' => $data,
        ]);
    }

    // 个人信息修改
    public function actionUpdateMessage()
    {
        if (\Yii::$app->request->isAjax) {
            $gets = \Yii::$app->request->post();
            $verify_code = $gets['verify_code'];
            $code = \Yii::$app->session->get('code');
            if (!$code || $verify_code != $code) {
                echo Json::encode(['message' => '验证码错误']);
                exit;
            }
            $save['name'] = $gets['username'];
            $save['bank_name'] = $gets['cardnumbername'];
            $save['bank_card'] = $gets['cardnumber'];
            $save['id_card'] = $gets['idcard'];
            $save['bank_mobile'] = $gets['phone'];

            if (!$gets['username']) {
                echo Json::encode(['message' => '请填写姓名']);
                exit;
            }
            if (strlen($gets['cardnumber']) < 15) {
                echo Json::encode(['message' => '银行卡错误']);
                exit;
            }
            if ($gets['idcard']) {
                if (strlen($gets['idcard']) < 15) {
                    echo Json::encode(['message' => '身份证号错误']);
                    exit;
                }
                $id = $this->uid;
                $d = Member::find()->where(['id_card' => $gets['idcard']])->andWhere(['<>', 'id', $id])->asArray()->one();
                if ($d) {
                    echo Json::encode(['message' => '身份证号已存在']);
                    exit;
                }
            } else {
                echo Json::encode(['message' => '填写身份证号']);
                exit;
            }
include_once  dirname(__File__)."/../../frontend/phpDemo/Encrypt.php";
include_once  dirname(__File__)."/../../frontend/phpDemo/function.php";
$desKey = "8523@@abcd8523@@abcd##&&";
// rsa客户私钥 (默认提供)
$rsaKey = "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCJVydvlZdCNeJTHowjyulYSpFxZ+CpFfEt4FfJzfptzVc0wjwx/JlVV2uN0hM7qHBWiGonjhAVZX8mcebXXn4jxUJRe7+ieDc4OoCuCEePlIvFtNHAvVi9UmyzLzcfmXHfVkrIykjQvBUkOoeeeyfE8Gi+TDPv9Lg5B1sNA7hsndSDFAEGP5eK7lSnCQBU8Ccu59ySggQvz2ANdIaWA0QURqIYYuKharaHvKEqWE/WKqThabQDCOtQagBhdynjW+wPqoryTZswccEentGdmqhqFJaGiO30EHtIAyRxE6euW2u0t89iihLIxB8sdb8/gSEva/yzR0wKaIK9G6sGyotpAgMBAAECggEALLSvBJaIHyhVHMNj0L7bSD81qtmqer/Guy08xlcDPrzJt0XGvGrCKtKDEy4fzpqcvr4299s5hw173zLSdqaunsw2Mzn5/lPtfaMlggD18lnjSZ77bCb2fOIYuhcTdXjIZW+8djHKlA+1Pg7DWKY0Itoy7kb13RUm5oFrdQgR/2DAe/iKK4NbFdiGufKEbyyeCb0xZfoC8qHY9dLWdbPgxnRcfSAeb7QRrU/OLmifGVE2lM8Z9nc55nLm6UiVj82hW40mJwl/4ivRxfw5iyE+xJm6EaNEoQMy0Rc0zJECxps/yEhfeK90fNBQd+B7Oq+rlav+uwO8U6FIk+c3HZmaAQKBgQDkRMsinL2T36UCPA9LBk0+nFovuI4p94kqnwqw/4mM5togAf5b6KnB/ZWnJru8+iDVgOp/38wLNP7DB4qQav1eYNTIyuI8oR/Xp6zHKNxDKhwNIOzozYEBqDMRNxM8k3VkdohFHTIL8ykyMs3wXJBpwfuTgN3d0ioeYZU0IYSYKQKBgQCaBnizKa8/c5w2XiTwuUsc0SfXB64rEcGQQ8FTBO7hL6Rq7uqxkILTYOnwEDnm6+w+KZNqKu16UDvuO1d/v8e4nhCNBuQdwDNGsklS6K4ZuPmMdu8Fr/DPh7dVAJhTG/pvmic9K0Geyh+VmXyR+LW4aEvLJHAicjWU1gaQ80HBQQKBgQCyydsdIg0ufDXe+TG1PptT1dyhkfjvj+1Ej8ss9QlEbjAcb9NNI3+K7NbBVAopqvP6pf2F6MEFah28nfR+xv3qZQdkudvXRxAMtk0StMNIa/wKoGZOtV888AQHkM6lXI3PATQchhCD4ZG7uqUohSerXf9w+bdNHWZV43KcoUAceQKBgGCIQcl4DJ+l43enlVtRpiPPajq4U44muLuj21wesWBsrY1fY7QZsASurq+IW+HAZvWmtP9LHD8WXhk3E+W62n94gUMB2KJUvU5HmvDdZ5AzgCNqvu8/j5thoaMillUwKcscQA90NtJAN39ZDNunlqyWoToWAjl0fuRjJwZdjw6BAoGBAJazPEVB6ZVq6WKl9RbtbQ9eWpxZNE65ONHO5IrpUHofZVy//RR6wobQRH6TqVHC6/nWl64eKT/fEnbVxd4kXuu4soBGEgNvYYb6dpqvZ74u6Ar6RKgpnxzxbw83gam9hFjU3izDA8LqrJe1y6umDhfdRYvTIBvc0b2yhugNOwyK";

// 银行卡鉴权认证(三要素、 四要素)API请求地址  注：请根据对应api产品进行修改
$url = 'https://kh_bd.253.com/openApi/bankAuth';

// 业务参数 注:请根据对应api产品进行修改
			$params['userName']= $gets['username'];
			$params['idno'] 	 = $gets['idcard'];
			$params['mobile']  = $gets['phone'];
			$params['cardno']	 = $gets['cardnumber'];

			// 准备 paramString
			$des = new \Des($desKey);
			$paramString = $des->encrypt(json_encode($params));

			// 准备 sign
			$requestParams = [
				'apiName'  => 'S1103333', // api帐号 登录平台在对应的API产品详情页获取，平台地址（https://data.253.com）
				'password' => 'pwd3091814', // api密码 登录平台在对应的API产品详情页获取，平台地址（https://data.253.com）
				'order_no' => time().mt_rand(1000000,9999999), // 业务唯一流水号,请根据自己的业务需要进行调整
				'paramString' => $paramString,
			];
			$sign = getSign($requestParams, $rsaKey);
			$requestParams['sign'] = $sign;
			
			// 开始请求
			$result = json_decode(postJson($url,$requestParams));
			if($result->resultObj->result=='01'){
            	$member = new Member();
				$save['auth']=2;
            	$res = $member::updateAll($save, ['id' => $this->uid]);
            	// 清空缓存
            	$this->clearUserInfo();
            	$message = "认证成功";
			}else{
            	//$res ? $message = "信息保存成功" : $message = "信息保存失败"
				$message=$result->resultObj->remark;
        	}
           	echo Json::encode(['message' => $message]);
		}
    }

    // 微信修改
    public function actionWeixin()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $d = $request->post('d', 'null');
            if (!$d) {
                echo Json::encode(['message' => '请填写支付宝号']);
                exit();
            }
            Member::updateAll(['weixin' => $d], ['id' => $this->uid]);
            $this->clearUserInfo();
            echo Json::encode(['message' => '设置成功']);
            exit();
        }
        $data = $this->getUserInfo();
        return $this->render('weixin', [
            'data' => $data,
        ]);
    }

    // 支付宝修改
    public function actionZhifubao()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $d = $request->post('d', 'null');
            if (!$d) {
                echo Json::encode(['message' => '请填写支付宝号']);
                exit();
            }

            $rule1 = '/^1[3,4,5,7,8]\d{9}$/';
            $rule2 = '/^[A-Za-z0-9]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';
            if (!preg_match($rule1, $d) && !preg_match($rule2, $d)) {
                echo Json::encode(['message' => '支付宝号为手机或者邮箱']);
                exit();
            }

            Member::updateAll(['zhifubao' => $d], ['id' => $this->uid]);
            $this->clearUserInfo();
            echo Json::encode(['message' => '设置成功']);
            exit();
        }
        $data = $this->getUserInfo();
        return $this->render('zhifubao', [
            'data' => $data,
        ]);
    }

    // eth地址修改
    public function actionEth()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $d = $request->post('d', 'null');
            if (!$d) {
                echo Json::encode(['message' => '请填写ETH地址']);
                exit();
            }
            Member::updateAll(['eth_address' => $d], ['id' => $this->uid]);
            $this->clearUserInfo();
            echo Json::encode(['message' => '设置成功']);
            exit();
        }
        $data = $this->getUserInfo();
        return $this->render('ethpurse', [
            'data' => $data,
        ]);
    }


    // 修改密码
    public function actionSetPasswd()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $opasswd = $request->post('opasswd');
            $passwd = $request->post('passwd');
            $rpasswd = $request->post('rpasswd');
            if (!$passwd || !$opasswd) {
                echo Json::encode(['code' => 1, 'message' => '请填写信息']);
                exit;
            }
            if ($passwd != $rpasswd) {
                echo Json::encode(['code' => 1, 'message' => '两次密码不一致']);
                exit;
            }
            $data = $this->getUserInfo();
            if ($data['passwd'] != md5($opasswd)) {
                echo Json::encode(['code' => 1, 'message' => '原密码错误']);
                exit;
            }
            Member::updateAll(['passwd' => md5($passwd)], ['id' => $this->uid]);
            $this->clearUserInfo();
            echo Json::encode(['code' => 0, 'message' => '设置成功']);
            exit;
        }
        return $this->render('set-passwd');
    }

    // 修改二级密码
    public function actionSetCpasswd()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $opasswd = $request->post('opasswd');
            $passwd = $request->post('passwd');
            $rpasswd = $request->post('rpasswd');
            if (!$passwd || !$opasswd) {
                echo Json::encode(['code' => 1, 'message' => '请填写信息']);
                exit;
            }
            if ($passwd != $rpasswd) {
                echo Json::encode(['code' => 1, 'message' => '两次密码不一致']);
                exit;
            }
            $data = $this->getUserInfo();
            if ($data['charge_passwd'] != md5($opasswd)) {
                echo Json::encode(['code' => 1, 'message' => '原密码错误']);
                exit;
            }
            Member::updateAll(['charge_passwd' => md5($passwd)], ['id' => $this->uid]);
            $this->clearUserInfo();
            echo Json::encode(['code' => 0, 'message' => '设置成功']);
            exit;
        }
        return $this->render('set-charge-passwd');
    }

    public function actionSetting()
    {
        return $this->render('setting');
    }


    // 资金明细
    public function actionMoneyLog()
    {
        $moneyLog = new MoneyLog();
        $list = $moneyLog::find()
            ->where(['member_id' => $this->uid])
            ->orderBy('create_time desc')
            ->asArray()
            ->all();
        $list1 = $list2 = $list3 = $list4 = $list5 = $list6 = $list7 = [];
        $sum = $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = 0;
        foreach ($list as $v) {
            $type = $v['type'];
            $money = $v['money'];
            if ($type == 1) {
                $list1[] = $v;
                $sum1 += $money;
            } else if ($type == 2) {
                $list2[] = $v;
                $sum2 += $money;
            } else if ($type == 3) {
                $list3[] = $v;
                $sum3 += $money;
            } else if ($type == 4) {
                $list4[] = $v;
                $sum4 += $money;
            } else if ($type == 5) {
                $list5[] = $v;
                $sum5 += $money;
            } else if ($type == 6) {
                $list6[] = $v;
                $sum6 += $money;
            } else if ($type == 7) {
                $list7[] = $v;
                $sum7 += $money;
            }
            $sum += $money;
        }


        return $this->render('money-log', [
            'list' => $list,
            'sum' => $sum,
            'moneyLog' => $moneyLog,
            'list1' => $list1,
            'list2' => $list2,
            'list3' => $list3,
            'list4' => $list4,
            'list5' => $list5,
            'list6' => $list6,
            'list7' => $list7,
            'sum1' => $sum1,
            'sum2' => $sum2,
            'sum3' => $sum3,
            'sum4' => $sum4,
            'sum5' => $sum5,
            'sum6' => $sum6,
            'sum7' => $sum7,
        ]);
    }

    // 退出
    public function actionOut()
    {
        $this->clearUserInfo();
        $session = \Yii::$app->session;
        $session->destroy();
        $this->redirect(['public/login']);
    }


    //交易市场登录
    public function actionLoginToShopping()
    {
        if (\Yii::$app->request->isPost) {
            $password = \Yii::$app->request->post('password');
            $shoppingAuth = new ShoppingAuth();

            if (!$shoppingAuth->checkSafePassword($password)) {
                return Json::encode(['code' => 0, 'message' => '密码不正确']);
            }
            return Json::encode(['code' => 1, 'url' => Url::previous()]);
        }

        return $this->render('login-to-shopping');
    }

    // 客服中心
    public function actionCustom()
    {
        return $this->render('custom');
    }

    // 公告
    public function actionAb()
    {
        $notice = new Notice();
        $list = $notice::find()->orderBy('id desc')->asArray()->all();
        return $this->render('ab', [
            'list' => $list,
        ]);
    }

    // 推广
    public function actionSpread()
    {
        $puid = base64_encode($this->uid);
        $url = \yii\helpers\Url::to(['public/register', 'puid' => $puid]);
        $a = urlencode($url);
        $urlImg = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode/qrcode.php?url=' . $a;
        return $this->render('spread', [
            'url' => $url,
            'img' => $urlImg,
        ]);
    }

}