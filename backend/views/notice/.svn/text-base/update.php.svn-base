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
            <a href="#">公告管理</a>
        </li>
        <li class="active">修改公告</li>
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
        <input type="hidden" value="<?php echo $data['id']; ?>" name="uid">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?=Yii::$app->request->csrfToken;?>">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">公告标题</label>

            <div class="col-sm-6">
                <input type="text" name="Notice[title]" value="<?php echo $data['title']; ?>" placeholder="请输入公告标题"
                       class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                公告标题不能为空
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">公告内容</label>

            <div class="col-sm-6">
                <textarea class="form-control" style="resize: none" rows="5" name="Notice[content]"><?php echo $data['content']; ?></textarea>
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>

            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">确定修改</button>
            </div>
        </div>
    </form>
</div>
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
