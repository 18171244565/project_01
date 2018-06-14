<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">理财收益</a>
        </li>
        <li class="active">收益明细</li>
    </ul>
</div>
<div class="page-content">
    <h3>理财订单号： 【<?php echo $product_number; ?>】收益明细</h3>
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
    </div>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>


