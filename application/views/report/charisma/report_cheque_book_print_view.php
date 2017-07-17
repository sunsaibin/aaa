<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link id="bs-css" href="http://op.faxianbook.com/php/webroot//jslibs/charisma/css/bootstrap-cerulean.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/laydate/need/laydate.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/cheque_style.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/searchnode.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/themes/default/style.min.css" />
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/modifBusiDoc.css"> -->
	</head>
	<body>
		<div class="inputd-group">
			<button id="button" class="btn btn-default btn-sm" style="float:left;background-color: rgb(0, 204, 255);color:#fff;">打印</button>
		</div>
		<!-- <div class="mobudoc-head" style="padding-left: 375px;float:left">
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
			<div class="inputd-group" onclick="search_cheque_book()">
				<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">查询</button>
			</div>
		</div>
		<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>"> -->
		<div class="accout" style="clear: both">
			<!-------------------------------------->
			<div class="header">
				<!--------------------------------------------->
				<div>
					<div class="header-left">
						<p>点美</p>
						<p>DIANMEI</p>
					</div>
					<div class="middle">
						<div class="header-middle">记账凭证</div>
						<div class="date">
							<span id="happenddate_year" style="display: inline-block; width:28px ;"><?php echo $year;?></span><span>年</span>
							<span id="happenddate_month" style="display: inline-block; width:14px ;"><?php echo $month;?></span><span>月</span>
							<span id="happenddate_day" style="display: inline-block; width:14px ;"><?php echo $day;?></span><span>日</span>
						</div>
					</div>
					<div class="table" style="width:20%;">
						<table  cellpadding="0" cellspacing="0">
							<tr>
								<td width="60px">总号</td>
								<td width="160px"></td>
							</tr>
							<tr>
								<td>分号</td>
								<td></td>
							</tr>
						</table>
				    <div class="attachment">
							<span>附件</span>
							<span style="width: 30px; display: inline-block;"><!--4--></span><span>张</span>
						</div>
					</div>
				</div>
				<!-------------------------------------------->
			</div>
			<!------------------------------------>
			<div class="content">
				<div class="content-left">
					<span><?php echo $cheque_name_data[0]->cbn_name?></span>
					<!-- <span>货号:139-30</span> -->
				</div>
				<div class="content-table">
					<table cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th rowspan="2" width="275px" style="letter-spacing: 18px;text-align: center;">摘要</th>
								<th rowspan="2" width="200px" style="letter-spacing: 10px;text-align: center;">一级科目</th>
								<th rowspan="2" width="200px" style="letter-spacing: 2px;text-align: center;">二级及明细科目</th>
								<th rowspan="2" width="20px" style="text-align: center;">过账</th>
								<th></th>
								<th colspan="10" width="160px" style="letter-spacing: 4px;text-align: center;">借方金额</th>
								<th></th>
								<th colspan="10" width="160px" style="letter-spacing: 4px;text-align: center;">贷方金额</th>
							</tr>
							<tr style="font-size: 12px;">
							<th width="4px"></th>
							<th>千</th>
							<th class="space-set">百</th>
							<th>十</th>
							<th>万</th>
							<th class="space-set">千</th>
							<th>百</th>
							<th>十</th>
							<th class="space-set">元</th>
							<th>角</th>
							<th>分</th>
					    <th width="4px"></th>
							<th>千</th>
							<th class="space-set">百</th>
							<th>十</th>
							<th>万</th>
							<th class="space-set">千</th>
							<th>百</th>
							<th>十</th>
							<th class="space-set">元</th>
							<th>角</th>
							<th>分</th>
						</tr>
						</thead>
						<tbody id="accountList">
						<?php
							$debit_total = 0;
							$credit_total = 0;
							foreach ($evidence_detail as $key => $value) {
								$debit_total += $value->ced_debit;

								$debit_point_site = strpos($value->ced_debit,'.');
								$debit_2 = substr($value->ced_debit,$debit_point_site+2,1);// 分
								$debit_1 = substr($value->ced_debit,$debit_point_site+1,1);// 角
								$debit1 = substr($value->ced_debit,$debit_point_site-1,1);// 元
								$debit2 = substr($value->ced_debit,$debit_point_site-2,1);// 十
								$debit3 = substr($value->ced_debit,$debit_point_site-3,1);// 百
								$debit4 = substr($value->ced_debit,$debit_point_site-4,1);// 千
								$debit5 = substr($value->ced_debit,$debit_point_site-5,1);// 万
								$debit6 = substr($value->ced_debit,$debit_point_site-6,1);// 十万
								$debit7 = substr($value->ced_debit,$debit_point_site-7,1);// 百万
								$debit8 = substr($value->ced_debit,$debit_point_site-8,1);// 千万
								if($debit_point_site-2 < 0){
									$debit2 = 0;
								}
								if($debit_point_site-3 < 0){
									$debit3 = 0;
								}
								if($debit_point_site-4 < 0){
									$debit4 = 0;
								}
								if($debit_point_site-5 < 0){
									$debit5 = 0;
								}
								if($debit_point_site-6 < 0){
									$debit6 = 0;
								}
								if($debit_point_site-7 < 0){
									$debit7 = 0;
								}
								if($debit_point_site-8 < 0){
									$debit8 = 0;
								}

								$credit_total += $value->ced_credit;
								$credit_point_site = strpos($value->ced_credit,'.');
								$credit_2 = substr($value->ced_credit,$credit_point_site+2,1);// 分
								$credit_1 = substr($value->ced_credit,$credit_point_site+1,1);// 角
								$credit1 = substr($value->ced_credit,$credit_point_site-1,1);// 元
								$credit2 = substr($value->ced_credit,$credit_point_site-2,1);// 十
								$credit3 = substr($value->ced_credit,$credit_point_site-3,1);// 百
								$credit4 = substr($value->ced_credit,$credit_point_site-4,1);// 千
								$credit5 = substr($value->ced_credit,$credit_point_site-5,1);// 万
								$credit6 = substr($value->ced_credit,$credit_point_site-6,1);// 十万
								$credit7 = substr($value->ced_credit,$credit_point_site-7,1);// 百万
								$credit8 = substr($value->ced_credit,$credit_point_site-8,1);// 千万
								if($credit_point_site-2 < 0){
									$credit2 = 0;
								}
								if($credit_point_site-3 < 0){
									$credit3 = 0;
								}
								if($credit_point_site-4 < 0){
									$credit4 = 0;
								}
								if($credit_point_site-5 < 0){
									$credit5 = 0;
								}
								if($credit_point_site-6 < 0){
									$credit6 = 0;
								}
								if($credit_point_site-7 < 0){
									$credit7 = 0;
								}
								if($credit_point_site-8 < 0){
									$credit8 = 0;
								}
								//echo "<br>";var_dump($value->cb_debit);echo "<br>";
								//var_dump("千万：".$debit8."<br>百万：".$debit7."<br>十万：".$debit6."<br>万：".$debit5."<br>千：".$debit4."<br>百：".$debit3."<br>十：".$debit2."<br>元：".$debit1."<br>角：".$debit_1."<br>分：".$debit_2);
								echo "<tr><td>".$value->ced_summary."</td><td>".$value->ced_accounts."</td><td>".$value->ced_particulars."</td><td>".$value->ced_posting."</td><td></td><td>".$debit8."</td><td>".$debit7."</td><td>".$debit6."</td><td>".$debit5."</td><td>".$debit4."</td><td>".$debit3."</td><td>".$debit2."</td><td>".$debit1."</td><td>".$debit_1."</td><td>".$debit_2."</td><td></td><td>".$credit8."</td><td>".$credit7."</td><td>".$credit6."</td><td>".$credit5."</td><td>".$credit4."</td><td>".$credit3."</td><td>".$credit2."</td><td>".$credit1."</td><td>".$credit_1."</td><td>".$credit_2."</td></tr>";
							}
							// 借方合计
							$debit_total = sprintf("%.2f", $debit_total);
							$debit_total_point_site = strpos($debit_total,'.');
							$debit_total_2 = substr($debit_total,$debit_total_point_site+2,1);// 分
							$debit_total_1 = substr($debit_total,$debit_total_point_site+1,1);// 角
							$debit_total1 = substr($debit_total,$debit_total_point_site-1,1);// 元
							$debit_total2 = substr($debit_total,$debit_total_point_site-2,1);// 十
							$debit_total3 = substr($debit_total,$debit_total_point_site-3,1);// 百
							$debit_total4 = substr($debit_total,$debit_total_point_site-4,1);// 千
							$debit_total5 = substr($debit_total,$debit_total_point_site-5,1);// 万
							$debit_total6 = substr($debit_total,$debit_total_point_site-6,1);// 十万
							$debit_total7 = substr($debit_total,$debit_total_point_site-7,1);// 百万
							$debit_total8 = substr($debit_total,$debit_total_point_site-8,1);// 千万
							if($debit_total_point_site-2 < 0){
								$debit_total2 = 0;
							}
							if($debit_total_point_site-3 < 0){
								$debit_total3 = 0;
							}
							if($debit_total_point_site-4 < 0){
								$debit_total4 = 0;
							}
							if($debit_total_point_site-5 < 0){
								$debit_total5 = 0;
							}
							if($debit_total_point_site-6 < 0){
								$debit_total6 = 0;
							}
							if($debit_total_point_site-7 < 0){
								$debit_total7 = 0;
							}
							if($debit_total_point_site-8 < 0){
								$debit_total8 = 0;
							}

							// 贷方合计
							$credit_total = sprintf("%.2f", $credit_total);
							$credit_total_point_site = strpos($credit_total,'.');
							$credit_total_2 = substr($credit_total,$credit_total_point_site+2,1);// 分
							$credit_total_1 = substr($credit_total,$credit_total_point_site+1,1);// 角
							$credit_total1 = substr($credit_total,$credit_total_point_site-1,1);// 元
							$credit_total2 = substr($credit_total,$credit_total_point_site-2,1);// 十
							$credit_total3 = substr($credit_total,$credit_total_point_site-3,1);// 百
							$credit_total4 = substr($credit_total,$credit_total_point_site-4,1);// 千
							$credit_total5 = substr($credit_total,$credit_total_point_site-5,1);// 万
							$credit_total6 = substr($credit_total,$credit_total_point_site-6,1);// 十万
							$credit_total7 = substr($credit_total,$credit_total_point_site-7,1);// 百万
							$credit_total8 = substr($credit_total,$credit_total_point_site-8,1);// 千万
							if($credit_total_point_site-2 < 0){
								$credit_total2 = 0;
							}
							if($credit_total_point_site-3 < 0){
								$credit_total3 = 0;
							}
							if($credit_total_point_site-4 < 0){
								$credit_total4 = 0;
							}
							if($credit_total_point_site-5 < 0){
								$credit_total5 = 0;
							}
							if($credit_total_point_site-6 < 0){
								$credit_total6 = 0;
							}
							if($credit_total_point_site-7 < 0){
								$credit_total7 = 0;
							}
							if($credit_total_point_site-8 < 0){
								$credit_total8 = 0;
							}
						?>
						</tbody>
						<tfoot id="accountTotal">
							<tr>
									<td colspan="3">合计</td>
									<td></td>
									<td></td>
									<td><?php echo $debit_total8;?></td>
									<td><?php echo $debit_total7;?></td>
									<td><?php echo $debit_total6;?></td>
									<td><?php echo $debit_total5;?></td>
									<td><?php echo $debit_total4;?></td>
									<td><?php echo $debit_total3;?></td>
									<td><?php echo $debit_total2;?></td>
									<td><?php echo $debit_total1;?></td>
									<td><?php echo $debit_total_1;?></td>
									<td><?php echo $debit_total_2;?></td>
									<td></td>
									<td><?php echo $credit_total8;?></td>
									<td><?php echo $credit_total7;?></td>
									<td><?php echo $credit_total6;?></td>
									<td><?php echo $credit_total5;?></td>
									<td><?php echo $credit_total4;?></td>
									<td><?php echo $credit_total3;?></td>
									<td><?php echo $credit_total2;?></td>
									<td><?php echo $credit_total1;?></td>
									<td><?php echo $credit_total_1;?></td>
									<td><?php echo $credit_total_2;?></td>
							</tr>
						</tfoot>
						
					</table>
				</div>
			</div>
		  <div class="footer">
		  	<div class="list"><span>财会主管</span><span class="list-result"><!--张三--></span></div>
		  	<div class="list"><span>复核</span><span class="list-result"><!--同意--></span></div>
				<div class="list"><span>记账</span><span class="list-result"><!--记账--></span></div>
				<div class="list"><span>制单</span><span class="list-result"><!--制单--></span></div>
		  </div>
		</div>
		<!-- <div class="fpag" style="padding-left: 400px;margin-top: 5px;">
			<span class="pre btn-search" onclick="search_flowlist('',-1)"><img src="<?php echo base_url();?>/jslibs/content/images/pre-icon.png" alt="pre"></span>
			<span class="curent-pae">第<span id="current_page">1</span>页</span>
			<span class="curent-query">转到第&nbsp;<input type="text" id="search_flowlist">&nbsp;页</span>
			<span class="next btn-search" onclick="search_flowlist('',1)"><img src="<?php echo base_url();?>/jslibs/content/images/next-icon.png" alt="pre"></span>
		</div> -->
	<!-- <div class="nodeTreeBox"></div> -->
	<!-- <script type="application/javascript">
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
	</script> -->
	<script src="<?php echo base_url(); ?>/jslibs/content/bootstrap/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/laydate/laydate.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/modifBusiDoc.js"></script>
	<!-- <script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script> -->
	<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
		<script type="text/javascript">
			var annotation_siteurl = "<?php echo site_url(); ?>";

			var oButton=document.getElementById('button');
			var accountList = $('#accountList');
			//打印
			oButton.onclick=function(){
				this.style.display="none";
				window.print();
			}
			$.ajax({
				type:"get",
				url:"data.json",
				async:true,
				dataType:"json",
		    success:function(data){	
		    
			    for(var item in data.message){  //循环message的6个对象
			      var obj=data.message[item]; //获取每个对象的内容
			      console.log(obj);
				    
				    //处理前四列数据
						var  tr = $('<tr></tr>');
						var i = 1;
			      for(key in obj){
			      	if(i==5){
			      		break;
			      	}
				      var td = $('<td></td>');
				      td.text(obj[key]);
				      tr.append(td);
			       	i++;
			      }
			      
			      tr.append('<td></td>');//加一个空的td
			      
			      // 借方金额处理
			      var borrowMon = obj.borrowMon;
			      var num=borrowMon.split('.');
			      var len=num[0].length+num[1].length;
			      for(var j = 0; j<10-len;j++){
			      	tr.append('<td></td>');
			      }
			      tr.append(getSub(num[0]));//添加前半部分数据如1500
			      
			      tr.append(getSub(num[1]));//添加后半部分数据如01
			      
			      tr.append('<td></td>');//加一个空的td
			      
			      // 贷方金额处理
			      var loanMon = obj.loanMon;
			      var num2=loanMon.split('.');
			      var len2=num2[0].length+num2[1].length;
			      for(var j = 0; j<10-len2;j++){
			      	tr.append('<td></td>');
			      }
			      tr.append(getSub(num2[0]));
			      
			      tr.append(getSub(num2[1]));
			      accountList.append(tr);
			     }
		    	
		    }
			});

			 function getSub(numstr){
			 	var subC = "";
			 	for(var k=0;k<numstr.length;k++){
			      var	sub = numstr.substring(k,k+1);
			      var subTd = '<td>'+ sub +'</td>';
			      subC += subTd;
			  }
			 	return subC;
			 }
			
			// 默认起始日期为当天
			function get_start_toDay()
			{
				var start_toDay = document.getElementById("start_date");
				if(start_toDay.value.length<4){
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

			function back_evidence() {
				window.location.href = "<?php echo base_url();?>index.php/report_cheque/cheque_book_evidence";
			}

			/*function search_cheque_book()
			{
				var account_list_obj = $("#accountList");
				var account_total_obj = $("#accountTotal");
				account_list_obj.children().remove();
				account_total_obj.children().remove();

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
			        url: annotation_siteurl+"/report_cheque/get_cheque_book_data",
			        data:{seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val},
			        dataType:'json',
			        async: true
			    })
			    .success(function(data){
			    	console.log(data);
			    	var happendate = data[0].cb_happendate;
			    	happendate = new Date(Date.parse(happendate.replace(/-/g, "/")));
			    	var happenddate_year = happendate.getFullYear();
			    	var happenddate_month = happendate.getMonth();
			    	var happendate_day = happendate.getDate();
			    	$("#happenddate_year").html(happenddate_year);
			    	$("#happenddate_month").html(happenddate_month+1);
			    	$("#happenddate_day").html(happendate_day);

			    	var debit_total = 0;
					var credit_total = 0;
					
			    	for (var i = data.length - 1; i >= 0; i--) {
			    		var item = data[i];
			    		var cb_debit = item.cb_debit;
			    		debit_total += parseFloat(cb_debit);

						var debit_point_site = cb_debit.indexOf('.');
						var debit_2 = cb_debit.substring(debit_point_site+2,debit_point_site+3);// 分
						var debit_1 = cb_debit.substring(debit_point_site+1,debit_point_site+2);// 角
						var debit1 = cb_debit.substring(debit_point_site-1,debit_point_site);// 元
						var debit2 = cb_debit.substring(debit_point_site-2,debit_point_site-1);// 十
						var debit3 = cb_debit.substring(debit_point_site-3,debit_point_site-2);// 百
						var debit4 = cb_debit.substring(debit_point_site-4,debit_point_site-3);// 千
						var debit5 = cb_debit.substring(debit_point_site-5,debit_point_site-4);// 万
						var debit6 = cb_debit.substring(debit_point_site-6,debit_point_site-5);// 十万
						var debit7 = cb_debit.substring(debit_point_site-7,debit_point_site-6);// 百万
						var debit8 = cb_debit.substring(debit_point_site-8,debit_point_site-7);// 千万
						if(debit_point_site-2 < 0){
							debit2 = 0;
						}
						if(debit_point_site-3 < 0){
							debit3 = 0;
						}
						if(debit_point_site-4 < 0){
							debit4 = 0;
						}
						if(debit_point_site-5 < 0){
							debit5 = 0;
						}
						if(debit_point_site-6 < 0){
							debit6 = 0;
						}
						if(debit_point_site-7 < 0){
							debit7 = 0;
						}
						if(debit_point_site-8 < 0){
							debit8 = 0;
						}

						var cb_credit = item.cb_credit;
			    		credit_total += parseFloat(cb_credit);

						var credit_point_site = cb_credit.indexOf('.');
						var credit_2 = cb_credit.substring(credit_point_site+2,credit_point_site+3);// 分
						var credit_1 = cb_credit.substring(credit_point_site+1,credit_point_site+2);// 角
						var credit1 = cb_credit.substring(credit_point_site-1,credit_point_site);// 元
						var credit2 = cb_credit.substring(credit_point_site-2,credit_point_site-1);// 十
						var credit3 = cb_credit.substring(credit_point_site-3,credit_point_site-2);// 百
						var credit4 = cb_credit.substring(credit_point_site-4,credit_point_site-3);// 千
						var credit5 = cb_credit.substring(credit_point_site-5,credit_point_site-4);// 万
						var credit6 = cb_credit.substring(credit_point_site-6,credit_point_site-5);// 十万
						var credit7 = cb_credit.substring(credit_point_site-7,credit_point_site-6);// 百万
						var credit8 = cb_credit.substring(credit_point_site-8,credit_point_site-7);// 千万
						if(credit_point_site-2 < 0){
							credit2 = 0;
						}
						if(credit_point_site-3 < 0){
							credit3 = 0;
						}
						if(credit_point_site-4 < 0){
							credit4 = 0;
						}
						if(credit_point_site-5 < 0){
							credit5 = 0;
						}
						if(credit_point_site-6 < 0){
							credit6 = 0;
						}
						if(credit_point_site-7 < 0){
							credit7 = 0;
						}
						if(credit_point_site-8 < 0){
							credit8 = 0;
						}		    		
			    		
			    		var account_list_html = "<tr><td>"+item.cb_summary+"</td><td>"+item.cb_accounts+"</td><td>"+item.cb_particulars+"</td><td>"+item.cb_posting+"</td><td></td><td>"+debit8+"</td><td>"+debit7+"</td><td>"+debit6+"</td><td>"+debit5+"</td><td>"+debit4+"</td><td>"+debit3+"</td><td>"+debit2+"</td><td>"+debit1+"</td><td>"+debit_1+"</td><td>"+debit_2+"</td><td></td><td>"+credit8+"</td><td>"+credit7+"</td><td>"+credit6+"</td><td>"+credit5+"</td><td>"+credit4+"</td><td>"+credit3+"</td><td>"+credit2+"</td><td>"+credit1+"</td><td>"+credit_1+"</td><td>"+credit_2+"</td></tr>";
			    		account_list_obj.append(account_list_html);
			    	}

			    	// 借方合计
			    	debit_total = debit_total.toFixed(2);
					debit_total_point_site = debit_total.indexOf('.');
					debit_total_2 = debit_total.substring(debit_total_point_site+2,debit_total_point_site+3);// 分
					debit_total_1 = debit_total.substring(debit_total_point_site+1,debit_total_point_site+2);// 角
					debit_total1 = debit_total.substring(debit_total_point_site-1,debit_total_point_site);// 元
					debit_total2 = debit_total.substring(debit_total_point_site-2,debit_total_point_site-1);// 十
					debit_total3 = debit_total.substring(debit_total_point_site-3,debit_total_point_site-2);// 百
					debit_total4 = debit_total.substring(debit_total_point_site-4,debit_total_point_site-3);// 千
					debit_total5 = debit_total.substring(debit_total_point_site-5,debit_total_point_site-4);// 万
					debit_total6 = debit_total.substring(debit_total_point_site-6,debit_total_point_site-5);// 十万
					debit_total7 = debit_total.substring(debit_total_point_site-7,debit_total_point_site-6);// 百万
					debit_total8 = debit_total.substring(debit_total_point_site-8,debit_total_point_site-7);// 千万
					if(debit_total_point_site-2 < 0){
						debit_total2 = 0;
					}
					if(debit_total_point_site-3 < 0){
						debit_total3 = 0;
					}
					if(debit_total_point_site-4 < 0){
						debit_total4 = 0;
					}
					if(debit_total_point_site-5 < 0){
						debit_total5 = 0;
					}
					if(debit_total_point_site-6 < 0){
						debit_total6 = 0;
					}
					if(debit_total_point_site-7 < 0){
						debit_total7 = 0;
					}
					if(debit_total_point_site-8 < 0){
						debit_total8 = 0;
					}

					// 贷方合计
					credit_total = credit_total.toFixed(2);
					credit_total_point_site = credit_total.indexOf('.');
					credit_total_2 = credit_total.substring(credit_total_point_site+2,credit_total_point_site+3);// 分
					credit_total_1 = credit_total.substring(credit_total_point_site+1,credit_total_point_site+2);// 角
					credit_total1 = credit_total.substring(credit_total_point_site-1,credit_total_point_site);// 元
					credit_total2 = credit_total.substring(credit_total_point_site-2,credit_total_point_site-1);// 十
					credit_total3 = credit_total.substring(credit_total_point_site-3,credit_total_point_site-2);// 百
					credit_total4 = credit_total.substring(credit_total_point_site-4,credit_total_point_site-3);// 千
					credit_total5 = credit_total.substring(credit_total_point_site-5,credit_total_point_site-4);// 万
					credit_total6 = credit_total.substring(credit_total_point_site-6,credit_total_point_site-5);// 十万
					credit_total7 = credit_total.substring(credit_total_point_site-7,credit_total_point_site-6);// 百万
					credit_total8 = credit_total.substring(credit_total_point_site-8,credit_total_point_site-7);// 千万
					if(credit_total_point_site-2 < 0){
						credit_total2 = 0;
					}
					if(credit_total_point_site-3 < 0){
						credit_total3 = 0;
					}
					if(credit_total_point_site-4 < 0){
						credit_total4 = 0;
					}
					if(credit_total_point_site-5 < 0){
						credit_total5 = 0;
					}
					if(credit_total_point_site-6 < 0){
						credit_total6 = 0;
					}
					if(credit_total_point_site-7 < 0){
						credit_total7 = 0;
					}
					if(credit_total_point_site-8 < 0){
						credit_total8 = 0;
					}
					
					var account_total_html = '<tr><td colspan="3">合计</td><td></td><td></td><td>'+debit_total8+'</td><td>'+debit_total7+'</td><td>'+debit_total6+'</td><td>'+debit_total5+'</td><td>'+debit_total4+'</td><td>'+debit_total3+'</td><td>'+debit_total2+'</td><td>'+debit_total1+'</td><td>'+debit_total_1+'</td><td>'+debit_total_2+'</td><td></td><td>'+credit_total8+'</td><td>'+credit_total7+'</td><td>'+credit_total6+'</td><td>'+credit_total5+'</td><td>'+credit_total4+'</td><td>'+credit_total3+'</td><td>'+credit_total2+'</td><td>'+credit_total1+'</td><td>'+credit_total_1+'</td><td>'+credit_total_2+'</td></tr>';
					account_total_obj.append(account_total_html);
			    });
			}*/
		</script>
	</body>
</html>

