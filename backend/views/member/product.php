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
        <li class="active">会员产品发放</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?= Yii::$app->urlManager->createUrl(['member/list']) ?>" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data"
          action="<?= Yii::$app->urlManager->createUrl(['member/product']) ?>" role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?= Yii::$app->request->csrfToken; ?>">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-6">
                <input type="text" name="mobile" value="" placeholder="请输入用户名"
                       class="form-control" id="mobile"> <span></span>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">发放产品</label>
            <div class="col-sm-6">
                <select name="product_id" id="" class="form-control">
                    <?php foreach ($product as $v) { ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">发放数量</label>
            <div class="col-sm-6">
                <select name="num" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>

        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">发放</button>
            </div>
        </div>
    </form>
    <hr>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">用户名</th>
                <th class="center">矿机名</th>
                <th class="center">发放时间</th>
            </tr>
            </thead>
            <tbody>
            <?php $member = new \common\models\Member(); ?>
            <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td class="center"><?= $member->getMobile($v['member_id']) ?></td>
                    <td class="center"><?= $v['product_name'] ?></td>
                    <td class="center"><?= date('Y-m-d H:i:s', $v['create_time']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination pright">
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
            </ul>
        </nav>
    </div>
</div>
<script>
    $(function () {

        $('#mobile').focus(function () {
            var tishi = $(this).next();
            tishi.html('');
        });

        $('#mobile').blur(function () {
            var mobile = $(this).val();
            var tishi = $(this).next();
            var url = "<?php echo \yii\helpers\Url::to(['check-mobile'])?>";
            if (mobile == '' || mobile === null) {
                tishi.html('请填写发放账号');
                tishi.css('color', 'red');
                return false;
            }
            $.ajax({
                url: url,
                type: 'get',
                data: 'mobile=' + mobile,
                dataType: 'json',
                success: function (data) {
                    var message = data.message;
                    tishi.html(message);
                    tishi.css('color', 'red');
                }
            });
            return false;
        })
    })

</script>
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
