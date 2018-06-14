<?php
namespace frontend\models;

//交易市场 验证类
use common\models\Member;

class ShoppingAuth
{
    const CACHE_KEY = "shopping_auth_member_%s";

    const CACHE_TTL = 1200; //缓存有效时间

    public $memberId = 0;

    public function __construct()
    {
        $this->memberId = \Yii::$app->session->get('uid');
    }

    public function checkSafePassword($password)
    {
        $member = Member::find()->where(['id' => $this->memberId])->one();
        if (!$member->checkChargePassword($password)) {
            return false;
        }
        //缓存
        \Yii::$app->cache->set($this->getCacheKey(), 1, self::CACHE_TTL);
        return true;
    }


    public function getCacheKey()
    {
        return sprintf(self::CACHE_KEY, $this->memberId);
    }

    //检查权限
    public function checkAuth()
    {
        $cacheKey = $this->getCacheKey();
        if (!\Yii::$app->cache->exists($cacheKey)) {
            return false;
        }
        return true;
    }

}