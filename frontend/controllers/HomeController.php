<?php

namespace frontend\controllers;

use common\models\Member;
use common\models\MoneyLog;
use common\models\Product;
use common\models\ProductOrder;
use Yii;
use yii\helpers\Json;

class HomeController extends BaseController
{
    public function init()
    {
        parent::init();

        // 验证是否完成实名认证
        $this->checkAuth();
    }

    public function actionIndex()
    {
        $product = new Product();
        $productData = $product::find()->asArray()->all();
        return $this->render('index', [
            'product' => $product,
            'productData' => $productData,
            'active' => 1,
        ]);
    }

    public function actionBuy()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            $uid = (int)$request->post('uid');
            $money = $this->getUserMoney();
            $money_lock = $this->getUserLockMoney();
            $product = Product::find()->where(['id' => $uid])->asArray()->one();
            if (!$product || $product['status'] != 1) {
                echo Json::encode(['code' => 1, 'message' => '矿机暂时无法购买']);
                exit;
            }
            $price = $product['price'];
            if (($money + $money_lock) < $price) {
                echo Json::encode(['code' => 1, 'message' => '账户余额不足']);
                exit;
            }
            $name = $product['name'];
            $member_id = $this->uid;
            if ($money_lock >= $price) {// 完全使用锁定金额
                $sql = "UPDATE `inv_member` SET money_lock=money_lock-$price WHERE id='{$member_id}'";
                \Yii::$app->db->createCommand($sql)->execute();
                $obj = new ProductOrder();
                $obj->buyProduct($uid, $this->uid);
                $message = '购买成功，请去矿机查看(使用锁仓币)';
                echo Json::encode(['code' => 0, 'message' => $message]);
                exit();
            } else if ($money_lock < $price && $money_lock > 0) { // 部分使用锁定金额
                $sql = "UPDATE `inv_member` SET money_lock=0.00000 WHERE id='{$member_id}'";
                \Yii::$app->db->createCommand($sql)->execute();
                $price = $price - $money_lock;
                $remark = "购买{$name}成功,使用锁仓:" . $money_lock;
            } else {
                $price = $price;
                $remark = "购买{$name}成功";
            }
            $moneyLog = new MoneyLog();
            if ($moneyLog->moneyChange($this->uid, 2, -1 * $price, $remark)) {
                $obj = new ProductOrder();
                $obj->buyProduct($uid, $this->uid);
                $message = '购买成功，请去矿机查看';
                echo Json::encode(['code' => 0, 'message' => $message]);
                exit;
            } else {
                $message = '购买失败';
                echo Json::encode(['code' => 1, 'message' => $message]);
                exit;
            }
        }
    }

    public function actionMyProduct()
    {
        $productOrder1 = ProductOrder::find()->where(['member_id' => $this->uid, 'status' => 1])->all();
        $productOrder2 = ProductOrder::find()->where(['member_id' => $this->uid, 'status' => 2])->all();
        $data['num'] = ProductOrder::find()->where(['member_id' => $this->uid, 'status' => 1])->sum('num');
        $data['day_rate'] = ProductOrder::find()->where(['member_id' => $this->uid, 'status' => 1])->sum('day_rate');
        $data['s1'] = $productOrder1;
        $data['s2'] = $productOrder2;
        $data['active'] = 2;
		
        return $this->render('my-product', $data);
    }
	public function actionLingqu(){
		$cache = \Yii::$app->cache;
        $key = 'order_rate_' . $this->uid;		
        $cache->delete($key);		
	    echo Json::encode(['status' => 1, 'info' => '领取矿机收益成功，请刷新']);
        exit;

	}
    public function actionTeam()
    {
        $info = $this->getUserInfo();
        $cache = \Yii::$app->cache;
        $key = 'team_' . $this->uid;
        if ($cache->get($key)) {
            $team = $cache->get($key);
        } else {
            Member::getTeam($this->uid, 1);
            $team = Member::$team;
            $cache->set($key, $team, 1800);
        }
        $d = [];
        $o = [];
        if ($team) {
            // 获取直推更新直推的团队人数和算力
            $i1 = $team[1];
            foreach ($i1 as $v) {
                $d[] = ['id' => $v['id'], 'level' => $v['level']];
            }
            unset($team[1]);
            if ($team) {
                foreach ($team as $key => $val) {
                    foreach ($val as $vue) {
                        $o[] = ['mobile' => $vue['mobile'], 'level' => $vue['level'], 'r' => $key . '代团员'];
                    }
                }
            }
        }
        $member = new Member();
        return $this->render('team', [
            'active' => 3,
            'd' => $d,
            'o' => $o,
            'info' => $info,
            'member' => $member,
        ]);
    }

}
