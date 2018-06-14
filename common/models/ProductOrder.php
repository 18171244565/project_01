<?php


namespace common\models;


use yii\db\ActiveRecord;

class ProductOrder extends ActiveRecord
{
    public $error;

    static public function tableName()
    {
        return "{{%product_order}}";
    }

    public function getStatus($status)
    {
        switch ($status) {
            case 1:
                return "<span style='color: red'>矿机运行中</span>";
            case 2:
                return "<span style='color: red'>矿机暂停运行</span>";
            case 3:
                return "<span style='color: green'>矿机运行结束</span>";
        }
    }

    public function getType($type)
    {
        switch ($type) {
            case 1:
                return "<span style='color: red'>购买</span>";
            case 2:
                return "<span style='color: red'>后台发放</span>";
            case 3:
                return "<span style='color: red'>注册赠送</span>";
            case 4:
                return "<span style='color: red'>升级奖励</span>";
        }

    }

    public function setProductNumber($t, $member_id)
    {
        $n = strlen($member_id);
        if ($n == 1) $num = mt_rand(10000, 99999);
        else if ($n == 2) $num = mt_rand(1000, 9999);
        else if ($n == 3) $num = mt_rand(100, 999);
        else if ($n == 4) $num = mt_rand(10, 99);
        else if ($n == 5) $num = mt_rand(1, 9);
        else $num = '';
        $str = $t . $member_id . $num . date('md');
        return $str;
    }

    // 后台发放
    public function grantProduct($product_id, $member_id)
    {
        $res = $this->getProductMsg($product_id);
        if ($res) {
            $t = $res['t'] ? $res['t'] : 'BUI';
            $this->product_number = $this->setProductNumber($t, $member_id);
            $this->product_id = $product_id;
            $this->member_id = $member_id;
            $this->product_name = $res['name'];
            $this->product_category_name = $res['category_name'];
            $this->price = $res['price'];
            $this->day = $res['day'];
            $this->day_rate = $res['day_rate'];
            $this->num = $res['num'];
            $this->create_time = time();
            $this->t_time = time();
            $this->t_count = 0;
            $this->status = 1;
            $this->type = 2;
            $this->insert(false);
            return true;
        }
        return false;
    }

    // 用户购买矿机
    public function buyProduct($product_id, $member_id)
    {
        $res = $this->getProductMsg($product_id);
        if ($res) {
            $t = $res['t'] ? $res['t'] : 'BUI';
            $this->product_number = $this->setProductNumber($t, $member_id);
            $this->product_id = $product_id;
            $this->member_id = $member_id;
            $this->product_name = $res['name'];
            $this->product_category_name = $res['category_name'];
            $this->price = $res['price'];
            $this->day = $res['day'];
            $this->day_rate = $res['day_rate'];
            $this->num = $res['num'];
            $this->create_time = time();
            $this->t_time = time();
            $this->t_count = 0;
            $this->status = 1;
            $this->type = 1;
            $this->insert(false);
            return true;
        }
        return false;
    }

    // 注册赠送矿机
    public function registerProduct($member_id)
    {
        $product_id = 1;
        $res = $this->getProductMsg($product_id);
        if ($res) {
            $t = $res['t'] ? $res['t'] : 'BUI';
            $this->product_number = $this->setProductNumber($t, $member_id);
            $this->product_id = $product_id;
            $this->member_id = $member_id;
            $this->product_name = $res['name'];
            $this->product_category_name = $res['category_name'];
            $this->price = $res['price'];
            $this->day = $res['day'];
            $this->day_rate = $res['day_rate'];
            $this->num = $res['num'];
            $this->create_time = time();
            $this->t_time = time();
            $this->t_count = 0;
            $this->status = 1;
            $this->type = 3;
            $this->insert(false);
            return true;
        }
        return false;
    }

