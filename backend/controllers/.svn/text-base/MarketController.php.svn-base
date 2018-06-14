<?php
namespace backend\controllers;

use common\models\FaceOrder;
use common\models\Member;
use common\models\Order;
use frontend\models\SelHandleForm;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\helpers\Url;

class MarketController extends CommonController
{
    public function actionList()
    {
        $condition = [];
        $orderNumber = \Yii::$app->request->post('order_number', '');
        if (!empty($orderNumber)) {
            $condition['order_number'] = $orderNumber;
        }
        $status = \Yii::$app->request->post('status', 0);
        if (!empty($status)) {
            $condition['status'] = $status;
        }
        $type = \Yii::$app->request->post('type', 0);
        if (!empty($type)) {
            $condition['type'] = $type;
        }

        $query = Order::find()->where($condition);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $list = $query->orderBy(['create_time' => 'desc'])
            ->offset($pages->offset)
            ->limit($pages->pageSize)
            ->all();

        return $this->render('list', [
            'list' => $list,
            'pages' => $pages
        ]);
    }

    public function actionDlist()
    {
        $condition = [];
        $orderNumber = \Yii::$app->request->post('order_number', '');
        if (!empty($orderNumber)) {
            $condition['order_number'] = $orderNumber;
        }
        $status = \Yii::$app->request->post('status', 0);
        if (!empty($status)) {
            $condition['status'] = $status;
        }

        $query = FaceOrder::find()->where($condition);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $list = $query->orderBy(['create_time' => 'desc'])
            ->offset($pages->offset)
            ->limit($pages->pageSize)
            ->all();

        return $this->render('dlist', [
            'list' => $list,
            'pages' => $pages
        ]);
    }

    public function actionDdetail()
    {

        $order = FaceOrder::find()->where(['id' => \Yii::$app->request->get('id')])->one();
        if (!$order) {
            return $this->error('订单不存在');
        }
        if ($order->target_member_id) {
            $buyMemberInfo = Member::find()->where(['id' => $order->target_member_id])->one();
        }
        $saleMemberInfo = Member::find()->where(['id' => $order->member_id])->one();
        return $this->render('ddetail', [
            'order' => $order,
            'saleMemberInfo' => isset($saleMemberInfo) ? $saleMemberInfo : '',
            'buyMemberInfo' => isset($buyMemberInfo) ? $buyMemberInfo : ''
        ]);
    }

    public function actionDetail()
    {
        $orderModel = new Order();
        $order = $orderModel->getOrderById(\Yii::$app->request->get('id'));
        if (!$order) {
            return $this->error('订单不存在');
        }
        if ($order->sale_member_id) {
            $saleMemberInfo = Member::find()->where(['id' => $order->sale_member_id])->one();
        }
        $buyMemberInfo = Member::find()->where(['id' => $order->buy_member_id])->one();

        return $this->render('detail', [
            'order' => $order,
            'saleMemberInfo' => isset($saleMemberInfo) ? $saleMemberInfo : '',
            'buyMemberInfo' => $buyMemberInfo
        ]);
    }

    public function actionDcancel()
    {
        if (\Yii::$app->request->isAjax) {
            $order = FaceOrder::find()->where(['id' => \Yii::$app->request->post('orderId')])->one();

            if (!$order) {
                return Json::encode(['code' => 1, 'message' => '错误操作']);
            }

            $model = new SelHandleForm();

            $result = $model->cancelOrder($order);
            $response = $result ? ['code' => 1, 'message' => '取消成功'] : ['code' => 0, 'message' => '取消失败'];

            return Json::encode($response);
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

            if ($order->status > Order::STATUS_WAIT_PAY) {
                return Json::encode(['code' => 0, 'message' => '非法操作']);
            }

            try {
                $order->cancel([
                    'id' => 0,
                    'name' => '后台取消'
                ]);

                return Json::encode(['code' => 1, 'message' => '取消成功']);

            } catch (\Exception $e) {

                return Json::encode(['code' => 0, 'message' => '取消失败']);
            }
        }
    }
}