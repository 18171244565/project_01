<?php
namespace frontend\controllers;

use common\models\Config;
use common\models\Member;
use common\models\Order;
use common\models\UnitPrice;
use common\models\WebConfig;
use frontend\models\OrderForm;
use frontend\models\ShoppingAuth;
use yii\helpers\Json;
use yii\helpers\Url;

class OrderController extends HomeController
{
    public function init()
    {
        parent::init();
        $shoppingAuth = new ShoppingAuth();
        if (!$shoppingAuth->checkAuth()) {
            Url::remember();
            if (\Yii::$app->request->isAjax) {
                return Json::encode(['code' => 0, 'message' => '登录失效', 'url' => Url::to('member/login-to-shopping')]);
            }
            return $this->redirect('member/login-to-shopping');
        }
    }

    //新手挂单
    public function actionIndex()
    {
        $this->unit();
        $data = UnitPrice::find()->asArray()->orderBy('id desc')->one();
        $configModel = new Config();
        $type = \Yii::$app->request->get('type');
        if ($data) {
            $nowPrice = $data['price'];
        } else {
            $m_p = Config::find()->where(['key' => 'm_p'])->asArray()->one();
            $nowPrice = $m_p['value'];
        }

        //查询信箱内容
        $orderModel = new Order();
        $messageList = $orderModel->getMessageOrder($this->uid, $type);

        $webConfig = new WebConfig();
        $data = [
            'money_name' => $webConfig->getConfigByKey('money_name'),
            'now_price' => $nowPrice,
            'min' => $configModel->getConfigByKey('g_d_min') ?: 0.1,
            'max' => $configModel->getConfigByKey('g_d_max') ?: 0,
            'numbers' => $orderModel->getRange($type),
            'message' => $messageList,
            'ownId' => $this->uid,
            'type' => $type,
        ];
        switch ($type) {
            case 1:
                return $this->render('rookie', $data);
            case 2:
                return $this->render('gaonei', $data);
            case 3:
                return $this->render('gaoshou', $data);
        }

    }

    public function actionConfirm()
    {
        if (\Yii::$app->request->isAjax) {
            $orderId = \Yii::$app->request->post('orderId');

            $orderModel = new Order();
            $order = $orderModel->getOrderById($orderId);

            if (!$order) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }
            if (!$order->image) {
                return Json::encode(['code' => 0, 'message' => '请先上传打款凭据']);
            }
            if ($order->status != Order::STATUS_WAIT_PAY) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }

            if ($order->setOrderToPay()) {
                return Json::encode(['code' => 1, 'message' => '操作成功，请等待卖家确认付款']);
            }

