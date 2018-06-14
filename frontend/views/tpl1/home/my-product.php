<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= WEB_TITLE ?> | 矿机</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <link href="/tpl/css/mui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tpl/css/own.css">
    <link rel="stylesheet" href="/tpl/css/index.css">
    <link rel="stylesheet" href="/tpl/css/public.css">
    <link rel="stylesheet" href="/tpl/css/kuangji.css">
    <style>
        .mycontent {
            z-index: 2;
            height: 100%;
        }

        .kuangjibox {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .showbox {
            flex: 1;
            overflow-y: scroll;
			background-color:#FFFFFF;
        }
    </style>
</head>
<body>
<div class="main">
    <header class="head own-main-background-color">
        <h1 id="nav-title" class="mui-title">矿机</h1>
    </header>
    <div class="content mui-content">
            <div class="mui-scroll-wrapper">
                <div class="kuangjibox" style="position: relative;">
                    <ul class="kuangjinum">
                        <li class="first"><p>个人算力(T)</p>
                            <div v-text="sumPower==null?'0':sumPower"><?= $num ? $num : 0 ?></div>
                        </li>
                        <li class="second"><p>个人产量(<?= MONEY_NAME ?>/天)</p>
                            <div v-text="profitDay==null?'0':profitDay"><?= $day_rate ? $day_rate : 0 ?></div>
                        </li>
                    </ul>
                    <ul class="tapbox">
                        <li class="kj-nav tapactive" data-index="show1"><span>进行中<i v-text="'('+ingnum+')'"></i></span></li>
                        <li class="kj-nav" data-index="show2"><span>已停止<i v-text="'('+endnum+')'"></i></span></li>
                    </ul>

                    <ul class="showbox" >
                        <li id="show1" class="show showactive" >
                            <div class="mui-scroll-wrapper scw" style="bottom: 1rem">
                                <div class="mui-scroll ms" id="scroll1">
                                    <table border="" cellspacing="" cellpadding="">
                                        <!--<tr>
                                            <th>状态</th>
                                            <th>机号类型</th>
                                            <th>运行时间(天)</th>
                                            <th>算力</th>
                                            <th>产量(<?= MONEY_NAME ?>/天)</th>
                                        </tr>-->
                                        <?php foreach ($s1 as $v) { ?>
                                            <tr class="ing" v-for="item in ing">
                                                <td>
                                                    <div></div>
                                                </td>
                                                <td><span>机号：</span><?= $v['product_number'] ?><br/><span>类型：</span><?= $v['product_category_name'] ?></td>
                                                <td><span>算力：</span><?= $v['num'] ?> <span> 运行时间(天)：</span><?= $v['t_count'] ; ?>天<br/>
													<span>产量(<?= MONEY_NAME ?>/天)：</span><?= $v['day_rate'] ?>
													</td>
													<td>
													<?php if(time()-$v['t_time']>3600*24){?><span class="lingqu">领取</span><?php } ?>
													</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li id="show2" class="show">
                            <div class="scw">
                                <div class="ms" id="scroll2">
                                    <table border="" cellspacing="" cellpadding="">
                                        <!--<tr>
                                            <th>状态</th>
                                            <th>机号</th>
                                            <th>类型</th>
                                            <th>运行时间(天)</th>
                                            <th>算力</th>
                                            <th>产量(<?= MONEY_NAME ?>/天)</th>
                                        </tr>-->
                                        <?php foreach ($s2 as $v) { ?>
                                            <tr class="ing" v-for="item in ing">
                                                <td>
                                                    <div></div>
                                                </td>
                                                <td><span>机号：</span><?= $v['product_number'] ?><br/><span>类型：</span><?= $v['product_category_name'] ?></td>
                                                <td><span>算力：</span><?= $v['num'] ?> <span> 运行时间(天)：</span><?= $v['t_count'] . '/' . $v['day']; ?><br/>
													<span>产量(<?= MONEY_NAME ?>/天)：</span><?= $v['day_rate'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		
        <!--<div class="shuaxin"><span class="iconfont" style="font-size:.4rem">&#xe611;</span></div>-->
        <?php include_once './tpl/nav.php' ?>
    </div>
</div>
</body>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script charset="UTF-8">
    //导航切换
    $(".kj-nav").click(function () {
        $(this).addClass("tapactive").siblings().removeClass("tapactive");
        $(".show").hide().eq($(this).index()).show();
    });
	$(".lingqu").click(function(){
		$.ajax({
			url:'/home/lingqu',
			type:'get',
			data:'',
			dataType:'json',
			success:function(data){
				alert(data.info);
				if(data.status==1){
					location.href='/home/my-product';
				}
			},
		});

	});
</script>
</html>