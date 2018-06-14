<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 创建账户</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/reg.css">

</head>

<body>
<div class="mui-content" id="reg">
    <div class="iconbox"><img src="/tpl/img/vrcicon.png" alt=""></div>
    <div class="selbox">
		<select name="reason" id="reason" class="selbar">
            <option value="86" data-other="86" data-place="中国（+86）">中国（+86）</option>
        </select>
		<input type="number" name="" class="user" id="tel" placeholder="手机号">
	</div>    
    <div class="yzcode"><input type="text" name="" id="yzcode" placeholder="验证码">
        <button class="send" type="button" v-show="showbtn">发送短信</button>
    </div>
    <!--
    <div class="yzcode"><input type="text" name="" id="imgcode" placeholder="图片验证码">
        <div class="hqimg" style="width:1.7rem;margin-left:.3rem">
            <img src="" style="width:100%" id="yzimg">
        </div>
    </div>-->
    <div class="input"><input type="text" name="" id="pass" placeholder="创建登录密码"></div>
    <div class="input"><input type="text" name="" id="pass2" placeholder="确认登录密码"></div>
    <div class="input"><input type="text" name="" id="spass" placeholder="创建安全密码"></div>
    <div class="input"><input type="text" name="" id="spass2" placeholder="确认安全密码"></div>
	<div class="input"><input type="number" name="" id="parentid" placeholder="推荐人：手机号" value="<?= $p_mobile ?>"></div>
    <div class="input">
	        <input type="text" id="yzm" placeholder="请输入验证码结果">
			<span class="verifycode" onClick="getverifycode();"></span>
    </div>

    <button class="freeget" type="button" v-show="showbtn">注册</button>
    <a href="<?= \yii\helpers\Url::to(['login']) ?>" class="login"
       style="text-align:center;display:block;margin-top:.2rem">返回登录页</a></div>

</body>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/vue.min.js" charset="utf-8"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script>
    var send_url = "<?= \yii\helpers\Url::to(['send-code']) ?>";
    var reg_url = "<?= \yii\helpers\Url::to(['register']) ?>";
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

    $('.freeget').click(function () {
        var phone = $('#tel').val();
        var verify_code = $('#yzcode').val();
        var pwd = $('#pass').val();
        var pwd2 = $('#pass2').val();
        var charge_passwd = $('#spass').val();
        var charge_passwd2 = $('#spass2').val();
        var p_mobile = $('#parentid').val();
        var yzm = $('#yzm').val();
        $.post(reg_url, {
            phone: phone,
            '_csrf-frontend': token,
            verify_code:verify_code,
            pwd:pwd,
            pwd2:pwd2,
			yzm:yzm,
            charge_passwd:charge_passwd,
            charge_passwd2:charge_passwd2,
            p_mobile:p_mobile,
        }, function (data) {
            alert(data.message);
            if (data.code == 0) {
                location.href=login_url;
            }
        }, 'json');
    });
	function getverifycode(){
	    var verify_url = "<?= yii\helpers\Url::to(['public/verifycode']) ?>";
		$.get(verify_url,{}, function (data) {
            if (data.code==1){
				$(".verifycode").html(data.info);
            }
        }, 'json');
	}
	getverifycode();

</script>
</html>