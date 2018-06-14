<?php
namespace backend\controllers;

use yii;
use common\models\UploadForm;
use yii\web\Controller;
use yii\helpers\Json;

class UploadController extends Controller
{
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
    }
    //文件上传
    function actionUpload(){
        $request = yii::$app->request;
        if($request->isPost){
            $model = new UploadForm();
            $model->file  = yii\web\UploadedFile::getInstance($model,'file');
            //$model->file = $_FILES;
            //var_dump($model->file);die;
            $path = $model->upload();
            $result =$path ?  ['stauts'=>0,'url'=>$path] : ['stauts'=>1,'error'=>$model->uploadError];
            echo Json::encode($result);
        }
    }
}