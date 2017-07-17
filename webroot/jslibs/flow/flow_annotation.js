

//*门店数据注解
var annotation_url = "";
$(".dmevent_store").click(
    function(){
        var idcard = $("#idcard_value").val();
        $.ajax({
            type:'post',
            url: url ,
            data:{idcard:idcard},
            dataType:'json',
            async: true
        })
        .success(function(data){
            if(data)
            {
                $(":input").each(function(){
                    var info = $(this).attr("info");
                    if(info != undefined)
                    {
                        if(info == "username"){
                            $(this).val(data.STAFFNAME);
                        }
                    }
                });
            }else{

                alert("无信息")
            }
        })
        .error(function(data){

            alert("请输入员工信息")
        });
    }
);