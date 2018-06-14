<?php


namespace backend\controllers;

use common\models\WebConfig;
use yii\helpers\Json;

/**
 * Class WebConfigController
 * @package backend\controllers 网站站点配置
 */
class WebConfigController extends CommonController
{
    public function actionIndex()
    {
        $webConfig = new WebConfig();
        $config = $webConfig->getAllConfig();
        return $this->render('index', ['config' => $config]);
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $gets = \Yii::$app->request->get();
            $key = $gets['key'];
            $value = $gets['value'];
            $webConfig = new WebConfig();
            $res = $webConfig->setConfig($key, $value);
            if ($res)
                $message = '设置成功';
            else
                $message = '设置失败';
            echo Json::encode(['message' => $message]);
        }
    }
}