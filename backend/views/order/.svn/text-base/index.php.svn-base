<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">矿机管理</a>
        </li>
        <li class="active">矿机列表</li>
    </ul>
</div>

<div class="page-content">
    <form class="form-horizontal" action="<?php echo \yii\helpers\Url::to(['/order/index']) ?>" method="post"
          role="form">

        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">

        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-lg-3 col-sm-6">
                <label class="col-sm-4 control-label">用户名</label>
                <div class="col-sm-8">
                    <input type="text" name="mobile" value="" placeholder="请输入会员用户名" class="form-control">
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 ">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-search orange"></i>搜索
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="reset()">
                    <i class="ace-icon fa fa-repeat"></i>重置
                </button>
            </div>
        </div>
    </form>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">矿机编号</th>
                <th class="center">会员用户名</th>
                <th class="center">矿机名</th>
                <th class="center">矿机类型</th>
                <th class="center">算力</th>
                <th class="center">周期（已运行/剩余）</th>
                <th class="center">每日产量</th>
                <th class="center">产量（当前/剩余）</th>
                <th class="center">购买时间</th>
                <th class="center">状态</th>
                <th class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $v) { ?>
                <tr>
                    <td class="center"><?php echo $v['product_number']; ?></td>
                    <td class="center"><?php echo $v['mobile']; ?></td>
                    <td class="center"><?php echo $v['product_name']; ?></td>
                    <td class="center"><?php echo $v['product_category_name']; ?></td>
                    <td class="center"><?php echo $v['num']; ?></td>
                    <td class="center"><?php echo $v['t_count']; ?>/<?= $v['day'] - $v['t_count'] ?></td>
                    <td class="center"><?php echo $v['day_rate']; ?></td>
                    <td class="center"><?php echo $v['t_count'] * $v['day_rate']; ?>/<?= ($v['day'] - $v['t_count']) * $v['day_rate'] ?></td>
                    <td class="center"><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                    <td class="center"><?php echo $productOrder->getStatus($v['status']); ?></td>
                    <td class="center">
                        <?php if ($v['status'] == 1) { ?>
                        <a href="<?php echo \yii\helpers\Url::to(['status', 'uid' => $v['id'], 'status' => 2]); ?>">停止</a>
                        <?php } ?>
                        <?php if ($v['status'] == 2) { ?>
                        <a href="<?php echo \yii\helpers\Url::to(['status', 'uid' => $v['id'], 'status' => 1]); ?>">启动</a>
                        <?php } ?>
                        <a href="<?php echo \yii\helpers\Url::to(['delete', 'uid' => $v['id']]); ?>">删除</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pagination]); ?>
    </div>
    <ul class="pagination" style="float: right">

    </ul>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>


