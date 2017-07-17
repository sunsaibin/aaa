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
				<lable class="label-control">查询节点：</lable>
				<input type="text" class="fm-control fm-disabled" value="<?php echo $seach_name;?>" readonly="true" id="searchStoreId" name="seach_name">
			</div>
			<div class="menu" onclick="showTree()"><img src="<?php echo base_url();?>/jslibs/content/images/menu-icon.svg" alt="menu"></div>
			<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
    		<input type="hidden" id="dminit_type" name="dminit_type">
			<button class="btn btn-primary" onclick="search_staffrank()">查询</button>
		</div>
		<!-- pagehd end -->
		<!-- pagecontent begin -->
		<div class="pagemain">
			<table class="table table-bordered table-condensed">
				<thead id="staffrank_name">
					<tr>
						<th>门店名称</th>
						<th>总人数</th>
						<th>区域经理</th>
						<th>门店总经理</th>
						<th>美发经理</th>
						<th>美容经理</th>
						<th>美容导师</th>
						<th>接待</th>
						<th>收银员</th>
						<th>美容师</th>
						<th>美发师</th>
						<th>首席</th>
						<th>总监</th>
						<th>技师</th>
						<th>美甲师</th>
						<th>足疗师</th>
						<th>门店后勤</th>
						<th>水吧员</th>
					</tr>
				</thead>
				<tbody id="staffrank_list">					
				</tbody>
			</table>
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
</script>
<script type="text/javascript">
	var annotation_siteurl = "<?php echo site_url(); ?>";
	function  search_staffrank(){
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

        request_data();
    }

    function request_data(){  	
    	var seach_name_val = $("#searchStoreId").val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();
        if(seach_storeid_val == 0 && seach_companyid_val < 3){
        	$.AlertDialog.CreateAlert("error","请选择品牌或门店!");
        	return false;
        }

        var name_obj = $("#staffrank_name");
    	var list_obj = $("#staffrank_list");
    	name_obj.children().remove();
    	list_obj.children().remove();

        $.ajax({
	        type:'post',
	        url: annotation_siteurl+"/flow_report/flow_storerank_report_detail",
	        data:{ seach_companyid: seach_companyid_val},
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	console.log(data);
	    	var name_html = '<tr><th>门店名称</th><th>总人数</th>';
	    	for (var i = 0; i < data.length; i++) {
	    		name_html += "<th rank='" + data[i]['RANKID'] + "'>" + data[i]['RANKNAME'] + "</th>";
	    	}
	    	name_html += "</tr>";
	    	name_obj.append(name_html);

	    	$.ajax({
		        type:'post',
		        url: annotation_siteurl+"/flow_report/flow_staffrank_report_detail",
		        data:{ seach_name: seach_name_val,seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val},
		        dataType:'json',
		        async: true
		    })
		    .success(function(json){
		    	console.log(json);
		    	var data = new Array();
		    	var jsonKeys = Object.keys(json);
		    	if($.inArray('0',jsonKeys) < 0){
		    		for (var i = 1; i <= jsonKeys.length; i++) {
			    		data[i-1] = json[i];
			    	}
		    	}else{
		    		data = json;
		    	}
		    	
		    	console.log(data);
		    	var list_html = '';
		    	var len = $("#staffrank_name tr th").length;
		    	for (var i = 0; i < data.length; i++) {
		    		if(data[i].total_count > 0){
		    			var storeinfo = data[i];
			    		//console.log(storeinfo);
			    		list_html += "<tr><td>" + storeinfo[0].STORENAME + "</td><td>" + storeinfo["total_count"] + "</td>";
			    		for (var j = 0; j < len-2; j++) {
			    			var th_rank_val = $("#staffrank_name tr :eq("+(j+2)+")").attr("rank");
			    			list_html += "<td rank=" + th_rank_val + "></td>";
			    		}
			    		list_html += "</tr>";
		    		}
		    		
		    	}
		    	list_obj.append(list_html);

		    	var m = 0;	 
		    	var count = 0;
		    	var rank_count = 0;
		    	var index = 0;
		    	var storeinfo_ = data[m];	
    			$("#staffrank_list tr [rank]").each(function(){
    				count++;
    				if(index == m){
    					index++;
    					var rank_td = $("#staffrank_list tr")[m].children;
	    				for (var k = 0; k < rank_td.length; k++) {
	    					var rank_num = rank_td[k].getAttribute("rank");
	    					if(rank_num != null){
		    					rank_count++;
		    				}
	    				}
    				}   				
    				
    				if(count>rank_count){
    					m++;
    				}

    				storeinfo_ = data[m];
    				for (var n = 0; n < len; n++) {
	    				var td_rank_val = $(this).attr("rank");
	    				if(storeinfo_[n] != undefined){
	    					if(td_rank_val == storeinfo_[n].RANKID){
		    					$(this).html(storeinfo_[n].rankid_count);
		    				}
	    				}	    				
    				}

    			});		    			

		    });

	    });
       
    }
</script>