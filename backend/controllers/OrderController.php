<?php


namespace backend\controllers;

use common\models\Member;
use common\models\ProductIncome;
use common\models\ProductOrder;
use yii\data\Pagination;

/**
 * Class OrderController
 * @package backend\controllers
 */
class OrderController extends CommonController
{
    // 未支付订单
    public function actionIndex()
    {
        $productOrder = new ProductOrder();
        $query = $productOrder::find();

        $pagination = new Pagination();

        // 查询条件
        $request = \Yii::$app->request->request();
        if (isset($request['mobile']) && $request['mobile']) {
            $mobile = $request['mobile'];
            $member = new Member();
            $data = $member::find()->select('id')->where(['mobile' => $mobile])->asArray()->one();
            if ($data) {
                $query = $query->where(['member_id' => $data['id']]);
                $pagination->params = [
                    'mobile' => $mobile
                ];
            }
        }

        $pagination->totalCount = $query->count();
        $list = $query->select('inv_product_order.*,inv_member.mobile')
            ->offset($pagination->offset)
            ->join('left join', 'inv_member', 'inv_product_order.member_id=inv_member.id')
            ->orderBy('inv_product_order.id desc')->limit($pagination->limit)->asArray()->all();

        return $this->render('index', [
            'pagination' => $pagination,
            'list' => $list,
            'productOrder' => $productOrder,
        ]);
    }

    // 产值明细
    public function actionDetail()
    {
        $gets = \Yii::$app->request->get();
        if (isset($gets['product_number'])) {
            $product_number = $gets['product_number'];
            $product = new ProductIncome();
            $data = $product::find()->where(['product_number' => $product_number])->orderBy('id desc')->all();
            return $this->render('detail', ['list' => $data, 'product_number' => $product_number]);
        }
        return $this->goBack();
    }

    // 修改状态
    public function actionStatus()
    {
        $gets = \Yii::$app->request->get();
        $uid = (int)$gets['uid'];
        $status = (int)$gets['status'];
        if ($uid) {
            $m = '操作成功';
            $save = [];
            $save['status'] = $status;
            if ($status == 1) {
                $save['t_time'] = time();
                $m = '启动成功';
            }
            if ($status == 2) {
                $m = '停止成功';
            }
            $res = ProductOrder::updateAll($save, ['id' => $uid]);
            if ($res) {
                $message = $m;
            } else {
                $message = '操作失败';
            }
        } else {
            $message = '请求失败';
        }
        $url = \yii\helpers\Url::to(['index']);
        $this->jump($url, $message);
    }

    // 删除订单
    public function actionDelete()
    {
        $gets = \Yii::$app->request->get();
        $uid = (int)$gets['uid'];
        if ($uid) {
            $productOrder = new ProductOrder();
            $productOrder::deleteAll(['id' => $uid, 'status' => 1]);
            $message = '删除成功';
        } else {
            $message = '非法请求';
        }
        $url = \yii\helpers\Url::to(['index']);
        $this->jump($url, $message);
    }
}