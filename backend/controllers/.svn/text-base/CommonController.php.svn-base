<?php


namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\web\Controller;

/**
 * Class CommonController
 * @package backend\controllers  基础控制器
 */
class CommonController extends Controller
{
    public $layout = 'adminLayout'; //加载公用配置文件

    public function init()
    {
        parent::init();
        $this->checkLogin();
    }

    protected function checkLogin()
    {
        $session = \Yii::$app->session;
        if (isset($session['admin']) && $session['admin']['loginStatus'] == 1) return true;
        else return $this->redirect(['/site/index']);
    }

    // 修改密码
    public function actionSetPasswd()
    {
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            $passwd = $posts['passwd'];
            $rpasswd = $posts['rpasswd'];
            if (!$passwd || !$rpasswd) {
                $message = '请填写密码';
            } else if ($passwd != $rpasswd) {
                $message = '两次密码不一致';
            } else {
                $admin = new Admin();
                $admin::updateAll(['passwd' => md5($passwd)]);
                $message = '修改成功';
            }
            $url = \yii\helpers\Url::to(['/common/set-passwd']);
            $this->jump($url, $message);
        }
        return $this->render('set-passwd');
    }

    // 退出
    public function actionOut()
    {
        \Yii::$app->session->destroy();
        $url = \yii\helpers\Url::to(['/site/index']);
        $message = '成功退出';
        $this->jump($url, $message);
    }

    // 提示跳转
    public function jump($url, $message)
    {
        header('Content-type:text/html;charset=utf-8');
        echo "<script>alert('$message');location.href='$url'</script>";
        die;
    }


    /**
     * 成功提示
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     */
    protected function success($msg = "", $jumpurl = "", $wait = 3, $type = 1)
    {
        $url = Yii::$app->urlManager->createUrl(['common/jump', 'msg' => $msg, 'jumpurl' => $jumpurl, 'wait' => $wait, 'type' => $type]);
        header('location:' . $url);
        die;
        //  $this->ActionJump($msg, $jumpurl, $wait, 1);
    }

    /**
     * 错误提示
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     */
    protected function error($msg = "", $jumpurl = "", $wait = 1, $type = 0)
    {
        $url = Yii::$app->urlManager->createUrl(['common/jump', 'msg' => $msg, 'jumpurl' => $jumpurl, 'wait' => $wait, 'type' => $type]);
        header('location:' . $url);
        die;
        //$this->redirect($url);
        //  $this->ActionJump($msg, $jumpurl, $wait, 0);
    }

    /**
     * 最终跳转处理
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     * @param int $type 消息类型 0或1
     */
    public function actionJump()
    {
        //$msg="",$jumpurl="",$wait=3,$type=0
        $msg = Yii::$app->request->get('msg');
        $jumpurl = Yii::$app->request->get('jumpurl');
        $wait = Yii::$app->request->get('wait');
        $type = Yii::$app->request->get('type');
        $data = array(
            'msg' => $msg,
            'jumpurl' => $jumpurl,
            'wait' => $wait,
            'type' => $type
        );
        $data['title'] = ($type == 1) ? "提示信息" : "错误信息";
        if (empty($jumpurl)) {
            if ($type == 1) {
                $data['jumpurl'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "javascript:window.close();";
            } else {
                $data['jumpurl'] = "javascript:history.back(-1);";
            }
        }

        return $this->renderPartial('jump_page', $data);
    }

}