<link href="/admin/addons/webUploader/webuploader.css" rel="stylesheet">
<link href="/admin/addons/webUploader/demo.css" rel="stylesheet">
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed')
        } catch (e) {
        }
    </script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">矿机管理</a>
        </li>
        <li class="active">矿机信息修改</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?php echo \yii\helpers\Url::to(['index']); ?>" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="" role="form">

        <input type="hidden" value="<?php echo \Yii::$app->getRequest()->getCsrfToken(); ?>" name="_csrf">
        <input type="hidden" value="<?php echo $data['id']; ?>" name="Product[id]">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机名</label>

            <div class="col-sm-6">
                <input type="text" name="Product[name]" value="<?php echo $data['name']; ?>"
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                请填写矿机名
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机分类名</label>

            <div class="col-sm-6">
                <input type="text" name="Product[category_name]" value="<?php echo $data['category_name']; ?>"
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                请填写矿机分类名（迷你矿机；小型矿机；中型框架；大型矿机；巨型矿机）
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">机号前缀</label>

            <div class="col-sm-6">
                <input type="text" name="Product[t]" value="<?php echo $data['t']; ?>"
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                请填写机号前缀（生成矿机编号使用）
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机价格</label>

            <div class="col-sm-6">
                <input type="number" name="Product[price]" value="<?php echo $data['price']; ?>" placeholder=""
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                矿机价格大于0
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机有效天数（天）</label>

            <div class="col-sm-6">
                <input type="number" name="Product[day]" value="<?php echo $data['day']; ?>" placeholder=""
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                有效天数大于0（单位：天）
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机每日收益</label>

            <div class="col-sm-6">
                <input type="text" name="Product[day_rate]" value="<?php echo $data['day_rate']; ?>"
                       placeholder=""
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                矿机每日产生收益
            </div>
        </div>


        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">玩家限购数量</label>

            <div class="col-sm-6">
                <input type="number" name="Product[max]" value="<?php echo $data['max']; ?>"
                       placeholder="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                0表示无上限
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">矿机算力</label>

            <div class="col-sm-6">
                <input type="number" name="Product[num]" value="<?php echo $data['num']; ?>"
                       placeholder="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                算力大于0的整数
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">剩余数据</label>

            <div class="col-sm-6">
                <input type="number" name="Product[counts]" value="<?php echo $data['counts']; ?>"
                       placeholder="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
            </div>
        </div>


        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>

            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">确认修改</button>
            </div>
        </div>
    </form>
</div>
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
