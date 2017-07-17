<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>员工报表</title>
	<link rel="stylesheet" href="<?php echo base_url("");?>/jslibs/content/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url("");?>/jslibs/content/laydate/need/laydate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/searchnode.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/themes/default/style.min.css" />
	<link rel='stylesheet' href='<?php echo base_url("");?>/jslibs/content/css/personnelreport.css'>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/dm_alert.css">

</head>
<body>
	<div class="pagecontent">
		<!-- pagehd begin -->
		<div class="pagehd">
			<div class="inputd-group">
				<lable class="label-control">当前节点：</lable>
				<input type="text" class="fm-control fm-disabled" value="<?php echo $seach_name;?>" readonly="true" id="searchStoreId" name="seach_name">
			</div>
			<div class="menu" onclick="showTree()"><img src="<?php echo base_url();?>/jslibs/content/images/menu-icon.svg" alt="menu"></div>
			<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
    		<input type="hidden" id="dminit_type" name="dminit_type">
			<div class="inputd-group">
				<lable class="label-control">查询日期：</lable>
				<input type="text" class="fm-control fm-control-one date" id="start_date" onclick="laydate()">
			</div>
			<div class="inputd-group">
				<lable class="label-control">至</lable>
				<input type="text" class="fm-control fm-control-one date" id="end_date" onclick="laydate()">
			</div>
			<button class="btn btn-primary" onclick="search_flowdetail()">查询</button>
		</div>
		<!-- pagehd end -->
		<!-- pagecontent begin -->
		<div class="pagemain">
			<!-- nav-pills begin -->
		  <ul class="nav nav-pills" role="tablist">
		    <li role="presentation" class="active" flow_id="2" onclick="search_flowdetail(1)"><a href="#pagetab1" aria-controls="pagetab1" role="tab" data-toggle="tab">入职员工明细</a></li>
		    <li role="presentation" flow_id="6" onclick="search_flowdetail(4)"><a href="#pagetab2" aria-controls="pagetab2" role="tab" data-toggle="tab">离职员工明细</a></li>
		    <li role="presentation" flow_id="3" onclick="search_flowdetail(2)"><a href="#pagetab3" aria-controls="pagetab3" role="tab" data-toggle="tab">本店调动员工明细</a></li>
		    <li role="presentation" flow_id="4" onclick="search_flowdetail(3)"><a href="#pagetab4" aria-controls="pagetab4" role="tab" data-toggle="tab">跨店调动员工明细</a></li>
		    <li role="presentation" flow_id="5" onclick="search_flowdetail(5)"><a href="#pagetab5" aria-controls="pagetab5" role="tab" data-toggle="tab">重回公司员工明细</a></li>
		  </ul>
			<!-- nav-pills end -->

		  <!-- tab-content begin -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="pagetab1">
		    	<table class="table table-bordered table-condensed">
		    		<thead>
		    			<tr>
		    				<th>门店名称</th>
		    				<th>员工编号</th>
		    				<th>员工名称</th>
		    				<th>员工职位</th>
		    				<th>所属行业</th>
		    				<th>手机号码</th>
		    				<th>身份证号码</th>
		    				<th>入职日期</th>
		    				<th>入职备注</th>
		    			</tr>
		    		</thead>
		    		<tbody id="entry_detail">
		    		</tbody>
		    	</table>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="pagetab2">
		    	<table class="table table-bordered table-condensed">
		    		<thead>
		    			<tr>
		    				<th>门店名称</th>
		    				<th>员工编号</th>
		    				<th>员工名称</th>
		    				<th>员工职位</th>
		    				<th>所属行业</th>
		    				<th>手机号码</th>
		    				<th>身份证号码</th>
		    				<th>离职日期</th>
		    				<th>离职备注</th>
		    			</tr>
		    		</thead>
		    		<tbody id="departure_detail">	    			
		    		</tbody>
		    	</table>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="pagetab3">
		    	<table class="table table-bordered table-condensed">
		    		<thead>
		    			<tr>
		    				<th>门店名称</th>
		    				<th>员工编号</th>
		    				<th>员工名称</th>
		    				<th>调动前员工职位</th>
		    				<th>调动后员工职位</th>
		    				<th>调动前所属行业</th>
		    				<th>调动后所属行业</th>
		    				<th>手机号码</th>
		    				<th>身份证号码</th>
		    				<th>调动日期</th>
		    				<th>调动备注</th>
		    			</tr>
		    		</thead>
		    		<tbody id="storeTransfer_detail">	    			
		    		</tbody>
		    	</table>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="pagetab4">
		    	<table class="table table-bordered table-condensed">
		    		<thead>
		    			<tr>
		    				<th>门店名称</th>
		    				<th>员工编号</th>
		    				<th>员工名称</th>
		    				<th>调动前门店</th>
		    				<th>调动前员工职位</th>
		    				<th>调动后员工职位</th>
		    				<th>调动前所属行业</th>
		    				<th>调动后所属行业</th>
		    				<th>手机号码</th>
		    				<th>身份证号码</th>
		    				<th>调动日期</th>
		    				<th>调动备注</th>
		    			</tr>
		    		</thead>
		    		<tbody id="CrossStoreTransfer_detail">		    			
		    		</tbody>
		    	</table>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="pagetab5">
		    	<table class="table table-bordered table-condensed">
		    		<thead>
		    			<tr>
		    				<th>门店名称</th>
		    				<th>员工编号</th>
		    				<th>员工名称</th>
		    				<th>员工职位</th>
		    				<th>所属行业</th>
		    				<th>手机号码</th>
		    				<th>身份证号码</th>
		    				<th>重回日期</th>
		    				<th>重回备注</th>
		    			</tr>
		    		</thead>
		    		<tbody id="back_detail">		    			
		    		</tbody>
		    	</table>
		    </div>
		  </div>
		  <!-- tab-content end -->
		</div>
		<!-- pagecontent end -->
	</div>
	<div class="nodeTreeBox"></div>
	<script src="<?php echo base_url(); ?>/jslibs/content/bootstrap/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/laydate/laydate.js"></script>
    <script src="<?php echo base_url("");?>/jslibs/charisma/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
