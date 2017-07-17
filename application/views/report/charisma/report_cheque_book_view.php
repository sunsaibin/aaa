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
			<div class="inputd-group report-radio">
	            <lable class="label-control txt-color">展示：</lable>
	            <lable class="radio-inline">
	                <input type="radio" name="choose-type"  checked="checked" value="1">按日期
	            </lable>
	            <lable class="radio-inline">
	                <input type="radio" name="choose-type"  value="2">按门店
	            </lable>
	        </div>
			<div class="inputd-group" onclick="prevent_repeat_click_search()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">查询</button>
			</div>
			<div class="inputd-group" onclick="prevent_repeat_click_generate()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">生成凭证</button>
			</div>
			<div class="inputd-group" onclick="to_cheque_book_evidence()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">查看凭证列表</button>
			</div>
		</div>
		<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
		<!------------------------------------------------------------------------->
		<div class="product-bottom">
			<div class="table-product row">
				<div class=" product-bottom-table table-responsive col-xs-9 table-set" id="contentDiv">
					<table class="table table-bordered table-condensed">
						<thead id="head_title">
							<tr>
								<th><a id="check-all" href="javascript:;" onclick="checkAll()">全选</a> | <a id="uncheck-all" href="javascript:;" onclick="uncheckAll()">反选</span></th>
								<th>日期/门店</th>
								<th>科目代码</th>
								<th>摘要</th>
								<th>一级科目</th>
								<th>二级科目</th>
								<th>过账</th>
								<th>借方</th>
								<th>贷方</th>
							</tr>
						</thead>
						<tbody id="account_list">
						</tbody>
					</table>
					
					<!-- <div class="fpag" style="position:inherit">
						<span class="pre btn-search" onclick="search_flowlist('',-1)"><img src="<?php echo base_url();?>/jslibs/content/images/pre-icon.png" alt="pre"></span>
						<span class="curent-pae">第<span id="current_page">1</span>页</span>
						<span class="curent-query">转到第&nbsp;<input type="text" id="search_flowlist">&nbsp;页</span>
						<span class="next btn-search" onclick="search_flowlist('',1)"><img src="<?php echo base_url();?>/jslibs/content/images/next-icon.png" alt="pre"></span>
					</div> -->
				</div>
				<div class="" id="floorDiv" style="width: 74.6%; position: fixed; top: 97%;left:0px; background: white;">
					<table class="table table-bordered table-condensed" style="height:30px;">
						<tbody id="totalCol">	
						</tbody>
					</table>
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
				get_start_toDay();
				get_end_toDay();
			});

			// 防止多次点击重复执行
			var timer;
			function prevent_repeat_click_search()
			{
				timer && clearTimeout(timer);
			    timer = setTimeout(function() {
			        console.log(0);
			        search_cheque_book();
			    }, 500);
			}

			function search_cheque_book()
			{
				var account_obj = $("#account_list");
				account_obj.children().remove();
				var totalColObj = $("#totalCol");
				totalColObj.children().remove();

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
				var choose_type_val = $('input:radio[name="choose-type"]:checked').val();

				$.ajax({
			        type:'post',
			        url: annotation_siteurl+"/report_cheque/get_cheque_book_data",
			        data:{seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val, choose_type: choose_type_val,},
			        dataType:'json',
			        async: true
			    })
			    .success(function(data){
			    	console.log(data);
			    	var account_html = '';

			    	for (var i = data.length - 1; i >= 0; i--) {
			    		var item = data[i];
			    		account_html += "<tr><td><input type='hidden' class='hidden_cb_id' value="+item.cb_id+"><input type='checkbox' name='checkbox_name' class='checked_storeid' value="+item.cb_store+" companyval="+item.COMPANYID+"></td><td>"+item.col1+"</td><td>"+item.cb_code+"</td><td>"+item.cb_summary+"</td><td>"+item.cb_accounts+"</td><td>"+item.cb_particulars+"</td><td>"+item.cb_posting+"</td><td>"+parseFloat(item.cb_debit).toFixed(2)+"</td><td>"+parseFloat(item.cb_credit).toFixed(2)+"</td></tr>";
			    	}
			    	
			    	account_obj.append(account_html);

			    	var total_col8 = 0;
			    	var total_col9 = 0;
			    	$("#account_list tr").each(function(){
			    		$(this).find('td:eq(7)').each(function(){
			    			total_col8 += parseFloat($(this).text());
			    		});

			    		$(this).find('td:eq(8)').each(function(){
			    			total_col9 += parseFloat($(this).text());
			    		});
			    	});

			    	var totalColHtml = "<tr><td>合计:</td><td></td><td></td><td></td><td></td><td></td><td></td><td>"+parseFloat(total_col8).toFixed(2)+"</td><td>"+parseFloat(total_col9).toFixed(2)+"</td></tr>";
			    	totalColObj.append(totalColHtml);
			    	for(var i=0;i<document.getElementById("account_list").rows[0].cells.length;i++)
					{
					 document.getElementById("totalCol").rows[0].cells[i].width=document.getElementById("account_list").rows[0].cells[i].offsetWidth;
					}

			    });
			}

			// 全选
			function checkAll() {  
  
			  var code_Values = document.all['checkbox_name'];  
			  
			  if (code_Values.length) {  
			    for ( var i = 0; i < code_Values.length; i++) {  
			      code_Values[i].checked = true;  
			    }  
			  } else {  
			   code_Values.checked = true;  
			  }  
			}     
			 
			// 反选 
			function uncheckAll() {  
			  
			  var code_Values = document.all['checkbox_name'];  
			  
			  if (code_Values.length) {  
			    for ( var i = 0; i < code_Values.length; i++) {  
			      code_Values[i].checked = false;  
			    }  
			  } else {  
			    code_Values.checked = false;  
			  }  
			}

			// 防止多次点击重复执行
			var timer;
			function prevent_repeat_click_generate()
			{
				timer && clearTimeout(timer);
			    timer = setTimeout(function() {
			        console.log(0);
			        generate_cheque_book_evidence();
			    }, 5000);
			}

			function generate_cheque_book_evidence()
			{
				var cb_store_arr = new Array();
				var cb_company_arr = new Array();
				var cb_id_arr = new Array();
				var cb_code_arr = new Array();
				var staffid = "<?php echo $staffid;?>";
				$(".hidden_cb_id").each(function(){
					if($(this).next().is(":checked")){
						var cb_store = $(this).next().val();
						cb_store_arr.push(cb_store);
						var cb_company = $(this).next().attr("companyval");
						cb_company_arr.push(cb_company);

						var cb_id = $(this).val();
						
						var tr_obj_childrens = $(this).parent().parent().children();
						cb_code_arr.push(tr_obj_childrens[2].textContent);
						cb_id_arr.push(cb_id);
					}
					
				});
				//console.log(cb_store_arr);
				//console.log(cb_company_arr);
				//console.log(cb_id_arr);
				$.ajax({
			        type:'post',
			        url: annotation_siteurl+"/report_cheque/generate_cheque_book_evidence",
			        data:{company_ids:cb_company_arr, store_ids:cb_store_arr, staffid:staffid, cb_ids:cb_id_arr, cb_codes:cb_code_arr},
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
				
			}

			function to_cheque_book_evidence()
			{
				location.href = "<?php echo base_url();?>index.php/report_cheque/cheque_book_evidence";
			}
		</script>
	</body>
</html>

