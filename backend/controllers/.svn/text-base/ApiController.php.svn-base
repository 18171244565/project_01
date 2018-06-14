<?php


namespace backend\controllers;

use common\models\Member;
use yii\web\Controller;
use common\models\ProductOrder;
use yii\db\Query;

class ApiController extends Controller
{
    // 定时任务触发动态发放
    public function actionIndex()
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $query = (new Query())
            ->from('inv_member')
            ->orderBy('id');

        foreach ($query->batch() as $users) {
            var_dump($users);
            echo "<hr/>";
        }

        /*
        foreach ($data as $v) {
            $rate_time = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            Member::updateAll(['rate_time' => $rate_time], ['id' => $id]);
            $productOrder = new ProductOrder();
            $productOrder->t($id);
        }*/
    }
}