<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title><?= WEB_TITLE ?> | 我的</title>
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/index.css">
    <link rel="stylesheet" href="/tpl/css/mine.css">

</head>
<body>
<div class="main">
    <header class="head own-main-background-color">
        <h1 id="nav-title" class="mui-title">我的</h1>
    </header>
    <div class="content mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll" style="padding: 15px;">
                    <ul class="topbtnbox">
                        <li><a href="<?= \yii\helpers\Url::to(['notice']) ?>" class="iconfont" id="message"
                               data-title="消息通知">&#xe614;</a>
                            <?php if ($messageTotal > 0): ?>
                                <div class="redcircle"></div>
                            <?php endif; ?>
                        </li>
                        <li><a href="<?= \yii\helpers\Url::to(['setting']) ?>" class="iconfont" id="setting"
                               data-title="设置">&#xe726;</a>
                        </li>
                    </ul>

                <div class="topbox">
                    <div class="headimg">
                        <a href="#" id="person" style="background: url(/tpl/img/mine/iconbg.png)">
                            <img id="myimg" src="/tpl/img/vrcicon.png">
                        </a>
                    </div>
                    <div class="toptext">
                        <p>手机：<?= $data['mobile'] ?></p>
                        <p>姓名：<?= $data['name'] ? $data['name'] : '没有填写' ?></p>
                    </div>
                    <?php if ($data['auth'] == 1) { ?>
                        <a class="norenzheng" href="<?= \yii\helpers\Url::to(['au']) ?>" style="color:#666">未认证</a>
                    <?php } else { ?>
                        <a class="renzheng" href="<?= \yii\helpers\Url::to(['message']) ?>"><img src="/tpl/img/rz.png">已认证</a>
                    <?php } ?>

                </div>
                <div class="numberbox">
					<p>锁仓总额</p>
                    <div v-text="vrcToTal"><?= number_format($data['money_lock'], 5) ?></div>
					<p><span class="sign">签到</span></p>
                    <ul>
                        <li><img src="/tpl/img/mine/keyong.png"><span>可用<?= MONEY_NAME ?>
                                ：<font><?= $data['money'] ?></font></span></li>
                        <li><img src="/tpl/img/mine/dongjie.png"><span>冻结<?= MONEY_NAME ?>
                                ：<font><?= number_format($s, 5) ?></font></span>
                        </li>
                    </ul>
                </div>
                <ul class="gongnengbox">
                    <li><a href="<?= \yii\helpers\Url::to(['message']) ?>" data-title="个人资料">
                            <img src="/tpl/img/mine/geren.png">
                            <span>个人资料</span><span class="more"></span></a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['money-log']) ?>" data-title="账单中心">
                            <img src="/tpl/img/mine/zhangdan.png">
                            <span>账单中心</span><span class="more"></span></a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['custom']) ?>" data-title="客服中心">
                            <img src="/tpl/img/mine/kefu.png">
                            <span>客服中心</span><span class="more"></span></a></li>
                    <li id="shop"><a href="#" data-title="商城">
                            <img src="/tpl/img/mine/shangcheng.png">
                            <span>商城</span><span class="more"></span></a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['ab']) ?>" data-title="公告">
                            <img src="/tpl/img/mine/gonggao.png">
                            <span>公告</span><span class="more"></span></a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['spread']) ?>" data-title="我的推广">
                            <img src="/tpl/img/mine/tuiguang.png">
                            <span>我的推广</span><span class="more"></span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php include_once './tpl/nav.php' ?>
</div>

<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script>
    var sgin_url = "<?= \yii\helpers\Url::to(['sign']) ?>";
    $('.sign').click(function () {
        $.get(sgin_url, {}, function (data) {
            alert(data.message);
        }, 'json');
        return false;
    });
    mui("#shop").on("tap", "a", function () {
        mui.alert('开发中');
    });
    mui("#san").on("tap", "a", function () {
        mui.alert('开发中');
    });
</script>
</body>
</html>