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
<script type="application/javascript">
    var pathname = window.location.pathname;
    if(pathname.indexOf("select_initiate") >= 0){
        var isfirLoad = true;
        function initDataByNodeId(selectCompId,selectStoreId){
            var stroe_val = $("#searchStoreId").val();
            if(isfirLoad){
                isfirLoad = false;
                var default_value = "<?php echo $seach_name; ?>";
                if(stroe_val.length>0 && default_value.length>0){
                    $("#searchStoreId").val(default_value);
                    selectStoreId = "<?php echo $seach_storeid; ?>";
                    selectCompId = "<?php echo $seach_companyid; ?>";
                    return;
                }
                init_store_data('',selectStoreId,selectCompId);
            }
        }

        set_tree_callback(function(t,c,s){
            // 点击树节点，设置companyid，storeid
            $("[dminit_compid]").val(c);
            $("[dminit_storeid]").val(s);
            $("[dmdata='COMPANYID']").val(c);
            $("[dmdata='STOREID']").val(s);
            $("#crossStoreTransfer_staff_compid_new").val(c);
            //alert("companyid:"+c+"  storeid:"+s);
            // 门店节点才请求数据
            if(t == 1 || t == 2 || t == 3){
                init_store_data(t,s,c);
            }else{
                $("[dminit_type]").val(t);
            }
        });
    }else{
        $(".menu").remove();
    }

</script>

