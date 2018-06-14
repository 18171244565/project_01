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
            <a href="#">产品管理</a>
        </li>
        <li class="active">添加产品</li>
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
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">产品名</label>

            <div class="col-sm-6">
                <input type="text" name="Product[name]" value="" placeholder="请输入用户名" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                请填写产品名
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">产品描述</label>

            <div class="col-sm-6">
                <textarea class="form-control" style="resize: none" rows="5" name="Product[content]"></textarea>
            </div>
            <div class="col-sm-3 help-block">
                请填写描述
            </div>
        </div>
<!--
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">产品图片</label>

            <div class="col-sm-6 input-group">
                <input type="text" name="Product[img]" value="" class="form-control">
                <span class="input-group-addon " onclick="showUploadModal(this,'<?php echo \yii\helpers\Url::to(['/upload/upload']); ?>')"
                      style="cursor: pointer">上传图片</span>
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label"></label>

            <div class="col-sm-6">
                <img src="/admin/images/nopic.jpg" class="img-responsive img-thumbnail" width="150">
                <em class="close" style="position:absolute; top: 0px; " title="删除这张图片"
                    img-defalut="images/nopic.jpg" onclick="deleteImage(this)">×</em>
            </div>
        </div>-->

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">售卖价格（元）</label>

            <div class="col-sm-6">
                <input type="number" name="Product[price]" value="" placeholder="请输入售卖价格" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                售卖价格大于0的整数（单位：元）
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">理财有效天数（天）</label>

            <div class="col-sm-6">
                <input type="number" name="Product[day]" value="" placeholder="请输入有效天数" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                有效天数大于0（单位：天）
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">理财每日收益（元）</label>

            <div class="col-sm-6">
                <input type="text" name="Product[day_rate]" value="" placeholder="理财每日收益" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                有效天数大于0（单位：天）
            </div>
        </div>


        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">每日发放数量</label>

            <div class="col-sm-6">
                <input type="number" name="Product[day_to_sell]" value="0" placeholder="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                0表示无上限
            </div>
        </div>


        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>

            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">保存</button>
            </div>
        </div>
    </form>
</div>
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
