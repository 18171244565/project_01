<?php


namespace backend\models;


use yii\db\ActiveRecord;

class Admin extends ActiveRecord
{
    public $verifyCode;

    static public function tableName()
    {
        return '{{%admin}}';
    }

    public function rules()
    {
        return [
            ['username', 'required', 'message' => '请填写登录账号'],
            ['passwd', 'required', 'message' => '请填写密码'],
            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha', 'message' => '验证码错误或过期'],
            ['passwd', 'validateLogin'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '管理员账号',
            'passwd' => '管理员密码',
            'verifyCode' => '验证码',
        ];
    }

    public function validateLogin()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where(['username' => $this->username, 'passwd' => md5($this->passwd)])->one();
            if (!$data) {
                $this->addError('username', '账号或者密码错误');
            } else {
                $this->login_time = $data['login_time'];
                $this->login_ip = $data['login_ip'];
            }
        }
    }

    public function login($posts)
    {
        if ($this->load($posts) && $this->validate()) {
            $session = \Yii::$app->session;
            $session['admin'] = [
                'username' => $this->username,
                'loginStatus' => 1,
                'login_time' => $this->login_time,
                'login_ip' => $this->login_ip,
            ];
            $this->updateAll(['login_time' => time(), 'login_ip' => \Yii::$app->request->userIP], ['username' => $this->username]);
            return true;
        }
        return false;
    }
}