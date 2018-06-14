<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title><?= WEB_TITLE ?> | 首页-矿市</title>
    <link rel="stylesheet" href="/tpl/css/mui.min.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/index.css">
    <link rel="stylesheet" href="/tpl/css/jishi.css">
</head>
<body class="own-gray-color">
<div class="main">


    <header class="head own-main-background-color">
        <h1 id="nav-title" class="mui-title">首页</h1>
    </header>

    <div class="content jishi">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <!-- 机市 -->
                <div class="" id="jishi">
                    <ul class="jsitems">
                        <?php foreach ($productData as $v) { ?>
                            <li>
                                <div class="jsleft"><img src="/tpl/img/p<?= $v['id'] ?>.png"></div>
                                <div class="jsmiddle">
                                    <h2><?= $v['name'] ?></h2>
                                    <p>算力：<?= $v['num'] ?>T</p>
                                    <p>运行周期：永久<!--<?= $v['day'] ?>天--></p>
                                    <p>每日产量：<?= $v['day_rate'] ?><?= MONEY_NAME ?></p>
									<p>剩余数量：<?= $v['counts']?></p>
                                </div>
                                <div class="jsright" uid="<?= $v['id'] ?>">
                                <span class="buybtn">
                                    <i class="iconfont">&#xe601;</i>
                                    <span><?= round($v['price'], 2) ?> <?= MONEY_NAME ?></span>
                                </span>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <?php include_once './tpl/nav.php' ?>

</div>
</body>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js" charset="UTF-8"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script>
    var buy_url = "<?= \yii\helpers\Url::to(['home/buy']) ?>";
    var token = "<?= \Yii::$app->getRequest()->getCsrfToken() ?>";
    $(".jsright").click(function () {
        var uid = $(this).attr('uid');
        if (confirm('确认购买当前矿机?')) {
            $.post(buy_url, {uid: uid, '_csrf-frontend': token}, function (data) {
                alert(data.message);
            }, 'json');
        }
    });
</script>
</html>