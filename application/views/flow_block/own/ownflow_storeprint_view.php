<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>本店调动申请</title>
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jslibs/flow/css/styles.css"/>
	</head>
	<body id="body-printDetail">
	<?php
		$array = array();
		foreach ($userdata as $key => $value) {
			$array[$value->lfuff_key] = $value->lfuff_value;
			$array["id"] = $value->lfuff_userflow;
		}
		foreach ($approvaluser as $k1 => $v1) {
			if($v1->fau_approval == 3){
				$array["fa_name1"] = $v1->fau_user_name;// 人事专员
			}elseif($v1->fau_approval == 4){
				$array["fa_name2"] = $v1->fau_user_name;// 人事经理
			}
			if($v1->luf_is_approve == 0){
				$array["approve_status"] = '等待审核';
			}elseif($v1->luf_is_approve == 1){
				$array["approve_status"] = '审核中';
			}elseif($v1->luf_is_approve == 2){
				$array["approve_status"] = '审核通过';
			}elseif($v1->luf_is_approve == 3){
				$array["approve_status"] = '审核拒绝';
			}
			$array["create_date"] = $v1->luf_cdate;
			$array["approval_cdate"] = $v1->lufs_approval_cdate;
			$array["explain"] = $v1->lufs_explain;
		}	
	?>
		<div class="enrty-com container" id="printDetail">
			<div class="header">
				<h3>(员工异动申请)审查表</h3>
				<h3>(本门店调动)</h3>
			</div>
			<div class="content">
				<div class="item2">调动单号：<span><?php echo $array["id"]; ?></span></div>
				<div class="item2">
					<div class="inline">员工姓名：<span><?php echo $array["storeTransfer_staff_staffnumber_old"].$array["storeTransfer_staff_staffname"]; ?></span></div>
					<div class="inline posi1">手机号码：<span><?php echo $staffinfo->PHONE; ?></span></div>
				</div>
				<div class="item2">
					<div class="inline">原员工工号：<span><?php echo $array["storeTransfer_staff_staffnumber_old"]; ?></span></div>
					<div class="inline posi2">原职位：<span>
					<?php
						foreach ($companyrank as $k => $v) {
						  	if($array["storeTransfer_staff_rankid_old"] == $v->option_key){
						  		echo $v->option_value;
						  	}
						}  				 
					?>
					</span></div>
				</div>
				<div class="item2">
					<div class="inline">新员工工号：<span><?php echo $array["storeTransfer_staff_staffnumber_new"]; ?></span></div>
					<div class="inline posi3">新职位：<span>
					<?php
						foreach ($companyrank as $k => $v) {
						  	if($array["storeTransfer_staff_rankid_new"] == $v->option_key){
						  		echo $v->option_value;
						  	}
						}  				 
					?>
					</span></div>
				</div>
				<div class="item2">
					<div class="inline">调动前工资：<span><?php echo $array["storeTransfer_staff_basesalary_old"]; ?></span></div>
					<div class="inline posi4">调动后工资：<span><?php echo $array["storeTransfer_staff_basesalary_new"]; ?></span></div>
				</div>
				<div class="item2">申请单状态：<span><?php echo $array["approve_status"]; ?></span></div>
				<div class="item2">人事专员审核：
					<span><?php echo isset($zhuanyuan) != false?$zhuanyuan:$array["fa_name1"]; ?></span>
				</div>
				<div class="item2">人事主管/经理审核：
					<span><?php echo isset($zhuguan) != false?$zhuguan:$array["fa_name2"]; ?></span>
				</div>
				<div class="item2">
					<div class="inline">申请日期：<span><?php echo date('Y-m-d',strtotime($array["create_date"]))=='1970-01-01'?'':date('Y-m-d',strtotime($array["create_date"])); ?></span></div>
        			<div class="inline posi4">生效日期：<span><?php echo date('Y-m-d',strtotime($array["approval_cdate"]))=='1970-01-01'?'':date('Y-m-d',strtotime($array["approval_cdate"])); ?></span></div>
				</div>
        		<div class="remark">备注:<?php echo $array["explain"]; ?></div>
			</div>
			
		</div>

		<!-- print-btn-box begin -->
    <div class="print-btn-box">
        <button class="btn btn-info" onclick="onClickPrint();">打印</button>
        <script src="<?php echo base_url("");?>/jslibs/print/jQuery.print.js"></script>
        <script type="text/javascript">
            function onClickPrint() {
            	//window.print();
                /*LODOP=getLodop();
                LODOP.SET_PRINT_PAGESIZE (2, 0, 0,"A4");
                LODOP.ADD_PRINT_HTM(10,10,"RightMargin:0.9cm","BottomMargin:9mm",$("#body-printDetail").html());
                //LODOP.SET_PRINT_PAGESIZE(3,2100,100,"")
                //LODOP.PREVIEW();
                LODOP.PRINT();*/

                    $("#printDetail").print({
	                    globalStyles: true,
	                    mediaPrint: false,
	                    stylesheet: null,
	                    noPrintSelector: ".no-print",
	                    iframe: true,
	                    append: null,
	                    prepend: null,
	                    manuallyCopyFormValues: true,
	                    deferred: $.Deferred()
	                 });

            }
        </script>
    </div>
	</body>
</html>
