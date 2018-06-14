<?php
namespace common\models;

use Yii;

class FaceOrder extends \yii\db\ActiveRecord
{

    const STATUS_DEFAULT = 1;
    const STATUS_PAY = 2;
    const STATUS_CONFIRM = 3;
    const STATUS_SUCCESS = 4;
    const STATUS_CANCEL = 5;

    public static function tableName()
    {
        return '{{%face_order}}';
    }

    public function getOrderNumber()
    {
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $orderMain = date('mdHis') . rand(1000, 9999);
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

    public function addData($data)
    {
        $model = new self();
        $model->member_id = $data['member_id'];
        $model->target_member_id = $data['target_member_id'];
        $model->order_number = $this->getOrderNumber();
        $model->money = $data['money'];
        $model->status = self::STATUS_PAY;
        $model->create_time = time();
        $model->rate_money = $data['rate_money'];
        $model->target_member_name = $data['target_member_name'];


        return $model->save();
    }

    public static function getMemberFaceOrderList($memberId)
    {
        //付钱
        return self::find()->where(['member_id' => $memberId])
            ->andWhere(['in', 'status', [self::STATUS_PAY, self::STATUS_DEFAULT, self::STATUS_CONFIRM]])
            ->orderBy(['create_time' => 'desc'])->all();
    }

    public static function getTargetFaceOrderList($memberId){
        //收钱
        return self::find()->where(['target_member_id' => $memberId])
            ->andWhere(['in', 'status', [self::STATUS_PAY, self::STATUS_DEFAULT, self::STATUS_CONFIRM]])
            ->orderBy(['create_time' => 'desc'])->all();
    }

    public static function getOrderByNumber($number)
    {
        $order = self::find()->where(['order_number' => $number])->one();
        if (!$order) {
            throw new \Exception('订单不存在');
        }
        return $order;
    }

    public function setConfirmStatus()
    {
        $this->status = self::STATUS_SUCCESS;
        $this->finish_time = time();

        return $this->save();
    }

    public function setCancelStatus()
    {
        $this->status = self::STATUS_CANCEL;
        $this->update_time = time();

        return $this->save();
    }

    public function checkMemberOrder($memberId)
    {
        $tableName = self::tableName();
        $status = implode(',', [self::STATUS_PAY, self::STATUS_CONFIRM]);
        $sql = <<<SQL
SELECT count(*) as total FROM {$tableName} WHERE `status` in ({$status}) AND (`member_id`={$memberId} OR `target_member_id`={$memberId})
SQL;
        $order = self::findBySql($sql)->asArray()->one();
        return $order['total'] >= 1 ? false : true;
    }

    public function getStatusText()
    {
        $statusArr = [
            self::STATUS_DEFAULT => '匹配成功',
            self::STATUS_PAY => '等待付款',
            self::STATUS_CONFIRM => '等待收款',
            self::STATUS_SUCCESS => '交易成功',
            self::STATUS_CANCEL => '交易取消'
        ];

        return $statusArr[$this->status] ?: '';
    }

    public function getBuyMemberName()
    {
        if ($this->target_member_id) {
            $member = Member::find()->where(['id' => $this->target_member_id])->one();
            return $member->mobile;
        }

        return '';
    }

    public function getSaleMemberName()
    {
        if ($this->member_id) {
            $member = Member::find()->where(['id' => $this->member_id])->one();
            return $member->mobile;
        }

        return '';
    }
}