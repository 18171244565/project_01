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
            <a href="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>">会员管理</a>
        </li>
        <li class="active">仓库释放</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <h5 style="color: red;">点击释放后请耐心等待</h5>
    <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">仓库释放（%）</label>
            <div class="col-sm-6">
                <input type="number" id="u" name="u" value="" placeholder="请输入释放比例（整数）" class="form-control">
            </div>
        </div>

        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary sure">释放</button>
            </div>
        </div>
    </form>
    <hr>

</div>
<script>
    var url = '<?= \yii\helpers\Url::to(['money-lock']) ?>';
    var token = '<?= \Yii::$app->getRequest()->getCsrfToken() ?>';
    $('.sure').click(function () {
        var u = $('#u').val();
        if (confirm('确认释放？确认后请耐心等待')) {
            $.post(url, {u: u, "_csrf-backend": token}, function (data) {
                alert(data.message);
            }, 'json');
        }
        return false;
    });
</script>
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
