<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/9
 * Time: 11:27
 *
 * 文件上传,添加FORMFILE前缀.
 */
?>

<script type="text/javascript">
    $('select').click(function(){
        $(this).css('color',"#333");
    });
    //生成唯一标示 uuid(8, 2) uuid(8, 10) uuid(8, 16)
    function uuid(len, radix) {
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
        var uuid = [], i;
        radix = radix || chars.length;

        if (len) {
          // Compact form
          for (i = 0; i < len; i++) uuid[i] = chars[0 | Math.random()*radix];
        } else {
          // rfc4122, version 4 form
          var r;

          // rfc4122 requires these characters
          uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
          uuid[14] = '4';

          // Fill in random data.  At i==19 set the high bits of clock sequence as
          // per rfc4122, sec. 4.1.5
          for (i = 0; i < 36; i++) {
            if (!uuid[i]) {
              r = 0 | Math.random()*16;
              uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r];
            }
          }
        }

        return uuid.join('');
    }
    
    //*门店数据注解
    var annotation_siteurl = "<?php echo site_url(); ?>";
    $(".dmevent_entity_store").blur(
        function(){
            var idcard = $("#idcard_value").val();
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_store_entity/<?php echo $storeid; ?>" ,
                    data:{storeid:<?php echo $storeid; ?>},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    if(data)
                    {
                        var data_item = data.item;
                        if(data_item){
                            $(":input").each(function(){
                                var info = $(this).attr("info");
                                if(info != undefined)
                                {
                                    var info_value =  data_item[info];
                                    if(info_value != undefined){
                                        $(this).val(info_value);
                                    }
                                }
                            });
                        }

                    }else{
                        alert("无信息")
                    }
                })
                .error(function(data){
                    alert("请输入正确信息")
                });
        }
    );

    $(".dmevent_array_store").click(
        function(){
            var idcard = $("#idcard_value").val();
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_store_entity/<?php echo $storeid; ?>" ,
                data:{storeid:<?php echo $storeid; ?>},
                dataType:'json',
                async: true
            })
            .success(function(data){
                if(data)
                {
                    var data_item = data.item;
                    if(data_item){
                        $(":input").each(function(){
                            var info = $(this).attr("info");
                            if(info != undefined)
                            {
//                                    $.each(data_item,function(index,value){
//                                        alert(i+"..."+value);
//                                        if(info == data_item[]){
//                                            $(this).val(data.STAFFNAME);
//                                        }
//                                    });
                            }
                        });
                    }
                }else{

                    alert("无信息")
                }
            })
            .error(function(data){
                console.log("请输入员工信息");
                //alert("请输入员工信息")
            });
        }
    );

    // 重回公司弹出数据
    $("#backCompany_staff_idcard").blur(function(){
        var staff_idcard = this.value;
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_staff_entity_idcard/<?php echo $storeid; ?>" ,
                    data:{staff_idcard:staff_idcard},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    console.log(data);
                    if(data)
                    {
                        var change_date = data.change_date;
                        $("input[dm_change_data]").val(change_date);

                        var data_item = data.item;
                        if(data_item){
                            $(":input").each(function(){
                                var info = $(this).attr("dmdata");
                                if(info != undefined)
                                {
                                    var info_value =  data_item[info];
                                    //console.log(data_item[info]);
                                    if(info_value != undefined){
                                        //console.debug(info+":"+info_value);
                                        $(this).val(info_value);
                                    }
                                }
                            });

                            $("input[dmdata]").each(function(){
                                var info = $(this).attr("dmdata");
                                if(info == "IDCARD"){
                                    $(this).val(data_item.IDCARD);
                                }
                            });

                            $("input[dminitdata]").each(function(){
                                initDminitdata($(this));
                            });
                        }
                        else{
                            $(":input").each(function(){
                                if(this.value != staffid){
                                    this.value = "无";
                                }
                            });
                        }
                    }else{
                        alert("获取数据失败! 请稍后再试!");
                    }
                })
                .error(function(data){
                    alert("请输入正确信息")
                });
    });

    //员工相关 blur
    $(".dmevent_entity_staff").blur(
        function(){
            var staff_number = this.value;
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_staff_entity/<?php echo $storeid; ?>" ,
                    data:{staff_number:staff_number},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    console.log(data);
                    if(data)
                    {
                        var data_item = data.item;
                        if(data_item){
                            $(":input").each(function(){
                                var info = $(this).attr("dmdata");
                                if(info != undefined)
                                {
                                    var info_value =  data_item[info];
                                    //console.log(data_item[info]);
                                    if(info_value != undefined){
                                        //console.debug(info+":"+info_value);
                                        $(this).val(info_value);
                                    }
                                }
                            });

                            $("input[dmdata]").each(function(){
                                var info = $(this).attr("dmdata");
                                if(info == "STAFFID"){
                                    $(this).val(data_item.STAFFID);
                                }
                            });

                            $("input[dminitdata]").each(function(){
                                initDminitdata($(this));
                            });
                        }
                        else{
                            $(":input").each(function(){
                                if(this.value != staffid){
                                    this.value = "无";
                                }
                            });
                        }
                    }else{
                        alert("获取数据失败! 请稍后再试!");
                    }
                })
                .error(function(data){
                    alert("请输入正确信息")
                });
        }
    );

    //初始化弹出数据
    function initDminitdata(obj){
        var dmDataCtr = obj.attr("dminitdata");
        $.ajax({
            type:'post',
            url: annotation_siteurl+"/flow_dictionary/get_form_initdata" ,
            data:{model:dmDataCtr,flow_storeid:<?php echo $storeid;?>},
            dataType:'json',
            async: true
        })
        .success(function(data){
            console.log(data);
            var items = data.items;
            for (var i = items.length - 1; i >= 0; i--) {
                var t_data = items[i];
                if(t_data['option_value'] != null){
                    var tm_input_obj = obj;
                    var dataValue = tm_input_obj.val();

                    // 入职创建的门店显示，与其他流程初始化不兼容，进行判断
                    var url_href = window.location.href;
                    var url_path = window.location.pathname;
                    if( url_path.indexOf('flow_initiate')>=0 && url_href.indexOf('flow_flowstep=2')>=0 ){
                        dataValue = tm_input_obj.attr("dmdata");
                    }

                    if(t_data.option_key == dataValue){
                       //tm_input_obj.attr("value",t_data.option_value);
                        tm_input_obj.val(t_data.option_value);
                        return;
                    }
                }
                else{
                    obj.val("没有数据!");
                }
            }
            
        }); 
    }

    //初始化填充
    $(document).ready(function(){
        //console.log(window.location.pathname);
        //
        
        // 初始化弹出数据，创建时加载即调用，查看和审核时在此调用
        $("input[dminitdata]").each(function(){
            var url_href = window.location.href;
            var url_path = window.location.pathname;

            initDminitdata($(this));
            // if( url_path.indexOf('flow_initiate')<0 || url_href.indexOf('flow_flowstep')>=0 ){
            //     // $(this).change(function(){
            //     //     alert(1122);
            //     //     //initDminitdata($(this));
            //     // });
            //     // $(this).click(function(){
            //     //     alert(111);
            //     //     initDminitdata($(this));
            //     // });
            //     initDminitdata($(this));
            // } 
        });

        
        /*var url = window.location.pathname;
        if(url.indexOf('approval_flow')>=0){
            var data = "<?php echo $store_name_value;?>";
            $("input[dminitdata]").val(data);
        }*/      
        
    })

    //h5表单填写结束，数据确认
    $("#last_button").click(function(){
        $('[dm_default_data]').each(function(){
            var _staff_default = $(this).attr('dm_default_data');
            //console.log(_staff_default);
            var _current_data = $(this).val();
            //console.log(_current_data);
            //_staff_default.substring(5);
            var _staff_default_stafflevel = _staff_default.indexOf('staff_stafflevel');
            var _staff_default_rankid = _staff_default.indexOf('staff_rankid');
            if(_staff_default_stafflevel >= 0 || _staff_default_rankid >= 0){
                $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_select_option/get_store_companyrank/<?php echo $storeid; ?>" ,
                    data:{param:_current_data},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    //console.log(data);
                    var data_item = data.items;
                    if (data_item != 'undefined') {
                        for (var i = 0; i < data_item.length; i++) {                           
                            var tem_option_data = data_item[i];                              
                            if(_current_data == tem_option_data.option_key){
                                $('#'+_staff_default).val(tem_option_data.option_value);                     
                            }
                        }
                    
                    }
                })
            }
            $('#'+_staff_default).val(_current_data);

        });
        


        /*var _current_store =$('#entryAppli_staff_store_name_old').val();
        var _staff_number = $('#entryAppli_staff_staffnumber').val();
        var _staff_name = $('#entryAppli_staff_staffname').val();
        var _staff_level = $('#entryAppli_staff_stafflevel').val();
        var _staff_rankid = $('#entryAppli_staff_rankid').val();
        var model = "get_store_companyrank";
        $('#current_store').val(_current_store);
        $('#staff_default_number').val(_staff_number);
        $('#staff_default_name').val(_staff_name);
        
        $.ajax({
            type:'post',
            url: annotation_siteurl+"/flow_dictionary/get_select_option/"+model+"/<?php echo $storeid; ?>" ,
            data:{param:_staff_level},
            dataType:'json',
            async: true
        })
        .success(function(data){
            console.log(data);
            var data_item = data.items;
            if (data_item != 'undefined') {
                for (var i = 0; i < data_item.length; i++) {                           
                    var tem_option_data = data_item[i];                              
                    if(_staff_level == tem_option_data.option_key){
                        $('#staff_default_level').val(tem_option_data.option_value);                      
                    }
                    if(_staff_rankid == tem_option_data.option_key){
                        $('#staff_default_rank').val(tem_option_data.option_value);
                    }
                }
            
            }
        })*/

    });

    //设置companyrankid
    /*$("#entryAppli_staff_rankid").change(function(){
        var rankid_val = $(this).val();
        $("#entryAppli_staff_companyrankid").val(rankid_val);
    });
    $("#backCompany_staff_rankid_new").change(function(){
        var rankid_val = $(this).val();
        $("#backCompany_staff_companyrankid_new").val(rankid_val);
    });*/

    //执行数据选择项填充
    $(document).ready(function(){
        //公共
        $('select[dmselect]').each(function(){
            var model = $(this).attr("dmselect");
            var select_value = $(this).attr("value");
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_select_option/"+model+"/<?php echo $storeid; ?>" ,
                    data:{param:select_value},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    console.log(data);
                    if(data)
                    {
                        var data_item = data.items;
                        var data_model = data.model;
                        //console.log(data_item[1]);
                        var tem_html ="";
                        if (data_item != 'undefined') {
                            var tm_selects = $('select[dmselect='+data_model+']');
                            for (var j = tm_selects.length - 1; j >= 0; j--) {
                                var tm_select_obj = tm_selects[j];
                                if (tm_select_obj != null) {
                                    var tm_select_jquery = $(tm_select_obj);
                                    var selectValue = tm_select_jquery.attr("select_value");
                                    tm_select_jquery.html("");

                                    for (var i = 0; i < data_item.length; i++) {                           
                                        var tem_option_data = data_item[i];                              
                                        if(selectValue == tem_option_data.option_key){
                                            tem_html += '<option value="' + tem_option_data.option_key + '" selected="selected">' + tem_option_data.option_value + '</option>';
                                        }
                                        else {                                  
                                            tem_html += '<option value="' + tem_option_data.option_key + '">' + tem_option_data.option_value + '</option>';
                                        }
                                        
                                    }
                                    tm_select_jquery.html(tem_html);
                                }
                            }
                        }
                    }else{

                        alert("无信息")
                    }
                })
                .error(function(data){
                    console.log("请输入员工信息");
                    //alert("请输入员工信息")
                }); 
        });

        $("input[dm_check_data]").blur(function(){
            var model = $(this).attr("dm_check_data");
            var check_data = $(this).val();
            var obj = $(this);
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_check_data/"+model+"/<?php echo $storeid; ?>" ,
                data:{check_data:check_data},
                dataType:'json',
                async: true
            })
            .success(function(data){
                //document.write(typeof(data.items));
                console.log(data);
                if(data)
                {
                    var data_status = data.status;
                    var data_message = data.message;
                    //console.log(data_item[1]);
                    var tem_html ="";
                    if (data_status != '000') {
                        alert(data_message);
                        obj.val("");
                        return;
                    }
                }
            });
        });

        //员工列表展示
        $("[dm_staff_list]").ready(function(){
            var _staff_number = "";
            //console.log(_This);
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_staff_list/<?php echo $storeid; ?>" ,
                data:{param:_staff_number},
                dataType:'json',
                async: true
            })
