<?php

namespace backend\controllers;

use backend\models\MemberModel;
use backend\models\ChargeModel;
use common\models\Member;
use common\models\MoneyLog;
use common\models\Product;
use common\models\ProductOrder;
use common\models\Recharge;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;

/**
 * Class MemberController
 * @package backend\controllers  会员管理
 */
class MemberController extends CommonController
{

    public function actionList()
    {
        $mobile = Yii::$app->request->request('mobile');
        $mobile = str_replace(["'", '"'], '', $mobile);
        $where = "mobile like '%$mobile%'";
        // $where = "mobile like '%".$mobile."%'";
        $model = new MemberModel();
        $totalCount = $model->findAllData('inv_member', true, '', '', '', $where);
        $config = ['totalCount' => $totalCount, 'pageSize' => 20];
        $page_obj = new Pagination($config);
        $limit = $page_obj->limit;
        $offset = $page_obj->offset;
        $list = $model->findAllData('inv_member', false, '*', $limit, $offset, $where, 'create_time desc');
        $page_obj->params = [
            'mobile' => $mobile,
        ];
        $member = new Member();
        $params = [
            'list' => $list,
            'page_info' => $page_obj,
            'member' => $member,
        ];
        return $this->render('list', $params);
    }

    public function actionAddUpdate()
    {
        $member_model = new MemberModel();
        $uid = Yii::$app->request->request('uid');
        $list_url = Yii::$app->urlManager->createUrl(['member/list']);
        if ($uid) {
            $user_info = $member_model->findOneData('inv_member', ['id' => $uid]);
            //         var_dump($user_info);
            //  $url = $_SERVER['HTTP_REFERER'] ;
            !$user_info && $this->redirect($list_url);
        } else {
            $user_info = null;
        }
        //读取所有的会员
        //   $user_list = $member_model->findAllData('inv_member', false, 'id,mobile,name', '', '', $uid ? "id!=$uid and status=1" : "status=1");
        if ($member_model->load(Yii::$app->request->post()) && $member_model->save()) {
            //验证通过
            $this->redirect($list_url);
        } else {
            $params = ['member_model' => $member_model,
                'user_info' => $user_info,
                //  'user_list' => $user_list,
                'model' => $member_model];
            return $this->render('addupdate', $params);
        }
    }

    public function actionFrozen()
    {
        $uid = Yii::$app->request->get('uid');
        $member_model = new MemberModel();
        $user_info = $member_model
            ->findOneData('inv_member', ['id' => $uid]);
        $jumpurl = Yii::$app->urlManager->createUrl(['member/list']);
        !$user_info && $this->error('用户信息不存在', $jumpurl); //提示用户信息
        $update_data = $user_info['status'] == 1 ? ['status' => 2] : ['status' => 1];
        $r = $member_model->updateData('inv_member', $update_data, ['id' => $uid]);
        $r ? $this->success('操作成功', $jumpurl) : $this->error('服务器繁忙,请稍后再试!', $jumpurl);
    }

    public function actionMoneyLog()
    {
        $uid = Yii::$app->request->get('uid');
        $moneyLog = new MoneyLog();
        $pagination = new Pagination();
        $member = new Member();
        $pagination->totalCount = $moneyLog::find()
            ->where(['member_id' => $uid])
            ->count();
        $list = $moneyLog::find()
            ->offset($pagination->offset)
            ->where(['member_id' => $uid])
            ->limit($pagination->limit)
            ->asArray()->orderBy('id desc')->all();

        $mobile = Member::find()->where(['id' => $uid])->asArray()->one()['mobile'];

        return $this->render('money-log', [
            'pagination' => $pagination,
            'list' => $list,
            'member' => $member,
            'mobile' => $mobile,
        ]);
    }

    // 仓库释放
    public function actionMoneyLock()
    {
        if (\Yii::$app->request->isAjax) {
            $u = (int)\Yii::$app->request->post('u');
            if ($u <= 0) {
                echo Json::encode(['code' => 0, 'message' => '触发比率错误']);
                exit();
            }
            $data = Member::find()->select('id,money_lock')->where(['>', 'money_lock', '0'])->asArray()->all();
            $remark = '仓库释放';
            if ($data) {
                foreach ($data as $v) {
                    $m = $v['money_lock'];
                    $id = $v['id'];
                    $a = round($u * 0.01 * $m, 5);
                    if ($a <= 0) {
                        $a = $m;
                    }
                    if ($a > $m) {
                        $a = $m;
                    }
                    $sql = "UPDATE inv_member SET money_lock=money_lock-$a WHERE id='$id'";
                    \Yii::$app->db->createCommand($sql)->execute();
                    $moneyLog = new MoneyLog();
                    $moneyLog->moneyChange($id, 7, $a, $remark);
                    unset($moneyLog);
                }
            }
            echo Json::encode(['code' => 0, 'message' => '触发成功']);
            exit();
        }
        return $this->render('money-lock');
    }

