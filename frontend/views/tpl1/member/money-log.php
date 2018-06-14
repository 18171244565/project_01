<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>账单中心</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<link href="/tpl/css/mui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/tpl/css/own.css">
	<link rel="stylesheet" href="/tpl/css/public.css">
	<link rel="stylesheet" href="/tpl/css/bill.css">
	<style>
		.mui-fullscreen .mui-segmented-control ~ .mui-slider-group {
		    position: absolute;
		    top: 40px;
		    bottom: 0;
		    width: 100%;
		    height: 100%;
		}
		.mui-active{
			border-bottom: 5px solid #02D2F5 !important;
		}
	</style>
</head>
<body>
<header class="mui-bar mui-bar-nav own-main-background-color" style="position: static;">
	<span onclick="javascript :history.go(-1);" class="back mui-icon mui-icon-left-nav mui-pull-left"></span>
	<h1 class="mui-title">账单中心</h1>
</header>
<div class="mui-content" id="bill">
	<div class="mui-slider mui-fullscreen">
		<div class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
			<div class="mui-scroll">
				<span class="my-nav mui-control-item mui-active" data-index="0" >全部</span>
				<!--<span class="my-nav mui-control-item" data-index="1" >充值</span>-->
				<span class="my-nav mui-control-item" data-index="1" >其他</span>
				<span class="my-nav mui-control-item" data-index="2" >购买</span>
				<span class="my-nav mui-control-item" data-index="3" >收益</span>
				<span class="my-nav mui-control-item" data-index="4" >点对点</span>
				<span class="my-nav mui-control-item" data-index="5" >动态</span>
				<span class="my-nav mui-control-item" data-index="6" >矿市</span>
			</div>
		</div>
		<!--<div class="padd">-->
			<!--<div class="mui-slider-progress-bar"></div>-->
		<!--</div>-->
		<div class="mui-slider-group">
			<div class="show mui-slider-item mui-control-content mui-active">
				<div class="mui-scroll-wrapper" id="list1" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum >= 0) { ?>
							<div class="total"><span>+</span><span><?= abs($sum) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list as $v) { ?>
							<li>
								<div class="left"><p class="type" ><?= $v['money'] ?></p>
									<p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
								<div class="right"><?= $v['remark'] ?></div>
							</li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list2" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum7 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum7) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum7) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list7 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list3" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum2 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum2) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum2) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list2 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list4" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum3 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum3) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum3) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list3 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list5" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum4 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum4) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum4) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list4 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list6" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum5 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum5) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum5) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list5 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="show mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper" id="list7" style="height:90%">
					<div class="mui-scroll">
						<ul class="bill">
                            <?php if ($sum6 >= 0) { ?>
                                <div class="total"><span>+</span><span><?= abs($sum6) ?></span></div>
                            <?php } else { ?>
                                <div class="total"><span>-</span><span><?= abs($sum6) ?></span></div>
                            <?php } ?>
                            <?php foreach ($list6 as $v) { ?>
                                <li>
                                    <div class="left"><p class="type" ><?= $v['money'] ?></p>
                                        <p class="time" ><?= date('Y-m-d H:i:s',$v['create_time']) ?></p></div>
                                    <div class="right"><?= $v['remark'] ?></div>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/tpl/js/mui.min.js"></script>
<script src="/tpl/js/libs/jquery.min.js" charset="utf-8"></script>
<script src="/tpl/js/function.js" charset="utf-8"></script>
<script>
	mui(".mui-scroll").on("tap","span", function(){
//		$(this).addClass("my-nav-bar").siblings().removeClass("my-nav-bar");
		$(".show").hide().eq($(this).index()).show();
	})
</script>
</body>
</html>