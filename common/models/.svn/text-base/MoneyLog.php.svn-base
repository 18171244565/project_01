<?php


namespace common\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Class MoneyLog
 * @package common\models 理财收益钱包资金明细
 */
class MoneyLog extends ActiveRecord
{
    CONST TYPE_DDD = 4; //点对点转账
    CONST TYPE_MARKET = 6; //市场交易

    static public function tableName()
    {
        return "{{%money_log}}";
    }

    public function getType($type)
    {
        switch ($type) {
            case 1:
                return '后台充值';
                break;
            case 2:
                return '购买矿机';
                break;
            case 3:
                return '矿机收益';
                break;
            case self::TYPE_DDD:
                return '点对点转账';
                break;
            case 5:
                return '动态奖';
            case self::TYPE_MARKET:
                return '市场交易';
            case 7:
                return '其他';

        }
    }

    /**
     * 会员金额变动
     * @param $member_id
     * @param $type
     * @param $money
     * @param string $remark
     */
    public function moneyChange($member_id, $type, $money, $remark = '', $create_time = null, $oid = null)
    {
        $member = new Member();
        $data = $member::find()->select('money')->where(['id' => $member_id])->one();
        if ($data) {
            $money_begin = $data['money'];
            $money_end = $money_begin + $money;
            if ($money_end < 0) {
                return false;
            }
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $create_time = $create_time ? $create_time : time();
                $db = \Yii::$app->db;
                $sql = "insert into inv_money_log (`member_id`,`type`,`money_begin`,`money`,`money_end`,`remark`,`create_time`, `oid`) VALUES ('$member_id','$type','$money_begin','$money','$money_end','$remark','$create_time', '$oid')";
                $db->createCommand($sql)->execute();
                $member->updateAll(['money' => $money_end], ['id' => $member_id]);
                $transaction->commit();
            } catch (Exception $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param $memberId
     * @param $old
     * @param $new
     * @param $money
     * @param string $remark
     * @return bool
     */
    public static function AddLog($memberId, $old, $new, $money, $type, $remark = '')
    {
        $model = new self();
        $model->member_id = $memberId;
        $model->type = $type;
        $model->money_begin = $old;
        $model->money = $money;
        $model->money_end = $new;
        $model->remark = $remark;
        $model->create_time = time();
        return $model->save();
    }

}