<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/12
 * Time: 14:12
 */

?>
<script>
    var annotation_siteurl = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        <?php
        if(isset($submit_hide) && $submit_hide == "show"){
            echo "$('button[type=submit]').show();";
        }
        else{
            echo "$('button[type=submit]').hide();";
            echo "$('select,.date,input[type=checkbox],input[type=radio]').prop('disabled',true);";
        }
        ?>
        //$('button[type=submit]').show()
    });

    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==27){ // 按 Esc
            //要做的事情
        }
        if(e && e.keyCode==113){ // 按 F2
            //要做的事情
        }
        if(e && e.keyCode==13){ // enter 键
            //要做的事情
        }
    };

    /*$("button[data-target='#entry4']").click(function(){
        //入职
        var _staff_number = $('#entryAppli_staff_staffnumber').val();
        var _staff_name = $('#entryAppli_staff_staffname').val();
        var _staff_level = $('#entryAppli_staff_stafflevel').val();
        var _staff_rankid = $('#entryAppli_staff_rankid').val();
        var model = "get_store_companyrank";

        //重回
        var _back_store_name = $("#backCompany_staff_store_name_old").val();
        var _staff_number = $("backCompany_staff_staffnumber_new").val();
        var _staff_name = $("backCompany_staff_staffname").val();
        var _staff_level = $("backCompany_staff_stafflevel_new").val();
        var _staff_rankid = $('backCompany_staff_rankid_new').val();
        $

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
        })

    });*/

    $(document).ready(function() {
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
    });
</script>

