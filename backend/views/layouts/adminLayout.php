<?php
use yii\helpers\Html;

//use Yii;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="/admin/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/admin/assets/css/font-awesome.min.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/admin/assets/css/font-awesome-ie7.min.css"/>
    <![endif]-->
    <link rel="stylesheet" href="/admin/css/fontmy.css"/>
    <link rel="stylesheet" href="/admin/assets/css/ace.min.css"/>
    <link rel="stylesheet" href="/admin/assets/css/ace-rtl.min.css"/>
    <link rel="stylesheet" href="/admin/assets/css/ace-skins.min.css"/>
    <link rel="stylesheet" href="/admin/css/style.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/admin/assets/css/ace-ie.min.css"/>
    <![endif]-->
    <script src="/admin/assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/admin/assets/js/html5shiv.js"></script>
    <script src="/admin/assets/js/respond.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script src="/admin/js/jquery-2.0.3.min.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script src="/admin/js/jquery-1.10.2.min.js"></script>
    <![endif]-->
    <style type="text/css">
        *, .btn, h1, h2, h3, h4, h5, h6 {
            font-family: "微软雅黑";
        }

        .table tbody > tr > td {
            vertical-align: middle;
        }
    </style>
    <title><?= Html::encode($this->title) ?></title>
</head>
<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small><i class="icon-leaf"></i>  挖矿虚拟币系统</small>
            </a>
        </div>
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background-color: rgba(0,0,0,.2)">
                        <img class="nav-user-photo" src="/admin/assets/avatars/user.jpg" alt="Jason's Photo"/>
                        <span class="user-info"><small>欢迎光临,</small>admin</span>
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                        <li><a href="<?php echo \yii\helpers\Url::to(['/common/set-passwd']) ?>"><i
                                    class="icon-cog"></i>修改密码</a></li>
                        <!--<li><a href="#"><i class="icon-user"></i>个人资料</a></li>-->
                        <li class="divider"></li>
                        <li><a href="<?php echo \yii\helpers\Url::to(['/common/out']); ?>"><i
                                    class="icon-off"></i>退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#"><span class="menu-text"></span></a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }</script>
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left"
                   data-icon2="icon-double-angle-right"></i>
            </div>
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'collapsed')
                } catch (e) {
                }
            </script>
            <ul class="nav nav-list">
                <li class="active">
                    <a href="<?php echo \yii\helpers\Url::to(['/index/index']); ?>"><i class="icon-dashboard"></i><span
                            class="menu-text"> 网站统计 </span></a>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-cog"></i>
                        <span class="menu-text"> 网站配置 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li class="">
                            <a href="<?php echo \yii\helpers\Url::to(['/web-config/index']); ?>"><i
                                    class="icon-double-angle-right"></i>基本配置</a>
                        </li>
                        <li class="">
                            <a href="<?php echo \yii\helpers\Url::to(['/config/index']); ?>"><i
                                    class="icon-double-angle-right"></i>参数配置</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-folder-open"></i>
                        <span class="menu-text"> 矿机管理 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li class=""><a href="<?php echo \yii\helpers\Url::to(['/product/index']); ?>"><i
                                    class="icon-double-angle-right"></i>矿机设置</a></li>
                        <li class=""><a href="<?php echo \yii\helpers\Url::to(['/order/index', 'status' => 1]); ?>"><i
                                        class="icon-double-angle-right"></i>矿机管理</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-group"></i>
                        <span class="menu-text"> 会员管理 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>"><i
                                    class="icon-double-angle-right"></i>会员列表</a>
                        </li>
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['member/charge']) ?>"><i
                                    class="icon-double-angle-right"></i>会员充值</a>
                        </li>
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['member/product']) ?>"><i
                                    class="icon-double-angle-right"></i>发放矿机</a>
                        </li>
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['member/money-lock']) ?>"><i
                                        class="icon-double-angle-right"></i>仓库释放</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-star"></i>
                        <span class="menu-text"> 市场管理 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['market/list']) ?>"><i
                                        class="icon-double-angle-right"></i>虚拟币交易订单</a>
                        </li>
                        <li class="">
                            <a href="<?= Yii::$app->urlManager->createUrl(['market/dlist']) ?>"><i
                                        class="icon-double-angle-right"></i>虚拟币点对点订单</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-file"></i>
                        <span class="menu-text"> 公告管理 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['notice/create']); ?>"><i
                                    class="icon-double-angle-right"></i>添加公告</a>
                        </li>
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['notice/index']); ?>"><i
                                    class="icon-double-angle-right"></i>公告列表</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="main-content" style="margin-bottom: 50px">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>
            <?= $content ?>
        </div>
    </div>
    <div class="ace-settings-container" id="ace-settings-container" style="top:85px;">
        <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
            <i class="icon-cog bigger-150"></i>
        </div>
        <div class="ace-settings-box" id="ace-settings-box">
            <div>
                <div class="pull-left">
                    <select id="skin-colorpicker" class="hide">
                        <option data-skin="default" value="#438EB9">#438EB9</option>
                        <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                        <option data-skin="skin-2" selected value="#C6487E">#C6487E</option>
                        <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                    </select>
                </div>
                <span>&nbsp; 选择皮肤</span>
            </div>
            <div>
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar"/>
                <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
            </div>

            <div>
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"/>
                <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
            </div>

            <div>
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs"/>
                <label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
            </div>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div>
<script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src='/admin/assets/js/jquery.mobile.custom.min.js}'>" + "<" + "script>");
</script>
<script src="/admin/assets/js/bootstrap.min.js"></script>
<script src="/admin/assets/js/typeahead-bs2.min.js"></script>
<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="/admin/assets/js/ace-elements.min.js"></script>
<script src="/admin/assets/js/ace.min.js"></script>
<script src="/admin/js/BeAlert.js"></script>
</body>
</html>

