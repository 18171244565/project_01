<?php


namespace common\models;


use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    static public function tableName()
    {
        return "{{%product}}";
    }

    public function rules()
    {
        return [
            [['name', 'category_name', 't', 'price', 'day', 'day_rate', 'max', 'num','counts'], 'required', 'message' => '请填写完整信息', 'on' => ['create', 'update']],
            ['id', 'required', 'on' => 'update'],
            [['day', 'max', 'num'], 'integer', 'on' => ['create', 'update']],
        ];
    }

    public function getStatus($status)
    {
        switch ($status) {
            case 1:
                return '<span style="color: green">可购买</span>';
            case 2:
                return '<span style="color: red">无法购买</span>';
        }
    }


    public function createNewProduct($posts)
    {
        $this->scenario = 'create';
        if ($this->load($posts) && $this->validate()) {
            return $this->insert(false);
        }
        return false;
    }

    public function updateProduct($posts)
    {
        $this->scenario = 'update';
        if ($this->load($posts) && $this->validate()) {
            $save['name'] = $this->name;
            $save['category_name'] = $this->category_name;
            $save['t'] = $this->t;
            $save['price'] = $this->price;
            $save['day_rate'] = $this->day_rate;
            $save['day'] = $this->day;
            $save['max'] = $this->max;
            $save['num'] = $this->num;
            $save['counts'] = $this->counts;
            return self::updateAll($save, ['id' => $this->id]);
        }
        return false;
    }

    public function setStatus($uid, $status)
    {
        if (!in_array($status, [1, 2])) return false;
        return self::updateAll(['status' => $status], ['id' => $uid]);
    }

    public function getName($product_id)
    {
        $data = self::find()->select('name')->where(['id' => $product_id])->asArray()->one();
        return $data['name'];
    }
}