    public function levelProduct($product_id, $member_id)
    {
        $res = $this->getProductMsg($product_id);
        if ($res) {
            $t = $res['t'] ? $res['t'] : 'BUI';
            $this->product_number = $this->setProductNumber($t, $member_id);
            $this->product_id = $product_id;
            $this->member_id = $member_id;
            $this->product_name = $res['name'];
            $this->product_category_name = $res['category_name'];
            $this->price = $res['price'];
            $this->day = $res['day'];
            $this->day_rate = $res['day_rate'];
            $this->num = $res['num'];
            $this->create_time = time();
            $this->t_time = time();
            $this->t_count = 0;
            $this->status = 1;
            $this->type = 4;
            $this->insert(false);
            return true;
        }
        return false;
    }

    // 获取单个产品信息
    public function getProductMsg($product_id)
    {
        $product = new Product();
        $data = $product::find()->where(['id' => $product_id])->asArray()->one();
        if ($data) {
            if ($data['status'] == 2) {
                $this->error = '产品未上架!';
                return false;
            }
            return $data;
        } else {
            $this->error = '产品不存在!';
            return false;
        }
    }

    // 判断用户限购个数
    public function checkBuyCount($product_id, $member_id)
    {
        $product = new Product();
        $data = $product::find()->select('max')->where(['id' => $product_id])->asArray()->one();
        $max = (int)$data['max'];
        if (!$max) return true;
        $productOrder = new ProductOrder();
        $count = $productOrder::find()->where(['product_id' => $product_id, 'member_id' => $member_id, 'status' => 1])->count();
        if ($count < $max) {
            return true;
        }
        return false;
    }

    // 用户所有运行的矿机产生收益
    public function rateAll($member_id)
    {
        $data = self::find()->where(['member_id' => $member_id, 'status' => 1])->asArray()->all();
        if (!$data) return true;
        $sum = 0;// 收益总数
        foreach ($data as $v) {
            $this->rate($v['id']);
            usleep(10);
        }
        // 发放

        return true;
    }

    // 单台矿机生产收益
    public function rate($uid)
    {
        $data = self::find()->where(['id' => $uid, 'status' => 1])->asArray()->one();
        if (!$data) return true;
        $product_number = $data['product_number'];
        $member_id = $data['member_id'];
        $day_rate = $data['day_rate'];
        $day = $data['day'];// 矿机总收益次数
        $t_time = $data['t_time'];// 矿机上次收益时间
        $t_count = $data['t_count'];// 矿机已收益次数
        $time = time();
        $j = ($time - $t_time) / (24 * 3600);
        $c = (int)floor($j);// 向下取整
        if ($c <= 0) return true;// 不需要产生收益
		
		$c=1;
		
        if (($day - $t_count) < $c) {
            $c = $day - $t_count;
            $new_t_count = $day;
            $status = 3;// 表示收益结束
        } else {
            $new_t_count = $t_count + $c;
            $status = 1;// 表示收益结束
        }

        $new_t_time = $t_time + 24 * 3600 * $c;
		
		$new_t_time = time();
		
		
		$remark = '矿机' . $product_number . '收益(已扣除5%管理费)';

        $d = Member::find()->select('s')->where(['id' => $member_id])->asArray()->one();
        $s = $d['s'];
        // 判断是否锁仓
        $config = new Config();
        $lock = $config->getConfigByKey('lock');
        if ($lock > 0 && $s == 2) {
            $day_rate0 = round($day_rate * (100 - $lock) * 0.01, 5);
            $l = $day_rate - $day_rate0;
            $remark .= '锁仓:' . $l;
            $l_sum = 0;
            for ($i = 1; $i <= $c; $i++) {
                $create_time = $new_t_time;//$t_time + 24 * 3600 * $i;
                $moneyLog = new MoneyLog();
				$day_rate0*=0.95;
                $moneyLog->moneyChange($member_id, 3, $day_rate0, $remark, $create_time, $uid);
                usleep(10);
                $l_sum += $l;
            }
            $sql = "UPDATE inv_member SET money_lock=money_lock+{$l_sum} WHERE id='{$member_id}'";
            \Yii::$app->db->createCommand($sql)->execute();
        } else { // 没有锁仓
            for ($i = 1; $i <= $c; $i++) {
                $create_time = $new_t_time;//$t_time + 24 * 3600 * $i;
                $moneyLog = new MoneyLog();
				$day_rate*=0.95;
                $moneyLog->moneyChange($member_id, 3, $day_rate, $remark, $create_time, $uid);
                usleep(10);
            }
        }
        $save = [];
        $save['t_count'] = $new_t_count;
        $save['t_time'] = $new_t_time;
        $save['status'] = $status;
        self::updateAll($save, ['id' => $uid]);
        return true;
    }

