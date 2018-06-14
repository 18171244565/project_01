<?php


namespace backend\controllers;

use common\models\MoneyLog;
use common\models\Product;

/**
 * Class ProductController
 * @package backend\controllers 理财产品管理
 */
class ProductController extends CommonController
{
    public $enableCsrfValidation = false;

    // 理财产品列表
    public function actionIndex()
    {
        $product = new Product();
        $productData = $product::find()->asArray()->all();
        return $this->render('index', ['product' => $product, 'productData' => $productData]);
    }

    // 理财产品添加
    public function actionCreate()
    {
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            $porduct = new Product();
            if ($porduct->createNewProduct($posts)) {
                $message = '添加理财产品成功！';
                $url = \yii\helpers\Url::to(['index']);
            } else {
                $message = '添加失败，请检查参数！';
                $url = \yii\helpers\Url::to(['create']);
            }
            $this->jump($url, $message);
        }

        return $this->render('create');
    }

    // 上架下架
    public function actionStatus()
    {
        $gets = \Yii::$app->request->get();
        $uid = $gets['uid'];
        $status = $gets['status'];
        if ($uid && $status && in_array($status, [1, 2])) {
            $product = new Product();
            if ($product->setStatus($uid, $status))
                $message = '状态修改成功';
            else
                $message = '状态修改失败';

            $url = \yii\helpers\Url::to(['index']);
            $this->jump($url, $message);

        }
        return $this->goBack();
    }

    // 产品修改
    public function actionUpdate()
    {
        $product = new Product();
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            if ($product->updateProduct($posts)) {
                $message = '修改成功!';
            } else {
                $message = '修改失败，检查参数!';
            }
            $url = \yii\helpers\Url::to(['update', 'uid' => $product->id]);
            $this->jump($url, $message);
        }

        $gets = \Yii::$app->request->get();
        $uid = $gets['uid'];
        if ($uid) {
            $data = $product::find()->where(['id' => $uid])->asArray()->one();
            return $this->render('update', ['data' => $data]);
        }
        return $this->goBack();
    }
}