    /**
     * 会员充值
     */
    public function actionCharge()
    {
        $model = new ChargeModel();
        if ($model->load(Yii::$app->request->post()) && $model->charge()) {
            $this->success('充值成功');
        } else {
            $pagination = new Pagination();
            $count = MoneyLog::find()->where(['type' => 1])->count();
            $pagination->totalCount = $count;
            $list = MoneyLog::find()->where(['type' => 1])
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('id desc')->asArray()->all();
            $params = ['model' => $model, 'pagination' => $pagination, 'list' => $list];
            return $this->render('charge', $params);
        }

    }

    // 会员发放产品
    public function actionProduct()
    {
        if (\Yii::$app->request->isPost) {
            $posts = \Yii::$app->request->post();
            $mobile = $posts['mobile'];
            $member = new Member();
            $res = $member::find()->select('id')->where(['mobile' => $mobile])->asArray()->one();
            $member_id = $res['id'];
            $product = $posts['product_id'];
            $num = $posts['num'];// 发放矿机
            for ($i = 1; $i <= $num; $i++) {
                $productOrder = new ProductOrder();
                $productOrder->grantProduct($product, $member_id);
            }
            $res = true;
            $res ? $message = '发放成功！' : $message = '发放失败！';
            $url = \yii\helpers\Url::to(['product']);
            $this->jump($url, $message);
        }
        $product = new Product();
        $productData = $product::find()->where(['status' => 1])->all();

        $pagination = new Pagination();
        $pagination->totalCount = $count = ProductOrder::find()->where(['type' => 2])->count();
        $list = ProductOrder::find()
            ->offset($pagination->offset)
            ->where(['type' => 2])
            ->limit($pagination->limit)
            ->asArray()->all();

        return $this->render('product', ['product' => $productData, 'list' => $list, 'pagination' => $pagination]);
    }

    // ajax 查询账号是否存在
    public function actionCheckMobile()
    {
        if (\Yii::$app->request->isAjax) {
            $gets = \Yii::$app->request->get();
            $mobile = $gets['mobile'];
            $member = new Member();
            $res = $member::find()->select('id')->where(['mobile' => $mobile])->one();
            if ($res)
                echo Json::encode(['message' => '可以发放']);
            else
                echo Json::encode(['message' => '账号不存在']);
        }
    }

    public function actionAuthStatus()
    {
        if (Yii::$app->request->isAjax) {
            $uid = Yii::$app->request->get('uid');
            $member_model = new MemberModel();
            $user_info = $member_model
                ->findOneData('inv_member', ['id' => $uid]);
            $jumpurl = Yii::$app->urlManager->createUrl(['member/list']);
            !$user_info && $this->error('用户信息不存在', $jumpurl); //提示用户信息
            $update_data = $user_info['auth'] == 1 ? ['auth' => 2] : ['auth' => 1];
            $r = $member_model->updateData('inv_member', $update_data, ['id' => $uid]);
            if ($r) {
                echo Json::encode(['code' => 0, 'message' => '操作成功']);
            } else {
                echo Json::encode(['code' => 1, 'message' => '操作失败']);
            }
            // $r ? $this->success('操作成功', $jumpurl) : $this->error('服务器繁忙,请稍后再试!', $jumpurl);
        }
    }

    public function actionSu()
    {
        $uid = Yii::$app->request->get('uid');
        $s = Yii::$app->request->get('s');
        $r = Member::updateAll(['s' => $s], ['id' => $uid]);
        $jumpurl = Yii::$app->urlManager->createUrl(['member/list']);
        $r ? $this->success('操作成功', $jumpurl) : $this->error('服务器繁忙,请稍后再试!', $jumpurl);
    }

    // 我的团队
    public function actionTeam()
    {
        $gets = \Yii::$app->request->get();
        $uid = (int)$gets['uid'];
        if ($uid) {
            $member = new Member();
            $data = $member->myTeam($uid);
            return $this->render('team', ['data' => $data]);
        }
        return $this->goBack();
    }
}
