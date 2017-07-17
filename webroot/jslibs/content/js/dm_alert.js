/**
 * Created by chenzhenxing on 2017/2/4.
 */
/*
 * $.AlertDialog.CreateAlert(title,info);
 * title : 标题
 * info ： 提示信息
 * 使用示例 ： $.AlertDialog.CreateAlert("警告","用户名不可为空!");
 */
$.AlertDialog = {
    CreateAlert: function(title,info){
        var alertDialog = $("<div class='alert-mask'>" +
            "<div class='alert-dailog'>"+
            "<div class='alert-hd'>"+ title +"!</div>"+
            "<div class='alert-infor'>"+ info +"</div>"+
            "<div class='btn-group'>"+
            "</div>"+
            "</div>"+
            "</div>");
        var closeAlertBtn = $("<button>关&nbsp;&nbsp;闭<tton>");
        closeAlertBtn.on('click',function(){
            $(this).parents(".alert-mask").remove();
        });
        alertDialog.find(".btn-group").append(closeAlertBtn);;
        $("body").append(alertDialog);
    }
};
