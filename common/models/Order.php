<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\Json;

class Order extends ActiveRecord
{
    const TYPE_LOWER = 1; //新手
    const TYPE_MIDDLE = 2; //进阶
    const TYPE_ADVANCED = 3; //高手

    const STATUS_DEFAULT = 1; //买家发出
    const STATUS_WAIT_PAY = 2; //等待支付
    const STATUS_WAIT_CONFIRM = 3; //等待确认交易
    const STATUS_SUCCESS = 4; //交易成功
    const STATUS_CANCEL = 5; //交易取消

    const MIDDLE_MIN_POWER = 5;
    const ADVANCED_MIN_POWER = 200;

    public static function tableName()
    {
        return "{{%order}}";
    }

    public function getRange($type)
    {
        if ($type == self::TYPE_LOWER) {
            return ['min' => 1, 'max' => 10, 'step' => 1];
        }
        if ($type == self::TYPE_MIDDLE) {
            return ['min' => 10, 'max' => 200, 'step' => 10];
        }
        if ($type == self::TYPE_ADVANCED) {
            return ['min' => 200, 'max' => 5000, 'step' => 10];
        }

        return ['min' => 0, 'max' => 0];

    }

    public function getOrderNumber()
    {
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $orderMain = date('YmdHis') . rand(10000000, 99999999);
        //订单号码主体长度
        $orderLen = strlen($orderMain);
        $orderSum = 0;
        for ($i = 0; $i < $orderLen; $i++) {
            $orderSum += (int)(substr($orderMain, $i, 1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $orderNum = $orderMain . str_pad((100 - $orderSum % 100) % 100, 2, '0', STR_PAD_LEFT);

        return $orderNum;
    }

    public function getOrderById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    public function getOrderTotal($memberId)
    {

        $tableName = self::tableName();
        $status = implode(',', [self::STATUS_DEFAULT, self::STATUS_WAIT_CONFIRM, self::STATUS_WAIT_PAY]);
        $sql = <<<SQL
SELECT count(*) as total FROM {$tableName} WHERE (`buy_member_id`={$memberId} OR `sale_member_id`={$memberId}) AND `status` in ({$status})
SQL;
        $order = self::findBySql($sql)->asArray()->one();
        return $order['total'] >= 1 ? false : true;

    }

    public function initData($data)
    {
        $model = new self();
        $model->order_number = $this->getOrderNumber();
        $model->buy_member_id = $data['uid'];
        $model->number = $data['number'];
        $model->price = $data['price'];
        $model->create_time = time();
        $model->status = self::STATUS_DEFAULT;
        $model->type = $data['type'];

        //计算手续费
        $config = new Config();
        $rate = $config->getConfigByKey('g_d_d');
        $model->change_money = $data['number'] * $rate / 100;

        return $model->save();
    }

    public function saleHandle($member)
    {
        if ($this->status != self::STATUS_DEFAULT) {
            throw new \Exception('该挂单已在交易中,请刷新后重新操作');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->sale_member_id = $member->id;
            $this->status = self::STATUS_WAIT_PAY;
            $this->sale_time = time();

            if (!$this->save()) {
                throw new \Exception('交易失败');
            }

            $old = $member->money;
            $new = $old - $this->number - $this->change_money;
            $member->money = $new;

            if (!$member->save()) {
                throw new \Exception('交易失败');
            }

            $ownRemark = sprintf('%s区中卖出', $this->getTypeText($this->type));
            $result = MoneyLog::AddLog($member->id, $old, $new, -1 * ($this->number + $this->change_money), MoneyLog::TYPE_MARKET, $ownRemark);
            if (!$result) {
                throw new \Exception('交易失败');
            }

            Message::addMessage(['member_id' => $this->buy_member_id, 'content' => sprintf('你在%s中的挂单有新的动态',$this->getTypeText($this->type))]);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
        }

    }

    public function getMessageOrder($memberId, $type)
    {
        $tableName = self::tableName();
        $status = implode(',', [self::STATUS_DEFAULT,self::STATUS_WAIT_CONFIRM, self::STATUS_WAIT_PAY]);
        $sql = <<<SQL
SELECT * FROM {$tableName} WHERE (`buy_member_id`={$memberId} OR `sale_member_id`={$memberId}) AND `status` in ({$status}) AND `type`={$type}
SQL;
        return self::findBySql($sql)->all();
    }

    public function getBuyMemberName()
    {
        if ($this->buy_member_id) {
            $member = Member::find()->where(['id' => $this->buy_member_id])->one();
            return $member->mobile;
        }

        return '';
    }

    public function getSaleMemberName()
    {
        if ($this->sale_member_id) {
            $member = Member::find()->where(['id' => $this->sale_member_id])->one();
            return $member->mobile;
        }

        return '';
    }

    public function setOrderImage($orderId, $url)
    {
        $order = $this->getOrderById($orderId);
        if (!$order) {
            throw new \Exception('订单不存在');
        }

        $order->image = $url;
        if (!$order->save()) {
            throw new \Exception('保存失败');
        }

        return true;
    }

    public function setOrderToPay()
    {
        $this->status = self::STATUS_WAIT_CONFIRM;
        $this->pay_time = time();

        Message::addMessage(['member_id' => $this->sale_member_id, 'content' => sprintf('你在%s中的挂单对方已确认付款',$this->getTypeText($this->type))]);

        return $this->save();
    }

    public function setOrderToFinish()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->status = self::STATUS_SUCCESS;
            $this->finish_time = time();
            if (!$this->save()) {
                throw new \Exception('交易失败');
            }
            //===================买家操作=========================
            $member = Member::find()->where(['id' => $this->buy_member_id])->one();
            $old = $member->money;
            $new = $old + $this->number;
            $member->money = $new;

            if (!$member->save()) {
                throw new \Exception('交易失败');
            }

            $ownRemark = sprintf('%s区中买入', $this->getTypeText($this->type));
            $result = MoneyLog::AddLog($this->buy_member_id, $old, $new, $this->number, MoneyLog::TYPE_MARKET, $ownRemark);
            if (!$result) {
                throw new \Exception('交易失败');
            }

            Message::addMessage(['member_id' => $this->buy_member_id, 'content' => sprintf('你在%s中的挂单已交易完成',$this->getTypeText($this->type))]);

            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function getTypeText($type)
    {
        $types = [
            self::TYPE_LOWER => '新手挂单',
            self::TYPE_MIDDLE => '进阶挂单',
            self::TYPE_ADVANCED => '高手挂单'
        ];

        return $types[$type] ?: '';
    }

    public function cancel($hanles)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->status = self::STATUS_CANCEL;
            $extra = Json::decode($this->extra);
            if (!empty($extra)) {
                $data[] = $extra;
            }
            $data[] = [
                'cancel_time' => time(),
                'handle_id' => $hanles['id'],
                'handle_name' => $hanles['name']
            ];

            $this->extra = Json::encode($data);
            if (!$this->save()) {
                throw new \Exception('取消失败');
            }

            if ($this->sale_member_id) {
                //返回卖家的币
                $member = Member::find()->where(['id' => $this->sale_member_id])->one();
                $old = $member->money;
                $new = $old + $this->number + $this->change_money;
                $member->money = $new;

                if (!$member->save()) {
                    throw new \Exception('交易失败');
                }

                $ownRemark = sprintf('%s区中交易取消,取消者[%s]', $this->getTypeText($this->type),  $hanles['name']);
                $result = MoneyLog::AddLog($member->id, $old, $new, $this->number + $this->change_money, MoneyLog::TYPE_MARKET, $ownRemark);
                if (!$result) {
                    throw new \Exception('交易失败');
                }

                Message::addMessage(['member_id' => $this->sale_member_id, 'content' => sprintf('你在%s中的挂单已被取消交易',$this->getTypeText($this->type))]);
            }

            Message::addMessage(['member_id' => $this->buy_member_id, 'content' => sprintf('你在%s中的挂单已被取消交易',$this->getTypeText($this->type))]);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function getStatusText()
    {
        $statusArr = [
            self::STATUS_DEFAULT => '买家发出',
            self::STATUS_WAIT_PAY => '等待付款',
            self::STATUS_WAIT_CONFIRM => '等待收款',
            self::STATUS_SUCCESS => '交易成功',
            self::STATUS_CANCEL => '交易取消'
        ];

        return $statusArr[$this->status] ?: '';
    }

}