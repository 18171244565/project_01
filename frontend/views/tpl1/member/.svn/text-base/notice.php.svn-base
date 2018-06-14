<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>消息通知</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/message.css">

</head>
<body>
<header class="mui-bar mui-bar-nav own-main-background-color">
    <span onclick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>

    <h1 class="mui-title">消息通知</h1>
</header>
<div class="mui-content" id="message">
    <div class="mui-scroll-wrapper" id="gg">
        <div class="mui-scroll" style="padding-top:.4rem">
            <ul class="messagebox">
                <?php foreach ($list as $message): ?>
                    <li>
                        <a class="messlist">
                            <div class="time"><?= date('m月d日 H时i分',$message->create_time)?></div>
                            <div class="info">
                                <div class="red"></div>
                                <div class="infocon"><?= $message->content ?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/vue.min.js" charset="utf-8"></script>
<script src="/tpl/js/sub/message.js" charset="utf-8"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script>
    $(function(){
        var url = "<?= \yii\helpers\Url::to(['set-message'])?>"
        setTimeout(function(){
            $.get(url,function(){

            })
        },5000)
    })
</script>
</body>
</html>