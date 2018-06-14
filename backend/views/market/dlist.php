<?php
use yii\widgets\LinkPager;

?>
<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">市场管理</a>
        </li>
        <li class="active">点对点交易订单</li>
    </ul>
</div>
<div class="page-content">
    <form class="form-horizontal" method="post" action="<?php echo \yii\helpers\Url::to(['market/dlist']) ?>"
          role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">

        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-lg-3 col-sm-6">
                <input type="text" name="order_number" value="<?= \Yii::$app->request->post('order_number') ?>"
                       placeholder="请输入订单编号" class="form-control">
            </div>
            <div class="col-lg-2 col-sm-4">
                <select class="form-control" name="status">
                    <option value="0">全部订单</option>
                    <option <?php if (\Yii::$app->request->post('status') == 1): ?>selected<?php endif; ?> value="1">
                        等待确认交易
                    </option>
                    <option <?php if (\Yii::$app->request->post('status') == 2): ?>selected<?php endif; ?> value="2">
                        交易完成
                    </option>
                    <option <?php if (\Yii::$app->request->post('status') == 3): ?>selected<?php endif; ?> value="3">
                        交易取消
                    </option>
                </select>
            </div>
            <div class="col-lg-3 col-sm-6 ">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-search orange"></i>搜索
                </button>
            </div>
        </div>
    </form>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">订单编号</th>
                <th class="center">买家信息</th>
                <th class="center">卖家信息</th>
                <th class="center">数量</th>
                <th class="center">状态</th>
                <th class="center">时间</th>
                <th class="center" width="300px">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $order): ?>
                <tr>
                    <td class="center"><?= $order->order_number ?></td>
                    <td class="center">
                        ID：<?= $order->target_member_id ?><br>
                        mobile：<?= $order->getBuyMemberName() ?>
                    </td>
                    <td class="center">
                        ID：<?= $order->member_id ?><br>
                        mobile：<?= $order->getSaleMemberName() ?>
                    </td>
                    <td class="center">
                        数量：<?= $order->money ?><br>
                        手续费：<?= $order->rate_money ?>
                    </td>
                    <td class="center">
                        <?= $order->getStatusText() ?>
                    </td>
                    <td class="center">
                        <?= date('Y-m-d H:i:s', $order->create_time) ?>
                    </td>
                    <td class="center">
                        <a href="<?= \yii\helpers\Url::to(['market/ddetail', 'id' => $order->id]) ?>">查看详细</a>
                        <?php if ($order->status == 1): ?>
                            <a onclick="cancelOrder(this)" data-id="<?= $order->id ?>">取消交易</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <ul class="pagination" style="float: right">
        <ul class="pagination pright">
            <?= LinkPager::widget(['pagination' => $pages]) ?>
        </ul>
    </ul>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>
<script>
    var url = "<?= \yii\helpers\Url::to(['market/dcancel']) ?>";
    var token = "<?= \Yii::$app->request->csrfToken ?>";
    function cancelOrder(e){
        var $this = $(e);
        var orderId = $(e).attr('data-id');
        $this.attr('disabled',true);
        $this.html('取消中...')
        confirm('','你确定要取消此交易吗?',function(isConfirm){
            if (isConfirm) {
                $.post(url,{orderId:orderId,'_csrf-backend':token},function(response){
                    if(response.code == 1){
                        alert('',response.message,function(){
                            window.location.reload();
                        })
                    }else{
                        alert('',response.message)
                    }
                },'json')
            }
        })
    }
</script>
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