/*                <div class="weui_cell_bd weui_cell_primary">
            <span class="search-staff-num"></span>
            <span></span>
        </div>
        <div class="weui_cell_ft"></div>
        <input class="weui_input" type="text" value="" readonly>*/
            .success(function(data){
                console.log(data);
                if(data)
                {
                    var data_item = data.items;
                    var tem_html ="";
                    if (data_item != 'undefined') {
                        var dmelement = $("#checkFlowCell");
                        var current_obj = dmelement;
                        if(current_obj != null){
                            var tm_current_jquery = $(current_obj);
                            tm_current_jquery.html("");

                            for (var i = 0; i < data_item.length; i++) {                           
                                var tem_option_data = data_item[i];  
                                tem_html ='<div class="weui_cell open-popup" data-target="#departure2"><div class="weui_cell_bd weui_cell_primary"><span class="search-staff-num" dm_staff_list="staff_number">' + tem_option_data.STAFFNUMBER + '</span><span dm_staff_list="staff_name">' + tem_option_data.STAFFNAME+ '</span></div><div class="weui_cell_ft"></div><input class="weui_input" type="text" value="' + tem_option_data.RANKNAME + '" dm_staff_list="staff_rankname" readonly></div>';
                                tm_current_jquery.append(tem_html);                                       
                            }
                         }  
                                                                                       
                    }
                }else{

                    alert("获取数据失败");
                }
            });
        });

        $(document).ready(function(){
            var input_dmradio = $('input[dmradio]');
            
            var radio_array = new Array();
            for (var i = input_dmradio.length - 1; i >= 0; i--) {
                var tem_obj = input_dmradio[i];
                var tem_name = $(tem_obj).attr("name");
                if($.inArray(tem_name, radio_array)){
                    radio_array.push(tem_name);
                }
                
            }

            for (var i = radio_array.length - 1; i >= 0; i--) {
                var tem_name = radio_array[i];
                $("input[type='radio'][name='"+ tem_name +"']").each(function(index){
                    var tem_obj = $(this);
                    //console.log(data_item[1]);
                    if(tem_obj){
                        var check = tem_obj.attr("value");
                        if(check == 'on' || check==1){
                            check = 1;
                        }else{
                            check = 0;
                        }
                        var radio_default = tem_obj.attr('radio_default');
                        //console.log(check);console.log(radio_default);
                        if(check == radio_default){
                            tem_obj.attr("checked","checked");
                        }
                        else{
                            tem_obj.removeAttr("checked");
                        }
                    }
                });
            }

        });

        //设置staffid
        /*$("input[type='hidden']").ready(function(){
            var _staff = uuid(8,10);//uuid(8,2) uuid(8,10) uuid(8, 16)
            $('input[dm_uniqid]').val(_staff);
        });*/

        // $(document).ready(function(){
        //     $("textarea[name!=explain]").each(function(){
        //         var tem_obj = $(this).attr();
        //         tem_obj.html(tem_obj.val());
        //     });
        // });

        // $('input[dmradio]').each(function(index){
        //     var tem_obj = $(this);
        //     //console.log(data_item[1]);
        //     if(tem_obj){
        //         var check = tem_obj.attr("value");
        //         if(check == index){
        //             tem_obj.attr("checked","checked");
        //         }
        //         else{
        //             tem_obj.attr("checked","");
        //         }
        //     }
        // });
    
        // $(document).ready(function(){
        //     $.ajax({
        //         type:'post',
        //         url: annotation_siteurl+"/flow_dictionary/get_staff_gender" ,
        //         data:{storeid:<?php echo $storeid; ?>},
        //         dataType:'json',
        //         async: true
        //     })
        //     .success(function(data){
        //         if (data) {
        //             $('input[dmradio]').each(function(){
        //                 var data_item = data.items;
        //                 //console.log(data_item[1]);
        //                 var tem_html ="";
        //                 if (data_item != 'undefined') {
        //                     for (var i = 0; i < data_item.length; i++) {   
        //                         var tem_option_data = data_item[i];                              
        //                         if(selectValue == tem_option_data.option_key){

        //                         }
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // });

        // get_staff_performancetype

        //$('button[type=submit]').hide();
       // $('button[type=submit]').show()

    });



    //常见的功能
    $('#btn_adopt').click(function(){
        dm_verify();
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            if(window.confirm('你确定同意通过流程吗？')){
                $("#adopt").val("1");
                $('#formflow').submit();
                return true;
            }
            return false;
        }else{
            alert("批注不能为空");
            return false;
        }

    });

    $('#btn_refuse').click(function(){
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            if(window.confirm('你确定要驳回流程吗？')){
                $("#adopt").val("3");
                $('#formflow').submit();
                return true;
            }
            return false;
        }else{
            alert("批注不能为空");
            return false;
        }
    });

    $('#btn_break').click(function(){
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            if(window.confirm('你确定要结束流程吗？')){
                $("#adopt").val("2");
                $('#formflow').submit();
                return true;
            }
            return false;
        }else{
            alert("批注不能为空");
            return false;
        }
    });

    $('#btn_repeal').click(function(){
        dm_verify();
            if(window.confirm('你确定要撤销申请吗？')){
                $("#adopt").val("4");
                $('#formflow').submit();
                return true;
            }
            return false;
    });
    function dm_verify(){
        var  nonull= $("input[dm_verify_nonull]");

        dm_mapping_data();

        if(!dm_verify_nonull()) {
            return;
        }
        if(!dm_verify_phone()) {
            return;
        }
        if(!dm_verify_idCard()) {
            return;
        }
        if(!dm_verify_money()) {
            return;
        }
        if(!dm_verify_bank()) {
            return;
        }
        if(!dm_verify_email()) {
            return;
        }
        if(!dm_verify_floate()) {
            return;
        }
        if(!dm_verify_time_hour()) {
            return;
        }  
        if(!dm_verify_time_minu()) {
            return;
        }
        $("#formflow").submit();
        return true;
    }

    function dm_mapping_data(){
        $("input[dm_mapping]").each(function(){
            var mapping = $(this).attr("dm_mapping");
            var map_obj = $("#"+mapping).val();
            $(this).val(map_obj);
        });
    }

    /*function dm_check_salary(){
        var basesalary = $("input[dm_check_salary='basesalary']").val();
        var guaranteedsalary = $("input[dm_check_salary='guaranteedsalary']").val();
        if(guaranteedsalary>basesalary){
            alert('保底工资不能大于基本工资！');
            return false;
        }
        return true;
    }*/

    function dm_verify_nonull(){
        var  nonull= $("input[dm_verify_nonull]");

        for(var i=0;i<nonull.length;i++){
            var nonull_item = nonull[i];
            if(nonull_item.value == ''){
                var message = $(nonull_item).attr('dm_verify_nonull');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_phone(){
        var phone=$("input[dm_verify_phone]");
        for(var i=0;i<phone.length;i++) {
            if (!(/^1[34578]\d{9}$/.test(phone[i].value))) {
                var message = $(phone[i]).attr('dm_verify_phone');
                alert(message);
                //$(phone[i]).css("boreder","1px solid red");
                return false;
            }
        }
        return true;
    }
    function dm_verify_idCard(){
        var idCard=$("input[dm_verify_idCard]");
        for(var i=0;i<idCard.length;i++) {
            var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
            if (!(reg.test(idCard[i].value))) {
                var message = $(idCard[i]).attr('dm_verify_idCard');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_money(){
        var money=$("input[dm_verify_money]");
        for(var i=0;i<money.length;i++) {
            var reg =/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/;
            if (!(reg.test( money[i].value))) {
                var message = $(money[i]).attr('dm_verify_money');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_bank(){
        var bank=$("input[dm_verify_bank]");
        if($("input[dm_verify_bank]").val() == ''){
            return true;
        }
        for(var i=0;i<bank.length;i++) {
            var reg = /^(\d{16}|\d{19})$/;
            if (!(reg.test( bank[i].value))) {
                var message = $(bank[i]).attr('dm_verify_bank');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_email(){
        var email=$("input[dm_verify_email]");
        if($("input[dm_verify_email]").val() == ''){
            return true;
        }
        for(var i=0;i<email.length;i++) {
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!(reg.test( email[i].value))) {
                var message = $(email[i]).attr('dm_verify_email');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_floate(){
        var floate=$("input[dm_verify_floate]");
        for(var i=0;i<floate.length;i++) {
            var reg =/^(([1-9]+)|([0-9]+\.[0-9]{1,2}))$/;
            if (!(reg.test( floate[i].value))) {
                var message = $(floate[i]).attr('dm_verify_floate');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_time_hour(){
        var hour=$("input[dm_verify_time_hour]");
        for(var i=0;i<hour.length;i++) {
            var reg=/[0-1]\d|2[0-3]/;
            if (!(reg.test( hour[i].value))) {
                var message = $(hour[i]).attr('dm_verify_time_hour');
                alert(message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_time_minu(){
        var minu=$("input[dm_verify_time_minu]");
        for(var i=0;i<minu.length;i++) {
            var reg=/^[0-5]+[0-9]*$/;
            if (!(reg.test( minu[i].value))) {
                var message = $(minu[i]).attr('dm_verify_time_minu');
                alert(message);
                return false;
            }
        }
        return true;
    }
</script>
