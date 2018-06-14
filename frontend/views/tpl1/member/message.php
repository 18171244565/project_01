<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 个人资料</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/person.css">

</head>
<body>
<div class="main">
    <header class="head mui-bar mui-bar-nav own-main-background-color" style="position: static;">
        <span onClick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>
        <h1 class="mui-title">个人资料</h1>
    </header>
    <div class="content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class=" mui-content" id="person">                    
                    <ul class="infobox">
						<a class="headbox" href="#" data-title="设置头像">
    	                    <img id="myimg" src="/tpl/img/vrcicon.png">
	                    </a>
                        <li>
							<p>上级用户名：<?= $member->getMobile($data['p_id']) ?></p>
							<p>我的用户名：<?= $data['mobile'] ?></li>
                        <li><p style="text-align:right;">等级：<?= $member->getLevelName($data['level']) ?> &nbsp; </p></li>
                    </ul>
                    <ul class="my-lists">
                        <li><a class="telcheck"><b><img src="/tpl/img/mine/renzheng_shouji.png"><br/>手机号验证</b>
                                <div class="person-text">
								<!--<span v-text="tel"><?= $data['mobile'] ?></span>--> <span class="succ">已认证</span>
                                </div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['au']) ?>">
                                <b><img src="/tpl/img/mine/renzheng_shiming.png"><br/>实名认证</b>
                                <div class="person-text">
                                    <?php if ($data['auth'] == 2) { ?>
                                        <!--<span><?= $data['name'] ?></span>-->
                                        <span class="succ">已认证</span>
                                    <?php } else { ?>
                                        <span class="none">未认证</span>
                                    <?php } ?>
                                </div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['au']) ?>">
                                <b><img src="/tpl/img/mine/renzheng_yinhang.png"><br/>银行卡认证</b>
                                <div class="person-text">
                                    <?php if ($data['auth'] == 2) { ?>
                                        <!--<span><?= $data['bank_name'] ?></span>-->
                                        <span class="succ">已认证</span>
                                    <?php } else { ?>
                                        <span class="none">未认证</span>
                                    <?php } ?>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!--<div class="iconfont xia">&#xe600;</div>-->
                    <ul class="two">
                        <li><a href="<?= \yii\helpers\Url::to(['weixin']) ?>">
								
								<b><img src="/tpl/img/mine/weixin.png">微信</b>
                                <div style="margin-right:.1rem"><span></span> <i class="iconfont">&#xe603;</i>
                                </div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['zhifubao']) ?>"><b><img src="/tpl/img/mine/zhifu.png">支付宝</b>
                                <div style="margin-right:.1rem"><span></span> <i class="iconfont">&#xe603;</i>
                                </div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['eth']) ?>"><b><img src="/tpl/img/mine/qianbao.png">虚拟钱包</b>
                                <div style="margin-right:.1rem"><span></span> <i class="iconfont">&#xe603;</i></div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['set-passwd']) ?>"><b><img src="/tpl/img/mine/jiesuo.png">修改登录密码</b>
                                <div style="margin-right:.1rem"><i class="iconfont">&#xe603;</i></div>
                            </a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['set-cpasswd']) ?>"><b><img src="/tpl/img/mine/jiesuo.png">修改交易密码</b>
                                <div style="margin-right:.1rem"><i class="iconfont">></i></div>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/vue.min.js" charset="utf-8"></script>
<script src="/tpl/js/sub/person.js" charset="utf-8"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
</body>
</html>