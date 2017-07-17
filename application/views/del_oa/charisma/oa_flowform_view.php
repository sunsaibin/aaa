<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-flag"></i> 填写审批表</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>

<div >
   <div class="form-group col-xs-6 col-md-3">
<!--     <label class="col-sm-4 control-label">输入员工信息:</label> -->

</div>


</div>

    <div class="box-content">

        <!-- <div style="float:right;list-style-type:none;">
            <div class="btn-group">
                <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新建审批</a>
            </div>
        </div> -->
        <?php if($_POST['flow_flowstep'] != 2){ ?>
        <div  >
            <div class="col-md-2">
            <input type="text" class="form-control" id="idcard_value" name="idcard_value"  value="请输入员工姓名,员工编号,身份证号码" onfocus="if(value=='请输入员工姓名,员工编号,身份证号码') {value=''}" onblur="if (value=='') {value='请输入员工姓名,员工编号,身份证号码'}"/>
            </div>
            <button type="button" id="checkuser" class="btn btn-success"> 查 询</button> 
        </div>   
        <?php } ?> 
        <div class="container-fluid" style="margin-top:20px;">
        <?php 

            //print_r($query);

            $flowFormHtml = ""; 
            $flowFormitems = ""; 
            $flowformid = "";
            $flowstepid = "5";
            $flowid = "";
            if (isset($query)) {
                foreach ($query as $key => $value) {
                    $flowFormHtml .= $value->flowform_html;
                    $flowFormitems .= $value->flowform_formitems;
                    $flowformid = $value->flowform_id;
                    $flowstepid = $value->flowstep_id;
                    $flowid = $value->ff_flow;
                }
            }
        ?>
        <form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("del_oa/oa_form");?>">
            <?php echo $flowFormHtml; ?>
            <div class="form-group col-xs-12">
                <label>批注：</label>
                <div>
                    <textarea class="form-control" rows="5" id="explain" name="explain"></textarea>
                </div>
            </div>
            <div style="float:right;list-style-type:none;margin-right: 32px;">
                <div class="form-actions" >
                  <button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
            <input type="hidden" name="adopt" id="adopt" value="0" event_dm="staff">
            <input type="hidden" name="usertype" value="1" class="store staff">
            <input type="hidden" name="company" value="1">
            <input type="hidden" name="flowid" value="<?php echo $flowid;?>">
            <input type="hidden" name="flowstepid" value="<?php echo $flowstepid; ?>">
            <input type="hidden" name="flowformid" value="<?php echo $flowformid; ?>">
            <input type="hidden" name="formitems" value="<?php echo $flowFormitems; ?>">
            <input type="hidden" name="userid" value="<?php echo $_SESSION["userid"];?>">
            <input type="hidden" name="randid" id="randid" value="<?php echo md5(uniqid("",true)); ?>">
            <input type="hidden" name="url" id="url" value="<?php echo  $url =  site_url('Oa/staff_ajax?type=');?>">
            <input type="hidden" name="roleurl " id="roleurl" value="<?php echo  $roleurl =  site_url('Flow_block/role_url?type=');?>">
        </form>
        </div>
    </div>
    
    </div>
    </div>
    <!--/span-->
    
    <!-- end show model -->

    </div><!--/row-->

