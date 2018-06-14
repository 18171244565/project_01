function size(originw, type) {
    var type = type || "x";
    if (type == "x") {
        var clientw = document.documentElement.clientWidth;
        var originw = originw;
        var bili = clientw / originw * 100 + "px";
        document.getElementsByTagName("html")[0].style.fontSize = bili;
    } else if (type == "y") {
        var clienth = document.documentElement.clientHeight;
        var originh = originw;
        var bili = clienth / originh * 100 + "px";
        document.getElementsByTagName("html")[0].style.fontSize = bili;
    }

}
size(720, "x");
//屏幕尺寸改变时候，动态改变html的font-size值
addEventListener("resize", function () {
    size(720, "x");
});

mui.init();
mui('body').on('tap', 'a', function () {
    window.top.location.href = this.href;
});
mui(".mui-scroll-wrapper").scroll({
    bounce: true,//滚动条是否有弹力默认是true
    indicators: true, //是否显示滚动条,默认是true
    deceleration: 0.0005
});

function showUserInfo(target) {
    var url = $(target).attr('data-url');
    var type = $(target).attr('data-type');
    var title = type == 1 ? '卖家资料' : (type == 2 ? '买家资料' : '对方资料')
    $.get(url, function (response) {
        $("#popover").find("#title").html(title);
        $("#popover").find("#accountName").val(response.name);
        $("#popover").find("#openingBank").val(response.bank_name);
        $("#popover").find("#cardNumber").val(response.bank_card);
        $("#popover").find("#weixin").val(response.weixin);
        $("#popover").find("#alipay").val(response.zhifubao);
        $("#popover").find("#tel").val(response.bank_mobile);
        mui('#popover').popover('show');
    }, 'json');
}

function SaleOrder(target) {
    var orderId = $(target).attr('data-id');
    var url = $(target).attr('data-url');
    var btnArray = ['取消', '确定'];
    var token = $("meta[name=token]").attr('content');
    var $this = $(target);
    $this.attr('disabled', true);
    $this.html('处理中...')
    mui.confirm('你确定卖给ta吗？', '', btnArray, function (e) {
        if (e.index == 1) {
            $.post(url, {orderId: orderId, '_csrf-frontend': token}, function (data) {
                mui.alert(data.message, function () {
                    window.location.reload();
                })
            }, 'json')
        }
    })
}

function selectFile() {
    $("#image_file").click();
}

function uploadImage(target) {
    var $this = $(target);
    var url = $this.attr('data-url');
    var file = target.files[0];
    var orderId = $this.attr('data-id');
    if (file.length == 0) {
        mui.alert('请选择需要上传的图片');
        return false;
    }
    var token = $("meta[name=token]").attr('content');
    var data = new FormData();
    data.append('_csrf-frontend', token);
    data.append('UploadForm[file]', file);
    data.append('orderId', orderId);
    $("#select_file").html('上传中...');
    $("#select_file").attr('disabled', true);
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false,  // 告诉jQuery不要去处理发送的数据
        contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
        dataType: 'json',
        success: function (response) {
            $("#select_file").html('重新上传');
            $("#select_file").attr('disabled', false);
            if (response.code == 0) {
                mui.alert(response.message);
            } else {
                $("#show_image").attr('data-image', response.url);
                $("#show_image").show();
                mui.alert('上传成功');
            }
        }
    })
}

function showImage(e) {
    var url = $(e).attr('data-image');
    dialog(url);
}

function dialog(url) {
    var context = '<div id="dialog_box" style="display: none" class="dialog"><div class="dialog_market"></div><div class="dialog_content"><img src="' + url + '"><div class="dialog_footer" onclick="closeDialog(this)">关闭</div></div></div>';
    $("body").append(context);
    $("#dialog_box").show();
}

function closeDialog(e) {
    $(e).parents('#dialog_box').hide();
    $("#dialog_box").remove();
}

/*$('.copy').on('click', function () {
    var id = $(this).attr('data-clipboard-target');
    var value = $(id).val();
    $(this).attr('data-clipboard-text', value);
    var clipboard = new Clipboard($(this)[0]);
    clipboard.on('success', function (e) {
        mui.alert('复制成功');
    });
    clipboard.on('error', function (e) {
        mui.alert('复制失败');
    });
})*/
