<?php
/**
 * 上传文件
 */
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;

class UploadForm extends Model
{
    public $file;

    public $uploadError = "";

    public function rules()
    {
        return [
            /*['file', 'file',
                'extensions'=>['jpg','png','gif'],'wrongExtension'=>'只能上传{extensions}类型文件！',
                'maxSize'=>1024*1024*2,'tooBig'=>'文件上传过大！',
                'skipOnEmpty'=>false,'uploadRequired'=>'请上传文件！',
                'message'=>'上传失败！'
            ]*/
            [['file'], 'file']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function upload()
    {
        if ($this->validate()) {
            $root_path = 'uploads/' . date('ymd', time());
            if (!is_dir($root_path)) {
                mkdir($root_path, 0777, true);
            }
            $randName = rand(100, 999) . '-' . md5(microtime());   //生成随机文件名
            $uploadPath = $root_path . '/' . $randName . '.' . $this->file->extension;  //设置保存路径， 为 backend\web\uploads
            $this->file->saveAs($uploadPath);  //保存文件

            $webConfig = new WebConfig();
            $http_img = $webConfig->getConfigByKey('http_img');
            if ($http_img) {
                return $http_img . '/' . substr($uploadPath, 8);
            } else {
                return Url::to($uploadPath, true); //返回文件的 url 路径，使用 Url 帮助类。
            }
            // return Url::to($uploadPath, true); //返回文件的 url 路径，使用 Url 帮助类。
        } else {
            $this->uploadError = $this->errors['file'];
            return false;
            //return 2;
        }
    }

}