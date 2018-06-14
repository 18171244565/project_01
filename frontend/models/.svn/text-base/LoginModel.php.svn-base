<?php

/* 
 * @author:Bobo.
 * @date:2017-3-3 14:57:27
 * @qq:836044851@qq.com
 */

namespace frontend\models;

use backend\models\CommonModel;
use common\models\Member;
use Yii;

class LoginModel extends CommonModel
{
    public $mobile;
    public $pwd;
    static $table_name = 'inv_member';

    public function rules()
    {
        return [
            [['mobile', 'pwd'], 'required', 'message' => '用户名或者密码错误'],
            ['mobile', 'Check']
        ];
    }

    public function Check($attribute)
    {
        if (!$this->hasErrors()) {
            $password = md5($this->pwd);
            $where = "mobile='$this->mobile' and passwd='$password' and `status`=1";
            $user_info = $this->findOneData(static::$table_name, $where);

            !$user_info && $this->addError($attribute, '用户名或者密码错误!');
            //存入session
            Yii::$app->session->set('username', $user_info['mobile']);
            Yii::$app->session->set('uid', $user_info['id']);
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return true;
        } else {
            return false;
        }
    }
}
