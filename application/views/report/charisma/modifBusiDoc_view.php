<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>业务单据修改</title>
	<link id="bs-css" href="http://op.faxianbook.com/php/webroot//jslibs/charisma/css/bootstrap-cerulean.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/laydate/need/laydate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/modifBusiDoc.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/searchnode.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/searchnode/content/css/themes/default/style.min.css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/css/dm_alert.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/content/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/jquery.autocomplete.css">
</head>
<body>
	<!-- pagecontent begin -->
	<div class="pagecontent">
		<div class=" pull-left mobudoc-left">
			<!-- mobudoc-head begin -->
			<div class="mobudoc-head">
				<div class="inputd-group">
					<lable class="label-control">当前门店：</lable>
					<input type="text" class="fm-control fm-disabled" value="<?php echo $seach_name;?>" readonly="true" id="searchStoreId" name="seach_name">
				</div>
				<div class="menu inputd-group-margin" onclick="showTree()"><img src="<?php echo base_url("");?>/jslibs/content/images/menu-icon.svg" alt="menu"></div>
				<div class="inputd-group">
					<lable class="label-control">日期：</lable>
					<input type="text" class="fm-control fm-control-one date" onclick="laydate()" id="toDay">
				</div>
				<div class="inputd-group">
					<button type="button" class="btn btn-default btn-sm" id="search_btn" style="background-color: #3399ff;color:#fff">查询</button>
				</div>
			</div>
			<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    		<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
			<!-- mobudoc-head end -->
			<!-- mobudoc-left-content begin -->
			<!-- mobudoc-left-content end -->
			<div class="mobudoc-left-content" id="mobudocLeftContent">
				<dl>
					<dt>订单类型</dt>
					<dd class="active" data-num="1" data_type="0"><span>开单收银</span><span></span></dd>
					<dd data-num="2" data_type="1"><span>会员办卡</span><span></span></dd>
					<dd data-num="3" data_type="5"><span>会员充值</span><span></span></dd>
					<!-- <dd data-num="4" data_type="3" onclick="get_list(4);"><span>购买疗程</span><span></span></dd> -->
					<!-- <dd data-num="5" data_type="0" onclick="get_list(5);"><span>会员转卡</span><span></span></dd>
					<dd data-num="6" data_type="0" onclick="get_list(6);"><span>会员并卡</span><span></span></dd> -->
					<dd data-num="8" data_type="0"><span>会员退卡</span><span></span></dd>
				</dl>
				<!-- mobudoc-left-table begin -->
				<div class="mobudoc-left-table">
					<table class="table table-bordered" id="table_list">
						<thead id="thead_list">
							<tr>
								<th>消费单号</th>
								<th>消费卡号</th>
								<th>序号</th>
							</tr>
						</thead>
						<tbody id="tbody_list">
						<!-- <?php
							foreach ($reportOrderData as $key => $value) {
								echo "<tr>";
								echo '<td><a href="#billsOrderset" class="orderno" oid="1" onclick="click_list('.$value->ORDERID.', 1)">'.$value->ORDERNUMBER.'</a></td>';
								echo '<td><a href="#billsOrderset" class="orderno" oid="2" onclick="click_list('.$value->ORDERID.', 1)">'.$value->CARDNUM.'</a></td>';
								echo '<td><a href="#billsOrderset" class="orderno" oid="3" onclick="click_list('.$value->ORDERID.', 1)">'.$value->store_order_number.'</a></td>';
								echo "</tr>";
							}
						?> -->
						</tbody>
					</table>
				</div>
				<!-- mobudoc-left-table end -->
			</div>
			
		</div>
		<div class="mobudoc-right" id="mobudocRight">
			<!-- panel 开单收银 begin -->
			<div class="panel panel-default active" data-num="1">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order" id="billing" style="border-right: none;width:880px;">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">消费门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">订单状态：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="ORDERSTATUS">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control">消费单号：</label>
					    		<input type="text" class="fm-control fm-disabled ordernumber" value="" readonly="true" dmdata="ORDERNUMBER">
						 	</div>
						 	
						</div>
			  		<!-- panel-form-line end -->
						
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
						<div class="inputd-group">
								<label class="label-control">订单序号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="store_order_number">
						 	</div>
					  	<div class="inputd-group">
								<label class="label-control">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control" style="padding-left: 12px;">手牌号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="HANDNUMBER">
						 	</div>
						 	
						</div>
			  		<!-- panel-form-line end -->
						<div class="panel-form-line">
							<div class="inputd-group">
								<label class="label-control">订单来源：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="order_source_name">
						 	</div>
						 	<div class="inputd-group" style="margin-left: 24px;">
								<label class="label-control" style="vertical-align:10px ">备注：</label>
					     	<textarea class="text_explain" style="width: 460px;height: 30px;resize: none; outline: none;border: 1px solid #ccc" ></textarea>
						 	</div>

						 </div>
 					<button class="btn btn-primary btn-save" onclick="update_order_one(this)">保存</button>
			   	</div>

			  	<!-- panel-form-order end -->

			  	<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered  table-condensed">
							<thead>
								<tr>
									<th>编号</th>
									<th>名称</th>
									<th>数量</th>
									<th>支付方式</th>
									<th>金额</th>
									<th>设计师/美容师</th>
									<th>类型</th>
									<th>技师</th>
									<th>类型</th>
								</tr>
							</thead>
							<tbody id="product_list" class="product_list">
								<tr>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNO"></td>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNAME"></td>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNUMBER" ></td>
									<td><input type="text" value="" readonly="true" dmdata="PAYNAME" ></td>
									<td><input type="text" value="" readonly="true" dmdata="real_amount" ></td>
									<td><input type="text" value="" class="tags" ></td>
									<td><input type="text" value="" readonly="true" dmdata="is_specify" ></td>
									<td><input type="text" value="" class="tags" ></td>
									<td><input type="text" value="" readonly="true" dmdata="is_specify_min"></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->
		  		<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>支付方式</th>
									<th>支付金额</th>
									<th>支付状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody id="payinfo_list">
								<tr>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="payname" ></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="total_amout" ></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="PAYNAME" ></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="ORDERMEMO"></td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			</div>
			<!-- panel 开单收银 end -->
			<!-- panel 会员办卡 begin -->
			<div class="panel panel-default" data-num="2">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  <div style="width: 900px">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order" id="opencard" style="float: left;">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">购买门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
					     	<input type="hidden" id="hidden_account_id" value="" dmdata="accountid"/>
						 	</div>
							<div class="inputd-group">
								<label class="label-control">充值金额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="amount">
						 	</div>
						 	
						</div>
			  		<!-- panel-form-line end -->
			  		
			  	
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
						<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" DMDATA="USERNAME">
						 	</div>
					  	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
						 	</div>
						 	
						</div>
 						<div class="panel-form-line">
						<div class="inputd-group">
							<label class="label-control">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
						 </div>
						 <div class="inputd-group" style="padding-left: 64px;">
						 	<button class="btn btn-primary btn-save" onclick="update_order_two(this,2)">保存</button>
						 </div>
 						 </div>


 							  		<!-- panel-form-line end -->
			  	</div>
			  	<div class="table-res table-responsive" style="width:280px; border-left: 1px solid #ccc">
							<table class="table table-bordered table-condensed" style="width:350px;">
									<thead>
										<tr>
											<th>销售员工</th>
											<th>业绩</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody class="product_list workorder_list2" id="card_performance_edit">
										<!-- <tr>
											<td><input class="fm-control staffname" dmdata="STAFFNAME"/><input type="hidden" class="fm-control staff_id" dmdata="staff_id"/></td>
											<td><input class="fm-control performance_amount" dmdata="performance_amount"/></td>
											<td><button type="button" class="btn btn-default btn-sm" style="background-color: #3399ff;color:#fff" >删除</button></td>
										</tr> -->
									</tbody>
								</table>
								<div class="add-fomrline" onclick="add_fomrline_click()">
									<img src="<?php echo base_url();?>/jslibs/content/images/add-icon.svg" alt="add">
									<span>添加销售员工</span>
								</div>
						</div>
			  	<!-- panel-form-order end -->
			  </div>
			  
		  		<!-- panelrt-table begin -->
					<div class="panelrt-table" style="width:100%;">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>支付方式</th>
									<th>支付金额</th>
									<th>支付状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody class="product_list">
								<tr>
									<td><select class="fm-control select_paytype_name edit_account_paytype2" dmdata="paytype_name"></select></td>
									<td><input type="text" class="table_style pay_money" value="" readonly="true" dmdata="amount"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="card_pay_status"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="ORDERMEMO"></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->
			  </div>
			</div>
			<!-- panel 会员办卡 end -->
			<!-- panel 会员充值 begin -->
			<div class="panel panel-default" data-num="3">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  <div style="width: 900px">
			   <!-- panel-form-order begin -->
			  	<div class="panel-form-order" style="float: left;">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  		<div class="inputd-group">
								<label class="label-control">购买门店：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
					     		<input type="hidden" id="hidden_account_id" value="" dmdata="accountid"/>
						 	</div>
							<div class="inputd-group">
								<label class="label-control">充值金额：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="amount">
						 	</div>
						 	
						</div>

			  		<!-- panel-form-line end -->
			  		
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  		<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
						 	</div>
						 	
						</div>
						<div class="panel-form-line">
							<div class="inputd-group">
								<label class="label-control">会员卡号：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
						 	</div>
						 	<div class="inputd-group" style="padding-left: 64px;">
						 		<button class="btn btn-primary btn-save" onclick="update_order_two(this,3)">保存</button>
						 	</div>
						 </div>
			  	</div>
			  
			  	<div class="table-res table-responsive" style="width:280px;border-left: 1px solid #ccc">
							<table class="table table-bordered table-condensed" style="width:350px;">
									<thead>
										<tr>
											<th>销售员工</th>
											<th>业绩</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody class="product_list workorder_list3" id="rechargecard_performance_edit">
										<!-- <tr>
											<td><input class="fm-control staffname" dmdata="STAFFNAME"/><input type="hidden" class="fm-control staff_id" dmdata="staff_id"/></td>
											<td><input class="fm-control performance_amount" dmdata="performance_amount"/></td>
											<td></td>
										</tr> -->
									</tbody>
								</table>
								<div class="add-fomrline" onclick="add_fomrline_click()">
									<img src="<?php echo base_url();?>/jslibs/content/images/add-icon.svg" alt="add">
									<span>添加销售员工</span>
								</div>
						</div>
			  </div>
				<!-- <div style="clear: both;"></div> -->
			  	<!-- panel-form-order end -->

		  		<!-- panelrt-table begin -->
					<div class="panelrt-table" style="width:100%;">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>支付方式</th>
									<th>支付金额</th>
									<th>支付状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody class="product_list">
								<tr>
									<td><select class="fm-control select_paytype_name edit_account_paytype3" dmdata="paytype_name"></select></td>
									<td><input type="text" class="table_style pay_money" value="" readonly="true" dmdata="amount"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="card_pay_status"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="memo"></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->
			  </div>
			</div>
			<!-- panel 会员充值 end -->
			<!-- panel 购买疗程 begin -->
			<div class="panel panel-default" data-num="4">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  		<div class="inputd-group">
								<label class="label-control">购买门店：</label>
					     		<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
					     		<input type="hidden" id="hidden_account_id" value="" dmdata="accountid"/>
						 	</div>
							<div class="inputd-group">
								<label class="label-control">当前金额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="amount">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">当前欠款：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="liability">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  	</div>

			  	<!-- panel-form-order end -->

					<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>疗程名称</th>
									<th>疗程单价</th>
									<th>疗程金额</th>
									<th>购买次数</th>
									<th>购买金额</th>
								</tr>
							</thead>
							<tbody id="course_product">
								<tr>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNAME" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
									<td><input type="text" value="" readonly="true" dmdata="course_amount" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
									<td><input type="text" value="" readonly="true" dmdata="course_amount" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
									<td><input type="text" value="" readonly="true" dmdata="coupon_num" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
									<td><input type="text" value="" readonly="true" dmdata="SUBVALUE" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- panelrt-table end -->

					<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>支付方式</th>
									<th>支付金额</th>
									<th>支付状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="paytype_name"></td>
									<td><input type="text" class="table_style pay_money" value="" readonly="true" dmdata="amount"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="PAYNAME"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="memo"></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->

			  	<!-- panel-end-form begin -->
		  		<div class="panel-end-form">
		  			<div class="add-personal-panel">
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff_max_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">分享业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff1_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">分享业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff2_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">分享业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
						<div class="rec-right-formline" >
		  				<div class="inputd-group">
							<label class="label-control">支付方式：</label>
						    <select class="fm-control fm-disabled payname" select_payname="select_payname" select_value="paytype_name">
						    <option value=-1></option>
				     		</select>
						</div>
			  			</div>

							<!-- add-fomrline begin -->
							<div class="add-fomrline">
								<img src="<?php echo base_url("");?>/jslibs/content/images/add-icon.svg" alt="add">
								<span>添加销售员工</span>
							</div>
							<!-- add-fomrline end -->
							<button type="button" class="btn btn-default btn-sm edit_btn" style="background-color: #3399ff;color:#fff" onclick="update_order_two(this)">确认修改</button>
							<img class="savedit" src="<?php echo base_url("");?>/jslibs/content/images/savedit-icon.svg" alt="savedit">
		  			</div>
		  		</div>
		  		<!-- panel-end-form end -->
			  </div>
			</div>
			<!-- panel 购买疗程 end -->
			<!-- panel 会员转卡 begin -->
			<div class="panel panel-default" data-num="5">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">转卡门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
					     	<input type="hidden" id="hidden_account_id" value="" dmdata="accountid"/>
						 	</div>
							<div class="inputd-group">
								<label class="label-control">新卡卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="card_num">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="out_card_num">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">新卡卡类：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="newcard">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">当前余额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="oldcard">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">转卡额度：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  	</div>
			  	<!-- panel-form-order end -->

					<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>支付方式</th>
									<th>支付金额</th>
									<th>支付状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="paytype_name"></td>
									<td><input type="text" class="table_style pay_money" value="" readonly="true" dmdata="amount"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="PAYNAME"></td>
									<td><input type="text" class="table_style" value="" readonly="true" dmdata="memo"></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->

			  	<!-- panel-end-form begin -->
		  		<div class="panel-end-form">
		  			<div class="add-personal-panel">
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff_max_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff1_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff2_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
						<div class="rec-right-formline" >
			  				<div class="inputd-group">
								<label class="label-control">支付方式：</label>
							    <select class="fm-control fm-disabled payname" select_payname="select_payname" select_value="paytype_name">
							    <option value=-1></option>
					     		</select>
							</div>
			  			</div>

						  	<div class="inputd-group">
								<label class="label-control" style="padding-left:22px;">备注：</label>
								<textarea rows="2" cols="29"></textarea>
						 	</div>

							<!-- add-fomrline begin -->
							<!-- <div class="add-fomrline">
								<img src="<?php echo base_url("");?>/jslibs/content/images/add-icon.svg" alt="add">
								<span>添加销售员工</span>
							</div> -->
							<!-- add-fomrline end -->
							<button type="button" class="btn btn-default btn-sm edit_btn" style="background-color: #3399ff;color:#fff" onclick="update_order_two(this)">确认修改</button>
							<img class="savedit" src="<?php echo base_url("");?>/jslibs/content/images/savedit-icon.svg" alt="savedit">
		  			</div>
		  		</div>
		  		<!-- panel-end-form end -->
			  </div>
			</div>
			<!-- panel 会员转卡 end -->
			<!-- panel 会员并卡 begin -->
			<div class="panel panel-default" data-num="6">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">转卡门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
					     	<input type="hidden" id="hidden_account_id" value="" dmdata="accountid"/>
						 	</div>
							<div class="inputd-group" style="margin-right: 20px;">
								<label class="label-control">会员姓名：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control">当前余额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->

			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">目标卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			  	</div>
			  	<!-- panel-form-order end -->

					<!-- panel-end-form begin -->
					<div class="panel-end-form">
						<!-- coup-form begin -->
						<div class="coup-form">
							<!-- panel-form-line begin -->
							<div class="panel-form-line">
								<div class="inputd-group">
									<label class="label-control">并卡卡号：</label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							 	</div>
							 	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
						 	</div>
							 	<div class="inputd-group">
									<label class="label-control">当前余额：</label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" >
							 	</div>
							</div>
							<!-- panel-form-line end -->
							<!-- panel-form-line begin -->
							<div class="panel-form-line">
								<div class="inputd-group">
									<label class="label-control" style="padding-left: 64px;"></label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							 	</div>
							 	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
						 	</div>
							 	<div class="inputd-group">
									<label class="label-control">当前余额：</label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							 	</div>
							</div>
							<!-- panel-form-line end -->
							<!-- panel-form-line begin -->
							<div class="panel-form-line">
								<div class="inputd-group">
									<label class="label-control" style="padding-left: 64px;"></label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							 	</div>
							 	<div class="inputd-group">
								<label class="label-control">卡类名称：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
						 	</div>
							 	<div class="inputd-group">
									<label class="label-control">当前余额：</label>
						     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							 	</div>
							</div>
							<!-- panel-form-line end -->
						</div>
						<!-- coup-form end -->

						<!-- panelrt-table begin -->
						<div class="panelrt-table">
							<table class="table table-bordered table-condensed">
								<thead>
									<tr>
										<th>支付方式</th>
										<th>支付金额</th>
										<th>支付状态</th>
										<th>备注</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" class="table_style" value="" readonly="true" dmdata="paytype_name"></td>
										<td><input type="text" class="table_style pay_money" value="" readonly="true" dmdata="amount"></td>
										<td><input type="text" class="table_style" value="" readonly="true" dmdata="PAYNAME"></td>
										<td><input type="text" class="table_style" value="" readonly="true" dmdata="memo"></td>
									</tr>
								</tbody>
							</table>
						</div>
			  		<!-- panelrt-table end -->
					</div>
					<!-- panel-end-form end -->

			  	<!-- panel-end-form begin -->
		  		<div class="panel-end-form">
		  			<div class="add-personal-panel">
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff_max_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff1_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
							<!-- rec-right-formline begin -->
		  				<div class="rec-right-formline">
		  					<div class="inputd-group">
									<label class="label-control">销售员工：</label>
						    	<select class="fm-control" select_staff="select_staff" select_value="staff2_min_name">
						    	<option value=-1></option>
						    	</select>
								</div>
								<div class="inputd-group">
									<label class="label-control">业绩：</label>
						    	<input type="text" class="fm-control">
								</div>
								<div class="inputd-group">
									<input type="button" class="btn btn-default btn-sm" delete="delete-btn" value="删除">
								</div>
		  				</div>
							<!-- rec-right-formline end -->
						<div class="rec-right-formline" >
			  				<div class="inputd-group">
								<label class="label-control">支付方式：</label>
							    <select class="fm-control fm-disabled payname" select_payname="select_payname" select_value="paytype_name">
							    <option value=-1></option>
					     		</select>
							</div>
			  			</div>

							<!-- add-fomrline begin -->
							<div class="add-fomrline">
								<img src="<?php echo base_url("");?>/jslibs/content/images/add-icon.svg" alt="add">
								<span>添加销售员工</span>
							</div>
							<!-- add-fomrline end -->
							<button type="button" class="btn btn-default btn-sm edit_btn" style="background-color: #3399ff;color:#fff" onclick="update_order_two(this)">确认修改</button>
							<img class="savedit" src="<?php echo base_url("");?>/jslibs/content/images/savedit-icon.svg" alt="savedit">
		  			</div>
		  		</div>
		  		<!-- panel-end-form end -->
			  </div>
			</div>
			<!-- panel 会员并卡 end -->
			<!-- panel 会员补卡 begin -->
			<div class="panel panel-default" data-num="7">
			  <div class="panel-heading">会员卡信息</div>
			  <div class="panel-body">
					<!-- panelcard-rlt begin -->
					<div class="panelcard-rlt">
						<!-- panelcard-lt begin -->
						<div class="panelcard-lt">
							<div class="inputd-group">
								<label class="label-control txt-color">申请门店：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
							</div>
							<div class="inputd-group">
								<label class="label-control" style="padding-left:12px;">卡类型：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
							</div>
							<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
							</div>
							<div class="inputd-group">
								<label class="label-control">手机号码：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="MOBILE">
							</div>
							<div class="inputd-group">
								<label class="label-control">身份证号：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
							</div>
							<div class="inputd-group">
								<label class="label-control">归属门店：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
							</div>
							<div class="inputd-group">
								<label class="label-control">售卡日期：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CREATEDATE">
							</div>
						</div>
						<!-- panelcard-lt end -->
						<!-- panelcard-rt begin -->
						<div class="panelcard-rt">
							<!-- panelcard-rt-cardinfo begin -->
							<div class="panelcard-rt-cardinfo">
								<div class="inputd-group">
									<label class="label-control txt-color">会员卡号：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNUM">
								</div>
								<div class="inputd-group" style="margin-right: 20px;">
									<label class="label-control">储值余额：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
								</div>
								<div class="inputd-group">
									<label class="label-control">储值欠款：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="liability">
								</div>
								<div class="inputd-group">
									<label class="label-control">疗程余额：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
								</div>
							</div>
							<!-- panelcard-rt-cardinfo end -->
							<!-- panelcard-rt-table begin -->
							<div class="panelcard-rt-table">
								<table class="table table-bordered table-condensed">
									<thead>
										<tr>
											<th>剩余疗程</th>
											<th>购买次数</th>
											<th>剩余次数</th>
											<th>剩余金额</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td>3</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td>3</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td>3</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td>3</td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- panelcard-rt-table end -->
						</div>
						<!-- panelcard-rt end -->
					</div>
					<!-- panelcard-rlt end -->
			   	<div class="panel-heading">流程信息</div>
			   	<!-- panel-subform begin -->
			   	<div class="panel-subform">
			   		<!-- panel-subform-hd begin -->
			   		<div class="panel-subform-hd">
				   		<div class="inputd-group">
								<label class="label-control txt-color">新卡卡号：</label>
					    	<input type="text" class="fm-control fm-disabled" readonly="true">
							</div>
			   		</div>
			   		<div class="inputd-group txtarea-group">
				  		<lable class="lable-control">换卡备注：</lable>
				  		<textarea rows="4" class="txtarea-control fm-disabled" readonly="true"></textarea>
				  	</div>
			   	</div>
			   		<!-- panel-subform-hd end -->
			  </div>
			   <!-- panel-subform end -->
			</div>
			<!-- panel 会员补卡 end -->
			<!-- panel 会员退卡 begin -->
			<div class="panel panel-default" data-num="8">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panelcard-rlt begin -->
					<div class="panelcard-rlt" style="width:1250px;">
						<!-- panelcard-lt begin -->
						<div class="panelcard-lt">
							<div class="inputd-group">
								<label class="label-control txt-color">申请门店：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
							</div>
							<div class="inputd-group">
								<label class="label-control" style="padding-left:12px;">卡类型：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDNAME">
							</div>
							<div class="inputd-group">
								<label class="label-control">会员姓名：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="USERNAME">
							</div>
							<div class="inputd-group">
								<label class="label-control">手机号码：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="MOBILE">
							</div>
							<div class="inputd-group">
								<label class="label-control">身份证号：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" >
							</div>
							<div class="inputd-group">
								<label class="label-control">归属门店：</label>
					    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
							</div>
							
						</div>
						<!-- panelcard-lt end -->
						<!-- panelcard-rt begin -->
						<div class="panelcard-rt panelcard1" style="width:276px">
							<!-- panelcard-rt-cardinfo begin -->
							<div class="panelcard-rt-cardinfo">
								<div class="inputd-group">
									<label class="label-control txt-color">会员卡号：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="card_num">
								</div>
							
								<div class="inputd-group">
									<label class="label-control">储值余额：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
								</div>
								<br>
								<div class="inputd-group">
									<label class="label-control">储值欠款：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="liability">
								</div>
								<div class="inputd-group">
									<label class="label-control">疗程余额：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" >
								</div>
								<div class="inputd-group">
								<label class="label-control">售卡日期：</label>
						    	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CREATEDATE">
								</div>
								<div class="inputd-group" style="padding-left: 64px;">
								<button class="btn btn-primary btn-save" onclick="update_order_two(this,8)">保存</button>
								</div>
							</div>

							<!-- panelcard-rt-cardinfo end -->
							<!-- panelcard-rt-table begin -->
							
							<!-- panelcard-rt-table end -->
						</div>
						<div class="table-res table-responsive" style="width:280px;">
							<table class="table table-bordered table-condensed" style="width:350px;">
									<thead>
										<tr>
											<th>销售员工</th>
											<th>业绩</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody class="product_list workorder_list8" id="returncard_performance_edit">
										<!-- <tr>
											<td><input class="fm-control staffname" dmdata="STAFFNAME"/><input type="hidden" class="fm-control staff_id" dmdata="staff_id"/></td>
											<td><input class="fm-control performance_amount" dmdata="performance_amount"/></td>
										</tr> -->
									</tbody>
								</table>
								<div class="add-fomrline" onclick="add_fomrline_click()">
									<img src="<?php echo base_url();?>/jslibs/content/images/add-icon.svg" alt="add">
									<span>添加销售员工</span>
								</div>
						</div>
						<!-- panelcard-rt end -->
					</div>
			<div style="margin-top:5px;margin-bottom: 5px">
 				<div class="panelcard-rt-table table-responsive">
					<table class="table table-bordered table-condensed">
						<thead> 
							<tr>
								<th>剩余疗程</th>
								<th>购买次数</th>
								<th>剩余次数</th>
								<th>剩余金额</th>
							</tr>
						</thead>
						<tbody id="surplus_course">
							<tr>
								<td><input type="text" value="" readonly="true" dmdata="PRODUCTNAME" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
								<td><input type="text" value="" readonly="true" dmdata="PRODUCTNUMBER" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
								<td><input type="text" value="" readonly="true" dmdata="course_remain" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
								<td><input type="text" value="" readonly="true" dmdata="surplus" style='border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;'></td>
							</tr>
						</tbody>
					</table>
				</div>		
			</div>
					<!-- panelcard-rlt end -->
			   <!-- panelcard-rlt end -->
			   	<div class="panel-heading">流程信息</div>
			   	<!-- panel-subform begin -->
			   	<div class="panel-subform">
			   		<!-- panel-subform-hd begin -->
			   		<div class="panel-subform-hd">
				   		<div class="inputd-group">
								<label class="label-control">退卡方式：</label>
					    	<lable class="radio-inline">
					  			<input  type="radio" class="fm-disabled" id="returnCardMethod1" name="returnCardMethod" value="0" readonly="true" dmdata="return_card_method" disabled> 完整退卡
					  		</lable>
					  		<lable class="radio-inline">
					  			<input  type="radio" class="fm-disabled" id="returnCardMethod2" name="returnCardMethod" value="1" readonly="true" dmdata="return_card_method" disabled> 部分退卡
					  		</lable>
							</div>
							<div class="inputd-group" style="position: relative; top: -4px;">
								<label class="label-control">退卡类型：</label>
						    	<select class="fm-control fm-control-one fm-disabled" id="returnCardType" name="returnCardType" readonly="true" dmdata="return_card_type" disabled> 
						  			<option value="1">协议退卡</option>
						  			<option value="2">余额退卡</option>
						  			<option value="3">折算退卡</option>
					  			</select>
							</div>
							<div class="inputd-group" style="position: relative; top: -4px;">
								<label class="label-control">退卡金额：</label>
					    	<input type="text" class="fm-control fm-disabled pay_money" id="returncard_amount" value="" readonly="true" dmdata="returncard_amount">
							</div>
			   		</div>
			   		<!-- panel-subform-hd end -->
						<div class="inputd-group txtarea-group">
					  		<lable class="lable-control">退卡备注：</lable>
					  		<textarea rows="4" class="txtarea-control fm-disabled" id="returncard_memo" readonly="true" dmdata="returncard_memo"></textarea>
					  	</div>
			   	</div>
			    <!-- panel-subform end -->
			  </div>
			</div>
			<!-- panel 会员退卡 end -->
			<!-- panel 开单返销 begin -->
			<div class="panel panel-default" data-num="9">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control txt-color">申请门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="card_num">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">消费单号：</label>
					     	<input type="text" class="fm-control" value="" dmdata="ORDERNUMBER">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">消费余额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="CARDBALANCE">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">消费日期：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="create_date">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control" style="padding-left: 12px;">消费积分：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="card_point">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">订单类型：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="operator_function">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			   	</div>
			  	<!-- panel-form-order end -->

			  	<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered  table-condensed">
							<thead>
								<tr>
									<th>服务项目/产品</th>
									<th>消费次数</th>
									<th>消费金额</th>
									<th>支付方式</th>
									<th>美发师/美容师</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNAME" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td>
									<td><input type="text" value="" readonly="true" dmdata="PRODUCTNUMBER" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td>
									<td><input type="text" value="" readonly="true" dmdata="SUBVALUE" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td>
									<td><input type="text" value="" readonly="true" dmdata="pay_name" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td>
									<td><input type="text" value="" readonly="true" dmdata="staff_max_name" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td>
								</tr>
								<tr>
									<td></td>
									<td>2</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>2</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->
		  		<div class="panel-heading">流程信息</div>
					<div class="panel-subform" style="margin-top:10px;">
						<div class="inputd-group txtarea-group">
				  		<lable class="lable-control">返销备注：</lable>
				  		<textarea rows="4" class="txtarea-control fm-disabled" readonly="true"></textarea>
				  	</div>
				  	<div class="inputd-group">
							<label class="label-control txt-color">流程状态：</label>
				    	<input type="text" class="fm-control fm-disabled" value="等待审核" readonly="true">
						</div>
			   	</div>
			    <!-- panel-subform end -->
			  </div>
			</div>
			<!-- panel 开单返销 end -->
			<!-- panel 办卡反充 begin -->
			<div class="panel panel-default" data-num="10">
			  <div class="panel-heading">订单信息</div>
			  <div class="panel-body">
			  	<!-- panel-form-order begin -->
			  	<div class="panel-form-order">
			  		<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control txt-color">申请门店：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="STORENAME">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">充值金额：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="amount">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control txt-color">会员卡号：</label>
					     	<input type="text" class="fm-control fm-disabled" readonly="true" dmdata="card_num">
						 	</div>
							<div class="inputd-group">
								<label class="label-control">支付方式：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="paytype_name">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">订单类型：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true" dmdata="operator_function">
						 	</div>
						 	<div class="inputd-group">
								<label class="label-control" style="padding-left: 12px;">销售人员：</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
						<!-- panel-form-line begin -->
						<div class="panel-form-line">
					  	<div class="inputd-group">
								<label class="label-control">操作日期</label>
					     	<input type="text" class="fm-control fm-disabled" value="" readonly="true">
						 	</div>
						</div>
			  		<!-- panel-form-line end -->
			   	</div>
			  	<!-- panel-form-order end -->

			  	<!-- panelrt-table begin -->
					<div class="panelrt-table">
						<table class="table table-bordered  table-condensed">
							<thead>
								<tr>
									<th>购买疗程</th>
									<th>购买次数</th>
									<th>购买金额</th>
									<th>卡内抵扣</th>
									<th>支付抵扣</th>
									<th>支付方式</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td>2</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>2</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>2</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
		  		<!-- panelrt-table end -->
		  		<div class="panel-heading">流程信息</div>
					<div class="panel-subform" style="margin-top:10px;">
						<div class="inputd-group txtarea-group">
				  		<lable class="lable-control">反充备注：</lable>
				  		<textarea rows="4" class="txtarea-control fm-disabled" readonly="true"></textarea>
				  	</div>
				  	<div class="inputd-group">
							<label class="label-control txt-color">流程状态：</label>
				    	<input type="text" class="fm-control fm-disabled" value="等待审核" readonly="true">
						</div>
			   	</div>
			    <!-- panel-subform end -->
			  </div>
			</div>
			<!-- panel 办卡反充 end -->
		</div>
	</div>
	<!-- pagecontent end -->
	<div class="nodeTreeBox"></div>

	<script src="<?php echo base_url(); ?>/jslibs/content/bootstrap/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/laydate/laydate.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/modifBusiDoc.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
	<script src="<?php echo base_url(); ?>/jslibs/content/select2/js/select2.full.js"></script>
	<script src="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/jquery.ajaxQueue.js"></script>
	<script src="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/compatible.js"></script>
	<script src="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/jquery.autocomplete.js"></script>
	<script src="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/jquery.bgiframe.min.js"></script>
	<script src="<?php echo base_url(); ?>/phpMyAdmin/js/jquery/src/jquery-ui/thickbox-compressed.js"></script>
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

    function  callback_searchnode(selectCompId,selectStoreId){
        alert(selectCompId);
    }
