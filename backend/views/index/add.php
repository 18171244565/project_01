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
            <a href="#">会员管理</a>
        </li>
        <li class="active">添加会员</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="u-user" class="btn btn-sm btn-danger">
        <i class="icon-reply icon-only"></i>
        返回列表
    </a>
</h3>

<div class="page-content">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="u-user-add" role="form">
        <input type="hidden" name="_token" value="iDF70RWUxHji9lQtwkTvsowdoSP6uM8gvHG4oQMa">

        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">用户名</label>

            <div class="col-sm-6">
                <input type="text" name="User[nick_name]" value="" placeholder="请输入用户名" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                用户名不能为空
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">电话号码</label>

            <div class="col-sm-6">
                <input type="text" name="User[phone]" value="" placeholder="请输入电话号码" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                电话号码不能为空
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">邮箱地址</label>

            <div class="col-sm-6">
                <input type="email" name="User[email]" value="" placeholder="请输入邮箱地址" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                邮箱地址不能为空
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">会员类型</label>

            <div class="col-sm-3">
                <select name="User[type]" class="form-control">
                    <option value="">请选择会员类型</option>
                    <option value="1">普通会员</option>
                    <option value="2">自媒体</option>
                    <option value="3">手艺人</option>
                    <option value="4">设计师</option>
                </select>
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">登录密码</label>

            <div class="col-sm-6">
                <input type="password" name="User[password]" value="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">
                密码由6-16位数字和字母，特殊字符组成
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">确认密码</label>

            <div class="col-sm-6">
                <input type="password" name="User[password_confirmation]" value="" class="form-control">
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">地区</label>

            <div class="col-sm-2">
                <select class="form-control" name="User[province]" onchange="getCity(this)" id="province"></select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="User[city]" onchange="getQuxian(this)" style="display: none"
                        id="city"></select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="User[quxian]" style="display: none" id="quxian"></select>
            </div>
            <div class="col-sm-3 help-block">

            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">头像</label>

            <div class="col-sm-6 input-group">
                <input type="text" name="User[header]" value="" class="form-control">
                    <span class="input-group-addon " onclick="showUploadModal(this,'upload?dirname=header')"
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
        </div>
        <div class="form-group col-sm-12">
            <label class="col-sm-2 control-label">用户描述</label>

            <div class="col-sm-6">
                <textarea class="form-control" style="resize: none" rows="5" name="User[name_dsc]"></textarea>
            </div>
            <div class="col-sm-3 help-block">

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
