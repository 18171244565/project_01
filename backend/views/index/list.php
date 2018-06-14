<link href="/admin/css/foundation-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/admin/assets/css/chosen.css"/>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">内容管理</a>
        </li>
        <li class="active">文章管理</li>
    </ul>
</div>
<h3 class="header smaller lighter grey" style="padding-left: 15px">
    <a href="p-post-add" class="btn btn-sm btn-primary">
        <i class="icon-plus"></i>新建
    </a>
</h3>
<div class="page-content">
    <form class="form-horizontal" action="p-post" method="post" role="form">
        <input type="hidden" name="_token" value="iDF70RWUxHji9lQtwkTvsowdoSP6uM8gvHG4oQMa">

        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-lg-3 col-sm-6">
                <label class="col-sm-4 control-label">内容名称</label>

                <div class="col-sm-8">
                    <input type="text" name="title" value="" placeholder="请输入内容名称" class="form-control">
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 multiselect-box">
                <label class="col-sm-4 control-label">分类</label>

                <div class="col-sm-8">
                    <select name="cate_id" class="form-control" id="cont_category">
                        <option value="0">全部分类</option>
                        <option value="8">手工</option>
                        <option value="10">&nbsp;&nbsp;&nbsp;&nbsp;旧物改造</option>
                        <option value="12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;测试的122</option>
                        <option value="11">测试的</option>
                        <option value="13">&nbsp;&nbsp;&nbsp;&nbsp;测试的3</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <label class="col-sm-4 control-label">发布状态</label>

                <div class="col-sm-8">
                    <select name="is_public" class="form-control">
                        <option value="0">请选择</option>
                        <option value="1">未发布</option>
                        <option value="2">已发布</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <label class="col-sm-4 control-label">编辑状态</label>

                <div class="col-sm-8">
                    <select name="status" class="form-control">
                        <option value="">请选择</option>
                        <option value="5">审核不通过</option>
                        <option value="1">编辑中</option>
                        <option value="3">待审核</option>
                        <option value="4">审核通过</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 15px;height: 30px">
            <div class="col-md-3 date-box">
                <label class="col-sm-4 control-label" for="createBeginTime">创建开始时间
                </label>

                <div class="col-sm-8 input-group">
                    <input type="text" value="" name="begin" class="form-control date-select"
                           id="createBeginTime"
                           placeholder="创建时间"> <span class="input-group-addon">
                            <i class="icon-th"></i>
                        </span>
                </div>
            </div>

            <div class="col-md-3 date-box">
                <label class="col-sm-4 control-label" for="createEndTime">创建结束时间
                </label>

                <div class="col-sm-8 input-group">
                    <input type="text" name="end" value="" id="createEndTime"
                           class="form-control date-select"
                           placeholder="创建时间"> <span class="input-group-addon"> <i class="icon-th"></i>
                        </span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 ">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-search orange"></i>搜索
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="reset()">
                    <i class="ace-icon fa fa-repeat"></i>重置
                </button>
            </div>
        </div>
    </form>
    <div class="table-responsive" style="margin-top: 35px">
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center" width="80px">序号</th>
                <th class="center">标题</th>
                <th class="center">分类</th>
                <th class="center">视频</th>
                <th class="center">创建者/创建时间</th>
                <th class="center">状态</th>
                <th class="center">浏览次数</th>
                <th class="center">点赞次数</th>
                <th class="center" width="300px">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center" width="100px">1</td>
                <td class="center">東西物语 | 创意折纸 - 收纳盒9</td>
                <td class="center">测试的122</td>
                <td class="center">
                    <button onclick="myPlayer(this)"
                            vedio-url="http://player.youku.com/player.php/sid/XMjUxNzc4NzU4OA==/v.swf"
                            class="btn btn-sm btn-info">播放
                    </button>
                </td>
                <td>
                    创建者：系统发布<br/>
                    创建时间：2017-02-19 16:55
                </td>
                <td>
                    编辑状态：审核通过<br/>
                    发布状态： 已发布
                </td>
                <td class="center">0</td>
                <td class="center">0</td>
                <td class="center" width="300px">
                    <a href="javascript:void(0)">预览</a>
                    <a onclick="changePost(this,'nopublic')" data-id="4" href="javascript:void(0)">撤销发布</a>
                    <a onclick="changePost(this,'delete')" data-id="4" href="javascript:void(0)">删除</a>
                </td>
            </tr>
            <tr>
                <td class="center" width="100px">2</td>
                <td class="center">東西物语 | 手工编织 - 少女心爆棚耳环</td>
                <td class="center">手工</td>
                <td class="center">
                    <button onclick="myPlayer(this)"
                            vedio-url="http://player.youku.com/player.php/sid/XMjQ5NTkwMzQzNg==/v.swf"
                            class="btn btn-sm btn-info">播放
                    </button>
                </td>
                <td>
                    创建者：系统发布<br/>
                    创建时间：2017-02-11 11:28
                </td>
                <td>
                    编辑状态：审核失败<br/>
                    发布状态： 未发布
                </td>
                <td class="center">0</td>
                <td class="center">0</td>
                <td class="center" width="300px">
                    <a href="javascript:void(0)">预览</a>
                    <a href="p-post-edit/3">编辑</a>
                    <a onclick="changePost(this,'verify')" data-id="3" href="javascript:void(0)">提交审核</a>
                    <a onclick="showModalNoVerify(this)" data-reason="测试的" data-id="3"
                       href="javascript:void(0)">查看驳回缘由</a>
                    <a onclick="changePost(this,'delete')" data-id="3" href="javascript:void(0)">删除</a>
                </td>
            </tr>
            <tr>
                <td class="center" width="100px">3</td>
                <td class="center">東西物语 | 手工编织 - 幸运手链</td>
                <td class="center">手工</td>
                <td class="center">
                    <button onclick="myPlayer(this)"
                            vedio-url="http://player.youku.com/player.php/sid/XMjUwMDU3NzY0OA==/v.swf"
                            class="btn btn-sm btn-info">播放
                    </button>
                </td>
                <td>
                    创建者：系统发布<br/>
                    创建时间：2017-02-11 10:18
                </td>
                <td>
                    编辑状态：编辑中<br/>
                    发布状态： 未发布
                </td>
                <td class="center">0</td>
                <td class="center">0</td>
                <td class="center" width="300px">
                    <a href="javascript:void(0)">预览</a>
                    <a href="p-post-edit/2">编辑</a>
                    <a onclick="changePost(this,'verify')" data-id="2" href="javascript:void(0)">提交审核</a>
                    <a onclick="changePost(this,'delete')" data-id="2" href="javascript:void(0)">删除</a>
                </td>
            </tr>
            <tr>
                <td class="center" width="100px">4</td>
                <td class="center">東西物语 | 手工折纸 - 独一无二的礼品袋</td>
                <td class="center">手工</td>
                <td class="center">
                    <button onclick="myPlayer(this)"
                            vedio-url="http://player.youku.com/player.php/sid/XMjUwMzYxNDIxMg==/v.swf"
                            class="btn btn-sm btn-info">播放
                    </button>
                </td>
                <td>
                    创建者：系统发布<br/>
                    创建时间：2017-02-11 09:56
                </td>
                <td>
                    编辑状态：编辑中<br/>
                    发布状态： 未发布
                </td>
                <td class="center">0</td>
                <td class="center">0</td>
                <td class="center" width="300px">
                    <a href="javascript:void(0)">预览</a>
                    <a href="p-post-edit/1">编辑</a>
                    <a onclick="changePost(this,'verify')" data-id="1" href="javascript:void(0)">提交审核</a>
                    <a onclick="changePost(this,'delete')" data-id="1" href="javascript:void(0)">删除</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <ul class="pagination" style="float: right">

    </ul>
</div>
<script src="/admin/assets/js/chosen.jquery.min.js"></script>
<script src="/admin/js/dateTime/foundation-datepicker.js"></script>
<script src="/admin/js/dateTime/locales/foundation-datepicker.zh-CN.js"></script>
<script>
    $("#cont_category").chosen();
    $('#chosen-multiple-style').on('click', function (e) {
        var target = $(e.target).find('input[type=radio]');
        var which = parseInt(target.val());
        if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
        else $('#form-field-select-4').removeClass('tag-input-style');
    });
    $(".date-select").fdatepicker({format: 'yyyy-mm-dd'});
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#createBeginTime').fdatepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.update(newDate);
        }
        checkin.hide();
        $('#createEndTime')[0].focus();
    }).data('datepicker');
    var checkout = $('#createEndTime').fdatepicker({
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
    }).data('datepicker');
</script>

