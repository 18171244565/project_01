<?php

use yii\widgets\LinkPager;

?>
<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">会员管理</a>
        </li>
        <li class="active">会员列表</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?= Yii::$app->urlManager->createUrl(['member/add-update']) ?>" class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>新增会员
    </a>
</h3>
<div class="page-content">
    <form class="form-horizontal" action="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>" method="post"
          role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">

        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-lg-3 col-sm-6">
                <label class="col-sm-4 control-label">用户名</label>

                <div class="col-sm-8">
                    <input type="text" name="mobile" value="" placeholder="请输入用户名" class="form-control">
                </div>
            </div>
        </div>
        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-lg-3 col-sm-6 ">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-search orange"></i>搜索
                </button>

            </div>
        </div>
    </form>
    <p style="color: red;">注意：用户不登陆，团队算力和团队人数不会更新，登陆后更新截止到前一天</p>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">序号</th>
                <th class="center">用户名</th>
                <th class="center">推荐人用户名</th>
                <th class="center">虚拟币数量</th>
                <th class="center">锁仓数量</th>
                <th class="center">运行矿机数量</th>
                <th class="center">级别</th>
                <th class="center">注册时间</th>
                <th class="center">最后登录时间</th>
                <th class="center">团队算力（包含自己算力）</th>
                <th class="center">团队人数</th>
                <th class="center">状态</th>
                <th class="center">是否认证</th>
                <th class="center">是否开启锁仓</th>
                <th class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php $member = new \common\models\Member(); ?>
            <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td class="center"><?= $page_info->page * $page_info->pageSize + $k + 1 ?></td>
                    <td class="center"><?= $v['mobile'] ?></td>
                    <td class="center"><?= $member->getMobile($v['p_id']) ?></td>
                    <td class="center"><?= $v['money'] ?></td>
                    <td class="center"><?= $v['money_lock'] ?></td>
                    <td class="center"><?= $member->getUserProductCount($v['id']) ?></td>
                    <td class="center"><?= $member->getLevelName($v['level']) ?></td>
                    <td class="center"><?= date('Y-m-d H:i:s', $v['create_time']) ?></td>
                    <td class="center"><?= date('Y-m-d H:i:s', $v['login_time']) ?></td>
                    <td class="center"><?= $v['team_num'] ?></td>
                    <td class="center"><?= $v['team_count'] ?></td>
                    <td class="center"><?= (!isset($v['status']) || $v['status'] == 1) ? '<span style="color: green">正常</span>' : '<span style="color: red">禁用</span>' ?></td>
                    <td class="center"><?= (!isset($v['auth']) || $v['auth'] == 1) ? '<span style="color: red">未认证</span>' : '<span style="color: green">已认证</span>' ?></td>
                    <td class="center"><?= (!isset($v['s']) || $v['s'] == 1) ? '<span style="color: green">关闭</span>' : '<span style="color: red">开启</span>' ?></td>
                    <td class="center">
                        <a href="#"
                           data-url="<?= Yii::$app->urlManager->createUrl(['member/auth-status', 'uid' => $v['id']]) ?>"
                           class="auth"><?= (!isset($v['auth']) || $v['auth'] == 1) ? '认证成功' : '取消认证' ?></a>
                        <a href="<?= Yii::$app->urlManager->createUrl(['member/frozen', 'uid' => $v['id']]) ?>"><?= (!isset($v['status']) || $v['status'] == 1) ? '封号' : '解除封号' ?></a>
                        <a href="<?= Yii::$app->urlManager->createUrl(['member/add-update', 'uid' => $v['id']]) ?>">修改</a>
                        <a href="<?= Yii::$app->urlManager->createUrl(['member/money-log', 'uid' => $v['id']]) ?>">资金明细</a>
                        <?php if ($v['s'] == 2) { ?>
                            <a href="<?php echo \yii\helpers\Url::to(['member/su', 'uid' => $v['id'], 's' => 1]) ?>">关闭锁仓</a>
                        <?php } else { ?>
                            <a href="<?php echo \yii\helpers\Url::to(['member/su', 'uid' => $v['id'], 's' => 2]) ?>">开启锁仓</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination pright">
                <?= LinkPager::widget(['pagination' => $page_info]) ?>
            </ul>
        </nav>
    </div>
    <ul class="pagination" style="float: right">

    </ul>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>
<script>
    $("#cont_category").chosen();
    $('#chosen-multiple-style').on('click', function (e) {
        var target = $(e.target).find('input[type=radio]');
        var which = parseInt(target.val());
        if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
        else $('#form-field-select-4').removeClass('tag-input-style');
    });
    $(".date-select").fdatepicker({format: 'yyyy-mm-dd'});
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#createBeginTime').fdatepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.update(newDate);
        }
        checkin.hide();
        $('#createEndTime')[0].focus();
    }).data('datepicker');
    var checkout = $('#createEndTime').fdatepicker({
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
    }).data('datepicker');


    $('.auth').click(function () {
        var url = $(this).attr('data-url');
        $.get(url, {}, function (data) {
            alert(data.message)
            if (data.code == 0) {
                location.reload();
            }
        }, 'json')
    });
</script>

