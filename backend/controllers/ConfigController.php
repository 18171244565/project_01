<?php


namespace backend\controllers;

use common\models\Config;
use common\models\ProductIncome;
use yii\data\Pagination;
use yii\helpers\Json;

/**
 * Class ConfigController
 * @package backend\controllers 主要参数配置
 */
class ConfigController extends CommonController
{
    public function actionIndex()
    {
        $config = new Config();
        $allConfig = $config->getAllConfig();
        return $this->render('index', ['config' => $allConfig]);
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $gets = \Yii::$app->request->get();
            $key = $gets['key'];
            $value = $gets['value'];
            $config = new Config();
            $res = $config->setConfig($key, $value);
            if ($res)
                $message = '设置成功';
            else
                $message = '设置失败';
            echo Json::encode(['message' => $message]);
        }
    }
}