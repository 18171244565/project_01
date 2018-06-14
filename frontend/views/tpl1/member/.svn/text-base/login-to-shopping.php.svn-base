<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>进入交易市场</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl//css/own.css">
    <link rel="stylesheet" href="/tpl//css/public.css">
    <link rel="stylesheet" href="/tpl//css/fixpass.css">

</head>
<body>
<header class="mui-bar mui-bar-nav own-main-background-color">
    <span onclick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>

    <h1 class="mui-title">交易市场</h1>
</header>
<div class="mui-content" id="fixpass">
    <div class="input">
        <label for="">安全密码</label>
        <input type="password" id="password" placeholder="请输入安全密码">
    </div>
    <button type="button" class="post">进入</button>
</div>
<script src="/tpl//js/mui.min.js"></script>
<script src="/tpl//js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl//js/sub/fixpass.js" charset="utf-8"></script>
<script src="/tpl//js/function.js" charset="utf-8"></script>
<script>
    var url = "<?= \yii\helpers\Url::to(['member/login-to-shopping']) ?>";
    var token = "<?= \Yii::$app->getRequest()->getCsrfToken() ?>";
    $('.post').click(function () {
        var password = $('#password').val();
        if (!password) {
            mui.alert('请输入安全密码进入交易市场');
            return false;
        }
        $this = $(this);
        $this.attr('disabled',true);
        $this.html('登录中...');
        $.post(url, {password: password, '_csrf-frontend': token}, function (data) {
            if (data.code == 0) {
                mui.alert('请输入安全密码进入交易市场');
                $this.attr('disabled',false);
                $this.html('重新提交');
            }else{
                window.location.href = data.url
            }
        }, 'json');
    });
</script>
</body>
</html>