</script>
<script type="text/javascript">

	var annotation_siteurl = "<?php echo site_url(); ?>";

	function show_stafflist(){
		if(selectStoreId == 0){
			return;
		}
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/get_staff_list/"+selectStoreId ,
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	var items = data.items;
	    	findStaffListData(items);
	    });
	}

	function findStaffListData(staff_list){

		var order_length = $("#product_list").children().length;
		var card_length = $("#card_performance_edit").children().length;
		var rechargecard_length = $("#rechargecard_performance_edit").children().length;
		var returncard_length = $("#returncard_performance_edit").children().length;
		var length = 0;
		if(order_length > 0 ){
			length = order_length;
		}else if(card_length > 0){
			length = card_length;
		}else if(rechargecard_length > 0){
			length = rechargecard_length;
		}else if(returncard_length > 0){
			length = returncard_length;
		}
		for (var i = 0; i < staff_list.length; i++) {
			var order_max_obj = $("#"+i+"_maxname0");
			var order_maxid_obj = $("#"+i+"_maxid0");

			var order_min_obj = $("#"+i+"_minname0");
			var order_minid_obj = $("#"+i+"_minid0");

			var card_max_obj = $("#"+i+"_maxname1");
			var card_maxid_obj = $("#"+i+"_maxid1");

			var rechargecard_max_obj = $("#"+i+"_maxname5");
			var rechargecard_maxid_obj = $("#"+i+"_maxid5");

			var returncard_max_obj = $("#"+i+"_maxname7");
			var returncard_maxid_obj = $("#"+i+"_maxid7");
			// 开单收银 大工 下拉获取
			if(order_max_obj.length > 0){
				order_max_obj.autocomplete(staff_list, {
					minChars: 0,
					width: 200,
					matchContains: true,
					autoFill: false,
					mustMatch:true,
					max:100,
					mustMatch:false ,
					formatItem: function(row, i, max) {
						return row.STAFFNUMBER+'-'+row.STAFFNAME;
					},
					formatResult: function(row) {
						return row.STAFFNUMBER+"-"+row.STAFFNAME;
					}
				});
				
				$(order_max_obj).result(function(formatResult, data, formatted){
					if(data!=null || data!="" || data!=undefined){
						var id=$(this).attr("id");
						var index=id.substring(0,id.indexOf("_"));
						$("#"+index+"_maxname0").attr("value",data.STAFFNAME);
						$("#"+index+"_maxid0").val(data.STAFFID);
					}
				})
			}
			// 开单收银 小工
			if(order_min_obj.length > 0){
				order_min_obj.autocomplete(staff_list, {
					minChars: 0,
					width: 200,
					matchContains: true,
					autoFill: false,
					mustMatch:true,
					max:100,
					mustMatch:false ,
					formatItem: function(row, i, max) {
						return row.STAFFNUMBER+'-'+row.STAFFNAME;
					},
					formatResult: function(row) {
						return row.STAFFNUMBER+row.STAFFNAME;
					}
				});
				
				order_min_obj.result(function(formatResult, data, formatted){
					if(data!=null || data!="" || data!=undefined){
						var id=$(this).attr("id");
						var index=id.substring(0,id.indexOf("_"));
						$("#"+index+"_minname0").attr("value",data.STAFFNAME);
						$("#"+index+"_minid0").val(data.STAFFID);
					}
				})
			}
			// 开卡
			if(card_max_obj.length > 0){
				card_max_obj.autocomplete(staff_list, {
					minChars: 0,
					width: 200,
					matchContains: true,
					autoFill: false,
					mustMatch:true,
					max:100,
					mustMatch:false ,
					formatItem: function(row, i, max) {
						return row.STAFFNUMBER+'-'+row.STAFFNAME;
					},
					formatResult: function(row) {
						return row.STAFFNUMBER+row.STAFFNAME;
					}
				});
				
				card_max_obj.result(function(formatResult, data, formatted){
					if(data!=null || data!="" || data!=undefined){
						var id=$(this).attr("id");
						var index=id.substring(0,id.indexOf("_"));
						$("#"+index+"_maxname1").attr("value",data.STAFFNAME);
						$("#"+index+"_maxid1").val(data.STAFFID);
					}
				})
			}
			//充值
			if(rechargecard_max_obj.length > 0){
				rechargecard_max_obj.autocomplete(staff_list, {
					minChars: 0,
					width: 200,
					matchContains: true,
					autoFill: false,
					mustMatch:true,
					max:100,
					mustMatch:false ,
					formatItem: function(row, i, max) {
						return row.STAFFNUMBER+'-'+row.STAFFNAME;
					},
					formatResult: function(row) {
						return row.STAFFNUMBER+row.STAFFNAME;
					}
				});
				
				rechargecard_max_obj.result(function(formatResult, data, formatted){
					if(data!=null || data!="" || data!=undefined){
						var id=$(this).attr("id");
						var index=id.substring(0,id.indexOf("_"));
						$("#"+index+"_maxname5").attr("value",data.STAFFNAME);
						$("#"+index+"_maxid5").val(data.STAFFID);
					}
				})
			}
			// 退卡
			if(returncard_max_obj.length > 0){
				returncard_max_obj.autocomplete(staff_list, {
					minChars: 0,
					width: 200,
					matchContains: true,
					autoFill: false,
					mustMatch:true,
					max:100,
					mustMatch:false ,
					formatItem: function(row, i, max) {
						return row.STAFFNUMBER+'-'+row.STAFFNAME;
					},
					formatResult: function(row) {
						return row.STAFFNUMBER+row.STAFFNAME;
					}
				});
				
				returncard_max_obj.result(function(formatResult, data, formatted){
					if(data!=null || data!="" || data!=undefined){
						var id=$(this).attr("id");
						var index=id.substring(0,id.indexOf("_"));
						$("#"+index+"_maxname7").attr("value",data.STAFFNAME);
						$("#"+index+"_maxid7").val(data.STAFFID);
					}
				})
			}
		}

	}

    function  submitDmForm(str_id){
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

    }

	// 下拉插件
	function select2(max_staff_num,min_staff_num,n){
		$("[select_value]").select2({
	  	    placeholder	: "请输入",
	  	    allowClear: true,
	    });

	    $("[select_payname]").select2({
	    	minimumResultsForSearch: -1
	    });

	    $("[select_specify]").select2({
	    	minimumResultsForSearch: -1,
	    	'width': '58px'
	    });
	    if(max_staff_num != undefined && min_staff_num != undefined){
	    	staffList(max_staff_num,min_staff_num,n);
	    }
	  	else{
	  		staffList();
	  	}
	    is_specify();
	}

	$(document).ready(function() {
		show_stafflist();
		select2();
		get_toDay();
		paynameList();
		get_list(1);    
	});

	// 获取改变的select2 框变化的值
	$('select').on('select2:select', function (evt) {
  		var data = $(this).val();
  		//alert(data);
	});

	function get_toDay()
	{
		var toDay = document.getElementById("toDay");
		if(toDay.value.length<4){
			/*$.AlertDialog.CreateAlert("警告","请选择日期！");
			return null;*/
			var date = new Date();
			var date_str = date.toLocaleDateString();
			toDay.value = date_str.replace(/\//g,'-');
		}
		return toDay.value;
	}

	$("#search_btn").click(function(){
		var index = $(".active").attr("data-num");
		submitDmForm('seach_condition');
		get_list(index,selectCompId,selectStoreId);
		staffList();
	});

	$("#mobudocLeftContent dl [data-num]").click(function(){
		var card_list = $("#card_performance_edit");
		card_list.children().remove();
	});

	// 点击订单类型展示单号/卡号/序号 列表
	function get_list(fun_index,comp_id,store_id)
	{
		$("[select_value]").children().remove();
		var option_html = "<option value=-1></option>";
		$("[select_value]").append(option_html);

		var today = get_toDay();
		if(today==null)return;
		var thead_obj = $("#thead_list");

		if(fun_index == 1 || fun_index == 9){
	    		thead_obj.children().remove();
	    		var thead_html = "<tr><th>消费单号</th><th>消费卡号</th><th>序号</th></tr>";
	    		thead_obj.append(thead_html);
	    }
	    else{
	    	thead_obj.children().remove();
			var thead_html = "<tr><th>会员卡号</th><th>会员姓名</th><th>序号</th></tr>";
			thead_obj.append(thead_html);
	    }
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/get_list" ,
	        data:{fun_index:fun_index,today:today,comp_id:comp_id,store_id:store_id},
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	var tbody_obj = $("#tbody_list");
	    	tbody_obj.children().remove();

	    	if(data.code != "000"){
	    		$.AlertDialog.CreateAlert("警告",data.message);
	    		return;
	    	}
	    	var items = data.items;
	    	if(data.items == null){
	    		$.AlertDialog.CreateAlert("警告","没有数据!");
	    		return;
	    	}

	    	var tm_html = '';
	    	for (var i = data.items.length - 1; i >= 0; i--) {
	    		var item = data.items[i];
    			if(item.col11 == null){
	    			item.col11 = '';
	    		}
	    		if(item.col12 == null){
	    			item.col12 = '';
	    		}
	    		if(item.col13 == null){
	    			item.col13 = '';
	    		}
	    		var style_str = '';
	    		if(item.col3 > 0){
	    			style_str = 'style="color:red"';
	    		}
	    		tm_html += '<tr><td><a href="#billsOrderset" class="orderno" oid="1" '+style_str+' onclick="prevent_repeat_click(' + item.col1+', '+ item.col2 + ', '+ item.col3 + ')">'+item.col11+'</a></td><td><a href="#billsOrderset" class="orderno" oid="2" '+style_str+' onclick="prevent_repeat_click(' + item.col1 +', '+ item.col2 + ', '+ item.col3 + ')">'+item.col12+'</a></td><td><a href="#billsOrderset" class="orderno" oid="3" '+style_str+' onclick="prevent_repeat_click(' + item.col1 +', '+ item.col2  + ',  '+ item.col3 + ')">'+item.col13+'</a></td></tr>';
	    		
    		}
    		tbody_obj.append(tm_html);
	    		  	
	    });

	    // 清空已填数据
	    $("[dmdata]").each(function(){
	    	var this_obj = $(this);
	    	this_obj.val("");
	    });
	}

	// 防止多次点击重复执行
	var timer;
	function prevent_repeat_click(list_id, fun_id, back=0)
	{
		timer && clearTimeout(timer);
	    timer = setTimeout(function() {
	        console.log(0);
	        click_list(list_id, fun_id, back);
	    }, 100);
	}

	// 点击单号/卡号/序号 展示右边页面数据
	function click_list(list_id, fun_id, back)
	{
		$(".btn-save").removeAttr("disabled");
		if(back != 0){
			$(".btn-save").attr("disabled","disabled");
		}
		var today = get_toDay();

		var product_list = $("#product_list");
		product_list.children().remove();

		var card_list = $("#card_performance_edit");
		card_list.children().remove();

		var rechargecard_list = $("#rechargecard_performance_edit");
		rechargecard_list.children().remove();

		var returncard_list = $("#returncard_performance_edit");
		returncard_list.children().remove();

		var payinfo_obj = $("#payinfo_list");
		payinfo_obj.children().remove();

		var course_product = $("#course_product");
		course_product.children().remove();

		var surplus_course = $("#surplus_course");
		surplus_course.children().remove();

		var workorder_obj = $(".workorder_list"+fun_id);
		workorder_obj.children().remove();

		$(".select_paytype_name :first-child").removeAttr("selected");

		var select_payname = $(".select_paytype_name");
		select_payname.removeAttr("disabled");
		select_payname.removeClass("fm-disabled");
		if(today==null)return;
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/get_list_item/"+selectStoreId ,
	        data:{fun_index:fun_id, list_index:list_id,today:today},
	        dataType:'json',
	        async: true,
	        error:function(msg){
	        	console.log(msg);
	        }
	    })
	    .success(function(data){
	    	if(data.code != "000"){
	    		$.AlertDialog.CreateAlert("警告",data.message);
	    		return;
	    	}

	    	if(data.items == null){
	    		$.AlertDialog.CreateAlert("警告","没有数据!");
	    		return;
	    	}
	    	var key = data.key;
	    	var items = data.items;
	    	var items_order = items.order;	    	

	    	var items_workorder =items.workorder;
	    	var items_orderproduct = items.orderproduct;
	    	var returncard = items.returncard_info;
	    	if(items.bonus_data != undefined){
	    		var items_bonusdata  = items.bonus_data;
	    		var len = items_bonusdata.length;
	    	}	    	

	    	if(items.orderproduct != null){
	    		var n = 0;
	    		for (var i = 0; i <= items_orderproduct.length - 1; i++) {
		    		var value = items_orderproduct[i];
		    		if(value.PRODUCTNO == null){
		    			value.PRODUCTNO = '无';
		    		}
		    		if(value.PRODUCTNAME == null){
		    			value.PRODUCTNAME = '无';
		    		}
		    		if(value.product_name == null){
		    			value.product_name = '无';
		    		}
		    		if(value.PRODUCTNUMBER == null){
		    			value.PRODUCTNUMBER = '无';
		    		}
		    		if(value.coupon_num == null){
		    			value.coupon_num = '无';
		    		}
		    		if(value.pay_name == null){
		    			value.pay_name = '无';
		    		}
		    		if(value.real_amount == null){
		    			value.real_amount = '无';
		    		}
		    		if(value.staff_name == null){
		    			value.staff_name = '';
		    		}
		    		if(value.staff_min_name == null || value.staff_min_name == ''){
		    			value.staff_min_name = '';
		    		}
		    		if(value.once_price == null){
		    			value.once_price = '无';
		    		}
		    		if(value.product_price == null){
		    			value.product_price = '无';
		    		}
		    		if(value.total_number == null){
		    			value.total_number = '无';
		    		}
		    		if(value.surplus == null){
		    			value.surplus = '无';
		    		}
		    		if(value.paymoney == null){
		    			value.paymoney = '无';
		    		}
		    		if(value.remain_number == null){
		    			value.remain_number = '无';
		    		}
		    		if(value.surplus_money == null){
		    			value.surplus_money = '无';
		    		}
		    		if(value.pay_state == null){
		    			value.pay_state = '无';
		    		}
		    		if(value.pay_memo == 'null'){
		    			value.pay_memo = '';
		    		}
		    		if(value.max_staff_num == null){
		    			value.max_staff_num = '';
		    		}
		    		if(value.min_staff_num == null){
		    			value.min_staff_num = '';
		    		}
		    		var style_str = '';
		    		if(value.back > 0){
		    			value.real_amount = '-'+value.real_amount;
		    			style_str = 'style="color:red"';
		    		}
		    		// specifyid,specify_minid 0：轮排 1：点客
		    		var specifyid = 1;
		    		var specify_minid = 1;
		    		if(value.is_specify == 1){
		    			specifyid = value.is_specify;
		    			value.is_specify = '点客';
		    		}else if(value.is_specify == 0){
		    			specifyid = value.is_specify;
		    			value.is_specify = '轮排';
		    		}else{
		    			specifyid = '';
		    			value.is_specify = '';
		    		}

		    		if(value.is_specify_min == 1 && value.staff_min_name != ''){
		    			specify_minid = value.is_specify_min;
		    			value.is_specify_min = '点客';
		    		}else if(value.is_specify_min == 0 && value.staff_min_name != ''){
		    			specify_minid = value.is_specify_min;
		    			value.is_specify_min = '轮排';
		    		}else if(value.staff_min_name == '' || value.is_specify_min < 0){
		    			specify_minid = 0;
		    			value.is_specify_min = '轮排';
		    		}

		    		if(value.paytype == 4){
		    			if(specifyid == 0 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="1">点客</option><option selected="selected value="1">轮排</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="5">现金</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="1">轮排</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}
		    		}
		    		else if(value.paytype == 5){
		    			if(specifyid == 0 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option value="4">银联POS</option><option selected="selected" value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option value="4">银联POS</option><option selected="selected" value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="4">银联POS</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option value="4">银联POS</option><option selected="selected" value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option value="4">银联POS</option><option selected="selected" value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control order-payname"><option selected="selected" value="' + value.paytype + '" '+style_str+'>' + value.pay_name + '</option><option value="4">银联POS</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}
		    		}
		    		else{
		    			if(specifyid == 0 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 0 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option><option value="1">点客</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 0){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option><option value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 1){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specify_minid + '">' + value.is_specify_min + '</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}else if(specifyid == 1 && specify_minid == 2){
		    				var product_html = '<tr id="'+i+'"><td><input type="text" value="'+ value.PRODUCTNO +'" readonly="true" disabled '+style_str+'><input type="hidden" class="hidden_opid" value="' + value.OPID + '"/></td><td><input type="text" value="' + value.PRODUCTNAME + '" readonly="true" disabled '+style_str+'></td><td><input type="text" value="' + value.PRODUCTNUMBER + '" readonly="true" disabled '+style_str+'></td><td><select class="fm-control fm-disabled order-payname"  disabled><option value="' + value.paytype + '">' + value.pay_name + '</option></select></td><td><input type="text" value="' + value.real_amount + '" readonly="true" disabled '+style_str+'></td><td><input type="text" id="'+i+'_maxname0" class="enter_event" value="' + value.max_staff_num + value.staff_name + '" '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid0" value="'+value.staff_id+'"/></td><td><select class="fm-control specify_name" '+style_str+'></option><option value="0">轮排</option><option selected="selected" value="' + specifyid + '">' + value.is_specify + '</option></select></td><td><input type="text" id="'+i+'_minname0" class="enter_event" value="' + value.min_staff_num + value.staff_min_name + '"  '+style_str+'><input type="hidden" class="fm-control staff_id" id="'+i+'_minid0" value="'+value.staff_min_id+'"/></td><td><select class="fm-control specify_name_min" '+style_str+'></option><option value="0">轮排</option><option selected="selected value="1">点客</option></select></td></tr>';
		    				product_list.append(product_html);
		    			}
		    			n++;
		    		}

		    		var payinfo_html = '<tr><td><input type="text" class="table_style" value="' + value.pay_name + '" readonly="true"  '+style_str+'></td><td><input type="text" class="table_style" value="' + value.real_amount + '" readonly="true"  '+style_str+'></td><td><input type="text" class="table_style" value="' + value.pay_state + '" readonly="true"  '+style_str+'></td><td><input type="text" class="table_style" value="' + value.pay_memo + '" readonly="true" '+style_str+'></td></tr>';
		    		payinfo_obj.append(payinfo_html);    		
		    		
		    		var course_html = '<tr><td><input type="text" value="' + value.product_name + '" readonly="true" dmdata="PRODUCTNO" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.once_price + '" readonly="true" dmdata="PRODUCTNO" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.product_price + '" readonly="true" dmdata="PRODUCTNO" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.total_number + '" readonly="true" dmdata="PRODUCTNO" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.paymoney + '" readonly="true" dmdata="PRODUCTNO" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td></tr>';
		    		course_product.append(course_html);

		    		var surplus_course_html = '<tr><td><input type="text" value="' + value.product_name + '" readonly="true" dmdata="PRODUCTNAME" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.total_number + '" readonly="true" dmdata="PRODUCTNUMBER" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.remain_number + '" readonly="true" dmdata="course_remain" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td><td><input type="text" value="' + value.surplus_money + '" readonly="true" dmdata="surplus" style="border-left:0px;border-top:0px;border-right:0px;border-bottom:0px;text-align:center;"></td></tr>';
		    		surplus_course.append(surplus_course_html);
	    		}
	    		
	    	}

	    	// 开单收银界面 回车事件
	    	var order_inputs = $("#product_list tr td :input[class='enter_event']");// 获取当前页面所有输入框
	    	$("#product_list tr td :input[class='enter_event']").keypress(function(e){
	    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
	    		if (keyCode == 39) // 判断所按是否方向右键
			    {
			    	keyCode = 9;
			    }
			    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
			    {
			    	keyCode = 9;
			    	var idx = order_inputs.index(this); // 获取当前焦点输入框所处的位置

			    	if (idx == order_inputs.length - 1) // 判断是否是最后一个输入框
			    	{
			     		return false;// 取消默认的提交行为
			    	} else {
			     		order_inputs[idx + 1].focus(); // 设置焦点
			     		order_inputs[idx + 1].select(); // 选中
			    	}
			    return false;// 取消默认的提交行为
			   }
	    	});

	    	if(items.bonus_data != null){
	    		for (var i = items_bonusdata.length - 1; i >= 0; i--) {
	    			var bonus_value = items_bonusdata[i];
	    			if(bonus_value.STAFFNAME != null || bonus_value.STAFFNUMBER != null){
	    				var bonus_html = '<tr id="'+i+'"><td><input class="fm-control staffname enter_event" id="'+i+'_maxname'+bonus_value.operator_type+'" value="' + bonus_value.STAFFNUMBER + bonus_value.STAFFNAME + '" style="height:18px;"/><input type="hidden" class="fm-control staff_id" id="'+i+'_maxid'+bonus_value.operator_type+'" value="' + bonus_value.staff_id + '"/></td><td><input class="fm-control performance_amount enter_event" id="'+i+'_maxperformance'+bonus_value.operator_type+'" value="' + bonus_value.performance_amount + '" style="height:18px;"/></td><td style="padding:4px 2px;"><button type="button" class="btn btn-default btn-sm" onclick="delete_staff(this)" style="background-color: #3399ff;color:#fff;padding:2px 5px;" >删除</button><input type="hidden" id="'+i+'_bonusdata_hidden" value=""></td></tr><input type="hidden" id="0_funid_hidden" value="'+fun_id+'">';
	    				$("#0_funid_hidden").remove();
	    				workorder_obj.append(bonus_html);
	    			}else{
	    				var hidden_html = '<input type="hidden" id="0_funid_hidden" value="'+fun_id+'">';
	    				$("#0_funid_hidden").remove();
		    			workorder_obj.append(hidden_html);
	    			}
	    			
	    		}
	    		if(items_bonusdata.length <= 0)
		    	{
		    		var hidden_html = '<input type="hidden" id="0_funid_hidden" value="'+fun_id+'">';
		    		$("#0_funid_hidden").remove();
		    		workorder_obj.append(hidden_html);
		    	}
	    		items_bonusdata = JSON.stringify(items_bonusdata);
	    		$("#0_bonusdata_hidden").val(items_bonusdata);
	    	}
	    	show_stafflist();
	    	// 开卡界面 回车事件
	    	var card_inputs = $("#card_performance_edit tr td .enter_event");// 获取当前页面所有输入框
	    	$("#card_performance_edit tr td .enter_event").keypress(function(e){
	    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
	    		if (keyCode == 39) // 判断所按是否方向右键
			    {
			    	keyCode = 9;
			    }
			    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
			    {
			    	keyCode = 9;
			    	var idx = card_inputs.index(this); // 获取当前焦点输入框所处的位置

			    	if (idx == card_inputs.length - 1) // 判断是否是最后一个输入框
			    	{
			     		add_fomrline_click(this);
			    	} else {
			     		card_inputs[idx + 1].focus(); // 设置焦点
			     		card_inputs[idx + 1].select(); // 选中
			    	}
			    return false;// 取消默认的提交行为
			   }
	    	});
	    	// 充值界面 回车事件
	    	var rechargecard_inputs = $("#rechargecard_performance_edit tr td .enter_event");// 获取当前页面所有输入框
	    	$("#rechargecard_performance_edit tr td .enter_event").keypress(function(e){
	    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
	    		if (keyCode == 39) // 判断所按是否方向右键
			    {
			    	keyCode = 9;
			    }
			    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
			    {
			    	keyCode = 9;
			    	var idx = rechargecard_inputs.index(this); // 获取当前焦点输入框所处的位置

			    	if (idx == rechargecard_inputs.length - 1) // 判断是否是最后一个输入框
			    	{
			     		add_fomrline_click(this);
			    	} else {
			     		rechargecard_inputs[idx + 1].focus(); // 设置焦点
			     		rechargecard_inputs[idx + 1].select(); // 选中
			    	}
			    return false;// 取消默认的提交行为
			   }
	    	});
	    	// 退卡界面 回车事件
	    	var returncard_inputs = $("#returncard_performance_edit tr td .enter_event");// 获取当前页面所有输入框
	    	$("#returncard_performance_edit tr td .enter_event").keypress(function(e){
	    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
	    		if (keyCode == 39) // 判断所按是否方向右键
			    {
			    	keyCode = 9;
			    }
			    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
			    {
			    	keyCode = 9;
			    	var idx = returncard_inputs.index(this); // 获取当前焦点输入框所处的位置

			    	if (idx == returncard_inputs.length - 1) // 判断是否是最后一个输入框
			    	{
			     		add_fomrline_click(this);
			    	} else {
			     		returncard_inputs[idx + 1].focus(); // 设置焦点
			     		returncard_inputs[idx + 1].select(); // 选中
			    	}
			    return false;// 取消默认的提交行为
			   }
	    	});

	    	// 
	    	$("[dmdata]").each(function(){
	    		var data_order = $(this).attr("dmdata");
	    		for (var i = key.length - 1; i >= 0; i--) {
	    			if(data_order == key[i]){
	    				var order_info = items_order[0][data_order];
	    				if(data_order == 'ORDERSTATUS'){
	    					if(order_info == 1){
	    						order_info = '已经下单';
	    					}
	    					if(order_info == 2){
	    						order_info = '已经付款，待发货';
	    					}
	    					if(order_info == 3){
	    						order_info = '已经发货';
	    					}
	    					if(order_info == 4){
	    						order_info = '发货完成或服务完成，待评价';
	    					}
	    					if(order_info == 5){
	    						order_info = '已经完成';
	    					}
	    					if(order_info == 6){
	    						order_info = '取消订单';
	    					}
	    				}
	    				if(data_order == 'card_pay_status'){
	    					if(order_info == 0){
	    						order_info = '未支付';
	    					}else if(order_info == 1){
	    						order_info = '已支付';
	    					}
	    				}
	    				if(order_info === null){
	    					order_info = '无';
	    				}
	    				if(items.orderproduct != null && items_orderproduct.length > 0){
				    		var orderproduct_info = items_orderproduct[0][data_order];
				    		if(orderproduct_info === null){
		    					orderproduct_info = '无';
		    				}
				    	}
				    	if(items.workorder != null && items_workorder.length > 0){
				    		var workorder_info = items_workorder[0][data_order];
				    		if(data_order == 'card_pay_status'){
		    					if(workorder_info == 0){
		    						workorder_info = '未支付';
		    					}else if(workorder_info == 1){
		    						workorder_info = '已支付';
		    					}
		    				}

				    		if(workorder_info === null){
		    					workorder_info = '';
		    				}
		    				
				    	}
	    				if(items.bonus_data != null && len>0){
				    		var bonus_data = items_bonusdata[0][data_order];
				    		if(bonus_data === null){
		    					bonus_data = '无';
		    				}
				    	}
				    	if(items.returncard_info != null && returncard.length > 0){
				    		var returncard_data = returncard[0][data_order];
				    		if(data_order == 'returncard_memo'){
				    			$("#returncard_memo").html(returncard_data);
				    		}
				    		if(data_order == 'return_card_method'){
				    			if(returncard_data == 0){
				    				$("#returnCardMethod1").attr("checked","checked");
				    			}else if(returncard_data == 1){
				    				$("#returnCardMethod2").attr("checked","checked");
				    			}
				    		}
				    		if(returncard_data == null){
				    			returncard_data = '无';
				    		}
				    	}

	    				var  workorder_id = 2;
	    				if(order_info != undefined){
	    					$(this).val(order_info);
	    					$(this).attr("value", order_info);
	    				}else if(orderproduct_info != undefined){
	    					$(this).val(orderproduct_info);
	    				}else if(workorder_info != undefined){
	    					if(data_order == 'paytype_name'){
	    						$("option[add_option='add_option']").remove();
	    						if(workorder_info == '支付宝'){
	    							workorder_id = 2;
	    							select_payname.attr("disabled","disabled");
	    							select_payname.addClass("fm-disabled");
	    							select_payname.append("<option value='2' add_option='add_option' selected='selected'>支付宝</option>");
	    						}else if(workorder_info == '微信'){
	    							workorder_id = 3;
	    							select_payname.attr("disabled","disabled");
	    							select_payname.addClass("fm-disabled");
	    							select_payname.append("<option value='3' add_option='add_option' selected='selected'>微信</option>");
	    						}else if(workorder_info == '银联' || workorder_info == '银联POS'){
	    							workorder_id = 4;
	    						}else if(workorder_info == '现金'){
	    							workorder_id = 5;
	    						}else if(workorder_info == '经理签单'){
	    							workorder_id = 8;
	    							select_payname.attr("disabled","disabled");
	    							select_payname.addClass("fm-disabled");
	    							select_payname.append("<option value='8' add_option='add_option' selected='selected'>经理签单</option>");
	    						}
	    						$(this).val(workorder_id);
		    				}else{
		    					$(this).val(workorder_info);		    					
		    				}
	    					
	    				}else if(bonus_data != undefined){
	    					$(this).val(bonus_data);
	    				}else if(returncard_data != undefined){
	    					$(this).val(returncard_data);
	    				}
	    			}
	    		}
	    	});

	    });
		
	}

	var m = 0;
	// 封装 添加销售员工
	function add_staff(){
		var bonus_data = $("#0_bonusdata_hidden").val();
		var fun_id = $("#0_funid_hidden").val()
		if(bonus_data != undefined && bonus_data != ''){
			bonus_data = JSON.parse(bonus_data);
			if(bonus_data.length == 0){
				bonus_data.length = 1;
			}
			var n = bonus_data.length+m;
			for (var i = bonus_data.length - 1; i >= 0; i--) {
				var bonus_value = bonus_data[i];
				var operator_type = bonus_value.operator_type	
			}
			if(operator_type == 1){
				fun_id = 2;
			}else if(operator_type == 5){
				fun_id = 3;
			}else if(operator_type == 7 ){
				fun_id = 8;
			}
			var bonus_html = '<tr id="'+n+'"><td><input class="fm-control staffname enter_event" id="'+n+'_maxname'+operator_type+'" value="" style="height:18px;"/><input type="hidden" class="fm-control staff_id" id="'+n+'_maxid'+operator_type+'" value=""/></td><td><input class="fm-control performance_amount enter_event" id="'+n+'_maxperformance'+operator_type+'" value="" style="height:18px;"/></td><td style="padding:4px 2px;"><button type="button" class="btn btn-default btn-sm" onclick="delete_staff(this)" style="background-color: #3399ff;color:#fff;padding:2px 5px;" >删除</button><input type="hidden" id="'+n+'_bonusdata_hidden" value=""></td></tr>';
			$("#"+n+"_bonusdata_hidden").remove();
			$(".workorder_list"+fun_id).append(bonus_html);
		}else{
			if(fun_id == 2){
				operator_type = 1;
			}else if(fun_id == 3){
				operator_type = 5;
			}else if(fun_id == 8){
				operator_type = 7;
			}
			var n = m;
			var bonus_html = '<tr id="'+n+'"><td><input class="fm-control staffname enter_event" id="'+n+'_maxname'+operator_type+'" value="" style="height:18px;"/><input type="hidden" class="fm-control staff_id" id="'+n+'_maxid'+operator_type+'" value=""/></td><td><input class="fm-control performance_amount enter_event" id="'+n+'_maxperformance'+operator_type+'" value="" style="height:18px;"/></td><td style="padding:4px 2px;"><button type="button" class="btn btn-default btn-sm" onclick="delete_staff(this)" style="background-color: #3399ff;color:#fff;padding:2px 5px;" >删除</button><input type="hidden" id="'+n+'_bonusdata_hidden" value=""></td></tr>';
			$("#"+n+"_bonusdata_hidden").remove();
			$(".workorder_list"+fun_id).append(bonus_html);
		}	
		
		m++;
	}
	// 添加销售员工
	function add_fomrline_click(obj){
		add_staff();
		show_stafflist();
		// 开卡界面 回车事件
		var card_inputs = $("#card_performance_edit tr td .enter_event");// 获取当前页面所有输入框
		if(obj != undefined && card_inputs.length > 0){
			var index = card_inputs.index(obj);
			card_inputs[index + 1].focus(); // 设置焦点
			card_inputs[index + 1].select(); // 选中
		}

		var rechargecard_inputs = $("#rechargecard_performance_edit tr td .enter_event");// 获取当前页面所有输入框
		if(obj != undefined && rechargecard_inputs.length > 0){
			var index = rechargecard_inputs.index(obj);
			rechargecard_inputs[index + 1].focus(); // 设置焦点
			rechargecard_inputs[index + 1].select(); // 选中
		}

		var returncard_inputs = $("#returncard_performance_edit tr td .enter_event");// 获取当前页面所有输入框
		if(obj != undefined && returncard_inputs.length > 0){
			var index = returncard_inputs.index(obj);
			returncard_inputs[index + 1].focus(); // 设置焦点
			returncard_inputs[index + 1].select(); // 选中
		}

    	$("#card_performance_edit tr td .enter_event").keypress(function(e){
    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
    		if (keyCode == 39) // 判断所按是否方向右键
		    {
		    	keyCode = 9;
		    }
		    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
		    {
		    	keyCode = 9;
		    	var idx = card_inputs.index(this); // 获取当前焦点输入框所处的位置

		    	if (idx == card_inputs.length - 1) // 判断是否是最后一个输入框
		    	{
		    		add_fomrline_click(this);
		    	} else {
		     		card_inputs[idx + 1].focus(); // 设置焦点
		     		card_inputs[idx + 1].select(); // 选中
		    	}
		    return false;// 取消默认的提交行为
		   }
    	});
    	// 充值界面 回车事件
    	$("#rechargecard_performance_edit tr td .enter_event").keypress(function(e){
    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
    		if (keyCode == 39) // 判断所按是否方向右键
		    {
		    	keyCode = 9;
		    }
		    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
		    {
		    	keyCode = 9;
		    	var idx = rechargecard_inputs.index(this); // 获取当前焦点输入框所处的位置

		    	if (idx == rechargecard_inputs.length - 1) // 判断是否是最后一个输入框
		    	{
		     		add_fomrline_click(this);
		    	} else {
		     		rechargecard_inputs[idx + 1].focus(); // 设置焦点
		     		rechargecard_inputs[idx + 1].select(); // 选中
		    	}
		    return false;// 取消默认的提交行为
		   }
    	});
    	// 退卡界面 回车事件
    	$("#returncard_performance_edit tr td .enter_event").keypress(function(e){
    		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
    		if (keyCode == 39) // 判断所按是否方向右键
		    {
		    	keyCode = 9;
		    }
		    if (keyCode == 13) // 判断所按是否回车键 FireFox下事件的keyCode 是只读的，不能修改
		    {
		    	keyCode = 9;
		    	var idx = returncard_inputs.index(this); // 获取当前焦点输入框所处的位置

		    	if (idx == returncard_inputs.length - 1) // 判断是否是最后一个输入框
		    	{
		     		add_fomrline_click(this);
		    	} else {
		     		returncard_inputs[idx + 1].focus(); // 设置焦点
		     		returncard_inputs[idx + 1].select(); // 选中
		    	}
		    return false;// 取消默认的提交行为
		   }
    	});
	}

	// 删除销售员工
	function delete_staff(obj){
		$(obj).parent().parent().remove();
	}

	// 员工列表
	function staffList(max_staff_num,min_staff_num,n){
		if(selectStoreId == 0){
			return;
		}
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/get_staff_list/"+selectStoreId ,
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	$("[select_staff]").append("<option value=-1></option>");
	    	var items = data.items;

	    	for (var i = items.length - 1; i >= 0; i--) {
	    		var staff_name = items[i]['STAFFNAME'];
	    		var staff_id = items[i]['STAFFID'];
	    		var staff_number = items[i]['STAFFNUMBER'];
	    		$("[select_staff]").each(function(){
	    			var option_html = '<option option_worker="option_worker" value="' + staff_id + '">' + staff_number + staff_name  + '</option>';
	    			$(this).append(option_html);
	    		});
	    		if(max_staff_num != undefined){
			    	if(max_staff_num == staff_number){
		    			var option_html1 = '<option selected="selected" option_worker="option_worker" value="' + staff_id + '">' + max_staff_num + staff_name  + '</option>';
		    			$("[value="+staff_id+"]").remove();
		    			$(".order-maxname"+(n)).append(option_html1);
			    	}
			    	
			    }
			    if(min_staff_num != undefined){
			    	if(min_staff_num == staff_number){
			    		var option_html2 = '<option selected="selected" option_worker="option_worker" value="' + staff_id + '">' + min_staff_num + staff_name  + '</option>';
			    		$("[value="+staff_id+"]").remove();
		    			$(".order-minname"+(n)).append(option_html2);
			    	}
			    }
	    	}
	    });
	}

	function paynameList(){
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/get_payname_list" ,
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	$(".select_paytype_name").empty();
	    	//$('.select_paytype_name').append("<option value=-1></option>");
	    	var items = data.items;
	    	for (var i = items.length - 1; i >= 0; i--) {
	    		var pay_type = items[i]['paytype_id'];
	    		var pay_name = items[i]['paytype_name'];
	    		if(pay_name != null && pay_type != null){
		    		var option_html = '<option option_paytype="' + pay_name + '" value="' + pay_type + '">' + pay_name + '</option>';
		    		$('.select_paytype_name').append(option_html);
	    		}
	    	}
	    });
	}

	function is_specify(){
		$.ajax({
	        type:'post',
	        url: annotation_siteurl+"/store_cashier/is_specify" ,
	        dataType:'json',
	        async: true
	    })
	    .success(function(data){
	    	$('[select_specify]').empty();
	    	var items = data.items;
	    	for (var i = items.length - 1; i >= 0; i--) {
	    		var specify_id = items[i]['specify_id'];
	    		var specify_name = items[i]['specify_name'];
	    		if(specify_name != null){
	    			$("[select_specify]").each(function(){
    					var option_html = '<option selected="selected" value="' + specify_id + '">' + specify_name + '</option>';
	    				$(this).append(option_html);
	    			});	    			
		    		
	    		}
	    	}
	    });
	}

	// 修改开单收银
	function update_order_one(obj){
		var text = '';
		var value = '';

		var data = new Object;
		data.items = new Array();
		$(".hidden_opid").each(function(index){
			var _index = $.inArray(index, data.items);
			if(_index<0){
				data.items[index] = new Object;
			}

			var obj = data.items[index];
			obj.opid = $(this).val();
			data.items[index] = obj;
		});

		$(".order-payname").each(function(index){
			var item_data = new Object;
			var payname_index = $(this)[0].selectedIndex;
			text = $(this)[0].options[payname_index].text;
			value = $(this)[0].options[payname_index].value;

			var _index = $.inArray(index, data.items);
			var obj = data.items[index];
			obj.payname = text; 
			obj.payid = value; 
			data.items[index] = obj;
		});

		var length = $("#product_list").children().length;
		for (var i = 0; i <= length-1; i++) {
			var _index = $.inArray(i, data.items);
			var obj = data.items[i];

			obj.maxname = $("#"+i+"_maxname0").val();
			if(obj.maxname == ''){
				$("#"+i+"_maxid0").val("");
			}
			obj.maxstaffid = $("#"+i+"_maxid0").val();

			obj.minname = $("#"+i+"_minname0").val();
			if(obj.minname == ''){
				$("#"+i+"_minid0").val("");
			}
			obj.minstaffid = $("#"+i+"_minid0").val();
			data.items[i] = obj;
		}

		$(".specify_name").each(function(index){
			var specify_index = $(this)[0].selectedIndex;
			text = $(this)[0].options[specify_index].text;
			value = $(this)[0].options[specify_index].value;
			var _index = $.inArray(index, data.items);
			var obj = data.items[index];
			obj.specify_name = text; 
			obj.specify_id = value; 
			data.items[index] = obj;
		});

		$(".specify_name_min").each(function(index){
			var min_specify_index = $(this)[0].selectedIndex;
			text = $(this)[0].options[min_specify_index].text;
			value = $(this)[0].options[min_specify_index].value;
			var _index = $.inArray(index, data.items);
			var obj = data.items[index];
			obj.specify_name_min = text;
			obj.specify_id_min = value; 
			data.items[index] = obj;
		});
		var ordernumber = $(".ordernumber").attr("value");
		var explain = $(".text_explain").val();

		$.ajax({
            type:'post',
            url: annotation_siteurl+"/store_cashier/update_order_payte/"+selectStoreId ,
            data:{data:JSON.stringify(data),explain:explain,ordernumber:ordernumber},
            dataType:'json',
            async: true
        })
        .success(function(json){
        	if(json.code == '000'){
        		json.code = 'success';
        	}else{
        		json.code = 'error';
        	}
        	$.AlertDialog.CreateAlert(json.code,json.message);
        	//history.go(0);
        	//console.log(json);
        });
	}

	function update_order_two(obj,fun_index){
		$(".performance_amount").each(function(){
			var amount = $(this).val();
			if(!$.isNumeric(amount)){
				$.AlertDialog.CreateAlert("error","输入错误！");
				jfslkdfgasdfasef; // 终止js
			}
		});
		var pay_money = $(".pay_money").attr("value");
		var total_amout = 0;
		var data = new Object;
		data.items = new Array();
		data.fun_index = fun_index;
		data.opid = $("#hidden_account_id").val();
		data.paytype_id = $(".edit_account_paytype"+fun_index).val();
		data.paytype_name = $(".edit_account_paytype"+fun_index).find("option:selected").text();
		var staffid_obj = $(".workorder_list"+fun_index+" > tr > td > .staff_id");
		var staff_obj = $(".workorder_list"+fun_index+" > tr > td > .staffname");
		var amount_obj = $(".workorder_list"+fun_index+" > tr > td > .performance_amount");
		staffid_obj.each(function(index){
			var _index = $.inArray(index, data.items);
			if(_index<0){
				data.items[index] = new Object;
			}
			var obj = data.items[index];
			obj.staffid = $(this).val();
			if(obj.staffid == ''){
				$.AlertDialog.CreateAlert("error","销售员工不能为空！");
				jfslkdfgasdfasef; // 终止js
			}
			data.items[index] = obj;
		});
		staff_obj.each(function(index){
			var obj = data.items[index];
			obj.staffname = $(this).val();
			data.items[index] = obj;
		});
		amount_obj.each(function(index){
			var obj = data.items[index];
			total_amout += Number($(this).val());
			obj.amount = $(this).val();
			data.items[index] = obj;
		});
		if(total_amout > Math.abs(pay_money)){
			alert("分享业绩不能超过总金额！");return false;
		}
		$.ajax({
            type:'post',
            url: annotation_siteurl+"/store_cashier/update_store_staff_card/"+selectStoreId ,
            data:{data:JSON.stringify(data)},
            dataType:'json',
            async: true
        })
        .success(function(json){
        	if(json.code == '000'){
        		json.code = 'success';
        	}else{
        		json.code = 'error';
        	}
        	$.AlertDialog.CreateAlert(json.code,json.message);
        	//history.go(0);
        	//console.log(json);
        });
	}

</script>
<SCRIPT LANGUAGE="JavaScript">

          <!--

          function stopError() {
            return true;
          }

          window.onerror = stopError;

          // -->
          

</SCRIPT>
