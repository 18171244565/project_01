<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 忘记密码</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/forgetpass.css">
    <script src="/tpl/js/function.js" charset="utf-8"></script>
</head>

<body>
<header class="mui-bar mui-bar-nav own-main-background-color">
    <span onclick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>
    <h1 class="mui-title">忘记密码</h1>
</header>
<div class="mui-content" id="forgetpage">

    <div class="input">
        <label for="">手机号</label>
        <input type="text" name="tel" id="tel" placeholder="请输入您的手机号">
    </div>
    <div class="yzbox">
        <div class="input">
            <label for="">验证码</label>
            <input type="text" name="" id="yzcode" placeholder="请输入短信验证码">
        </div>
        <button type="button" class="send">获取验证码</button>
    </div>
    <div class="input"><label for="">新密码</label>
        <input type="text" name="newpass" id="newpass" placeholder="请输入您的新密码"></div>
    <div class="input cfpass">
        <label for="">重复密码</label>
        <input type="text" name="cfpass" id="cfpass" placeholder="请再次输入您的新密码">
    </div>
    <button type="button" class="post">提交</button>
</div>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/libs/ajax.js" charset="utf-8"></script>
<script>
    var send_url = "<?= \yii\helpers\Url::to(['send-forget-code']) ?>";
    var froget_url = "<?= \yii\helpers\Url::to(['forget']) ?>";
    var login_url = "<?= \yii\helpers\Url::to(['login']) ?>";
    var token = "<?= \Yii::$app->getRequest()->getCsrfToken() ?>";
    $('.send').click(function () {
        var phone = $('#tel').val();
        $.post(send_url, {
            phone: phone,
            '_csrf-frontend': token
        }, function (data) {
            alert(data.message);
        }, 'json');
    });

    $('.post').click(function () {
        var phone = $('#tel').val();
        var verify_code = $('#yzcode').val();
        var passwd = $('#newpass').val();
        var rpasswd = $('#cfpass').val();
        $.post(froget_url, {
            phone: phone,
            '_csrf-frontend': token,
            verify_code: verify_code,
            passwd: passwd,
            rpasswd: rpasswd,
        }, function (data) {
            alert(data.message);
            if (data.code == 0) {
                location.href = login_url;
            }
        }, 'json');
    });
</script>
</body>

</html>