            return Json::encode(['code' => 1, 'message' => '操作失败']);
        }
    }

    public function actionReceive()
    {
        if (\Yii::$app->request->isAjax) {
            $orderId = \Yii::$app->request->post('orderId');

            $orderModel = new Order();
            $order = $orderModel->getOrderById($orderId);

            if (!$order) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }
            if ($order->status != Order::STATUS_WAIT_CONFIRM) {
                return Json::encode(['code' => 0, 'message' => '请等待对方打款']);
            }

            try {
                $order->setOrderToFinish();

                return Json::encode(['code' => 1, 'message' => '交易成功']);
            } catch (\Exception $e) {
                return Json::encode(['code' => 0, 'message' => '操作失败']);
            }
        }

    }

    public function actionBuyOrder()
    {
        if (\Yii::$app->request->isAjax) {
            $model = new OrderForm();
            $model->attributes = \Yii::$app->request->post();

            if ($model->save()) {
                return Json::encode(['code' => 1, 'message' => '挂单成功']);
            }

            return Json::encode(['code' => 0, 'message' => '挂单失败']);
        }
    }

    public function actionSale()
    {
        if (\Yii::$app->request->isAjax) {
            $orderModel = new Order();
            if ($orderModel->getOrderTotal($this->uid) == false) {
                return Json::encode(['code' => 0, 'message' => '你还有交易未处理完']);
            }
            $order = $orderModel->getOrderById(\Yii::$app->request->post('orderId'));
            if (!$order) {
                return Json::encode(['code' => 0, 'message' => '操作错误']);
            }

            if ($order->buy_member_id == $this->uid) {
                return Json::encode(['code' => 0, 'message' => '操作错误']);
            }

            $member = Member::find()->where(['id' => $this->uid])->one();
            if ($member->money < ($order->number + $order->change_money)) {
                return Json::encode(['code' => 0, 'message' => '资金不足']);
            }

            try {

                $order->saleHandle($member);
                return Json::encode(['code' => 1, 'message' => '请到交易信箱中进行下步操作']);

            } catch (\Exception $e) {
                return Json::encode(['code' => 0, 'message' => $e->getMessage()]);
            }
        }
    }

    public function actionCancel()
    {
        if (\Yii::$app->request->isAjax) {
            $orderId = \Yii::$app->request->post('orderId');

            $orderModel = new Order();
            $order = $orderModel->getOrderById($orderId);

            if (!$order) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }
            if (!($order->buy_member_id == $this->uid || $order->sale_member_id == $this->uid)) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }

            if ($order->status > Order::STATUS_WAIT_PAY) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }

            try {
                $order->cancel([
                    'id' => $this->uid,
                    'name' => $this->getUserInfo()['mobile']
                ]);

                return Json::encode(['code' => 1, 'message' => '取消成功']);

            } catch (\Exception $e) {

                return Json::encode(['code' => 0, 'message' => '取消失败']);
            }
        }

    }

    public function actionList()
    {
        $page = \Yii::$app->request->get('page') ?: 1;
        $pageSize = \Yii::$app->request->get('pagesize') ?: 20;
        $type = \Yii::$app->request->get('type');
        $offset = ($page - 1) * $pageSize;

        $orderTable = Order::tableName();
        $memberTable = Member::tableName();
        $status = Order::STATUS_DEFAULT;

        $sql = <<<SQL
SELECT o.*,m.mobile FROM {$orderTable} as o LEFT JOIN {$memberTable} as m ON o.buy_member_id=m.id
WHERE o.buy_member_id <> {$this->uid} AND o.type={$type} AND o.status={$status} ORDER BY o.create_time DESC
LIMIT {$offset},{$pageSize}
SQL;

        $list = \Yii::$app->db->createCommand($sql)->queryAll();
        $data = [];
        $webConfig = new WebConfig();
        if ($list) {
            foreach ($list as $value) {
                $data[] = [
                    'orderNumber' => $value['order_number'],
                    'time' => date('m月d日 H时i分', $value['create_time']),
                    'memberId' => $value['buy_member_id'],
                    'price' => $value['price'],
                    'number' => $value['number'] . $webConfig->getConfigByKey('money_name'),
                    'orderId' => $value['id'],
                    'mobile' => $value['mobile'],
                    'saleUrl' => Url::to('order/sale')
                ];
            }
        }
        return Json::encode($data);
    }


    //检测权限
    public function actionCheckAuth()
    {
        $type = \Yii::$app->request->get('type');
        $member = Member::find()->where(['id' => $this->uid])->one();
        $model = new OrderForm();
        $result = $model->checkInAuth($member, $type);
        if (!$result) {
            return Json::encode(['code' => 0, 'message' => $this->getAuthError($type)]);
        }
        return Json::encode(['code' => 1, 'url' => Url::to(['order/index', 'type' => $type])]);
    }

    protected function getAuthError($type)
    {
        switch ($type) {
            case Order::TYPE_LOWER:
                return '你的账号还未认证，请先去认证账号';
            case Order::TYPE_MIDDLE:
                return '账号算力不够，你可以去新手区挂单';
            case Order::TYPE_ADVANCED:
                return '账号算力不够，你可以去新手区或者进阶区挂单';
            default:
                return '';
        }
    }


    protected function unit()
    {
        $obj = new UnitPrice();
        $obj->setData();
    }

}