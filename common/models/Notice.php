<?php


namespace common\models;


use yii\db\ActiveRecord;

class Notice extends ActiveRecord
{
    static public function tableName()
    {
        return "{{%notice}}";
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required', 'message' => '请填写完整内容', 'on' => ['create', 'update']],
        ];
    }

    // 发布公告
    public function createNotice($post)
    {
        $this->scenario = 'create';
        if ($this->load($post) && $this->validate()) {
            $this->create_time = time();
            return $this->insert(false);
        }
        return false;
    }

    // 修改公告
    public function updateNotice($post, $uid)
    {
        $this->scenario = 'update';
        if ($this->load($post) && $this->validate()) {
            $save['title'] = $this->title;
            $save['content'] = $this->content;
            return self::updateAll($save, ['id' => $uid]);
        }
        return false;
    }
}