<?php
namespace frontend\controllers;

use common\models\FaceOrder;
use common\models\Order;
use common\models\UploadForm;
use yii\helpers\Json;
use yii\web\UploadedFile;

class UploadController extends BaseController
{
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    public function actionUpload()
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model = new UploadForm();
            $model->file = UploadedFile::getInstance($model, 'file');
            $path = $model->upload();
            if (!$path) {
                return Json::encode(['code' => 0, 'message' => $model->uploadError]);
            }
            $orderModel = new Order();
            $orderId = $request->post('orderId');
            try {
                $orderModel->setOrderImage($orderId, $path);

                return Json::encode(['code' => 1, 'url' => $path]);
            } catch (\Exception $e) {
                return Json::encode(['code' => 0, 'message' => $e->getMessage()]);
            }

        }
    }

    public function actionUploads()
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model = new UploadForm();
            $model->file = UploadedFile::getInstance($model, 'file');
            $path = $model->upload();
            if (!$path) {
                return Json::encode(['code' => 0, 'message' => $model->uploadError]);
            }

            $orderId = $request->post('orderId');
            try {
                $orderModel = FaceOrder::find()->where(['id' => $orderId])->one();
                $orderModel->image = $path;
                if (!$orderModel->save()) {
                    throw new \Exception('上传失败');
                }
                return Json::encode(['code' => 1, 'url' => $path]);
            } catch (\Exception $e) {
                return Json::encode(['code' => 0, 'message' => $e->getMessage()]);
            }

        }
    }
}