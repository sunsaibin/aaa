<?php
/**
 * Created by Sublime.
 * User: sunsaibin
 * Date: 2017/04/07
 * Time: 16:20
 *
 * 文件上传,添加FORMFILE前缀.
 */
?>
<script type="application/javascript">
    var isfirLoad = true;
    function initDataByNodeId(selectCompId,selectStoreId){
        var stroe_val = $("#searchStoreId").val();
        if(isfirLoad){
            isfirLoad = false;
            var default_value = "<?php echo $seach_name; ?>";
            if(stroe_val.length>0 && default_value.length>0){
                $("#searchStoreId").val(default_value);
                selectStoreId = <?php echo $seach_storeid; ?>;
                selectCompId = <?php echo $seach_companyid; ?>;
                //return;
            }
        }
        // 页面加载后展示待审核申请. 注：initDataByNodeId()在页面加载事件之后执行,故在初始化树节点后调用,不然得不到正确的selectStoreId,selectCompId
        search_flowlist(0);
    }

    set_tree_callback(function(t,c,s){
    	//alert("companyid:"+c+"  storeid:"+s);
    	$("#dminit_type").val(t);
    });

    // function  callback_searchnode(selectCompId,selectStoreId){
    //     alert(selectCompId);
    // }
</script>
<script type="text/javascript">

	var annotation_siteurl = "<?php echo site_url(); ?>";
