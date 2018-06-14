<?php


namespace frontend\controllers;

use common\models\Config;
use common\models\WebConfig;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Class CommonController
 * @package backend\controllers  基础控制器
 */
class CommonController extends Controller
{
    protected $request_ip;
    protected $request_time;
    protected $webConfig;
    protected $config;

    public function init()
    {
        header('Content-type:text/html;charset=utf-8');
        parent::init();
        $this->request_ip = Yii::$app->request->userIP;
        $this->request_time = time();
        $this->layout = false;
        // 参数初始化
        $this->configInit();
        // 站点是否关闭
        $this->webIsOpen();
        // 加载模板路径
        $this->loadView();
        // 初始化常量
        $this->doD();
    }

    /*
     * 动态加载模板
     */
    protected function loadView()
    {
        Yii::$app->viewPath = '@app/views/tpl1';
    }

    /*
     * 站点是否关闭
     */
    protected function webIsOpen()
    {
        $webConfig = $this->webConfig;
        if ($webConfig['start'] != 1) {
            $message = $webConfig['close_notice'];
            echo "<script>alert('{$message}')</script>";
            exit();
        }
        return true;
    }

    /*
     * 是否在市场交易时间
     */
    protected function marketIsTimeOpen()
    {
        $webConfig = $this->webConfig;
        $s = $webConfig['w_s'];
        $e = $webConfig['w_e'];
        $time = time();
	
        $stime = strtotime($s);
        $etime = strtotime($e);
        if ($time >= $stime && $time <= $etime) {
            return true;
        } else {
            $message = $webConfig['w_n'];
            $request = Yii::$app->request;
            if ($request->isAjax) {
                echo Json::encode(['code' => 1, 'message' => $message]);
            } else {
                echo "<script>alert('{$message}')</script>";
            }
            exit();
        }
    }

    /*
     * 市场是否关闭
     */
    protected function marketIsOpen()
    {

    }

    /*
     * 是否是手机登陆
     */
    protected function isMobile()
    {

    }

    /*
     * 参数初始化
     */
    protected function configInit()
    {
        $config = new Config();
        $data = $config->getAllConfig();
        $config = [];
        foreach ($data as $v) {
            $key = $v['key'];
            $value = $v['value'];
            $config[$key] = $value;
        }
        $this->config = $config;


        $webConfig = new WebConfig();
        $data = $webConfig->getAllConfig();
        $webConfig = [];
        foreach ($data as $v) {
            $key = $v['key'];
            $value = $v['value'];
            $webConfig[$key] = $value;
        }
        $this->webConfig = $webConfig;
    }

    /*
     * 系统常量定义
     */
    protected function doD()
    {
        $webConfig = $this->webConfig;
        $title = $webConfig['title'];
        $money_name = $webConfig['money_name'];
        define('WEB_TITLE', $title);// 网站名
        define('MONEY_NAME', $money_name);// 虚拟币名
    }
}