    // 触发动态奖
    public function t($member_id)
    {
        $data = Member::find()->where(['id' => $member_id])->asArray()->one();
        $day_rate = ProductOrder::find()->where(['member_id' => $member_id, 'status' => 1])->sum('day_rate');
        if (!$day_rate) return true;
        if ($data['p_id']) {
            // 获取一代
            $data = Member::find()->where(['id' => $data['p_id']])->asArray()->one();
            if ($data && $data['level'] != 10) {
                // 获取
                $day_rate0 = ProductOrder::find()->where(['member_id' => $data['id'], 'status' => 1])->sum('day_rate');
                if ($day_rate0) {// 烧伤
                    if ($day_rate0 < $day_rate) $money = $day_rate0;
                    else $money = $day_rate;

                    // 触发动态奖
                    $this->tt($data['id'], 1, $money);
                }
            }

            if ($data['p_id']) {
                // 获取二代
                $data = Member::find()->where(['id' => $data['p_id']])->asArray()->one();
                if ($data && $data['level'] != 10 && $data['level'] >= 1) {
                    // 获取
                    $day_rate0 = ProductOrder::find()->where(['member_id' => $data['id'], 'status' => 1])->sum('day_rate');
                    if ($day_rate0) {// 烧伤
                        if ($day_rate0 < $day_rate) $money = $day_rate0;
                        else $money = $day_rate;

                        // 触发动态奖
                        $this->tt($data['id'], 2, $money);
                    }
                }

                if ($data['p_id']) {
                    // 获取三代
                    $data = Member::find()->where(['id' => $data['p_id']])->asArray()->one();
                    if ($data && $data['level'] != 10 && $data['level'] >= 2) {
                        // 获取
                        $day_rate0 = ProductOrder::find()->where(['member_id' => $data['id'], 'status' => 1])->sum('day_rate');
                        if ($day_rate0) {// 烧伤
                            if ($day_rate0 < $day_rate) $money = $day_rate0;
                            else $money = $day_rate;

                            // 触发动态奖
                            $this->tt($data['id'], 3, $money);
                        }
                    }

                    if ($data['p_id']) {
                        // 获取四代
                        $data = Member::find()->where(['id' => $data['p_id']])->asArray()->one();
                        if ($data && $data['level'] != 10 && $data['level'] >= 3) {
                            // 获取
                            $day_rate0 = ProductOrder::find()->where(['member_id' => $data['id'], 'status' => 1])->sum('day_rate');
                            if ($day_rate0) {// 烧伤
                                if ($day_rate0 < $day_rate) $money = $day_rate0;
                                else $money = $day_rate;

                                // 触发动态奖
                                $this->tt($data['id'], 4, $money);
                            }
                        }

                        if ($data['p_id']) {
                            // 获取五代
                            $data = Member::find()->where(['id' => $data['id']])->asArray()->one();
                            if ($data && $data['level'] != 10 && $data['level'] >= 4) {
                                // 获取
                                $day_rate0 = ProductOrder::find()->where(['member_id' => $data['p_id'], 'status' => 1])->sum('day_rate');
                                if ($day_rate0) {// 烧伤
                                    if ($day_rate0 < $day_rate) $money = $day_rate0;
                                    else $money = $day_rate;

                                    // 触发动态奖
                                    $this->tt($data['id'], 5, $money);
                                }
                            }
                        }
                    }

                }

            }


        }
    }

    protected function tt($member_id, $type, $money)
    {
        $key = 'd_' . $type;
        $config = new Config();
        $rate = $config->getConfigByKey($key);
        $m = round($money * $rate * 0.01, 5);
        if ($m > 0) {
            $moneyLog = new MoneyLog();
            $remark = $type . '代动态奖';
            $moneyLog->moneyChange($member_id, 5, $m, $remark);
        }
        return true;
    }

}