//下拉框默认为灰色
	$('select').click(function(){
		$(this).css('color',"#333");
	});
	// 页面分页栏高度控制
	function height_control(){
		var topPosi=$('.product-bottom-right').height() -30 +"px";
		$(".fpag").css("top",topPosi);
	}
	
	// 默认起始日期为当天
	function get_start_toDay()
	{
		var start_toDay = document.getElementById("start_date");
		if(start_toDay.value.length<4){
			/*$.AlertDialog.CreateAlert("警告","请选择日期！");
			return null;*/
			var date = new Date();
			date.setDate(1);
			var date_str = date.toLocaleDateString();
			start_toDay.value = date_str.replace(/\//g,'-');
		}
		return start_toDay.value;
	}
	// 默认结束日期为当天
	function get_end_toDay()
	{
		var end_toDay = document.getElementById("end_date");
		if(end_toDay.value.length<4){
			/*$.AlertDialog.CreateAlert("警告","请选择日期！");
			return null;*/
			var date = new Date();
			var date_str = date.toLocaleDateString();
			end_toDay.value = date_str.replace(/\//g,'-');
		}
		return end_toDay.value;
	}

	$(document).ready(function(){
		height_control();
		get_start_toDay();
		get_end_toDay();
	});

	$('#flow_list tr').live("click",function(){
		var tr_objs = $('#flow_list').children();
		tr_objs.each(function(){
			$(this).removeAttr("style");
		});
		$(this).css("background","#3399ff");
		$(".approval_flowstep").remove();
		$("#user_flowid").html('');
		$("#init_date").html('');
		$("#luf_username").html('');
		$("#approve_status").html('');

		var user_flowid = $(this).attr("flowid");
		var init_cdate = $(this).attr("init_cdate");
		var luf_username = $(this).attr("luf_username");
		var approve_status = $(this).attr("approve_status");
		var userflow_id = $(this).attr("userflow_id");
		$("#user_flowid").html(user_flowid);
		$("#user_flowid").attr("userflow_id", userflow_id);
		$("#init_date").html(init_cdate);
		$("#luf_username").html(luf_username);
		$("#approve_status").html(approve_status);
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/flow_own/ownflow_step",
	        data:{user_flowid:user_flowid},
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	//console.log(data);
	    	for (var i = 0; i < data.length; i++) {
	    		var approval_data = data[i];
	    		if(approval_data.lufs_is_adopt == 1){
	    			approval_data.lufs_is_adopt = '通过';
	    		}else if(approval_data.lufs_is_adopt == 2){
	    			approval_data.lufs_is_adopt = '驳回';
	    		}else if(approval_data.lufs_is_adopt == 3){
	    			approval_data.lufs_is_adopt = '结束';
	    		}else if(approval_data.lufs_is_adopt == 4){
	    			approval_data.lufs_is_adopt = '撤销';
	    		}
	    		if(approval_data.fau_user_name == null){
	    			approval_data.fau_user_name = ''
	    		}
	    		if(approval_data.lufs_approval_cdate == null){
	    			approval_data.lufs_approval_cdate = '';
	    		}
	    		if(approval_data.lufs_explain == null){
	    			approval_data.lufs_explain = '';
	    		}
	    		if(approval_data.lufs_is_adopt != 0){
	    			var approval_data_html = '<div class="line approval_flowstep"><div class="inputd-group1"><label class="label-control label-control2">审核人：</label><span id="approval_user1">'+approval_data.fau_user_name+'</span></div><div class="inputd-group1"><label class="label-control label-control2">处理结果：</label><span id="approval_result1">'+approval_data.lufs_is_adopt+'</span></div><div class="inputd-group1"><label class="label-control label-control2">处理时间：</label><span id="approval_date1">'+approval_data.lufs_approval_cdate+'</span></div><div class="inputd-group1"><label class="label-control label-control2">处理说明：</label><span id="approval_explain1">'+approval_data.lufs_explain+'</span></div></div>';
	    			$(".approval_flow").after(approval_data_html);
	    		}    		
		 		height_control();
	    		$("#user_flowid").attr("flowstepid",approval_data.lufs_id);
	    	}
	    });
	    
	});

	var clicktag = 0;  
	function search_flowlist(approval,pre_next,pagenum = 1){
		if (clicktag == 0) {  
	        clicktag = 1;    
	        setTimeout(function () { clicktag = 0 }, 1000);  
	    }else{
	    	return false;
	    }
		/*
		* 保持翻页按钮在默认展示待审核的时候进行待审核的翻页，在查询所有审核的时候进行所有审核的翻页
		* 当点击查询按钮的时候,设置type,避免点击查询之后再点击翻页时approval=0,还是展示待审核的
		 */
		if(approval == undefined){
			$("#dminit_type").val(1);
		}
		var type = $("#dminit_type").val();
		if(type == '' && type != undefined && approval != undefined){
			// 当进入页面的时候，展示待审核申请。当选择节点的时候设置参数type，展示所有申请
			approval = 0;
		}
		var stroe_val = $("#searchStoreId").val();
        var default_value = "<?php echo $seach_name; ?>";
        if(default_value != stroe_val || stroe_val.length<1){
            $("#seach_companyid").val(selectCompId);
            $("#seach_storeid").val(selectStoreId);
        }
		$(".approval_flowstep").remove();
		$("#user_flowid").html('');
		$("#init_date").html('');
		$("#luf_username").html('');
		$("#approve_status").html('');
		$("#user_flowid").attr("flowstepid");
		var flow_list_obj = $("#flow_list");
		var thead_obj = flow_list_obj[0].previousElementSibling.children;
		flow_list_obj.children().remove();

		var seach_name_val = $("#searchStoreId").val();
		var seach_storeid_val = $("#seach_storeid").val();
		var seach_companyid_val = $("#seach_companyid").val();
		var start_date_val = $("#start_date").val();
		var end_date_val = $("#end_date").val();
		var staff_number_val = $("#staff_number").val();

		var current_page = parseInt($("#current_page").html());
		if(pre_next == -1){
			pagenum = current_page - 1;
		}else if(pre_next == 1){
			pagenum = current_page + 1;
		}

		if(staff_number == undefined){
			staff_number = '';
		}
		if(approval == undefined){
			approval == '';
		}
		$('[onclick="search_flowlist()"]').attr("disabled","true");
		var url_pathname = window.location.pathname;
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/flow_own/own_flow_info/"+pagenum,
	        data:{seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val,staff_number:staff_number_val,approval:approval,url_pathname:url_pathname},
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	$('[onclick="search_flowlist()"]').removeAttr("disabled");
	    	console.log(data);
	    	var userdata_flow = data.userdata_flow;
	    	var flow_id = '';
	    	var flow_html = '';
	    	$("#current_page").html(data.pagenum);
	    	for (var i = 0; i < userdata_flow.length; i++) {
	    		var data_row = userdata_flow[i];
	    		flow_id = data_row.luf_flow;
	    		if(data_row.luf_flow == 1){
	    			data_row.luf_flow = '请假申请';
	    		}else if(data_row.luf_flow == 2){
	    			data_row.luf_flow = '入职申请';
	    		}else if(data_row.luf_flow == 3){
	    			data_row.luf_flow = '本店调动';
	    		}else if(data_row.luf_flow == 4){
	    			data_row.luf_flow = '跨店调动';
	    		}else if(data_row.luf_flow == 5){
	    			data_row.luf_flow = '重回公司';
	    		}else if(data_row.luf_flow == 6){
	    			data_row.luf_flow = '离职申请';
	    		}else if(data_row.luf_flow == 7){
	    			data_row.luf_flow = '薪资调整';
	    		}else if(data_row.luf_flow == 14){
	    			data_row.luf_flow = '会员退卡';
	    		}else if(data_row.luf_flow == 15){
	    			data_row.luf_flow = '加班申请';
	    		}

	    		if(data_row.luf_is_approve == 0){
	    			data_row.luf_is_approve = '待审核';
	    		}else if(data_row.luf_is_approve == 1){
	    			data_row.luf_is_approve = '审核中';
	    		}else if(data_row.luf_is_approve == 2){
	    			data_row.luf_is_approve = '审核通过';
	    		}else if(data_row.luf_is_approve == 3){
	    			data_row.luf_is_approve = '审核拒绝';
	    		}else if(data_row.luf_is_approve == 4){
	    			data_row.luf_is_approve = '已撤销';
	    		}
	    		if(data_row.approval_cdate == null){
	    			data_row.approval_cdate = '';
	    		}
	    		if(data_row.lfuff_value == null){
	    			data_row.lfuff_value = '';
	    		}
	    		if(data_row.staff_name == undefined){
	    			data_row.staff_name = '';
	    		}
	    		if(data_row.userflow_id == undefined){
	    			data_row.userflow_id = 0;
	    		}
	    		if(thead_obj[0].childElementCount == 8){
	    			flow_html = "<tr flowid="+data_row.luf_id+" userflow_id="+data_row.userflow_id+" luf_username="+data_row.luf_user_name+" init_cdate="+data_row.luf_cdate+" approve_status="+data_row.luf_is_approve+"><td><input type='hidden' value="+data_row.luf_user_name+">"+data_row.luf_flow+"</td><td>"+data_row.luf_store_name+"</td><td>"+data_row.number+"</td><td>"+data_row.staff_name+"</td><td class='init_cdate'>"+data_row.luf_cdate+"</td><td>"+data_row.lfuff_value+"</td><td class='approve_status'>"+data_row.luf_is_approve+"</td><td><a class='btn btn-success' style='width:50px;height:15px;padding:0px 8px;' href="+annotation_siteurl+"/flow_own/own_flow_print/"+data_row.luf_company+'/'+data_row.luf_storeid+'/'+data_row.luf_id+'/'+flow_id+'/'+data_row.userflow_id+">打印</a></td></tr>";
	    		}else{
	    			flow_html = "<tr flowid="+data_row.luf_id+" userflow_id="+data_row.userflow_id+" luf_username="+data_row.luf_user_name+" init_cdate="+data_row.luf_cdate+" approve_status="+data_row.luf_is_approve+"><td><input type='hidden' value="+data_row.luf_user_name+">"+data_row.luf_flow+"</td><td>"+data_row.luf_store_name+"</td><td>"+data_row.number+"</td><td>"+data_row.staff_name+"</td><td class='init_cdate'>"+data_row.luf_cdate+"</td><td>"+data_row.lfuff_value+"</td><td class='approve_status'>"+data_row.luf_is_approve+"</td></tr>";
	    		}
	    		
	    		flow_list_obj.append(flow_html);
	    	}
	    });
	    height_control();
	}

	$("#search_flowlist").keypress(function(e){
		var pagenum = $("#search_flowlist").val();
		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
		if(keyCode == 13){
			if($.isNumeric(pagenum)){
				search_flowlist('','',pagenum);
			}
			else{
				alert("输入错误！");
				return false;
			}
		}
	});

	$(".btn-search2").click(function(){
		var user_flowid = $("#user_flowid").html();
		var flowstepid = $("#user_flowid").attr("flowstepid");
		var userflow_id = $("#user_flowid").attr("userflow_id"); // 卡操作流程获取数据需要的id
		var approve_status = $("#approve_status").html();
		if(user_flowid == undefined || user_flowid == ''){
			alert("找不到流程！");
			//$.AlertDialog.CreateAlert("找不到流程！");
			return false;
		}
		if(flowstepid == undefined || flowstepid == ''){
			alert("没有流程步骤！");
			//$.AlertDialog.CreateAlert("没有流程步骤！");
			return false;
		}
		var pathname = window.location.pathname;
		if(pathname.indexOf("flow_own") >= 0){
			location.href = "<?php echo base_url();?>index.php/flow_own/own_flowform?id="+flowstepid+"&tid="+user_flowid+"&userflow_id="+userflow_id;
		}
		if(pathname.indexOf("flow_approval") >= 0){
			var userid = "<?php echo $id;?>";

			/*if(approve_status == '待审核' || approve_status == '审核中'){

				$.ajax({
			        type:'post',
			        url: annotation_siteurl+"/flow_own/own_flow_approval_user/",
			        data:{userid:userid,flowstepid:flowstepid,approve_status:approve_status},
			        dataType:'json',
			        async: true
			    })
			    .success(function(data){
			    	//console.log(data);return;
			    	if(data == null || data.length <= 0){
			    		$.AlertDialog.CreateAlert("error","该账号不能进行审核，请更改登陆账号！");
			    	}else{
			    		location.href = "<?php echo base_url();?>index.php/flow_approval/approval_flow/"+user_flowid+"/"+approve_status+"/"+selectCompId+"/"+selectStoreId;
			    	}
			    });

			}else{*/
				location.href = "<?php echo base_url();?>index.php/flow_approval/approval_flow/"+user_flowid+"/"+approve_status+"/"+selectCompId+"/"+selectStoreId+"/"+userflow_id;
			//}
			
		}
	});

	function flowstep_from(flowstep){
		window.location.href = "<?php echo base_url();?>index.php/flow_initiate/select_initiate/?id=1&flow_flowstep="+flowstep;
	}
</script>