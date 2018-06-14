<?php


namespace common\models;


use yii\db\ActiveRecord;

class Member extends ActiveRecord
{
    static public function tableName()
    {
        return "{{%member}}";
    }

    public function getMemberByMobile($mobile = '')
    {
        $member = self::find()->where(['mobile' => $mobile])->one();
        return $member;
    }

    // 注册成功奖励
    public function registerSuccess($uid)
    {

    }

    // 获取用户名
    public function getMobile($uid)
    {
        $data = self::find()->where(['id' => $uid])->asArray()->one();
        return $data ? $data['mobile'] : '无';
    }

    // 获取会员等级名
    public function getLevelName($level)
    {
        switch ($level) {
            case 10:
                return '<span style="color: green">普通会员</span>';
            default:
                $n = 'k_' . $level;
                break;
        }
        $webConfig = new WebConfig();
        $name = $webConfig->getConfigByKey($n);
        return '<span style="color: red">' . $name . '</span>';
    }

    public function getUserInfo($uid)
    {
        return self::find()->where(['id' => $uid])->asArray()->one();
    }

    // 获取直推人数
    public function getT1Count($uid)
    {
        $count = self::find()->where(['p_id' => $uid])->count();
        return $count ? $count : 0;
    }

    public function getUserProductCount($uid)
    {
        $count = ProductOrder::find()->where(['member_id' => $uid, 'status' => 1])->count();
        return $count ? $count : 0;
    }

    public function getUserProductNum($uid)
    {
        $num = ProductOrder::find()->where(['member_id' => $uid, 'status' => 1])->sum('num');
        return $num ? $num : 0;
    }

    // 计算会员等级升级
    public function levelChange($uid)
    {
        $data = self::find()->where(['id' => $uid])->asArray()->one();
        // 获取当前算力
        $num = ProductOrder::find()->where(['member_id' => $uid, 'status' => 1])->sum('num');

        if ($data['level'] == 10) {// 表明是普通会员
            $data = ProductOrder::find()->where(['member_id' => $uid, 'status' => 1])->one();
            if ($data) {// 升级成普通矿工
                self::updateAll(['level' => 0], ['id' => $uid]);
            }
            return true;
        } else if ($data['level'] == 0) {// 表明是普通矿工
            // 获取直推的普通矿工人数
            $count = self::find()->where(['p_id' => $uid, 'level' => 0])->count();
            $key = 's_1';
            $j = 'j_1';
            $new_level = 1;
            $product_id = 2;
        } else if ($data['level'] == 1) {// 表明是一级矿工
            // 获取直推的一级矿工人数
            $count = self::find()->where(['p_id' => $uid, 'level' => 1])->count();
            $key = 's_2';
            $j = 'j_2';
            $new_level = 2;
            $product_id = 3;
        } else if ($data['level'] == 2) {
            $count = self::find()->where(['p_id' => $uid, 'level' => 2])->count();
            $key = 's_3';
            $j = 'j_3';
            $new_level = 3;
            $product_id = 4;
        } else if ($data['level'] == 3) {
            $count = self::find()->where(['p_id' => $uid, 'level' => 3])->count();
            $key = 's_4';
            $j = 'j_4';
            $new_level = 4;
            $product_id = 5;
        } else {
            return true;
        }
        $config = new Config();
        $s = $config->getConfigByKey($key);
        $arr = explode(';', $s);
        // 奖励矿机
        $j = $config->getConfigByKey($j);
        if ($count >= $arr[1] && $num >= $arr[0]) {
            for ($i = 1; $i <= $j; $i++) {
                $obj = new ProductOrder();
                $obj->levelProduct($product_id, $uid);
                usleep(10);
            }
            self::updateAll(['level' => $new_level], ['id' => $uid]);
        }
        return true;
    }

    public static $team = [];

    // 递归获取团队
    public static function getTeam($str, $num)
    {
        if (!$str) {
            return true;
        } else {
            $sql = "SELECT * FROM `inv_member` WHERE `p_id` IN ({$str})";
            $data = \Yii::$app->db->createCommand($sql)->queryAll();
            $str = '';
            if ($data) {
                $id = array_column($data, 'id');
                $str = implode(',', $id);
                self::$team[$num] = $data;
            }
            $num += 1;
            self::getTeam($str, $num);
        }
    }

    // 团队矿工人数和团队算力更新
    public function teamData($str)
    {
        $uid = $str;
        self::getTeam($str, 1);
        $team = self::$team;

        $teamNum = $this->teamNum($team);
        $teamCount = $this->teamCount($team);

        // 获取自己的算力
        $my = ProductOrder::find()->where(['member_id' => $uid])->asArray()->sum('num');
        if ($my)
            $teamNum += $my;// 团队算力要算自己

        self::updateAll(['team_count' => $teamCount, 'team_num' => $teamNum], ['id' => $uid]);
        return true;
    }

    // 计算团队矿工人数
    public function teamCount($team)
    {
        $count = 0;
        foreach ($team as $v) {
            $count += count($v);
        }
        return $count;
    }


    // 计算团队算力
    public function teamNum($team)
    {
        $num = 0;
        $str = '';
        foreach ($team as $v) {
            foreach ($v as $val) {
                $str .= $val['id'] . ',';
            }
        }
        if ($str) {
            $str = substr($str, 0, -1);
            $sql = "SELECT SUM(num) as N FROM `inv_product_order` WHERE member_id in ({$str}) AND status=1";
            $data = \Yii::$app->db->createCommand($sql)->queryOne();
            $num = $data['N'];
        }
        return $num;
    }

    //检查交易密码
    public function checkChargePassword($password)
    {
        return $this->charge_passwd == md5($password) ? true : false;
    }

    public function getFreezeMoney($memberId)
    {
        //查询点对点冻结资金
        $faceMoney = FaceOrder::find()->where(['member_id' => $memberId, 'status' => FaceOrder::STATUS_DEFAULT])->sum('money');
        $faceRateMoney = FaceOrder::find()->where(['member_id' => $memberId, 'status' => FaceOrder::STATUS_DEFAULT])->sum('rate_money');

        //查看市场冻结资金
        $condition = [Order::STATUS_WAIT_PAY, Order::STATUS_WAIT_CONFIRM];
        $marketMoney = Order::find()->where(['sale_member_id' => $memberId])->andWhere(['in', 'status', $condition])->sum('number');
        $marketRateMoney = Order::find()->where(['sale_member_id' => $memberId])->andWhere(['in', 'status', $condition])->sum('change_money');

        return bcadd($faceMoney, $faceRateMoney) + bcadd($marketMoney, $marketRateMoney);

    }

}