<script type="text/javascript">
    $('select').click(function(){
        $(this).css('color',"#333");
    });
    //将文件以DataUrl形式读入页面
    function readAsDataURL(){
        var file=document.getElementById('file').files[0];// 头像
        if(file != undefined){
            if(!/image\/\w+/.test(file.type)){
                alert("请确保文件为图像类型");
                return false;
            }
            var reader= new FileReader();
            reader.readAsDataURL(file);
            reader.onload=function(e){
                var upload=document.getElementById('upload');
                var newDiv=document.createElement('div');
                var oWord=document.getElementById('word');
                newDiv.innerHTML='<img src="'+ this.result+'" width="150px" height="150px" />';
                newDiv.setAttribute('class','uploadImg');
                newDiv.setAttribute('style','width: 150px; height: 150px; border: 1px solid #c4e1fc; display: inline-block;position: absolute; top:0px; left: 0px;');
                imgList.insertBefore(newDiv,upload);
    //                  upload.removeChild(oWord);      
            }
        }
        
    }
    
    function onClickOpenFile()
    {
        var obj_file = document.getElementById('file');// 头像
        if(obj_file != undefined){
            obj_file.value = "";
            onClickfi();
        }
    }
    
    function onClickfi()
    {
        var obj_file = document.getElementById('file');// 头像
        if(obj_file.value.length>0){
            readAsDataURL();
        }
        else{
            setTimeout('onClickfi();',1);
        }
    }


    //将文件以DataUrl形式读入页面
    function readAsDataURL_idcard(){
        var file_idcard = document.getElementById('file_idcard').files[0];// 身份证

        if(file_idcard != undefined){
            if(!/image\/\w+/.test(file_idcard.type)){
                alert("请确保文件为图像类型");
                return false;
            }
            var reader= new FileReader();
            reader.readAsDataURL(file_idcard);
            reader.onload=function(e){
                var upload=document.getElementById('upload_idcard');
                var newDiv=document.createElement('div');
                var oWord=document.getElementById('word_card');
                newDiv.innerHTML='<img src="'+ this.result+'" width="150px" height="150px" />';
                newDiv.setAttribute('class','uploadImg');
                newDiv.setAttribute('style','width: 150px; height: 150px; border: 1px solid #c4e1fc; display: inline-block;position: absolute; top:0px; left: 0px;');
                imgList_idcard.insertBefore(newDiv,upload);
    //                  upload.removeChild(oWord);      
            }
        }
        
    }
    
    function onClickOpenFile_idcard()
    {
        var obj_file_idcard = document.getElementById('file_idcard');// 身份证
        if(obj_file_idcard != undefined){
            obj_file_idcard.value = "";
            onClickfi_idcard();
        }
    }
    
    function onClickfi_idcard()
    {
        var obj_file_idcard = document.getElementById('file_idcard');// 身份证
        if(obj_file_idcard.value.length>0){
            readAsDataURL_idcard();
        }
        else{
            setTimeout('onClickfi_idcard();',1);
        }
    }
    // 上传文件 头像
    $("#file").change(function(){
        var formData = new FormData();
        formData.append("images[]", this.files[0]);
        $.ajax({
            type:'POST',
            url: "http://res.faxianbook.com/app/uploadfile.php",
            data:formData,
            cache: false,  
            processData: false,  
            contentType: false,
        })
        .success(function(data){
            console.log(data);
            var obj=$.parseJSON(data);
            if(obj.status == 0){
                var images = obj.images;
                var logogroup = new Object;
                logogroup.big = images[0].initname;
                logogroup.mid = images[0].mid_;
                logogroup.thumb = images[0].thumb;
                logogroup = JSON.stringify(logogroup).replace(/\"/g,"'");
                $("#entryAppli_staff_logourl").val(images[0].dir);
                $("#entryAppli_staff_logogroup").val(logogroup);
            }
        });
    });

    // 上传文件 身份证
    $("#file_idcard").change(function(){
        var formData = new FormData();
        formData.append("images[]", this.files[0]);
        $.ajax({
            type:'POST',
            url: "http://res.faxianbook.com/app/uploadfile.php",
            data:formData,
            cache: false,  
            processData: false,  
            contentType: false,
        })
        .success(function(data){
            console.log(data);
            var obj=$.parseJSON(data);
            if(obj.status == 0){
                var images = obj.images;
                var logogroup = new Object;
                logogroup.big = images[0].initname;
                logogroup.mid = images[0].mid_;
                logogroup.thumb = images[0].thumb;
                logogroup = JSON.stringify(logogroup).replace(/\"/g,"'");
                $("#entryAppli_staff_idcardurl").val(images[0].dir+images[0].thumb);
            }
        });
    });

    //生成唯一标示 uuid(8, 2) uuid(8, 10) uuid(8, 16)
    /*function uuid(len, radix) {
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
    }*/
    
    //*门店数据注解
    var annotation_siteurl = "<?php echo site_url(); ?>";
    $(".dmevent_entity_store").blur(
        function(){
            var idcard = $("#idcard_value").val();
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_store_entity/"+selectStoreId ,
                    data:{storeid:selectStoreId},
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
                url: annotation_siteurl+"/flow_dictionary/get_store_entity/"+selectStoreId ,
                data:{storeid:selectStoreId},
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
        /*var type = $("[dminit_type]").val();
        if(type == 3 || type == ''){
            alert("请选择具体门店！");return;
        }*/
        var this_obj = this;
        var staff_idcard = this.value;
        var storeid = $("[dmdata='STOREID']").val();
/*        if(storeid == '' || storeid == 0){
            //alert("请选择具体门店！");
            $.AlertDialog.CreateAlert("error","请选择具体门店！");
            this_obj.value = '';
            return; 
        }*/
       
        if(staff_idcard == ''){
            //alert("请输入身份证");
            $.AlertDialog.CreateAlert("error","请输入身份证！");
            return;
        }

        $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_staff_entity_idcard/"+selectStoreId ,
                data:{staff_idcard:staff_idcard},
                dataType:'json',
                async: true
            })
            .success(function(data){
                //console.log(data);
                if(data)
                {
                    if(data.change_date != undefined){
                        var change_date = data.change_date;
                        $("input[dm_change_data]").val(change_date.change_date);
                    }
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
                        /*$(".fm-disabled").each(function(){
                            if(this.value != staffid){
                                this.value = "无";
                            }
                        });*/
                        //alert("获取数据失败! 请稍后再试!");
                        $.AlertDialog.CreateAlert("error","获取数据失败! 请稍后再试!");
                        this_obj.value = '';
                    }
                }else{
                    $.AlertDialog.CreateAlert("error","获取数据失败! 请稍后再试!");
                    this_obj.value = '';
                }
            })
            .error(function(data){
                //alert("请输入正确信息");
                $.AlertDialog.CreateAlert("error","请输入正确信息!");
                this_obj.value = '';
            });
    });

    //员工相关 blur
    $(".dmevent_entity_staff").blur(
        function(){
            /*var type = $("[dminit_type]").val();
            if(type == 3 || type == ''){
                alert("请选择具体门店！");return;
            }*/
            var storeid = $("[dmdata='STOREID']").val();
            /*if(storeid == '' || storeid == 0){
                //alert("请选择具体门店！");
                $.AlertDialog.CreateAlert("error","请选择具体门店！");
                $(".dmevent_entity_staff").val("");
                return; 
            }*/
            var this_obj = this;
            var staff_number = this.value;
            if(staff_number == ''){
                //alert("请输入员工工号！");
                $.AlertDialog.CreateAlert("error","请输入员工工号！");
                return;
            }
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_staff_entity/"+selectStoreId ,
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
                            data_item.salarytype_text = '';
                            if(data_item.salarytype == 1 || data_item.salarytype == 0){
                                data_item.salarytype_text = '税前';
                            }else{
                                data_item.salarytype_text = '税后';
                            }
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
                            /*$(":input").each(function(){
                                if(this.value != staffid){
                                    this.value = "无";
                                }
                            });*/
                            $.AlertDialog.CreateAlert("error","获取数据失败! 请稍后再试!");
                            this_obj.value = '';
                        }
                    }else{
                        $.AlertDialog.CreateAlert("error","获取数据失败! 请稍后再试!");
                        this_obj.value = '';
                    }
                    var dmdata_storeid = $("[dmdata='STOREID']").val();
                    $("[dminit_storeid]").val(dmdata_storeid);
                    var dmdata_companyid = $("[dmdata='COMPANYID']").val();
                    $("[dminit_compid]").val(dmdata_companyid);
                })
                .error(function(data){
                    $.AlertDialog.CreateAlert("error","请输入正确信息!");
                    this_obj.value = '';
                });
        }
    );

    //初始化弹出数据
    function initDminitdata(obj){
        var pathname = window.location.pathname;
        var companyid = $("#flow_compid").val();
        var storeid = $("#flow_storeid").val();
        /*if(pathname.indexOf('flow_initiate')>=0){

            if(storeid == '' || storeid == 0){
                $.AlertDialog.CreateAlert("error","请选择具体门店！");
                $(".dmevent_entity_staff").val("");
                return; 
            }
        }*/
        if(storeid == ''){
            storeid = $("[dmdata='STOREID']").val();
        }

        var dmDataCtr = obj.attr("dminitdata");

        if(obj.attr("id") == "backCompany_staff_rankname_old"){
            // 重回公司 由于离职员工storeid改为2 获取选择门店的storeid
            storeid = $("[dminit_storeid]").val();
            //storeid = "<?php echo $storeid;?>";
        }
        $.ajax({
            type:'post',
            url: annotation_siteurl+"/flow_dictionary/get_form_initdata" ,
            data:{model:dmDataCtr,flow_storeid:storeid,flow_compid:companyid},
            dataType:'json',
            async: true
        })
        .success(function(data){
            //console.log(data);
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
        // 重回公司下面的员工姓名和离职时间没带进去，故在此设置
        /*var staff_name = "<?php echo $staffname;?>";
        var change_date = "<?php echo $change_date?>";
        if(staff_name != ''){
            $("#backCompany_staff_staffname").val(staff_name);
        }
        if(change_date != ''){
            $("#dmdate_backCompany_staff_leavedate_old").val(change_date);
        }*/
        var url_path = window.location.pathname;
        // 初始化弹出数据，创建时加载即调用，查看和审核时在此调用
        $("input[dminitdata]").each(function(){
            if(url_path.indexOf('flow_initiate')<0){
                initDminitdata($(this));
            }
        });

        if (url_path.indexOf('flow_own')>=0) {
            $("#searchStoreId").css("margin-right","39px"); // 调整查看和审核页面样式展示问题
            init_store_data();
            $("#upload").children().remove();
            var img_url = $("#entryAppli_staff_logourl").val();
            var img_name = $("#entryAppli_staff_logogroup").val();
            if(img_name != '' && img_name != undefined){
                img_name = img_name.replace(/'/g, '"');
                img_name = JSON.parse(img_name);
                var image_html = '<img src="'+img_url+img_name.thumb+'" width="150px;" height="150px;" alt="pre">';
                $("#upload").before(image_html);
            }

            $("#upload_idcard").children().remove();
            var idcard_img_url = $("#entryAppli_staff_idcardurl").val();
            if(idcard_img_url != '' && idcard_img_url != undefined){    
                var idcard_image_html = '<img src="'+idcard_img_url+'" width="150px;" height="150px;" alt="pre">';
                $("#upload_idcard").before(idcard_image_html);
            }
        }

        if (url_path.indexOf('flow_approval')>=0) {
            $("#searchStoreId").css("margin-right","39px"); // 调整查看和审核页面样式展示问题
            init_store_data();
            //$("#upload").children().remove();
            var img_url = $("#entryAppli_staff_logourl").val();
            var img_name = $("#entryAppli_staff_logogroup").val();
            if(img_name != '' && img_name != undefined){
                img_name = img_name.replace(/'/g, '"');
                img_name = JSON.parse(img_name);
                var image_html = '<div class="uploadImg" style="width: 150px; height: 150px; border: 1px solid #c4e1fc; display: inline-block;position: absolute; top:0px; left: 0px;"><img src="'+img_url+img_name.thumb+'" width="150px;" height="150px;" alt="pre"></div>';
                $("#upload").before(image_html);
            }

            //$("#upload_idcard").children().remove();
            var idcard_img_url = $("#entryAppli_staff_idcardurl").val();
            if(idcard_img_url != '' && idcard_img_url != undefined){    
                var idcard_image_html = '<div class="uploadImg" style="width: 150px; height: 150px; border: 1px solid #c4e1fc; display: inline-block;position: absolute; top:0px; left: 0px;"><img src="'+idcard_img_url+'" width="150px;" height="150px;" alt="pre"></div>';
                $("#upload_idcard").before(idcard_image_html);
            }
        }

        // h5门店list 员工list展示
        /*if(url_path.indexOf('flow_initiate_h5') >= 0){
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_store_list" ,
                dataType:'json',
                async: true
            })
            .success(function(data){
                console.log(data);
            });
        }*/
        // h5 门店参数设置
        var storename =  "";
        var storeid = "";
        var companyid = "";
        if(url_path.indexOf('flow_initiate_h5') > 0){
            var storename =  "<?php echo $storename;?>";
            var storeid = "<?php echo $storeid;?>";
            var companyid = "<?php echo $companyid;?>";;
            $("[dminit_data='store_name']").val(storename);
            $("[dminit_data='store_id']").val(storeid);
            $("[dminit_data='company_id']").val(companyid);
            $("#flow_compid").val(companyid);
            $("#flow_storeid").val(storeid);    
        }
        else{
            companyid = $("[dminit_data='company_id']").val();
            storeid = $("[dminit_data='store_id']").val();
            $("#flow_compid").val(companyid);
            $("#flow_storeid").val(storeid);
        }
        // h5 员工级别
        var stafflevel_val = $(".staff_stafflevel").val();
        if(stafflevel_val == 1){
            stafflevel_val = 'A级';
        }else if(stafflevel_val == 2){
            stafflevel_val = 'B级';
        }else if(stafflevel_val == 3){
            stafflevel_val = 'C级';
        }else{
            stafflevel_val = 'D级';
        }
        $(".staff_stafflevelname").val(stafflevel_val);
    });

    // h5 搜索
    $('.btn-searchstaff-h5').click(function(){
        var staffinfo = $('.staffinfo-h5').val();
        var storeid = $("[dminit_data='store_id']").val();
        var flowid = $("input[type='hidden'][name='flowid']").val();
        $.ajax({
            type:'post',
            url: annotation_siteurl+"/flow_dictionary/get_staff_entity_h5/"+storeid ,
            data:{staffinfo:staffinfo,flowid:flowid},
            dataType:'json',
            async: true
        })
        .success(function(data){
            console.log(data);
            var item = data.item;
            $("input[dmdata]").each(function(){
                var info = $(this).attr("dmdata");
                if(info != undefined)
                {
                    var info_value =  item[info];
                    if(info_value != undefined){
                        $(this).val(info_value);
                    }
                }
            });
            $("input[dminitdata]").each(function(){
                initDminitdata($(this));
            });
        });
    });

    //h5表单填写结束，数据确认
    $("#last_button").click(function(){
        var storeid = $("[dminit_data='store_id']").val();
        $('[dm_default_data]').each(function(){
            var _staff_default = $(this).attr('dm_default_data');
            var _current_data = $(this).val();
            if($(this)[0].tagName.toLocaleLowerCase() == "select"){
                _current_data = $(this).find("option:selected").text();
            }
            var _staff_default_stafflevel = _staff_default.indexOf('staff_stafflevel');
            var _staff_default_rankid = _staff_default.indexOf('staff_rankid');
            if(_staff_default_stafflevel >= 0 || _staff_default_rankid >= 0){
                $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_select_option/get_store_companyrank/"+storeid ,
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

    });

    //执行数据选择项填充
    function init_store_data(type,selectStoreId,selectCompId){
        if(type != undefined){
            $("[dminit_type]").val(type);
        }
        var dmdata_companyid = $("[dmdata='COMPANYID']").val();
        if(dmdata_companyid == undefined || dmdata_companyid ==''){
            $("[dmdata='COMPANYID']").val(selectCompId);
        }       
        var dmdata_storeid = $("[dmdata='STOREID']").val();
        if(dmdata_storeid == undefined || dmdata_storeid ==''){
            $("[dmdata='STOREID']").val(selectStoreId);
        }
        var storeid = $("[dminit_storeid]").val();
        var companyid = $("[dminit_compid]").val();
        if(storeid == undefined || storeid == ''){
            storeid = $("[dmdata='STOREID']").val();
        }
        if(selectStoreId == undefined){
            selectStoreId = storeid;
        }

        if(selectCompId == undefined){
            selectCompId = companyid;
        }

        if(dmdata_companyid == '' || dmdata_companyid == undefined){
            dmdata_companyid = selectCompId;
        }

        if(dmdata_storeid == '' || dmdata_storeid == undefined){
            dmdata_storeid = selectStoreId;
        }

        $("[dminit_storeid]").val(dmdata_storeid);
        $("[dminit_compid]").val(dmdata_companyid);
        //公共
        $('select[dmselect]').each(function(){
            var model = $(this).attr("dmselect");
            var select_value = $(this).attr("value");
            $.ajax({
                    type:'post',
                    url: annotation_siteurl+"/flow_dictionary/get_select_option/"+model+"/"+dmdata_storeid+"/"+dmdata_companyid,
                    data:{param:select_value},
                    dataType:'json',
                    async: true
                })
                .success(function(data){
                    if(data)
                    {
                        var data_item = data.items;
                        var data_model = data.model;
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
                        $.AlertDialog.CreateAlert("error","无信息！");
                    }
                })
                .error(function(data){
                    console.log("请输入员工信息");
                    //$.AlertDialog.CreateAlert("error","请输入员工信息！");
                }); 
        });

        //员工列表展示
        /*$("[dm_staff_list]").ready(function(){
            var _staff_number = "";
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/get_staff_list/"+selectStoreId ,
                data:{param:_staff_number},
                dataType:'json',
                async: true
            })
            .success(function(data){
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
                    //alert("获取数据失败");
                    $.AlertDialog.CreateAlert("error","获取数据失败！");
                }
            });
        });*/
    }
    // 验证已经存在或审核中的数据
    $("input[dm_check_data]").blur(function(){
        var storeid = $("[dmdata='STOREID']").val();
        var model = $(this).attr("dm_check_data");
        var check_data = $(this).val();
        var obj = $(this);
        $.ajax({
            type:'post',
            url: annotation_siteurl+"/flow_dictionary/get_check_data/"+model+"/"+selectStoreId ,
            data:{check_data:check_data},
            dataType:'json',
            async: true
        })
        .success(function(data){
            if(data)
            {
                var data_status = data.status;
                var data_message = data.message;
                var tem_html ="";
                if (data_status != '000') {
                    //alert(data_message);
                    $.AlertDialog.CreateAlert("error",data_message);
                    obj.val("");
                    return false;
                }
            }
        });
    });

    $(document).ready(function(){
        init_store_data();
        var input_dmradio = $('input[dmradio]');
        var hidden_gender = $("input[radio_value]").attr("radio_value");

        var radio_array = new Array();
        for (var i = input_dmradio.length - 1; i >= 0; i--) {
            var tem_obj = input_dmradio[i];
            var tem_name = $(tem_obj).attr("id");
            if($.inArray(tem_name, radio_array)){
                radio_array.push(tem_name);
            }
            
        }

        for (var i = radio_array.length - 1; i >= 0; i--) {
            var tem_name = radio_array[i];
            $("input[type='radio'][id='"+ tem_name +"']").each(function(index){
                var radio_value = $(this).attr("radio_default");
                $(this).val(radio_value);
                var tem_obj = $(this);
                if(tem_obj){
                    var check = tem_obj.attr("value");
                    if(check == 'on' || check==1){
                        check = 1;
                    }else{
                        check = 0;
                    }

                    var radio_default = tem_obj.attr('radio_default');      
                    if(hidden_gender != '' && !isNaN(parseInt(hidden_gender))){

                        if(check == hidden_gender){
                            tem_obj.attr("checked","checked");
                            return false;
                        }else{
                            return false;
                        }
                        
                    }
                    if(check == 1){
                        tem_obj.attr("checked","checked");
                        return false;
                    }
                    else{
                        tem_obj.removeAttr("checked");
                    }
                }
            });
        }

    });

    $("#storeShortNum").blur(function(){
        // 跨店调动 storeid,companyid设置
        var storeShortNum = $(this).val();
        if(storeShortNum != undefined){
            $.ajax({
                type:'post',
                url: annotation_siteurl+"/flow_dictionary/getStoreInfo",
                data:{storeShortNum:storeShortNum},
                dataType:'json',
                async: true
            })
            .success(function(data){
                //console.log(data);
                if(data.length > 0){
                    $("#crossStoreTransfer_staff_storeid_new").val(data[0].STOREID);
                    $("#crossStoreTransfer_staff_compid_new").val(data[0].COMPANYID);
                    $("#crossStoreTransfer_staff_store_name_new").val(data[0].STORENAME);
                }else{
                    $.AlertDialog.CreateAlert("error","获取门店失败！");
                    $("#storeShortNum").val("");
                    return false;
                }
                
            });
        }
    });
    

    $("#btn_return").click(function(){
        var companyid = "<?php echo $seach_companyid;?>";
        var storeid = "<?php echo $seach_storeid;?>";
        window.location.href = "<?php echo base_url();?>index.php/flow_approval/approval/"+companyid+"/"+storeid;
    });

    // 防止回车键提交表单
    $(":input").keypress(function(e){
        var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
        if(keyCode == 13) 
        { 
            return false;
        }
    });

    //常见的功能
    $("#formflow").submit(function(){
        var days=$(".handdays").val();
        // 请假天数、加班时长验证
        if(days != '' && days != undefined){

            if(days >= 1){
                $("#flowstep").val(2); // 设置分组
            }else if(days > 0 && days < 1){
                $("#flowstep").val(1); // 设置分组
            }else{
                 var message = $("input[dm_verify_days]").attr('dm_verify_days');
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
                return false;
            }

        }
    
    });

    $('#btn_adopt').click(function(){
        dm_verify_approval();
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            if(window.confirm('你确定同意通过流程吗？')){
                $("#adopt").val("1");
                $('#formflow').submit();
                return true;
            }
            window.location.reload();
            //return false;
        }else{
            alert("批注不能为空");
            //$.AlertDialog.CreateAlert("error","批注不能为空！");
            window.location.reload();
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
            window.location.reload();
            //return false;
        }else{
            alert("批注不能为空");
            //$.AlertDialog.CreateAlert("error","批注不能为空！");
            window.location.reload();
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
            window.location.reload();
            //return false;
        }else{
            alert("批注不能为空");
            //$.AlertDialog.CreateAlert("error","批注不能为空！");
            window.location.reload();
        }
    });

    $('#btn_repeal').click(function(){
        dm_verify();
            if(window.confirm('你确定要撤销申请吗？')){
                $("#adopt").val("4");
                $('#formflow').submit();
                return true;
            }
            window.location.reload();
            return false;
    });
    function dm_verify(){
        // h5设置参数(员工级别)
        var stafflevel_val= $(".staff_stafflevelname").attr("data-values");
        $(".staff_stafflevel").attr("value", stafflevel_val);
        var  nonull= $("input[dm_verify_nonull]");
        //var type = $("[dminit_type]").val();
        var storeid = $("[dmdata='STOREID']").val();
        var flag = $("#adopt").val();
        /*if(flag == undefined){
            // if(type == 3 || type == ''){
            //     alert("请选择具体门店！");
            //     return;
            // }
            if(storeid == '' || storeid == 0){
                //alert("请选择具体门店！");
                $.AlertDialog.CreateAlert("error","请选择具体门店！");
                return; 
            }
        }*/
        var cruuent_timestamp = Date.parse(new Date());
        
        // 请假开始时间，结束时间验证
        var leace_start_date = $("#askForLeave_staff_hand_startdate").val();
        var leave_end_date = $("#askForLeave_staff_hand_enddate").val();
        if(leace_start_date != '' && leace_start_date != undefined && leave_end_date != '' && leave_end_date!=undefined){
            leace_start_date = leace_start_date.replace(/-/g,'/');
            leave_end_date = leave_end_date.replace(/-/g,'/');
            var start_date = new Date(leace_start_date);
            var end_date = new Date(leave_end_date);
            var start_timestap = start_date.getTime();
            var end_timestap = end_date.getTime();
            if(start_timestap > end_timestap){
                //alert("开始时间不能大于结束时间！");
                $.AlertDialog.CreateAlert("error","开始时间不能大于结束时间！");
                return false;
            }
        }
        
        // 入职日期验证
        var birthday =  $("#dmdate_entryAppli_staff_birthday").val();
        if(birthday != '' && birthday != undefined){
            birthday = birthday.replace(/-/g,'/');
            var date = new Date(birthday);
            var birthday_timestap = date.getTime();
            if(birthday_timestap >= cruuent_timestamp){
                //alert("出生日期超过当前时间！");
                $.AlertDialog.CreateAlert("error","出生日期不能超过当前时间！");
                return false;
            }
        }      

        //入职、重回 合同日期验证
        var entry_contractTime = $("#dmdate_entryAppli_staff_contract_time").val();      
        var back_contractTime = $("#dmdate_backCompany_staff_contractTime_new").val();      
        if(entry_contractTime != '' && entry_contractTime != undefined){
            var entry_contractTime_timestap = entry_contractTime.replace(/-/g,'/');
            var date = new Date(entry_contractTime_timestap);
            entry_contractTime_timestap = date.getTime();
            if(entry_contractTime_timestap < cruuent_timestamp){
                //alert("合同到期日期小于当前时间！");
                $.AlertDialog.CreateAlert("error","合同到期日期不能小于当前时间！");
                return false;
            }
        }
        if(back_contractTime != '' && back_contractTime != undefined){
            var back_contractTime_timestap = back_contractTime.replace(/-/g,'/');
            var date = new Date(back_contractTime_timestap);
            back_contractTime_timestap = date.getTime();
            if(back_contractTime_timestap < cruuent_timestamp){
                //alert("合同到期日期小于当前时间！");
                $.AlertDialog.CreateAlert("error","合同到期日期不能小于当前时间！");
                return false;
            }
        }

        var performancerate = $("[dm_verify_floate='业绩方式必须为数字!']").val();
        if(performancerate != '' && performancerate != undefined){
            if(performancerate<0 || performancerate>100 || isNaN(performancerate)){
                //alert("业绩系数错误");
                $.AlertDialog.CreateAlert("error","业绩系数错误！");
                return false;
            }    
        }
        // 本店调动日期验证 当月以后
        var store_date = $("#dmdate_storeTransfer_staff_change_date").val();
        if(store_date != '' && store_date != undefined){
            var store_date = new Date(store_date);
            var store_year = store_date.getFullYear();
            var store_month = store_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(store_year < date_year){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }else if(store_year = date_year && store_month < date_month){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }
        }
        // 跨店调动日期验证 当月以后
        var cross_date = $("#dmdate_crossStoreTransfer_staff_change_date").val();
        if(cross_date != '' && cross_date != undefined){
            var cross_date = new Date(cross_date);
            var cross_year = cross_date.getFullYear();
            var cross_month = cross_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(cross_year < date_year){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }else if(cross_year = date_year && cross_month < date_month){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }
        }

        // 重回日期验证 当月以后
        var back_date = $("#dmdate_backCompany_staff_change_date").val();
        if(back_date != '' && back_date != undefined){
            var back_date = new Date(back_date);
            var back_year = back_date.getFullYear();
            var back_month = back_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(back_year < date_year){
                //alert("重回日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","重回日期必须当月之后！");
                return false;
            }else if(back_year = date_year && back_month < date_month){
                //alert("重回日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","重回日期必须当月之后！");
                return false;
            }
        }
        // 离职日期验证 当月以后
        var departure_date = $("#dmdate_departure_staff_change_date").val();
        if(departure_date != '' && departure_date != undefined){
            var arrivedate_old = $("#dmdate_departure_staff_arrivedate_old").val();
            var departure_timestrap = Date.parse(new Date(departure_date));
            var arrive_timestrap = Date.parse(new Date(arrivedate_old));
            if(arrive_timestrap >= departure_timestrap){
                $.AlertDialog.CreateAlert("error","离职日期必须大于入职日期！");
                return false;
            }
            var departure_date = new Date(departure_date);
            var departure_year = departure_date.getFullYear();
            var departure_month = departure_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(departure_year < date_year){
                //alert("离职日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","离职日期必须当月之后！");
                return false;
            }else if(departure_year = date_year && departure_month < date_month){
                //alert("离职日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","离职日期必须当月之后！");
                return false;
            }
            
        }
        // 薪资调整日期验证 当月以后
        var salary_date = $("#dmdate_salaryAdjustment_staff_change_date").val();
        if(salary_date != '' && salary_date != undefined){
            var salary_date = new Date(salary_date);
            var salary_year = salary_date.getFullYear();
            var salary_month = salary_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(salary_year < date_year){
                //alert("调整日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调整日期必须当月之后！");
                return false;
            }else if(salary_year = date_year && salary_month < date_month){
                //alert("调整日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调整日期必须当月之后！");
                return false;
            }
        }
        
        
        dm_mapping_data();

        if(!dm_verify_nonull()) {
            return;
        }
        if(!dm_verify_staffnumber()) {
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

    function dm_verify_approval(){
        // h5设置参数(员工级别)
        var stafflevel_val= $(".staff_stafflevelname").attr("data-values");
        $(".staff_stafflevel").attr("value", stafflevel_val);
        var  nonull= $("input[dm_verify_nonull]");
        //var type = $("[dminit_type]").val();
        var storeid = $("[dmdata='STOREID']").val();
        var flag = $("#adopt").val();
        /*if(flag == undefined){
            // if(type == 3 || type == ''){
            //     alert("请选择具体门店！");
            //     return;
            // }
            if(storeid == '' || storeid == 0){
                //alert("请选择具体门店！");
                $.AlertDialog.CreateAlert("error","请选择具体门店！");
                return; 
            }
        }*/
        var cruuent_timestamp = Date.parse(new Date());
        
        // 请假开始时间，结束时间验证
        var leace_start_date = $("#askForLeave_staff_hand_startdate").val();
        var leave_end_date = $("#askForLeave_staff_hand_enddate").val();
        if(leace_start_date != '' && leace_start_date != undefined && leave_end_date != '' && leave_end_date!=undefined){
            leace_start_date = leace_start_date.replace(/-/g,'/');
            leave_end_date = leave_end_date.replace(/-/g,'/');
            var start_date = new Date(leace_start_date);
            var end_date = new Date(leave_end_date);
            var start_timestap = start_date.getTime();
            var end_timestap = end_date.getTime();
            if(start_timestap > end_timestap){
                //alert("开始时间不能大于结束时间！");
                $.AlertDialog.CreateAlert("error","开始时间不能大于结束时间！");
                return false;
            }
        }
        
        // 入职日期验证
        var birthday =  $("#dmdate_entryAppli_staff_birthday").val();
        if(birthday != '' && birthday != undefined){
            birthday = birthday.replace(/-/g,'/');
            var date = new Date(birthday);
            var birthday_timestap = date.getTime();
            if(birthday_timestap >= cruuent_timestamp){
                //alert("出生日期超过当前时间！");
                $.AlertDialog.CreateAlert("error","出生日期不能超过当前时间！");
                return false;
            }
        }      

        //入职、重回 合同日期验证
        var entry_contractTime = $("#dmdate_entryAppli_staff_contract_time").val();      
        var back_contractTime = $("#dmdate_backCompany_staff_contractTime_new").val();      
        if(entry_contractTime != '' && entry_contractTime != undefined){
            var entry_contractTime_timestap = entry_contractTime.replace(/-/g,'/');
            var date = new Date(entry_contractTime_timestap);
            entry_contractTime_timestap = date.getTime();
            if(entry_contractTime_timestap < cruuent_timestamp){
                //alert("合同到期日期小于当前时间！");
                $.AlertDialog.CreateAlert("error","合同到期日期不能小于当前时间！");
                return false;
            }
        }
        if(back_contractTime != '' && back_contractTime != undefined){
            var back_contractTime_timestap = back_contractTime.replace(/-/g,'/');
            var date = new Date(back_contractTime_timestap);
            back_contractTime_timestap = date.getTime();
            if(back_contractTime_timestap < cruuent_timestamp){
                //alert("合同到期日期小于当前时间！");
                $.AlertDialog.CreateAlert("error","合同到期日期不能小于当前时间！");
                return false;
            }
        }

        var performancerate = $("[dm_verify_floate='业绩方式必须为数字!']").val();
        if(performancerate != '' && performancerate != undefined){
            if(performancerate<0 || performancerate>100 || isNaN(performancerate)){
                //alert("业绩系数错误");
                $.AlertDialog.CreateAlert("error","业绩系数错误！");
                return false;
            }    
        }
        // 本店调动日期验证 当月以后
        var store_date = $("#dmdate_storeTransfer_staff_change_date").val();
        if(store_date != '' && store_date != undefined){
            var store_date = new Date(store_date);
            var store_year = store_date.getFullYear();
            var store_month = store_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(store_year < date_year){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }else if(store_year = date_year && store_month < date_month){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }
        }
        // 跨店调动日期验证 当月以后
        var cross_date = $("#dmdate_crossStoreTransfer_staff_change_date").val();
        if(cross_date != '' && cross_date != undefined){
            var cross_date = new Date(cross_date);
            var cross_year = cross_date.getFullYear();
            var cross_month = cross_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(cross_year < date_year){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }else if(cross_year = date_year && cross_month < date_month){
                //alert("调动日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调动日期必须当月之后！");
                return false;
            }
        }
        // 重回日期验证 当月以后
        var back_date = $("#dmdate_backCompany_staff_change_date").val();
        if(back_date != '' && back_date != undefined){
            var back_date = new Date(back_date);
            var back_year = back_date.getFullYear();
            var back_month = back_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(back_year < date_year){
                //alert("重回日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","重回日期必须当月之后！");
                return false;
            }else if(back_year = date_year && back_month < date_month){
                //alert("重回日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","重回日期必须当月之后！");
                return false;
            }
        }
        // 离职日期验证 当月以后
        var departure_date = $("#dmdate_departure_staff_change_date").val();
        if(departure_date != '' && departure_date != undefined){
            var arrivedate_old = $("#dmdate_departure_staff_arrivedate_old").val();
            var departure_timestrap = Date.parse(new Date(departure_date));
            var arrive_timestrap = Date.parse(new Date(arrivedate_old));
            if(arrive_timestrap >= departure_timestrap){
                $.AlertDialog.CreateAlert("error","离职日期必须大于入职日期！");
                return false;
            }
            var departure_date = new Date(departure_date);
            var departure_year = departure_date.getFullYear();
            var departure_month = departure_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(departure_year < date_year){
                //alert("离职日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","离职日期必须当月之后！");
                return false;
            }else if(departure_year = date_year && departure_month < date_month){
                //alert("离职日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","离职日期必须当月之后！");
                return false;
            }
            
        }
        // 薪资调整日期验证 当月以后
        var salary_date = $("#dmdate_salaryAdjustment_staff_change_date").val();
        if(salary_date != '' && salary_date != undefined){
            var salary_date = new Date(salary_date);
            var salary_year = salary_date.getFullYear();
            var salary_month = salary_date.getMonth();

            var date = new Date();
            var date_year = date.getFullYear();
            var date_month = date.getMonth();
            if(salary_year < date_year){
                //alert("调整日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调整日期必须当月之后！");
                return false;
            }else if(salary_year = date_year && salary_month < date_month){
                //alert("调整日期必须当月之后！");
                $.AlertDialog.CreateAlert("error","调整日期必须当月之后！");
                return false;
            }
        }
        
        
        dm_mapping_data();

        if(!dm_verify_nonull()) {
            return;
        }
        if(!dm_verify_staffnumber()) {
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

    function dm_verify_nonull(){
        var  nonull= $("input[dm_verify_nonull]");

        for(var i=0;i<nonull.length;i++){
            var nonull_item = nonull[i];
            if(nonull_item.value == ''){
                var message = $(nonull_item).attr('dm_verify_nonull');
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_staffnumber(){
        var staffnumber = $("input[dm_verify_staffnumber]");
        for (var i = 0; i < staffnumber.length; i++) {
            var reg = /^[A-Za-z0-9]+$/;
            if(!reg.test(staffnumber[i].value)){
                var message = $(staffnumber[i]).attr('dm_verify_staffnumber');
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
                return false;
            }
        }
        return true;
    }
    function dm_verify_floate(){
        var floate=$("input[dm_verify_floate]");
        for(var i=0;i<floate.length;i++) {
            //var reg =/^(([1-9]+)|([0-9]+\.[0-9]{1,2}))$/;
            //var reg = /^[0-9]((?=\d)\d)?(\.[\d])?$/;
            var reg = /^(((\d|[1-9]\d)(\.\d{1,2})?)|100|100.0|100.00)$/;
            if (!(reg.test( floate[i].value))) {
                var message = $(floate[i]).attr('dm_verify_floate');
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
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
                //alert(message);
                $.AlertDialog.CreateAlert("error",message);
                return false;
            }
        }
        return true;
    }
</script>
