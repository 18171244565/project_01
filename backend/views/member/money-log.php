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

</h3>
<div class="page-content">
    <h3>用户名：<?=  $mobile ?></h3>
    <div class="table-responsive" style="margin-top: 35px">
        <div class="table-responsive" style="margin-top: 35px">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">资金变动</th>
                    <th class="center">变动时间</th>
                    <th class="center">变动说明</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $k => $v): ?>
                    <tr>
                        <td class="center"><?= $v['money'] ?></td>
                        <td class="center"><?= date('Y-m-d H:i:s', $v['create_time']) ?></td>
                        <td class="center"><?= $v['remark'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination pright">
                    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
                </ul>
            </nav>
        </div>
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
</script>

