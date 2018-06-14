<?php

/* 
 * @author:Bobo.
 * @date:2017-3-3 8:44:44
 * @qq:836044851@qq.com
 */

namespace frontend\controllers;

use common\models\Member;
use common\models\WebConfig;
use frontend\models\RegisterModel;
use frontend\models\LoginModel;
use Yii;
use yii\helpers\Json;

class PublicController extends CommonController
{
    //登录页面
    public function actionLogin()
    {
        $model = new LoginModel();
        $request = Yii::$app->request;
        if ($request->isAjax) {
            // 获取市场交易时间 判断是否能登录
            $webConfig = new WebConfig();
            $w_s = $webConfig->getConfigByKey('w_s');
            $stime = strtotime($w_s);
            $w_e = $webConfig->getConfigByKey('w_e');
            $etime = strtotime($w_e);
            $time = time();
            if ($time < $stime || $time > $etime) {
                $message = $webConfig->getConfigByKey('w_n');
                echo Json::encode(['code' => '1', 'message' => $message]);
                exit();
            }

            $model->mobile = \Yii::$app->request->post()['mobile'];
            $model->pwd  = \Yii::$app->request->post()['pwd'];
            $yzm		 = \Yii::$app->request->post()['yzm'];
			$verifycode  = Yii::$app->session->get('verifycode');
            if($yzm && $yzm==$verifycode){
				
			}else{
                $data = ['code' => 1, 'message' => '验证码错误!'];
				echo Json::encode($data);
				exit;
				
			}
			
			if ($model->login()) {
                Member::updateAll(['login_time' => time()], ['mobile' => $model->mobile]);
                $data = ['code' => 0, 'message' => '登录成功'];
            } else {
                $data = ['code' => 1, 'message' => '用户名或者密码错误!'];
            }
            echo Json::encode($data);
            exit;
        }
        return $this->render('login');
    }

    /**
     * 注册页面
     * @return type
     */
    public function actionRegister()
    {
        $model = new RegisterModel();
        if (Yii::$app->request->isAjax) {
             $model->request_ip = $this->request_ip;
            $model->mobile = Yii::$app->request->post('phone', '');
            $model->verify_code = Yii::$app->request->post('verify_code');
            $model->pwd = Yii::$app->request->post('pwd');
            $pwd2 = Yii::$app->request->post('pwd2');
            $model->charge_passwd = Yii::$app->request->post('charge_passwd');
            $charge_passwd2 = Yii::$app->request->post('charge_passwd2');
            $model->p_mobile = Yii::$app->request->post('p_mobile');

            $yzm 		= \Yii::$app->request->post()['yzm'];
			$verifycode	= Yii::$app->session->get('verifycode');
			if($model->pwd!=$pwd2){
			    $data = ['code' => 1, 'message' => '登录密码不一致!'];            
    	        echo Json::encode($data);
	            exit;
			}
			if($model->charge_passwd!=$charge_passwd2){
			    $data = ['code' => 1, 'message' => '交易密码不一致!'];            
    	        echo Json::encode($data);
	            exit;
			}
			if($yzm && $yzm==$verifycode){
			
			}else{
			    $data = ['code' => 1, 'message' => '验证码错误!'];            
    	        echo Json::encode($data);
	            exit;
			}
			if (!$model->p_mobile)
                exit(json_encode(['code' => 1, 'message' => '请填写推荐人']));
            $this->checkRegisterOpen();
            $this->checkRegisterIp();
            $model->register();
        } else {
            $puid = Yii::$app->request->get('puid', '');
            $p_mobile = '';
            if ($puid) {
                $id = base64_decode($puid);
                $member = new Member();
                $data = $member::find()->select('mobile')->where(['id' => $id])->one();
                if ($data) $p_mobile = $data['mobile'];
            }
            return $this->render('reg', ['p_mobile' => $p_mobile]);
        }
    }

    protected function checkRegisterOpen()
    {
        // 注册是否开启
        $webConfig = new WebConfig();
        $r_open = $webConfig->getConfigByKey('r_open');
        if ($r_open != 1) {
            echo Json::encode(['code' => '1', 'message' => '平台注册关闭']);
            exit();
        }
        return true;
    }

    protected function checkRegisterIp()
    {
        // 注册IP限制
        $webConfig = new WebConfig();
        $r_number = (int)$webConfig->getConfigByKey('r_number');
        if ($r_number > 0) {
            $count = Member::find()->where(['create_ip' => $this->request_ip])->count();
            if ($count >= $r_number) {
                echo Json::encode(['code' => '1', 'message' => 'IP注册限制']);
                exit();
            }
        }
        return true;
    }


