<?php


namespace common\models;


use yii\db\ActiveRecord;

class IncomeLog extends ActiveRecord
{
    static public function tableName()
    {
        return "{{%income_log}}";
    }

    // 写入记录
    public function createLog()
    {
        $create_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $this->create_time = $create_time;
        self::insert(false);
        return true;
    }

    // 判断今日是否已产生记录
    public function isCreate()
    {
        $time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $res = self::find()->select('id')->where(['create_time' => $time])->one();
        return $res ? false : true;
    }
}