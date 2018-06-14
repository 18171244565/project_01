
window.onload = function(){
    getProvince();
}

function getProvince(){
    $.get('/get-province',function(data){
        if(data.code == 0){
            alert(data.message);return;
        }
        var options = "<option value='0'>选择省份</option>";
        var list = data.data
        for(var i in list){
            options += "<option value='"+list[i].region_id+"'>"+list[i].region_name+"</option>";
        }
        $("#province").html(options)
    },'json')
}

function getCity(elem){
    if($(elem).val() == 0){
        $("#city").css('display','none')
        return;
    }
    var province_id = $(elem).val();
    $.get('/get-city',{province_id:province_id},function(data){
        if(data.code == 0){
            alert(data.message);return;
        }
        var options = "<option value='0'>选择城市</option>";
        var list = data.data
        for(var i in list){
            options += "<option value='"+list[i].region_id+"'>"+list[i].region_name+"</option>";
        }
        $("#city").html(options)
        $("#city").css('display','block')
    },'json')
}

function getQuxian(elem){
    if($(elem).val() == 0){
        $("#quxian").css('display','none')
        return;
    }
    var city_id = $(elem).val();
    $.get('/get-quxian',{city_id:city_id},function(data){
        if(data.code == 0){
            alert(data.message);return;
        }
        var options = "<option value='0'>选择城市</option>";
        var list = data.data
        for(var i in list){
            options += "<option value='"+list[i].region_id+"'>"+list[i].region_name+"</option>";
        }
        $("#quxian").html(options)
        $("#quxian").css('display','block')
    },'json')
}