<script type="application/javascript">   
   var url = $("#url").attr("value");

   $(".store").click(
       function(){
           alert(111);
       }
   );

   $("input[event_dm='store'").click(
       function(){
           alert(111);
       }
   );

    $('#checkuser').click(function(){
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
                   if(info == "storeinfo"){
                     $(this).val(data.STORENAME);
                   }
                   if(info == "department"){
                    /* $(this).value(data.STAFFNAME);   */                 
                   }
                   if(info == "position"){
                     $(this).val(data.RULENAME);
                   }
                    if(info == "staffnumber"){
                     $(this).val(data.STAFFNUMBER);
                   }
                    if(info == "storeid"){
                     $(this).val(data.STOREID);
                   }
                    if(info == "company"){
                     $(this).val(data.COMPANYNAME);
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
    });

 var fenurl = "<?php echo  $url =  site_url('Oa/info_ajax');?>"
    $("select").each(function(){
       
       var  key = $(this).attr("attr");
        if(key == "positioninfo")
        {
         var type = "positioninfo";
        }
        if(key == "companyinfo")
        {
         var type ="companyinfo";
        }
        if(key != undefined)
        {
            $.ajax({
                type:'post',
                url: fenurl ,
                data:{type:type},
                dataType:'json',
                async: true
            })
            .success(function(data){
                        $.each(data,function(index,infor){
                            var option =$("<option></option>");
                            if(key =="positioninfo")
                            {
                                vid = infor.ROLEID;
                                vname = infor.RULENAME;  
                            }
                            if(key =="companyinfo")
                            {
                                vid = infor.COMPANYID;
                                vname = infor.COMPANYNAME;   
                                storeinfo(vid);
                            }
/*                            if(key =="storeinfo")
                            {
                                vid = infor.STOREID;
                                vname = infor.STORENAME;  
                            }*/
                               option.val(vid);
                               option.text(vname);
                           $("[attr="+key+"]").append(option);
                        });               
            })              
        }
    });

    function storeinfo(id){
        var companyid = $("[attr=companyinfo]").children('option:selected').val();
        var type = "storeinfo";
        $.ajax({
            type:'post',
            url: fenurl ,
            data:{type:type,companyid:id},
            dataType:'json',
            async: true
          })
         .success(function(data){
            $.each(data,function(index,infor){
                var option =$("<option></option>");
                    vid = infor.STOREID;
                    vname = infor.STORENAME;  
                   option.val(vid);
                   option.text(vname);
               $("[attr=storeinfo]").append(option);
            });   
        })

    }

    $('#btn_adopt').click(function(){
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');

        var moblie = $("input[attr ='moblie']").val();
    if(moblie != undefined)
    {
        var tel1 = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/;
        var is_true = tel1.test(moblie);
        if(is_true == false){
            alert("手机号不正确");
            return false;   
        }

    }
        var idcard = $("input[attr ='idcard']").val(); 
        var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/; 
        var is_idcard = reg.test(idcard);
        if(is_idcard == false && idcard != undefined)
        {
            alert("身份证号码无效");
            return false;
        }


        if(str_tem.length > 0){
            $("#adopt").val("1");
            $('#formflow').submit();
            return true;
        }else{
            alert("批注不能为空");
            return false;
        }
    });

    $(":input").each(function(){ 
        var tem = $(this).attr("time");
        if(tem =="yes")
        {
            $(this).click(function(){
                var start = {
                    format: 'YYYY/MM/DD hh:mm',
                    istime: true,
                    istoday: true,
                    choose: function(datas){
                    }
                }; 
                laydate(start);
            })
        }
    });

        //foreignData

/*function dispData(obj, arr){
   console.log(obj);
    for (var i = 1; i < arr.length; i++) {
        for (var j = 0; j < arr[i].data.length; j++) {
            var option =$("<option></option>");
            var name1 = arr[i].data[j].name;
            option.val(arr[i].data[j].value+'@'+name1);
            option.text(arr[i].data[j].name);
            obj.append(option);
        }
    }
};*/
    

/*function  loadingSelectData() {
    $("select[attr]").each(function(){//表单select数据
        var attr = $(this).attr("attr");
        var info = $(this);
        if(attr!="undefined")
        {
            var page=1;
            var arr = Array();
            function getJsonStore(page){
                $.ajax({
                    type:'get',
                    url: url +attr+'&page='+page+"&att="+attr,
                    dataType:'json',
                    async: true
                })
                .success(function(data) {
                    var _data = data.data;
                    var _status = data.status;
                    //console.log(data);
                    if (_status == "success") {
                        arr[page] = Array();
                        arr[page].data = Array();
                        $.each(_data,function(index,infor){
                            arr[page].data[index] = Array();
                            arr[page].data[index].name = infor.name;
                            arr[page].data[index].value = infor.value;
                        });

                        if (_data.length > 0) {
                            getJsonStore(page+1);
                        }
                        else{
                            dispData(info, arr);
                        }
                    }
                    else{
                        dispData(info, arr);
                    }
                }) 
                .error(function() {
                    dispData(info, arr);
                 });   

            }
            getJsonStore(1);
        }
    });
}


function loadingSelectForeigPassiveData () {
    $("select[foreignData]").each(function(){//表单select数据

        $(this).click(function(){
             var roleurl = $("#roleurl").attr("value");
            var attr = $(this).attr("attr");
            var foreignid = $(this).attr("foreignData");
            var info = $(this);
            if(foreignid!="undefined"){
                var selectValObj = $("#"+foreignid).children('option:selected').val();
                var selectValArr = selectValObj.split('@');
                selectVal = selectValArr[0];

                $.get(roleurl, { 'attr':attr,'selectid': selectVal}, function(data) {
           
                   if(data == 2)
                   {
                      alert("没有数据")
                   }
                   if(data.status == 'success')
                   {
                        var _data = data.data;
                        var _status = data.status;
                        //console.log(data);
                        if (_status == "success") {
                            arr[page] = Array();
                            arr[page].data = Array();
                            $.each(_data,function(index,infor){
                                arr[page].data[index] = Array();
                                arr[page].data[index].name = infor.name;
                                arr[page].data[index].value = infor.value;
                            });

                            if (_data.length > 0) {
                                getJsonStore(page+1);
                            }
                            else{
                                dispData(info, arr);
                            }
                        }
                        else{
                            dispData(info, arr);
                        }
                   }   

                });    
            }
        });
    });
}

function loadingSelectForeigInitiativeData() {
    
}

 $(function(){
      setTimeout("loadingSelectData();",1000);
    loadingSelectForeigPassiveData();
 });*/

//门店职位角色
// $("#FORMEAC8677DB943DA955F9E5B320F1AB0F5").change(function(){
//    var roleurl = $("#roleurl").attr("value");
//     var storeid = $(this).children('option:selected').val();
//         storeid = storeid.split('@');
//         storeid = storeid[0];

//     $.get(roleurl, { 'storeid': storeid,'att':'positioninfo'}, function(data) {
       
//        if(data == 2)
//        {
//         alert("没有数据")
//        }
//        if(data.status == 'success')
//        {
//             var obj = $("#FORMFORM80E3E6ADB449B2F72FEFB44A1502CE92");
//             obj.empty(); 
//             for (var j = 1; j < data.length; j++) {
//                 var option =$("<option></option>");
//                 option.val(data[j].value);
//                 option.text(data[j].name);
//                 $("#FORMFORM80E3E6ADB449B2F72FEFB44A1502CE92").append(option);
//             }
//        }   

//     });     

// });

</script>