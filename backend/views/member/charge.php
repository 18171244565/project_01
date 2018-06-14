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
            <a href="<?=Yii::$app->urlManager->createUrl(['member/list'])?>">会员管理</a>
        </li>
        <li class="active">会员充值</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?=Yii::$app->urlManager->createUrl(['member/list'])?>" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=Yii::$app->urlManager->createUrl(['member/charge'])?>" role="form">
      <input type="hidden" name="_csrf-backend" id="_crsf" value="<?=Yii::$app->request->csrfToken;?>">
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-6">
                <input type="text" name="ChargeModel[mobile]" value="<?=$model->mobile?>" placeholder="请输入用户名" class="form-control" id="mobile"><span></span>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">充值虚拟币</label>
            <div class="col-sm-6">
                <input type="text" name="ChargeModel[money]" value="<?=$model->money?>" placeholder="请输入虚拟币数量" class="form-control">
            </div>
        </div>
        
        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">充值</button>
            </div>
        </div>
    </form>
    <hr>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">用户名</th>
                <th class="center">充值数量</th>
                <th class="center">充值时间</th>
            </tr>
            </thead>
            <tbody>
            <?php $member = new \common\models\Member(); ?>
            <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td class="center"><?= $member->getMobile($v['member_id']) ?></td>
                    <td class="center"><?= $v['money'] ?></td>
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
<?php
           $errors = $model->getErrors();
          // dump($errors);
           $new_errors = array_values($errors);
           if($new_errors){
               $alert_error = $new_errors[0][0];
           }else{
               $alert_error = null;
           }

?>

<script>
   var error = '<?=$alert_error?>';
   if(error){
       alert(error);
   }
 </script>

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
