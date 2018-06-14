<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">网站配置</a>
        </li>
        <li class="active">基本配置管理</li>
    </ul>
</div>
<div class="page-content">
    <button class="btn btn-danger" onclick="location.reload();">刷新</button>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center" width="80px">序号</th>
                <th class="center">参数说明</th>
                <th class="center">key值</th>
                <th class="center">参数值</th>
                <th class="center" width="300px">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($config as $v) { ?>
                <tr>
                    <td class="center" width="100px"><?php echo $v['order_by']; ?></td>
                    <td class="center"><?php echo $v['name']; ?></td>
                    <td class="center"><?php echo $v['key']; ?></td>
                    <td class="center"><input type="text" name='value' value="<?php echo $v['value']; ?>"></td>
                    <td class="center" width="300px">
                        <a onclick="updateConfig('<?php echo $v['key']; ?>',this)" data-id="4"
                           href="javascript:void(0)">确认配置</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
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


</script>

