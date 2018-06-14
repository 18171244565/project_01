<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">会员管理</a>
        </li>
        <li class="active">充值申请</li>
    </ul>
</div>

<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?php echo \yii\helpers\Url::to(['recharge-list', 'status' => 1]); ?>"
       class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>待充值
    </a>
    <a href="<?php echo \yii\helpers\Url::to(['recharge-list', 'status' => 2]); ?>"
       class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>充值成功
    </a>
</h3>

<div class="page-content">
    <?php $recharge = new \common\models\Recharge(); ?>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">用户号</th>
                <th class="center">填写的用户号</th>
                <th class="center">金额（元）</th>
                <th class="center">状态</th>
                <th class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $v) { ?>
                <tr>
                    <td class="center" width="100px"><?php echo $v['mobile']; ?></td>
                    <td class="center"><?php echo $v['number']; ?></td>
                    <td class="center">
                        <?php echo $v['money'] / 100; ?>
                    </td>
                    <td class="center">
                        <?php echo $recharge->getStatus($v['status']) ?>
                    </td>
                    <td class="center" width="300px">
                        <?php if ($v['status'] == 1) { ?>
                            <a href="<?php echo \yii\helpers\Url::to(['delete-recharge', 'uid' => $v['id']]); ?>">删除</a>
                            <a href="<?php echo \yii\helpers\Url::to(['sure-recharge', 'uid' => $v['id']]); ?>">确认</a>
                        <?php } else { ?>
                            <a href="#">无操作</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pagination]); ?>
    </div>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>
