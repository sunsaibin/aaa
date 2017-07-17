	<div class="container-sum product-set">
		<!------------product-top 开始---------------------------->
		<div class="product-top">
			<div class="product-top-left">
				<div class="inputd-group">
					<label class="label-control">当前查询节点：</label>
					<input type="text" class="fm-control fm-disabled" id="searchStoreId" value="<?php echo $seach_name; ?>" readonly="true">
				</div>
				<div class="menu" onclick="showTree()"><img src="<?php echo base_url();?>/jslibs/content/images/menu-icon.svg" alt="menu"></div>
				<input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    			<input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
    			<input type="hidden" id="dminit_type" name="seach_storeid">
				<div class="inputd-group" style="margin-right: 0px;">
					<label class="label-control">日期：</label>
					<input type="text" class="fm-control date" id="start_date" onclick="laydate()">
				</div>
				<div class="inputd-group">
					<label class="label-control">至</label>
					<input type="text" class="fm-control  date" id="end_date" onclick="laydate()">
				</div>
				<div class="inputd-group">
					<label class="label-control">关键字：</label>
					<input type="text" class="fm-control" id="staff_number" placeholder="可输入工号/姓名/身份证">
				</div>
			</div>
			<div class="product-top-right" onclick="search_flowlist()">
				<button type="button" class="btn btn-primary btn-search"><span class="iconfont icon-search" style="font-size: 12px;"></span><span class="span-set">查询</span></button>
			</div>
		</div>
		<!-------------product-top 结束----------------------------------------->

		<!------------------------------------------------------------------------->
		<div class="product-bottom">
			<div class="table-product row">
				<div class=" product-bottom-table table-responsive col-xs-9 table-set">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th>异动类型</th>
								<th>申请门店</th>
								<th>申请工号</th>
								<th>员工姓名</th>
								<th>申请日期</th>
								<th>生效日期</th>
								<th>流程状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="flow_list">
						</tbody>
				</table>
					<div class="fpag">
						<span class="pre btn-search" onclick="search_flowlist('',-1)"><img src="<?php echo base_url();?>/jslibs/content/images/pre-icon.png" alt="pre"></span>
						<span class="curent-pae">第<span id="current_page">1</span>页</span>
						<span class="curent-query">转到第&nbsp;<input type="text" id="search_flowlist">&nbsp;页</span>
						<span class="next btn-search" onclick="search_flowlist('',1)"><img src="<?php echo base_url();?>/jslibs/content/images/next-icon.png" alt="pre"></span>
					</div>
				</div>
				<div class="product-bottom-right col-xs-3 text-center list-set">
					<div class="review">审核信息</div>
					<div class="review-result">
						<div class="line approval_flow">
							<div class="inputd-group1">
								<label class="label-control label-control2">申请单号：</label>
								<span id="user_flowid"></span>
							</div>
							<div class="inputd-group1">
								<label class="label-control label-control2">申请日期：</label>
								<span id="init_date"></span>
							</div>
							<div class="inputd-group1">
								<label class="label-control label-control2">操作人：</label>
								<span id="luf_username"></span>
							</div>
							<div class="inputd-group1">
							<label class="label-control label-control2">流程状态：</label>
							<span class="text-color" id="approve_status"></span>
						</div>
						</div>
					 <button type="button" class="btn btn-default btn-search2" style="position:absolute;left:0px;bottom:0px;" >查看申请单详情</button>
						<!----------------------------->
					</div>
				</div>
			</div>
			</div>
		<!------------------------------------------------>
		</div>	
	</div>
	<div class="nodeTreeBox"></div>
