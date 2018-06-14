<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改登录密码</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<link href="/tpl/css/mui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/tpl//css/own.css">
	<link rel="stylesheet" href="/tpl//css/public.css">
	<link rel="stylesheet" href="/tpl//css/fixpass.css">
	
</head>
<body>
<header class="mui-bar mui-bar-nav own-main-background-color">
	<span onclick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>
	<h1 class="mui-title">修改登录密码</h1>
</header>
<div class="mui-content" id="fixpass">
	<div class="input"><label for="">旧密码</label><input type="password" name="oldpass" id="oldpass" placeholder="请输入旧密码">
	</div>
	<div class="input"><label for="">新密码</label><input type="password" name="newpass" id="newpass" placeholder="请输入新密码">
	</div>
	<div class="input cfpass"><label for="">重复密码</label><input type="password" name="cfpass" id="cfpass"
															   placeholder="请确认新密码"></div>
	<button type="button" class="post">提交</button>
</div>
<script src="/tpl//js/mui.min.js"></script>
<script src="/tpl//js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl//js/sub/fixpass.js" charset="utf-8"></script>
<script src="/tpl//js/function.js" charset="utf-8"></script>
<script>
    var url = "<?= \yii\helpers\Url::to(['set-passwd']) ?>";
    var token = "<?= \Yii::$app->getRequest()->getCsrfToken() ?>";
    $('.post').click(function () {
        var oldpass = $('#oldpass').val();
        var newpass = $('#newpass').val();
        var cfpass = $('#cfpass').val();
        $.post(url, {opasswd: oldpass, passwd: newpass, rpasswd: cfpass, '_csrf-frontend': token}, function (data) {
            alert(data.message);
        }, 'json');
    });
</script>
</body>
</html>