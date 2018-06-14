<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">会员管理</a>
        </li>
        <li class="active">我的团队</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="#" class="btn btn-sm btn-primary" onclick="history.go(-1)">
        <i class="icon-plus"></i>返回
    </a>
</h3>
<div class="page-content">
    <div class="table-responsive" style="margin-top: 35px">

        <?php foreach ($data as $key => $value) { ?>
            <h3>我的<?php echo $key; ?>级会员
                <small>总人数：<?php echo count($value); ?></small>
            </h3>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">用户名</th>
                    <th class="center">收益理财总价值</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($value as $v) { ?>
                    <tr>
                        <td class="center"><?php echo $v['mobile']; ?></td>
                        <td class="center">￥<?php echo $v['sum'] / 100; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
        <?php } ?>
    </div>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>


