<?php
namespace common\models;

use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    const STATUS_NO_LOOK = 1; //未查看
    const STATUS_LOOKED = 2; //已查看

    public static function tableName()
    {
        return "{{%message}}";
    }

    public static function addMessage($data)
    {
        $model = new self();
        $model->member_id = $data['member_id'];
        $model->content = $data['content'];
        $model->create_time = time();
        $model->is_look = self::STATUS_NO_LOOK;

        return $model->save();
    }

    public function setMessageToLooked()
    {
        $this->is_look = self::STATUS_LOOKED;

        return $this->save();
    }


    public function setAllMessageToLooked($memberId)
    {
        return self::updateAll(['is_look' => self::STATUS_LOOKED], ['member_id' => $memberId, 'is_look' => self::STATUS_NO_LOOK]);
    }

}