</body>
</html>
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
                return;
            }
        }
    }

    /*set_tree_callback(function(t,c,s){
    	alert("companyid:"+c+"  storeid:"+s);
    });*/
</script>
<script type="text/javascript">
	var annotation_siteurl = "<?php echo site_url(); ?>";
	function  search_flowdetail(flow_id=0){
        var stroe_val = $("#searchStoreId").val();
        var default_value = "<?php echo $seach_name; ?>";
        if(default_value != stroe_val || stroe_val.length<1){
            $("#seach_companyid").val(selectCompId);
            $("#seach_storeid").val(selectStoreId);
        }

        if(parseInt($("#seach_companyid").val()) < 0){
            $.AlertDialog.CreateAlert("警告","请选择查询节点!");
            return;
        }

        if(parseInt($("#seach_storeid").val()) < 0){
            $.AlertDialog.CreateAlert("警告","请选择查询节点!");
            return;
        }

        var start_date = $("#start_date").val();
        if(start_date.length < 1){
            $.AlertDialog.CreateAlert("警告","请选择起始日期!");
            return;
        }

        var end_date = $("#end_date").val();
        if(end_date.length < 1){
            $.AlertDialog.CreateAlert("警告","请选择结束日期!");
            return;
        }

        /*if(compare_tab(start_date,end_date)){
            $.AlertDialog.CreateAlert("警告","起始时间不可以大于结束时间!");
            return;
        }*/

        request_data(flow_id);
        //$("#"+str_id).submit();
    }
	// 默认起始日期为当天
	function get_start_toDay()
	{
		var start_toDay = document.getElementById("start_date");
		if(start_toDay.value.length<4){
			/*$.AlertDialog.CreateAlert("警告","请选择日期！");
			return null;*/
			var date = new Date();
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
		get_start_toDay();
		get_end_toDay();
	});

	function request_data(flow_id){
		//console.log(flow_id);
		$("#entry_detail").children().remove();
		$("#departure_detail").children().remove();
		$("#storeTransfer_detail").children().remove();
		$("#CrossStoreTransfer_detail").children().remove();
		$("#back_detail").children().remove();
		if(flow_id == 0){
			flow_id = $(".pagemain ul .active").index();
			if(flow_id == 0){
				flow_id = 1;
			}else if(flow_id == 1){
				flow_id = 4;
			}else if(flow_id == 2){
				flow_id = 2;
			}else if(flow_id == 3){
				flow_id = 3;
			}else if(flow_id == 4){
				flow_id = 5;
			}else{
				alert("没有流程！");
				return;
			}
		}
		var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();
        var staff_number_val = $("#staff_number").val();
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/flow_report/flow_personnel_report_detail/",
	        data:{ seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val, seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val,staff_number:staff_number_val,flow_id:flow_id},
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	for (var i = 0; i < data.length; i++) {
	    		var item = data[i];
	    		if(item.PHONE == null){
	    			item.PHONE = '';
	    		}
	    		if(item.IDCARD == null){
	    			item.IDCARD = '';
	    		}
	    		if(item.RANKNAME_OLD == null){
	    			item.RANKNAME_OLD = '';
	    		}
	    		if(item.RANKNAME_NEW == null){
	    			item.RANKNAME_NEW = '';
	    		}
	    		if(item.PTYPEID == 1){
	    			item.PTYPEID = '美发';
	    		}else if(item.PTYPEID == 2){
	    			item.PTYPEID = '美容';
	    		}else if(item.PTYPEID == 3){
	    			item.PTYPEID = '美甲';
	    		}else{
	    			item.PTYPEID = '';
	    		}

	    		if(item.ptypeid_old == 1){
	    			item.ptypeid_old = '美发';
	    		}else if(item.ptypeid_old == 2){
	    			item.ptypeid_old = '美容';
	    		}else if(item.ptypeid_old == 3){
	    			item.ptypeid_old = '美甲';
	    		}else{
	    			item.ptypeid_old = '';
	    		}

	    		if(item.ptypeid_new == 1){
	    			item.ptypeid_new = '美发';
	    		}else if(item.ptypeid_new == 2){
	    			item.ptypeid_new = '美容';
	    		}else if(item.ptypeid_new == 3){
	    			item.ptypeid_new = '美甲';
	    		}else{
	    			item.ptypeid_new = '';
	    		}
	    		item.change_date = item.change_date.substring(0,10);
	    		if(flow_id == 1){
		    		var entry_detail_html = "<tr><td>"+item.storename_new+"</td><td>"+item.staffnumber_new+"</td><td>"+item.staffname+"</td><td>"+item.RANKNAME_NEW+"</td><td>"+item.PTYPEID+"</td><td>"+item.PHONE+"</td><td>"+item.IDCARD+"</td><td>"+item.change_date+"</td><td>"+item.changememo+"</td></tr>";
		    		$("#entry_detail").append(entry_detail_html);
		    	}else if(flow_id == 4){
		    		var entry_detail_html = "<tr><td>"+item.storename_old+"</td><td>"+item.staffnumber_old+"</td><td>"+item.staffname+"</td><td>"+item.RANKNAME_OLD+"</td><td>"+item.PTYPEID+"</td><td>"+item.PHONE+"</td><td>"+item.IDCARD+"</td><td>"+item.change_date+"</td><td>"+item.changememo+"</td></tr>";
		    		$("#departure_detail").append(entry_detail_html);
		    	}else if(flow_id == 2){
		    		var entry_detail_html = "<tr><td>"+item.storename_new+"</td><td>"+item.staffnumber_new+"</td><td>"+item.staffname+"</td><td>"+item.RANKNAME_OLD+"</td><td>"+item.RANKNAME_NEW+"</td><td>"+item.ptypeid_old+"</td><td>"+item.ptypeid_new+"</td><td>"+item.PHONE+"</td><td>"+item.IDCARD+"</td><td>"+item.change_date+"</td><td>"+item.changememo+"</td></tr>";
		    		$("#storeTransfer_detail").append(entry_detail_html);
		    	}else if(flow_id == 3){
		    		var entry_detail_html = "<tr><td>"+item.storename_new+"</td><td>"+item.staffnumber_new+"</td><td>"+item.staffname+"</td><td>"+item.storename_old+"</td><td>"+item.RANKNAME_OLD+"</td><td>"+item.RANKNAME_NEW+"</td><td>"+item.ptypeid_old+"</td><td>"+item.ptypeid_new+"</td><td>"+item.PHONE+"</td><td>"+item.IDCARD+"</td><td>"+item.change_date+"</td><td>"+item.changememo+"</td></tr>";
		    		$("#CrossStoreTransfer_detail").append(entry_detail_html);
		    	}else if(flow_id == 5){
		    		var entry_detail_html = "<tr><td>"+item.storename_new+"</td><td>"+item.staffnumber_new+"</td><td>"+item.staffname+"</td><td>"+item.RANKNAME_NEW+"</td><td>"+item.PTYPEID+"</td><td>"+item.PHONE+"</td><td>"+item.IDCARD+"</td><td>"+item.change_date+"</td><td>"+item.changememo+"</td></tr>";
		    		$("#back_detail").append(entry_detail_html);
		    	}else{
		    		var msg_html="<tr><td>没有该路程的数据！</tr></td>";
		    		$("#entry_detail").append(msg_html);
		    	}
	    	}
	    	//console.log(data);
	    	
	    });
	}
</script>