var playerBox = "";
function player(links){
    if(playerBox != ''){
        playerBox.close();
    }
    playerBox = $.jsPanel({
        id:"playerBox",
        maximizedMargin: {
            top:    50,
        },
        contentSize:  {width: 510, height: 495},
        headerTitle: "视频播放",
        content:     "<iframe height=498 width=510 src='"+links+"' frameborder=0  allowfullscreen></iframe>",
    });
}
$(document).on('jspanelmaximized',function(event,id){
    if(id == "playerBox"){
        var width = $("#"+id).css('width');
        var height = parseInt($("#"+id).css('height')) -50;
        $("#"+id).find('iframe').attr('width',width) ;
        $("#"+id).find('iframe').attr('height',height) ;
    }
    //alert(id)
})
$(document).on('jspanelnormalized',function(event,id){
    if(id == "playerBox"){
        $("#"+id).find('iframe').attr('width',510) ;
        $("#"+id).find('iframe').attr('height',498) ;
    }
})
