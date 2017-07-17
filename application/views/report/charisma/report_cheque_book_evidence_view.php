<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link id="bs-css" href="http://op.faxianbook.com/php/webroot//jslibs/charisma/css/bootstrap-cerulean.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/laydate/need/laydate.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/css/my.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/iconfont/iconfont.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/charisma/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/searchnode.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/themes/default/style.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/dm_alert.css">
	</head>
	<body>
		<div class="mobudoc-head" style="padding-top: 30px;">
			<div class="inputd-group" >
				<lable class="label-control">当前门店：</lable>
				<input type="text" class="fm-control fm-disabled" value="<?php echo $seach_name;?>" readonly="true" id="searchStoreId" name="seach_name">
			</div>
			<div class="menu inputd-group-margin" onclick="showTree()"><img src="<?php echo base_url("");?>/jslibs/content/images/menu-icon.svg" alt="menu"></div>
			<div class="inputd-group">
				<lable class="label-control">日期：</lable>
				<input type="text" class="fm-control date" id="start_date" onclick="laydate()">
			</div>
			<div class="inputd-group">
				<label class="label-control">至</label>
				<input type="text" class="fm-control  date" id="end_date" onclick="laydate()">
			</div>
			<!-- <div class="inputd-group report-radio">
	            <lable class="label-control txt-color">展示：</lable>
	            <lable class="radio-inline">
	                <input type="radio" name="choose-type"  checked="checked" value="1">按日期
	            </lable>
	            <lable class="radio-inline">
	                <input type="radio" name="choose-type"  value="2">按门店
	            </lable>
	        </div> -->
			<div class="inputd-group" onclick="prevent_repeat_click('','',this)">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">查询</button>
			</div>
			<div class="inputd-group" onclick="back_cheque_book()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">返回</button>
			</div>
			<!-- <div class="inputd-group" onclick="to_print_view()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">生成凭证</button>
			</div> -->
		</div>
		<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
		<!------------------------------------------------------------------------->
		<div class="product-bottom">
			<div class="table-product row">
				<div class=" product-bottom-table table-responsive col-xs-9 table-set">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th>门店</th>
								<th>凭证单号</th>
								<th>摘要</th>
								<th>凭证金额</th>
								<th>操作员工</th>
								<th>凭证状态</th>
								<th>生成时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="evidence_list">
						</tbody>
				</table>
					<div class="fpag" style="position:inherit">
						<span class="pre btn-search" onclick="prevent_repeat_click(-1)"><img src="<?php echo base_url();?>/jslibs/content/images/pre-icon.png" alt="pre"></span>
						<span class="curent-pae">第<span id="current_page">1</span>页</span>
						<span class="curent-query">转到第&nbsp;<input type="text" id="search_evidencelist">&nbsp;页</span>
						<span class="next btn-search" onclick="prevent_repeat_click(1)"><img src="<?php echo base_url();?>/jslibs/content/images/next-icon.png" alt="pre"></span>
					</div>
				</div>
			</div>
			</div>
		<!------------------------------------------------>
		</div>
	<div class="nodeTreeBox"></div>
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
	<script src="<?php echo base_url(); ?>/jslibs/content/bootstrap/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/laydate/laydate.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/modifBusiDoc.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
		<script type="text/javascript">
			var annotation_siteurl = "<?php echo site_url(); ?>";
			
			// 默认起始日期为当月第一天
			function get_start_toDay()
			{
				var start_toDay = document.getElementById("start_date");
				if(start_toDay.value.length<4){
					/*$.AlertDialog.CreateAlert("警告","请选择日期！");
					return null;*/
					var date = new Date();
					date.setDate(1); //设置为第一天
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

			// 防止多次点击重复执行
			var timer;
			function prevent_repeat_click(pre_next,pagenum = 1)
			{
				timer && clearTimeout(timer);
			    timer = setTimeout(function() {
			        console.log(0);
			        search_cheque_book_evidence(pre_next,pagenum);
			    }, 500);
			}

			function search_cheque_book_evidence(pre_next,pagenum)
			{
				
				var current_page = parseInt($("#current_page").html());
				if(pre_next == -1){
					pagenum = current_page - 1;
				}else if(pre_next == 1){
					pagenum = current_page + 1;
				}

				var evidence_obj = $("#evidence_list");
				evidence_obj.children().remove();
				var stroe_val = $("#searchStoreId").val();
		        var default_value = "<?php echo $seach_name; ?>";
		        if(default_value != stroe_val || stroe_val.length<1){
		            $("#seach_companyid").val(selectCompId);
		            $("#seach_storeid").val(selectStoreId);
		        }
		        var seach_name_val = $("#searchStoreId").val();
				var seach_storeid_val = $("#seach_storeid").val();
				var seach_companyid_val = $("#seach_companyid").val();
				var start_date_val = $("#start_date").val();
				var end_date_val = $("#end_date").val();

				$.ajax({
			        type:'post',
			        url: annotation_siteurl+"/report_cheque/query_cheque_book_evidence_data/"+pagenum,
			        data:{seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val},
			        dataType:'json',
			        async: true
			    })
			    .success(function(data){
			    	$("#current_page").html(data.pagenum);
			    	var evidence_data = data.evidence_data;
			    	console.log(data);
			    	var evidence_html = '';

			    	for (var i = evidence_data.length - 1; i >= 0; i--) {
			    		var item = evidence_data[i];
			    		if(item.summary == null){
			    			item.summary = '';
			    		}
						var commaCount = item.summary.match(new RegExp(',', 'g'));
						if(commaCount.length == item.summary.length){
							item.summary = '';
						}
			    		if(item.cbe_staffname == null){
			    			item.cbe_staffname = '';
			    		}
			    		if(item.cbe_status == 1){
			    			item.cbe_status = '未打印';
			    			evidence_html += "<tr><td>"+item.STORENAME+"</td><td>"+item.cbe_id+'-'+item.cbe_number+"</td><td>"+item.summary+"</td><td>"+item.amount+"</td><td>"+item.cbe_staffname+"</td><td>"+item.cbe_status+"</td><td>"+item.cbe_createdate+"</td><td><a class='btn btn-success' style='width:50px;height:15px;padding:0px 8px;' href="+annotation_siteurl+"/report_cheque/cheque_book_print/"+item.cbe_id+'/'+encodeURIComponent(item.cbe_createdate)+">打印</a></td></tr>";
			    		}else{
			    			item.cbe_status = '已打印';
			    			evidence_html += "<tr><td>"+item.STORENAME+"</td><td>"+item.cbe_id+'-'+item.cbe_number+"</td><td>"+item.cbe_staffid+"</td><td>"+item.cbe_status+"</td><td>"+item.cbe_createdate+"</td><td><a class='btn btn-success' style='width:50px;height:15px;padding:0px 8px;' href="+annotation_siteurl+"/report_cheque/cheque_book_print/"+item.cbe_id+'/'+encodeURIComponent(item.cbe_createdate)+" disabled>打印</a></td></tr>";
			    		}
			    	}
			    	
			    	evidence_obj.append(evidence_html);
			    });
			}

			$("#search_evidencelist").keypress(function(e){
				var pagenum = $("#search_evidencelist").val();
				var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
				if(keyCode == 13){
					if($.isNumeric(pagenum)){
						search_cheque_book_evidence(pagenum);
					}
					else{
						alert("输入错误！");
						return false;
					}
				}
			});

			// 控制storeid相同的复选框可以选取
			function checked_store(obj)
			{
				var obj_storeid = obj.value;
				var flag = $("input[type='checkbox']").is(":checked");
				$("input[type='checkbox']").each(function(){
					if($(this).val() != obj_storeid && flag != false){
						$(this).attr("disabled","disabled");
					}else{
						$(this).removeAttr("disabled");
					}
				});
			}

			function to_print_view()
			{
				var cb_id_arr = new Array();
				var cb_code_arr = new Array();
				var staffid = "<?php echo $staffid;?>";
				var cb_store = '';
				$(".hidden_cb_id").each(function(){
					if($(this).next().is(":checked")){
						var cb_id = $(this).val();
						cb_store = $(this).next().val();
						cb_company = $(this).next().attr("companyval");
						var tr_obj_childrens = $(this).parent().parent().children();
						cb_code_arr.push(tr_obj_childrens[2].textContent);
						/*document.cookie = "cb_id"+i+"="+cb_id;
						i++;*/
						cb_id_arr.push(cb_id);
					}
					
				});
				$.ajax({
			        type:'post',
			        url: annotation_siteurl+"/report_cheque/generate_cheque_book_evidence",
			        data:{companyid:cb_company, storeid:cb_store, staffid:staffid, cb_ids:cb_id_arr, cb_codes:cb_code_arr},
			        dataType:'json',
			        async: true
			    })
			    .success(function(data){
			    	console.log(data);
			    	if(data.code == '000'){
			    		$.AlertDialog.CreateAlert(data.msg,'生成成功！');
			    	}else{
			    		$.AlertDialog.CreateAlert(data.msg,'生成失败！');
			    	}	
	    			return;
			    });
				//location.href = "<?php echo base_url();?>index.php/report_cheque/cheque_book_print";
			}

			function back_cheque_book() {
				window.location.href = "<?php echo base_url();?>index.php/report_cheque/cheque_book";
			}
		</script>
	</body>
</html>

