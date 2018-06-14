<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 最新公告</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl//css/own.css">
    <link rel="stylesheet" href="/tpl//css/public.css">
    <link rel="stylesheet" href="/tpl//css/real_name.css">

</head>
<body>
<header class="mui-bar mui-bar-nav own-main-background-color">
    <span onClick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>
    <h1 class="mui-title">最新公告</h1>
</header>
<div class="mui-content" id="ethpurse">
    <div style="padding:.2rem" v-if="showbtn">
        <?php foreach ($list as $v) { ?>
            <div class="show" style="padding:.1rem .4rem">
                <div class="myinfo"><p  style="margin-bottom:.2rem" class="ti"> <?= $v['title'] ?></p>
                    <p  style="font-size:12px;display: none;text-align: left"><?= $v['content'] ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="/tpl//js/mui.min.js"></script>
<script src="/tpl//js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl//js/libs/vue.min.js" charset="utf-8"></script>
<script src="/tpl//js/function.js" charset="utf-8"></script>
<script>
	mui("body").on('tap','.ti',function(){
		if($(this).next().is(":hidden")){
			$(this).next().show();
		}else{
			$(this).next().hide();
		}
	})
</script>
</body>
</html>