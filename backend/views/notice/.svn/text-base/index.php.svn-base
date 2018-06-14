<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">公告管理</a>
        </li>
        <li class="active">公告列表</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?php echo \yii\helpers\Url::to(['create']); ?>" class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>发布公告
    </a>
</h3>
<div class="page-content">
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center" width="80px">公告标题</th>
                <th class="center">公告内容</th>
                <th class="center">发布时间</th>
                <th class="center" width="300px">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $v) { ?>
                <tr>
                    <td class="center" width="100px"><?php echo $v['title']; ?></td>
                    <td class="center"><?php echo $v['content']; ?></td>
                    <td class="center"><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                    <td class="center" width="300px">
                        <a href="<?php echo \yii\helpers\Url::to(['update', 'uid' => $v['id']]); ?>">修改</a>
                        <a href="<?php echo \yii\helpers\Url::to(['delete', 'uid' => $v['id']]); ?>">删除</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <ul class="pagination" style="float: right">

    </ul>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>

