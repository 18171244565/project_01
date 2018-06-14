<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 登录</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/login.css">
    <script src="/tpl/js/function.js" charset="utf-8"></script>
</head>

<body>
<div class="mui-content" id="login">
    <div class="iconbox"><img src="/tpl/img/vrcicon.png" alt=""></div>
    <div class="inputbox">
        <div class="input"><label for="user" class="user">中国 +86</label>
            <input type="text" id="user" placeholder="请输入您的手机号">
        </div>
        <div class="input"><label for="pass" class="pwd">&nbsp;</label>
            <input type="password" id="pass" placeholder="请输入您的密码">
        </div>
        <div class="input"><label for="yzm" class="pwd">&nbsp;</label>
            <input type="text" id="yzm" placeholder="请输入计算结果"><span class="verifycode" onclick="getverifycode();"></span>
        </div>
    </div>
    <div class="mui-input-row" style="display:flex;justify-content:space-between;align-items:center;margin:.3rem .8rem">
        <label style="font-size:.24rem;color:#168cee">记住密码</label>
        <div class="mycheckbox">
            <div class="iconfont rempass">&#xe604;</div>
        </div>
        <input type="hidden" name="isrem" id="isrem" value="false"></div>
    <button class="logbtn" type="button">登录</button>
    <a href="<?= \yii\helpers\Url::to(['register']) ?>" id="regpage" class="hrefpage" data-web="reg">注册</a>
    <a href="<?= \yii\helpers\Url::to(['forget']) ?>" id="forgetpage"
       class="hrefpage"
       data-web="forget">忘记密码？</a>
</div>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/libs/ajax.js" charset="utf-8"></script>
<script src="/tpl/js/sub/login.js" charset="utf-8"></script>
<script>
    var login_url = "<?= yii\helpers\Url::to(['public/login']) ?>";
    var index_url = "<?= yii\helpers\Url::to(['home/index']) ?>";
    var token = "<?= \Yii::$app->getRequest()->getCsrfToken() ?>";
    $('.logbtn').click(function () {
        var mobile = $('#user').val();
        var pwd = $('#pass').val();
		var yzm=	$("#yzm").val();
        $.post(login_url, {mobile: mobile, pwd: pwd ,yzm:yzm, '_csrf-frontend': token}, function (data) {
            alert(data.message);
            if (data.code == 0) {
                location.href = index_url;
            }
        }, 'json');
    });
	function getverifycode(){
		var verify_url = "<?= yii\helpers\Url::to(['public/verifycode']) ?>";
        $.get(verify_url, {}, function (data) {
            if (data.code == 1) {
				$(".verifycode").html(data.info);
            }
        }, 'json');
	}
	getverifycode();
</script>
</body>

</html>