<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">矿机管理</a>
        </li>
        <li class="active">矿机管理</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <!--
    <a href="<?php echo \yii\helpers\Url::to(['create']); ?>" class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>添加新产品
    </a>-->
</h3>
<div class="page-content">
    <h3>矿机参数调整不会影响已出售的矿机！</h3>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">序号</th>
                <th class="center">矿机名</th>
                <th class="center">矿机类型</th>
                <th class="center">机号前缀</th>
                <th class="center">矿机价格</th>
                <th class="center">每日产量</th>
                <th class="center">运行天数</th>
                <th class="center">用户限购台数（0无上限）</th>
                <th class="center">矿机运算力</th>
                <th class="center">状态</th>
                <th class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productData as $v) { ?>
                <tr>
                    <td class="center"><?php echo $v['id']; ?></td>
                    <td class="center"><?php echo $v['name']; ?></td>
                    <td class="center"><?php echo $v['category_name']; ?></td>
                    <td class="center"><?php echo $v['t']; ?></td>
                    <td class="center">
                        <?php echo $v['price']; ?>
                    </td>
                    <td class="center">
                        <?php echo $v['day_rate']; ?>
                    </td>
                    <td class="center"><?php echo $v['day']; ?></td>
                    <td class="center"><?php echo $v['max']; ?></td>
                    <td class="center"><?php echo $v['num']; ?></td>
                    <td class="center"><?php echo $product->getStatus($v['status']); ?></td>
                    <td class="center">
                        <?php if ($v['status'] == 2) { ?>
                            <a href="<?php echo \yii\helpers\Url::to(['status', 'uid' => $v['id'], 'status' => 1]); ?>">上架</a>
                        <?php } else if ($v['status'] == 1) { ?>
                            <a href="<?php echo \yii\helpers\Url::to(['status', 'uid' => $v['id'], 'status' => 2]); ?>">下架</a>
                        <?php } ?>
                        <a href="<?php echo \yii\helpers\Url::to(['update', 'uid' => $v['id']]); ?>">修改</a>
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
