<?php


namespace backend\controllers;

use common\models\Notice;

/**
 * Class NoticeController
 * @package backend\controllers 公告管理
 */
class NoticeController extends CommonController
{
    // 公告列表
    public function actionIndex()
    {
        $notice = new Notice();
        $list = $notice::find()->orderBy('id desc')->asArray()->all();
        return $this->render('index', ['list' => $list]);
    }

    // 添加公告
    public function actionCreate()
    {
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            $notice = new Notice();
            $res = $notice->createNotice($posts);
            if ($res) {
                $message = '发布成功';
                $url = \yii\helpers\Url::to(['index']);
                $this->success($message, $url);
            } else {
                $message = '发布失败';
                $url = \yii\helpers\Url::to(['create']);
                $this->jump($url, $message);
            }
        }
        return $this->render('create');
    }

    // 修改公告
    public function actionUpdate()
    {
        $notice = new Notice();
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            $uid = $posts['uid'];
            $res = $notice->updateNotice($posts, $uid);
            if ($res) {
                $message = '修改成功';
                $url = \yii\helpers\Url::to(['index']);
                $this->success($message, $url);
            } else {
                $message = '修改失败';
                $url = \yii\helpers\Url::to(['index']);
                $this->jump($url, $message);
            }
        }

        $gets = \Yii::$app->request->get();
        $uid = (int)$gets['uid'];
        $data = $notice::find()->where(['id' => $uid])->asArray()->one();
        if (!$data) return $this->goBack();
        return $this->render('update', ['data' => $data]);
    }

    // 删除公告
    public function actionDelete()
    {
        $gets = \Yii::$app->request->get();
        $uid = (int)$gets['uid'];
        if ($uid) {
            $notice = new Notice();
            $notice::deleteAll(['id' => $uid]);
            $message = '删除成功';
            $url = \yii\helpers\Url::to(['index']);
            $this->success($message, $url);
        }
        return $this->goBack();
    }
}