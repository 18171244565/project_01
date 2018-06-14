<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">网站配置</a>
        </li>
        <li class="active">收益管理</li>
    </ul>
</div>
<div class="page-content">
    <button class="btn btn-danger" onclick="income()">理财静态收益（触发后请耐心等待）</button>
    <button class="btn btn-danger" onclick="api()">团队收益和利息（触发后请耐心等待）</button>

    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">理财订单号</th>
                <th class="center">收益值</th>
                <th class="center">收益时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $v) { ?>
                <tr>
                    <td class="center"><?php echo $v['product_number']; ?></td>
                    <td class="center"><?php echo $v['income'] / 100; ?></td>
                    <td class="center"><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pagination]); ?>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">触发收益中，耐心等待...</h4>
                </div>
            </div>
        </div>
    </div>
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

    // ajax提交配置
    function updateConfig(key, elem) {
        var value = $(elem).parents('td').prev().find('input').val();
        var url = "<?php echo \yii\helpers\Url::to(['update']);?>";
        $.ajax({
            type: 'get',
            url: url,
            data: 'key=' + key + '&value=' + value,
            dataType: 'json',
            success: function (data) {
                alert(data.message);
            }
        })
    }


    function income() {
        $('#myModal').modal('show');
        var url = "<?php echo \yii\helpers\Url::to(['/config/to-rate']); ?>";
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#myModal').modal('hide');
                alert(data.message);
            }
        })
        return false;
    }

    function api() {
        $('#myModal').modal('show');
        var url = "<?php echo \yii\helpers\Url::to(['/api/index']); ?>";
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#myModal').modal('hide');
                alert(data.message);
            }
        })
        return false;
    }


</script>

