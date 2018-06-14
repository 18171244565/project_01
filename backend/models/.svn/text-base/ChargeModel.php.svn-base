<?php

/* 
 * @author:Bobo.
 * @date:2017-3-1 13:54:01
 * @qq:836044851@qq.com
 */

namespace backend\models;

use backend\models\CommonModel;
use common\models\Member;
use common\models\MoneyLog;

class ChargeModel extends CommonModel
{
    public $mobile;//用户名
    public $money;//充值金额
    static $table_name = 'inv_member';

    public function rules()
    {
        return [
            [['mobile', 'money'], 'required', 'message' => '信息填写不完整'],
            ['mobile', 'checkMobile'],
            ['money', 'checkMoney']
        ];
    }

    public function checkMobile($attribute = '')
    {
        if (!$this->hasErrors()) {
            !isMobile($this->mobile) && $this->addError($attribute, '用户名错误');
            $where = "mobile='{$this->mobile}'";
            $mobile_info = $this->findOneData(self::$table_name, $where);
            if ($mobile_info) {
                return $mobile_info;
            } else {
                $this->addError($attribute, '用户不存在');
            }

        }
    }

    public function checkMoney($attribute)
    {
        if (!$this->hasErrors()) {
            if (!is_numeric($this->money)) {
                $this->addError($attribute, '金额不合法');
            }
            if ($this->money <= 0.01) {
                $this->addError($attribute, '充值金额必须大于0.01元');
            }
        }

    }

    public function charge()
    {
        if ($this->validate()) {

            $moneyLog = new MoneyLog();
            $money = $this->money;
            $mobile = $this->mobile;
            $member = new Member();
            $data = $member::find()->select('id')->where(['mobile' => $mobile])->asArray()->one();
            $type = 1;// 后台充值
            $remark = date('Y-m-d H:i:s') . '后台充值';
            return $moneyLog->moneyChange($data['id'], $type, $money, $remark);
            /*
            $user_info = $this->checkMobile();
            $data = ['money_package_static'=>$this->money*100+$user_info['money_package_static']];
            $u_r = $this->updateData(static::$table_name, $data, ['mobile'=>$this->mobile]);
            return $u_r!==false ? true : false;*/
        }
    }

}