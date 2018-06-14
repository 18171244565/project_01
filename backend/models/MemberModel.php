<?php

/* 
 * @author:Bobo.
 * @date:2017-2-28 19:40:41
 * @qq:836044851@qq.com
 */

namespace backend\models;

use backend\models\CommonModel;

class MemberModel extends CommonModel
{
    public $mobile;//用户名
    public $passwd;
    public $money;
    public $charge_passwd;
    public $p_id;//上级用户名(电话号码)
    public $level;
    public $weixin;
    public $zhifubao;
    public $bank_name;
    public $bank_card;
    public $name;
    public $id_card;
    public $bank_mobile;
    public $uid;//用户id
    public $ip = null;
    static $table_name = 'inv_member';

    public function rules()
    {
        return [
            ['mobile', 'required', 'message' => '手机号不能为空'],
            ['mobile', 'CheckMobile'],
            [['passwd', 'money', 'charge_passwd', 'p_id', 'level', 'weixin', 'zhifubao', 'bank_name', 'bank_card', 'bank_mobile', 'name', 'id_card'], 'ReturnTrue'],
            ['p_id', 'CheckPid'],
            ['uid', 'required', 'when' => function () {
                return $this->uid ? true : false;
            }, 'message' => '用户参数不正确'],
            ['uid', 'checkUid']

        ];
    }

    /**
     * 检测上级用户
     */
    public function CheckPid($attribute = '')
    {
        if (!$this->hasErrors()) {
            if ($this->mobile == $this->p_id) {
                $this->addError($attribute, '自己不能作为自己的上级');
            }
            if ($this->p_id) {
                $where = "mobile ='$this->p_id'";
                $pid_info = $this->findOneData(self::$table_name, $where);
                !$pid_info && $this->addError($attribute, '无此上级用户');
                return $pid_info['id'];
            } else {
                return 0;
            }
        }
    }

    public function ReturnTrue()
    {
        if (!$this->hasErrors()) {
            return true;
        }
    }

    public function CheckMobile($attribute)
    {
        if (!$this->hasErrors()) {
            $where = "";
            $where .= $this->uid ? "id != '{$this->uid}' and mobile='{$this->mobile}'" :
                "mobile ='$this->mobile'";
            $mobile_info = $this->findOneData(self::$table_name, $where);
            $mobile_info && $this->addError($attribute, '手机已经存在');
            !isMobile($this->mobile) && $this->addError($attribute, '手机格式不合法');
        }
    }

    public function checkUid($attribute)
    {
        if (!$this->hasErrors()) {
            $user_info = $this->findOneData(self::$table_name, ['id' => $this->uid]);
            !$user_info && $this->addError($attribute, '用户参数错误');
        }
    }

    public function save()
    {
        if ($this->validate()) {
            $data = ['mobile' => $this->mobile,
                'money' => $this->money,
                'p_id' => $this->CheckPid(),
                'level' => $this->level,
                'weixin' => $this->weixin,
                'zhifubao' => $this->zhifubao,
                'bank_name' => $this->bank_name,
                'bank_card' => $this->bank_card,
                'name' => $this->name,
                'id_card' => $this->id_card,
                'bank_mobile' => $this->bank_mobile,
                'status' => 1
            ];
            if ($this->uid) {
                //表示修改
                $user_info = $this->findOneData(self::$table_name, ['id' => $this->uid]);
                if ($this->passwd != $user_info['passwd']) {
                    $data['passwd'] = md5($this->passwd);
                }
                if ($this->charge_passwd != $user_info['charge_passwd']) {
                    $data['charge_passwd'] = md5($this->charge_passwd);
                }
                $r = $this->updateData(self::$table_name, $data, ['id' => $this->uid]);
            } else {
                $data['passwd'] = $this->passwd ? md5($this->passwd) : md5(123456);//添加用户的时候如果默认不写密码则是123456
                $data['charge_passwd'] = $this->charge_passwd ? md5($this->charge_passwd) : md5(123456);//添加用户的时候如果默认不写密码则是123456
                $data['create_time'] = time();
                $data['create_ip'] = $this->ip;
                $data['login_time'] = time();
                $r = $this->addData(self::$table_name, $data);
            }
            return $r !== false ? true : false;

        } else {
            return false;
        }
    }
}

