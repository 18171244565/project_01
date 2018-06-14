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
            <a href="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>">管理员</a>
        </li>
        <li class="active">管理员密码修改</li>
    </ul>
</div>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data"
          action="" role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">新密码</label>
            <div class="col-sm-6">
                <input type="text" name="passwd" value="" placeholder="请输入新密码" class="form-control"
                       id="mobile"><span></span>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">重复密码</label>
            <div class="col-sm-6">
                <input type="text" name="rpasswd" value="" placeholder="请输入确认密码" class="form-control">
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
