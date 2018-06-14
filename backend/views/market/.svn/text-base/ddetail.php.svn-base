<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">点对点交易订单</a>
        </li>
        <li class="active">订单详细</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="javascript:history.back()" class="btn btn-sm btn-primary">
        返回列表
    </a>
</h3>
<div class="page-content">
    <h5>订单基本信息</h5>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">订单编号</th>
                <th class="center">数量</th>
                <th class="center">手续费</th>
                <th class="center">状态</th>
                <th class="center">挂单时间</th>
                <?php if($order->status == 2): ?>
                    <th class="center">完成时间</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center"><?= $order->order_number ?></td>
                <td class="center"><?= $order->money ?></td>
                <td class="center"><?= $order->rate_money ?></td>
                <td class="center"><?= $order->getStatusText() ?></td>
                <td class="center"><?= date('Y-m-d H:i:s',$order->create_time) ?></td>
                <?php if($order->status == 2): ?>
                    <td class="center"><?= date('Y-m-d H:i:s',$order->update_time) ?></td>
                <?php endif; ?>
            </tr>
            </tbody>
        </table>
    </div>
    <?php if($buyMemberInfo): ?>
        <h5>买家信息</h5>
        <div class="table-responsive" style="margin-top: 35px">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">ID</th>
                    <th class="center">mobile</th>
                    <th class="center">微信</th>
                    <th class="center">支付宝</th>
                    <th class="center">姓名</th>
                    <th class="center">银行卡名称</th>
                    <th class="center">银行卡卡号</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="center"><?= $buyMemberInfo->id ?></td>
                    <td class="center"><?= $buyMemberInfo->mobile ?></td>
                    <td class="center"><?= $buyMemberInfo->weixin ?></td>
                    <td class="center"><?= $buyMemberInfo->zhifubao ?></td>
                    <td class="center"><?= $buyMemberInfo->name ?></td>
                    <td class="center"><?= $buyMemberInfo->bank_name ?></td>
                    <td class="center"><?= $buyMemberInfo->bank_card ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <?php if($saleMemberInfo): ?>
        <h5>卖家信息</h5>
        <div class="table-responsive" style="margin-top: 35px">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">ID</th>
                    <th class="center">mobile</th>
                    <th class="center">微信</th>
                    <th class="center">支付宝</th>
                    <th class="center">姓名</th>
                    <th class="center">银行卡名称</th>
                    <th class="center">银行卡卡号</th>
                </tr>
                </thead>
                <tbody>
                <td class="center"><?= $saleMemberInfo->id ?></td>
                <td class="center"><?= $saleMemberInfo->mobile ?></td>
                <td class="center"><?= $saleMemberInfo->weixin ?></td>
                <td class="center"><?= $saleMemberInfo->zhifubao ?></td>
                <td class="center"><?= $saleMemberInfo->name ?></td>
                <td class="center"><?= $saleMemberInfo->bank_name ?></td>
                <td class="center"><?= $saleMemberInfo->bank_card ?></td>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
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

