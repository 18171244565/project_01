<?php


namespace backend\controllers;

use common\models\Member;
use common\models\ProductOrder;
use yii\web\Controller;

/**
 * Class IndexController
 * @package backend\controllers 后台登陆首页 统计数据
 */
class IndexController extends Controller
{
    public $layout = 'adminLayout';

    public function actionIndex()
    {
        $member = new Member();
        $member_all = $member::find()->count();
        $money = $member::find()->sum('money');
        $productOrder = new ProductOrder();
        $query = $productOrder::find()->where(['status' => 1]);
        $product_num = $query->sum('num');// 总算力
        $product_count = $query->count(); // 总台数

        $member_all = $member_all ? $member_all : 0;
        $product_count = $product_count ? $product_count : 0;
        $product_num = $product_num ? $product_num : 0;
        $money = $money ? $money : '0.00000';

        return $this->render('index', [
            'member_all' => $member_all,
            'product_count' => $product_count,
            'product_num' => $product_num,
            'money' => $money,
        ]);
    }

    public function actionAdd()
    {
        return $this->render('add');
    }

    public function actionList()
    {
        return $this->render('list');
    }
}