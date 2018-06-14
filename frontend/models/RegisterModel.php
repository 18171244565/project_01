<?php

/*
 * @author:Bobo.
 * @date:2017-3-3 11:38:11
 * @qq:836044851@qq.com
 */

namespace frontend\models;

use backend\models\CommonModel;
use common\models\Config;
use common\models\Member;
use common\models\ProductOrder;
use common\models\WebConfig;
use Yii;

class RegisterModel extends CommonModel
{
    public $p_mobile;// 推广人电话号码
    public $mobile; //电话号码
    public $verify_code; //验证码
    public $pwd; //密码
    public $charge_passwd;//二级密码
    public $request_ip;
    static $table_name = 'inv_member';


    public function rules()
    {
        return [
            [['mobile', 'verify_code', 'pwd', 'charge_passwd'], 'required', 'message' => '请将信息填写完整'],
            ['mobile', 'CheckMobile'],
            ['verify_code', 'CheckCode'],
        ];
    }

    /**
     * 检测手机号码
     * @param type $flag
     */
    public function CheckMobile()
    {
        if (!$this->hasErrors()) {
            $this->CommonCheckMobile($this->mobile);
        }
    }

    public function CommonCheckMobile($mobile)
    {
        !isMobile($mobile) && exit(json_encode(['code' => 1, 'message' => '手机格式不合法']));
        $where = "";
        $where .= "mobile ='$mobile'";
        $mobile_info = $this->findOneData(self::$table_name, $where);
        $mobile_info && exit(json_encode(['code' => 1, 'message' => '手机号已经存在']));
    }

    public function CheckCode($attribute)
    {
        if (!$this->hasErrors()) {
            $code = Yii::$app->session->get('code');
            // var_dump($code);
            if ($code != $this->verify_code) {
                exit(json_encode(['code' => 1, 'message' => '验证码输入错误']));
            }
        }
    }

    public function register()
    {
        if ($this->validate()) {
            $p_phone = $this->p_mobile;
            $member = new Member();
            $pData = $member::find()->select('id')->where(['mobile' => $p_phone])->asArray()->one();
            if (!$pData)
                exit(json_encode(['code' => 1, 'message' => '推荐人不存在']));

            $data = ['mobile' => $this->mobile,
                'passwd' => md5($this->pwd),
                'charge_passwd' => md5($this->charge_passwd),
                'status' => 1,
                'create_time' => time(),
                'create_ip' => $this->request_ip,
                'p_id' => $pData['id'],
            ];
            $res = $this->addData(self::$table_name, $data);
            usleep(2000);
            // 注册成功赠送
            if ($res) {
                $webConfig = new WebConfig();
                $r_s = $webConfig->getConfigByKey('r_s');
                if ($r_s == 1) {
                    $rsn = (int)$webConfig->getConfigByKey('r_s_n');
                    if ($rsn > 0) {
                        $data = Member::find()->where(['mobile' => $this->mobile])->asArray()->one();
                        $member_id = $data['id'];
                        for ($i = 1; $i <= $rsn; $i++) {
                            $productOrder = new ProductOrder();
                            $productOrder->registerProduct($member_id);
                            usleep(10);
                        }
                    }
                }
            }
            exit(json_encode($res ? ['code' => 0, 'message' => '注册成功'] : ['code' => 1, 'message' => '服务器繁忙,请稍后再试！']));
        } else {
            $error = $this->getErrors();
            $error = array_values($error);
            exit(json_encode(['code' => 1, 'message' => $error[0]]));
            //return false;
        }
    }

}