    /**
     * 发送验证码(注册)
     */
    public function actionSendCode()
    {
        $model = new RegisterModel();
        if (Yii::$app->request->isAjax) {
            $this->checkRegisterOpen();
            $phone = Yii::$app->request->post('phone');
            $model->CommonCheckMobile($phone);
			$url = 'https://api.253.com/open/wool/wcheck';
		    $params = [
        		'appId' 	=> 'BTX6Boa4', // appId,登录万数平台查看
        		'appKey'	=> 'IhbBqmts', // appKey,登录万数平台查看
        		'mobile'	=> $phone, // 要检测的手机号，限单个，仅支持11位国内号码
        		'ip' 		=>'' // 检测手机号的IP地址，非必传(重要，建议传入)
    		];
			$res=json_decode($this->post($url,$params));
			if($res->data->status=='W1'){
				$code = mt_rand(1000, 9999);
        	    Yii::$app->session->set('code', $code);
    	        $this->sendCode($code, $phone);
	            exit(json_encode(['code' => 1, 'message' => '验证码已经发送,请注意查收!']));
			}else{
	            exit(json_encode(['code' => 0, 'message' => $res->data->tag]));				
			}

		}
    }
	public function actionVerifycode(){
		$ma=rand(10,99);
		$mi=rand(1,9);
		$code=$ma.' - '.$mi;
		$veirfycode=$ma-$mi;
        Yii::$app->session->set('verifycode', $veirfycode);
        exit(json_encode(['code' => 1, 'info'=>$code]));
		
	}

    /**
     * 发送验证码(绑定银行卡)
     */
    public function actionSendCodeByBank()
    {
        $model = new RegisterModel();
        if (Yii::$app->request->isAjax) {
            $phone = Yii::$app->request->post('phone');
            $code = mt_rand(1000, 9999);
            //$this->sendCode($code, $phone);// 发送验证码
            Yii::$app->session->set('code', $code);


            //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/aliyun/demo/sendSms.php?mobile=' . $phone . '&code=' . $code;
            //@file_get_contents($url);
            $this->sendCode($code, $phone);

            // $_SESSION['code'] = $code;
            exit(json_encode(['code' => 1, 'message' => '验证码已经发送,请注意查收!']));
            //exit(json_encode(['code' => 1, 'message' => '验证码已经发送,请注意查收!验证码是：' . $code]));
        }
    }

    /**
     * 发送验证码--忘记密码
     */
    public function actionSendForgetCode()
    {
        $model = new RegisterModel();
        if (Yii::$app->request->isAjax) {
            $phone = Yii::$app->request->post('phone');
            $user_info = $model->findOneData('inv_member', "mobile='$phone'");
            !$user_info && exit(json_encode(['code' => 1, 'message' => '该账户不存在']));
            ($user_info['status'] == 2) && exit(json_encode(['code' => 1, 'message' => '该账户已经被冻结']));
            $code = mt_rand(1000, 9999);
            //$this->sendCode($code, $phone);// 发送验证码
            Yii::$app->session->set('forget_code', $code);
            Yii::$app->session->set('forget_phone', $phone);

            //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/aliyun/demo/sendSms.php?mobile=' . $phone . '&code=' . $code;
            //@file_get_contents($url);
            $this->sendCode($code, $phone);

            exit(json_encode(['code' => 0, 'message' => '验证码已经发送,请注意查收!']));
            //exit(json_encode(['code' => 0, 'message' => '验证码已经发送,请注意查收!验证码：' . $code]));
        }

    }

    public function actionForget()
    {
        $model = new RegisterModel();
        $request_obj = Yii::$app->request;
        if ($request_obj->isAjax) {
            $phone = $request_obj->post('phone');
            $verify_code = $request_obj->post('verify_code');
            $passwd = $request_obj->post('passwd');
            $rpasswd = $request_obj->post('rpasswd');
            if (!$passwd) exit(json_encode(['code' => 1, 'message' => '密码不能为空']));
            if ($passwd != $rpasswd) exit(json_encode(['code' => 1, 'message' => '两次密码不一致']));
            $user_info = $model->findOneData('inv_member', "mobile='$phone' and `status`=1");
            !$user_info && exit(json_encode(['code' => 1, 'message' => '该账户异常']));
            ($verify_code != Yii::$app->session->get('forget_code')) && exit(json_encode(['code' => 1, 'message' => '验证码不正确']));
            Yii::$app->session->remove('forget_code');
            Member::updateAll(['passwd' => md5($passwd)], ['mobile' => $phone]);
            exit(json_encode(['code' => 0, 'message' => '密码修改成功']));
        } else {
            return $this->renderPartial('forget');
        }

    }

    //退出
    public function actionLogOut()
    {
        //清空session
        Yii::$app->session->remove('username');
        $jump_url = Yii::$app->urlManager->createUrl(['public/login']);
        $this->redirect($jump_url);
    }
	protected function post($url, $data, $proxy = null, $timeout = 20) {
		$curl = curl_init();  
		curl_setopt($curl, CURLOPT_URL, $url);    
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。        
		curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。   
		curl_setopt($curl, CURLOPT_POST, true); //发送一个常规的Post请求  
		curl_setopt($curl,  CURLOPT_POSTFIELDS, $data);//Post提交的数据包  
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。     
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //文件流形式         
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数。   
		$content = curl_exec($curl);  
		curl_close($curl);  
		unset($curl);
		return $content;  
	} 
    // 发送验证码
    protected function sendCode($code, $phone)
    {
		$data['Account'] = '18727325101';
		$data['Pwd'] 	 = '9dacecc112a487fa976840213';
		$data['Content'] = '您的验证码为：'.$code.'，2分钟内有效，请尽快验证。如非本人操作，请忽略本短信。';
		$data['Mobile']	 = $phone;
		$data['SignId']	 = '41997';
		$url="http://api.feige.ee/SmsService/Send";

		$res=$this->post($url,$data);
		return true;
		
	}
} 
