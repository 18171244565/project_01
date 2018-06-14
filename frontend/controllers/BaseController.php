<?php
/**
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/3/5
 * Time: 下午1:34
 */

namespace frontend\controllers;

use common\models\Member;
use common\models\Order;
use common\models\ProductOrder;
use Yii;

class BaseController extends CommonController
{
    protected $uid;

    public function init()
    {
        parent::init();
        $url_obj = Yii::$app->urlManager;
        $url = $url_obj->createUrl(['public/login']);
        $username = Yii::$app->session->get('username');
        $uid = Yii::$app->session->get('uid');
        if (!$username || !$uid) {
            header('location:' . $url);
            die;
        }
        $this->uid = Yii::$app->session->get('uid');

        $this->orderRate();
        $this->levelCheck();
        $this->teamDataUpdate();
        $this->rateToOther();
    }

    protected function getUserInfo()
    {
        $cache = \Yii::$app->cache;
        $key = 'info_' . $this->uid;
        if ($cache->get($key)) {
            return $cache->get($key);
        }
        $data = Member::find()->where(['id' => $this->uid])->asArray()->one();
        $cache->set($key, $data, 180);
        return $data;
    }

    // 触发用户矿机收益(每一小时触发一次)
    protected function orderRate()
    {
        $cache = \Yii::$app->cache;
        $key = 'order_rate_' . $this->uid;
        if ($cache->get($key)) {
            return true;
        }
        $productOrder = new ProductOrder();
        $productOrder->rateAll($this->uid);
        $this->clearUserInfo();
        $cache->set($key, 1, 0);
        return true;
    }

    // 触发用户等级判断(每一小时触发一次)
    protected function levelCheck()
    {
        $cache = \Yii::$app->cache;
        $key = 'level_check_' . $this->uid;
        if ($cache->get($key)) {
            return true;
        }
        $member = new Member();
        $member->levelChange($this->uid);
        $this->clearUserInfo();
        $cache->set($key, 1, 300);
        return true;
    }

    // 触发团队人数和团队算力更新
    protected function teamDataUpdate()
    {
        $cache = \Yii::$app->cache;
        $key = 'team_data_' . $this->uid;
        if ($cache->get($key)) {
            return true;
        }
        $member = new Member();
        $member->teamData($this->uid);
        $cache->set($key, 1, 160);
        return true;
    }

    // 触发系统所有动态奖(24小时触发一次)
    protected function rateToOther()
    {
        $cache = \Yii::$app->cache;
        $key = 'rate_to_time_' . $this->uid;
        if ($cache->get($key)) {
            return true;
        }
        $rate_time = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        // 加入表记录
        $data = Member::find()->select('rate_time')->where(['id' => $this->uid])->asArray()->one();
        if ($data['rate_time'] && $data['rate_time'] == $rate_time) {

        } else {
            Member::updateAll(['rate_time' => $rate_time], ['id' => $this->uid]);
            $productOrder = new ProductOrder();
            $productOrder->t($this->uid);
        }

        $cache->set($key, 1, 7200);
        return true;
    }


    protected function clearUserInfo()
    {
        $cache = \Yii::$app->cache;
        $key = 'info_' . $this->uid;
        $cache->delete($key);
    }

    // 获取用户可用虚拟币
    public function getUserMoney()
    {
        $data = Member::find()->where(['id' => $this->uid])->asArray()->one();
        return $data['money'];
    }

    // 获取用户锁仓币
    public function getUserLockMoney()
    {
        $data = Member::find()->where(['id' => $this->uid])->asArray()->one();
        return $data['money_lock'];
    }

    // 用户没有认证跳转到个人中心
    public function checkAuth()
    {
        $data = $this->getUserInfo();
        $auth = $data['auth'];
        if ($auth == 1) {
            $url = \yii\helpers\Url::to(['/member/index']);
            echo "<script>alert('请填写资料完成实名认证');location.href='{$url}'</script>";
            exit();
        }
        return true;
    }
}