<?php
namespace frontend\models;

use common\models\Config;
use common\models\Order;
use common\models\ProductOrder;
use common\models\WebConfig;
use yii\base\Model;
use yii\helpers\Json;

class OrderForm extends Model
{
    public $price;
    public $number;
    public $type;

    public function rules()
    {
        return [
            [['price', 'number', 'type'], 'required'],
            ['type', 'in', 'range' => [Order::TYPE_LOWER, Order::TYPE_MIDDLE, Order::TYPE_ADVANCED]],
            ['price', 'checkPrice'],
            ['number', 'checkNumber']
        ];
    }

    public function attributes()
    {
        return [
            'price' => '单价',
            'number' => '数量'
        ];
    }

    public function checkPrice($attribute)
    {
        if (!$this->hasErrors()) {
            $configModel = new Config();
            $min = $configModel->getConfigByKey('g_d_min') ?: 0.1;
            $max = $configModel->getConfigByKey('g_d_max') ?: 0;

            if ($min > $this->price) {
                $this->addError($attribute, sprintf('最小单价不能低于%s元', $min));
                return false;
            }

            if ($max && $this->price > $max) {
                $this->addError($attribute, sprintf('最高单价不能高于%s元', $max));
                return false;
            }

            return true;
        }
    }

    public function checkNumber($attribute)
    {
        if (!$this->hasErrors()) {
            $numbers = (new Order())->getRange($this->type);
            $webConfig = new WebConfig();
            $moneyName = $webConfig->getConfigByKey('money_name');
            if ($this->number < $numbers['min'] || $this->price > $numbers['max']) {
                $this->addError($attribute, sprintf('只能买入%s-%s%s', $numbers['min'], $numbers['max'], $moneyName));
                return false;
            }
            return true;
        }
    }

    public function save()
    {
        if (!$this->validate()) {
            $errors = $this->getErrors();
            $error = array_values($errors);
            die(Json::encode(['code' => 0, 'message' => $error[0][0]]));
        }

        //判断用户是否有交易还在进行中
        $memberId = \Yii::$app->session->get('uid');
        $orderModel = new Order();
        if ($orderModel->getOrderTotal($memberId) == false) {
            die(Json::encode(['code' => 0, 'message' => '你还有交易未处理完']));
        }

        $result = $orderModel->initData([
            'uid' => $memberId,
            'number' => $this->number,
            'price' => $this->price,
            'type' => $this->type
        ]);

        return $result;
    }

    public function checkInAuth($member, $type)
    {
        if ($member->auth == 1) {
            return false;
        }
        if ($type == Order::TYPE_LOWER) {
            return true;
        }
        $power = ProductOrder::find()->where(['member_id' => $member->id, 'status' => 1])->sum('num');
        if ($type == Order::TYPE_MIDDLE) {
            return $power >= Order::MIDDLE_MIN_POWER ? true : false;
        }
        if ($type == Order::TYPE_ADVANCED) {
            return $power >= Order::ADVANCED_MIN_POWER ? true : false;
        }
    }
}