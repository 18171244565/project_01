<?php
/**
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/3/9
 * Time: 上午11:29
 */

namespace common\models;


use yii\db\ActiveRecord;

class UnitPrice extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%unit_price_log}}";
    }

    // 生成单价数据
    // 变化（不按照小时增加，按照天增加，只增加数量）
    public function setData()
    {
        $time = mktime(date('H'), 0, 0);
        $data = self::find()->where(['create_time' => $time])->asArray()->one();
        if ($data) return true;
        $a = false;

        $m_p = Config::find()->where(['key' => 'm_p'])->asArray()->one();
        $m_p = $m_p['value'];
        $m_p_r = Config::find()->where(['key' => 'm_p_r'])->asArray()->one();
        $m_p_r = $m_p_r['value'];

        $stime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data = self::find()->where(['>=', 'create_time', $stime])->asArray()->one();

        if (!$data) $a = true;// 表示新的一天

        if ($a === true)
            $n_m_p = round($m_p + $m_p_r, 2);
        else
            $n_m_p = $m_p;


        $this->price = $n_m_p;
        $this->create_time = $time;
        $this->insert(false);
        Config::updateAll(['value' => $n_m_p], ['key' => 'm_p']);
        return true;
    }
}