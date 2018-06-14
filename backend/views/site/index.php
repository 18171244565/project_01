<html>
<head>
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="renderer" content="webkit">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="content-language" content="zh-CN"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <script src="/admin/js/jquery-1.10.2.min.js"></script>
    <title>挖矿虚拟币后台管理系统</title>
    <style>
        body {
            min-height: 300px;
            background-color: #fff;
            font: 14px/18px "Microsoft Yahei", "宋体", "Hiragino Sans GB";
            color: #333;
        }

        * {
            font-family: "微软雅黑";
        }

        ul, li, ol {
            list-style: none;
            padding-left: 0;
            list-style-type: none;
        }

        h1, h2, h3, h4, h5, h6, p, ul, ol, form {
            margin: 0;
            font-size: 100%;
            font-weight: normal;
            -webkit-tap-highlight-color: transparent;
        }

        em {
            font-style: normal;
        }

        img {
            border: 0;
        }

        input, img, i.fa {
            vertical-align: middle;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        .none {
            display: none;
        }

        a {
            text-decoration: none;
            color: #333;
            -webkit-tap-highlight-color: transparent;
        }

        a:hover {
            text-decoration: none;
        }

        a, area {
            blr: expression(this.onFocus=this.blur());
        }

        :focus {
            outline: none;
        }

        button {
            border: 0 none;
            cursor: pointer;
        }

        .verticalAlign {
            vertical-align: middle;
            display: inline-block;
            height: 100%;
            width: 1px;
            margin-left: -1px;
        }

        .cf {
            zoom: 1;
        }

        .cf:after {
            content: " ";
            display: block;
            height: 0;
            clear: both;
        }

        html, body {
            margin: 0;
            width: 100%;
            height: 100%;
        }

        .login-main {
            position: relative;
            width: 100%;
            height: 100%;
            background-size: cover;
            overflow: hidden;
            text-align: center;
        }

        #loginVideo {
            position: absolute;
            left: 50%;
            top: 0;
            z-index: 1;
            -moz-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 1;
            min-width: 100%;
            min-height: 100%;
        }

        #videoCover {
            position: absolute;
            top: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
            background: #000;
            opacity: .7;
            filter: alpha(opacity=70);
        }

        .login-form {
            position: relative;
            z-index: 9;
            padding: 50px 0 146px;
            width: 300px;
            min-height: 150px;
            display: inline-block;
            vertical-align: middle;
        }

        .login-logo {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 5;
            width: 300px;
            height: 39px;
            line-height: 14px;
            font-size: 18px;
            font-weight: bold;
            color: #eee;
            text-align: center;
            background-size: 58px auto;
        }

        .login-form-li {
            position: relative;
            padding-top: 10px;
            height: 39px;
            line-height: 39px;
            font-size: 14px;
            color: #666;
            border-bottom: 1px solid #fff;
        }

        .login-form-li .verifyimg {
            position: absolute;
            left: 175px;
            bottom: 0;
            z-index: 5;
            width: 126px;
            height: 40px;
            cursor: pointer;
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            overflow: hidden;
        }

        .verifyimg img {
            margin: 0;
            width: 125px;
            height: 40px;
            vertical-align: top;
        }

        .login-input {
            width: 290px;
            height: 39px;
            line-height: 39px;
            font-size: 16px;
            color: #eee;
            border: 0;
            background: none;
        }

        .login-form-bt {
            position: absolute;
            left: 0;
            z-index: 5;
            width: 100%;
            height: 33px;
            line-height: 33px;
            font-size: 14px;
            box-sizing: border-box;
            cursor: pointer;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
        }

        .login {
            bottom: 53px;
            background-color: #fff;
            color: #000;
        }

        .login:hover {
            background-color: rgba(235, 235, 235, .85);
        }

        .reset {
            bottom: 0;
            border: 1px solid #fff;
            color: #fff;
        }

        .verticalAlign {
            vertical-align: middle;
            display: inline-block;
            height: 100%;
            width: 1px;
            margin-left: -1px;
        }

        .errortips {
            position: absolute;
            left: 0;
            bottom: 116px;
            z-index: 5;
            width: 100%;
            height: 20px;
            line-height: 20px;
            font-size: 14px;
            color: #f00;
            text-align: left;
        }

        @media only screen and (max-width: 359px) {
            .login-form {
                padding: 160px 0 136px;
            }

            .errortips {
                bottom: 110px;
            }
        }

        @media only screen and (min-width: 360px) and (max-width: 767px) {
            .login-form {
                padding: 180px 0 146px;
            }
        }
    </style>
    <script>
        function clearInput() {
            //$("#fm1").find('input').val('');
            var inputs = document.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }
        }
        function getCode() {
            var srcs = document.getElementById('captchaCodeImg-image').src;
            document.getElementById('captchaCodeImg-image').src = srcs + '&s='+Math.random();
        }
    </script>

</head>

<body>
<div class="login-main">
    <div id="videoCover"></div>
    <div class="login-form">
        <div class="login-logo">挖矿虚拟币后台管理系统</div>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'id' => 'login-form'
        ]); ?>
        <div class="login-form-li">
            <input name="Admin[username]" type="text" value="<?php !empty($admin->username) ? $admin->username : '' ?>" class="login-input" placeholder="用户名"/>
        </div>
        <div class="login-form-li">
            <input type="password" name="Admin[passwd]" class="login-input" placeholder="登录密码">
        </div>
        <div class="login-form-li" style="width:170px;margin-top: 8px">
            <input name="Admin[verifyCode]" type="text" class="login-input" value="<?php !empty($admin->verifyCode) ? $admin->verifyCode : '' ?>" style="width:170px;padding-left: 5px" placeholder="验证码"/>
            <div class="verifyimg">
                <?php echo \yii\captcha\Captcha::widget([
                    'id'=>"captchaCodeImg",
                    'name' => 'captcha',
                    'captchaAction' => '/site/captcha',
                    'imageOptions' => ['style' => 'width:140px;height:50px','onclick'=>"getCode()"],
                    'template' => '{image}',
                ]); ?>
                <!--<img src="{{ captcha_src() }}" id="captchaCodeImg" onclick="getCode()"/>-->
            </div>
        </div>
        <div class="errortips" id="errorMsg" style="text-align: center">
            <?php if(!empty($admin->firstErrors)){
                foreach($admin->firstErrors as $error){ echo $error; }
            } ?>
        </div>
        <button class="login-form-bt login" onclick="login()">登 录</button>
        <div class="login-form-bt reset" onclick="javascript:clearInput();">重 置</div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
    <span class="verticalAlign"></span>
</div>
<script>
    function login(){
        $(".login-input").each(function(){
            if(!$(this).val()){
                $("#errorMsg").html($(this).attr('placeholder')+'不能为空');
                return false;
            }
        })
        $("#login-form").submit();
    }
</script>
</body>
</html>