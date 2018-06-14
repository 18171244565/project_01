<?php
namespace frontend\models;

use common\models\Config;
use common\models\FaceOrder;
use common\models\Member;
use common\models\Message;
use common\models\MoneyLog;
use common\models\WebConfig;
use yii\base\Model;
use yii\helpers\Json;

class SelHandleForm extends Model
{
    public $idNum;
    public $selNum;
    protected $sideMember;
    protected $own;
    protected $ownTotal;
    protected $rateMoney;

    public function rules()
    {
        return [
            [['idNum', 'selNum'], 'required'],
            ['idNum', 'CheckIdNum'],
            ['selNum', 'checkSelNum']
        ];
    }

    public function attributeLabels()
    {
        return [
            'idNum' => '用户号码',
            'selNum' => '转让数量'
        ];
    }

    public function checkIdNum($attribute)
    {
        if (!$this->hasErrors()) {
            //判断用户是否存在
            $memberModel = new Member();
            $member = $memberModel->getMemberByMobile($this->idNum);
            if (!$member) {
                $this->addError($attribute, '用户不存在');
                return false;
            }
            if($member->id == \Yii::$app->session->get('uid')){
                $this->addError($attribute, '自己不能转给自己');
                return false;
            }
            $this->sideMember = $member;
            return true;
        }
    }

    public function checkSelNum($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->selNum <= 0) {
                $this->addError($attribute, '请填写正确的转让数量');
                return false;
            }
            $uid = \Yii::$app->session->get('uid');
            $configModel = new Config();
            $webConfigModel = new WebConfig();
            $own = Member::find()->where(['id' => $uid])->one();
            $rate = $configModel->getConfigByKey('d_t_d');
            $rateMoney = $this->selNum * $rate / 100;
            $totalMoney = $this->selNum + $rateMoney;
            if ($totalMoney > $own->money) {
                $this->addError($attribute, $webConfigModel->getConfigByKey('money_name') . '币不足');
                return false;
            }
            $this->own = $own;
            $this->ownTotal = $totalMoney;
            $this->rateMoney = $rateMoney;
            return true;
        }

    }

    public function handle()
    {
        if (!$this->validate()) {
            $errors = $this->getErrors();
            $error = array_values($errors);
            die(Json::encode(['code' => 0, 'message' => $error[0][0]]));
        }
        //验证是否有点对点的订单存在
        $faceOrderModel = new FaceOrder();
        if ($faceOrderModel->checkMemberOrder(\Yii::$app->session->get('uid')) === false) {
            die(Json::encode(['code' => 0, 'message' => '你还有点对点交易未处理完，请处理完成后再继续操作']));
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //================减少自己金额=======================
            $ownOld = $this->own->money;
            $ownNew = $ownOld - $this->ownTotal;
            $this->own->money = $ownNew;
            if (!$this->own->save()) {
                throw new \Exception('操作失败');
            }
            //=================写入日志==========================
            $ownRemark = sprintf('转账给%s', $this->sideMember->mobile);
            $result = MoneyLog::AddLog($this->own->id, $ownOld, $ownNew, -1 * $this->ownTotal, MoneyLog::TYPE_DDD, $ownRemark);
            if (!$result) {
                throw new \Exception('操作失败1');
            }
            //=================写入订单==========================
            $result = $faceOrderModel->addData([
                'member_id' => $this->sideMember->id,
                'target_member_id' => $this->own->id,
                'money' => $this->selNum,
                'rate_money' => $this->rateMoney,
                'target_member_name' => $this->own->mobile
            ]);
            if (!$result) {
                throw new \Exception('操作失败2');
            }

            Message::addMessage(['member_id' => $this->sideMember->id, 'content' => '你有新的点对点订单']);

            $transaction->commit();
            //return true;
            return ['code' => 1, 'message' => '转账成功'];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['code' => 0, 'message' => $e->getMessage()];
            //return false;
        }
    }


    public function cancelOrder($order)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $member = Member::find()->where(['id' => $order->target_member_id])->one();
            $old = $member->money;
            $new = $old + $order->money + $order->rate_money;
            $member->money = $new;
            if (!$member->save()) {
                throw new \Exception('操作失败');
            }


            $target = Member::find()->where(['id' => \Yii::$app->session->get('uid')])->one();
            $remark = sprintf('[%s]取消交易', $target->mobile);
            $result = MoneyLog::AddLog($order->target_member_id, $old, $new, $order->money + $order->rate_money, MoneyLog::TYPE_DDD, $remark);
            if (!$result) {
                throw new \Exception('操作失败');
            }

            if (!$order->setCancelStatus()) {
                throw new \Exception('操作失败');
            }

            Message::addMessage(['member_id' => $order->target_member_id, 'content' => '你的点对点交易订单已被对方取消交易']);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {

        }
    }

    public function confirmOrder($order)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $member = Member::find()->where(['id' => $order->member_id])->one();
            $old = $member->money;
            $new = $old + $order->money;
            $member->money = $new;
            if (!$member->save()) {
                throw new \Exception('操作失败');
            }

            $target = Member::find()->where(['id' => $order->target_member_id])->one();
            $remark = sprintf('收到用户[%s]转账', $target->mobile);
            $result = MoneyLog::AddLog($order->member_id, $old, $new, $order->money, MoneyLog::TYPE_DDD, $remark);
            if (!$result) {
                throw new \Exception('操作失败');
            }

            if (!$order->setConfirmStatus()) {
                throw new \Exception('操作失败');
            }

            Message::addMessage(['member_id' => $order->member_id, 'content' => '你的点对点交易订单已完成']);

            $transaction->commit();
            return true;

        } catch (\Exception $e) {

            $transaction->rollBack();
            return false;
        }
    }
}