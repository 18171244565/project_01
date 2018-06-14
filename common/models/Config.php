<?php


namespace common\models;


use yii\db\ActiveRecord;

class Config extends ActiveRecord
{
    static public function tableName()
    {
        return "{{%config}}";
    }

    // 获取所有参数配置
    public function getAllConfig()
    {
        $cache = \Yii::$app->cache;
        if ($data = $cache->get('config')) {
            //return $data;
        }
        $data = self::find()->orderBy('order_by')->asArray()->all();
        $cache->set('config', $data, 180);
        return $data;
    }

    // 修改参数配置
    public function setConfig($key, $value)
    {
        $res = self::updateAll(['value' => $value], ['key' => $key]);
        $cache = \Yii::$app->cache;
        $cache->delete($key);
        return $res;
    }

    // 获取参数值
    public function getConfigByKey($key)
    {
        $data = self::find()->where(['key' => $key])->asArray()->one();
        return $data['value'];
    }
}