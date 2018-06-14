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
        <li class="active">添加会员</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="<?=Yii::$app->urlManager->createUrl(['member/list'])?>" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=Yii::$app->urlManager->createUrl(['member/add-update','uid'=>$user_info['id']])?>" role="form">
        <input type="hidden" name="_csrf-backend" id="_crsf" value="<?=Yii::$app->request->csrfToken;?>">

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">用户名</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[mobile]" value="<?=$user_info ? $user_info['mobile']:$model->mobile?>" placeholder="请输入电话号码" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">真实姓名</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[name]" value="<?=$user_info ? $user_info['name']:$model->name?>" placeholder="请输入真实姓名" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">登录密码</label>

            <div class="col-sm-6">
                <input type="password" name="MemberModel[passwd]" value="<?=$user_info['passwd']?>" placeholder="请输入登录密码" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">交易密码</label>

            <div class="col-sm-6">
                <input type="password" name="MemberModel[charge_passwd]" value="<?=$user_info['charge_passwd']?>" placeholder="请输入交易密码" class="form-control">
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">虚拟币</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[money]" value="<?=$user_info ? $user_info['money']:$model->money?>" placeholder="请输入虚拟币" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">上级</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[p_id]" value="<?=$user_info ? getNameId($user_info['p_id']):$model->p_id?>" placeholder="请输入上级" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">会员等级</label>

            <div class="col-sm-3">
                <select name="MemberModel[level]" class="form-control">
                    <option value="10" <?=$user_info['level'] == 10 ? 'selected' : ''?> >普通会员</option>
                    <option value="0" <?=$user_info['level'] == 0 ? 'selected' : ''?>>普通矿工</option>
                    <option value="1" <?=$user_info['level'] == 1 ? 'selected' : ''?>>一级矿工</option>
                    <option value="2" <?=$user_info['level'] == 2 ? 'selected' : ''?>>二级矿工</option>
                    <option value="3" <?=$user_info['level'] == 3 ? 'selected' : ''?>>三级矿工</option>
                    <option value="4" <?=$user_info['level'] == 4 ? 'selected' : ''?>>四级矿工</option>
                </select>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">微信</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[weixin]" value="<?=$user_info ? $user_info['weixin']:$model->weixin?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">支付宝</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[zhifubao]" value="<?=$user_info ? $user_info['zhifubao']:$model->zhifubao?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">开户行</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[bank_name]" value="<?=$user_info ? $user_info['bank_name']:$model->bank_name?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">卡号</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[bank_card]" value="<?=$user_info ? $user_info['bank_card']:$model->bank_card?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">银行预留手机号</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[bank_mobile]" value="<?=$user_info ? $user_info['bank_mobile']:$model->bank_mobile?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">身份证号</label>

            <div class="col-sm-6">
                <input type="text" name="MemberModel[id_card]" value="<?=$user_info ? $user_info['id_card']:$model->id_card?>" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12" style="margin-top: 50px">
            <label class="col-sm-2 control-label"></label>
            <input type="hidden" name="MemberModel[uid]" value="<?=$user_info ? $user_info['id']:$model->uid?>">
            <div class="col-sm-5">
                <button type="submit" class="btn btn-sm btn-primary">保存</button>
            </div>
        </div>
    </form>
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
<script src="/admin/js/upload.plugin.js"></script>
<script src="/admin/addons/webUploader/webuploader.js"></script>
