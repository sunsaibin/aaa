<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>会员退卡申请</title>
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jslibs/flow/css/styles.css"/>
	</head>
	<body>
		<!--打印永琪会员退卡审核表-->
	<div class="qcardtable" id="printDetail" >
		<!-- <div class="qct-top">
			<img src="../content/images/yqlogo.jpg" alt="logo">
			<div class="top-hd">
				<div class="title">永琪企业管理</div>
				<div class="title-sub">****店VIP会员退卡审核表</div>
			</div>
		</div>
   -->
		<div class="qctable">
			<table class="table table-bordered table-condensed">
				<thead style="background:none;">
					<tr>
						<th colspan="10">
						   <div class="qct-top">
								<img src="<?php echo base_url(); ?>jslibs/content/images/yqlogo.jpg" alt="logo">
								<div class="top-hd">
									<div class="title">永琪企业管理</div>
									<div class="title-sub" style="color:#333;"><?php echo $approvaluser[0]->luf_store_name;?>VIP会员退卡审核表</div>
								</div>
							</div>
						
						</th>
					</tr>
					<tr style="text-align:right;">
						<td colspan="10" class="aTime">申请日期：<span id="aTime"><?php echo $approvaluser[0]->lufs_cdate;?></span></td>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td>卡&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</td>
						<td id ="vipCardNum"><?php echo $carddata["cardNum"]?></td>
						<td rowspan="7" colspan="8">粘卡处：(此卡作为开支凭证，无附卡视为无效)</td>
					</tr>
					<tr>
						<td>会员姓名</td>
						<td class="vipName"><?php echo $carddata["userLinkName"]?></td>
					</tr>
					<tr>
						<td>联系电话</td>
						<td class="vipPhone"><?php echo $carddata["phone"]?></td>
					</tr>
					<tr>
						<td>卡&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;种</td>
						<td class="vipCardType"><?php echo $carddata["cardTypeName"]?></td>
					</tr>
					<tr>
						<td>IC卡余额</td>
						<td class="vipCardBlance"><?php echo $carddata["cardBalance"]?></td>
					</tr>
					<tr>
						<td>实际退款</td>
						<td class="vipBackMoney"><?php echo $carddata["backMoney"]?></td>
					</tr>
					<tr>
						<td>退卡类型</td>
						<td class="vipBackMethod">
							<?php
								if($carddata["cardBackType"] == 1){
									$carddata["cardBackType"] = '协议退卡';
								}elseif($carddata["cardBackType"] == 2){
									$carddata["cardBackType"] = '余额退卡';
								}elseif($carddata["cardBackType"] == 3){
									$carddata["cardBackType"] = '折算退卡';
								}else{
									$carddata["cardBackType"] = '';
								}
								echo $carddata["cardBackType"];
							?>
						</td>
					</tr>
					<tr>
						<td>第一销售</td>
						<td>第二销售</td>
						<td>第三销售</td>
						<td>第四销售</td>
						<td>第五销售</td>
						<td>第六销售</td>
						<td>第七销售</td>
						<td>第八销售</td>
						<!-- <td>第九销售</td>
						<td>第十销售</td> -->
					</tr>
					<?php
						echo '<tr>';
						for ($i=0; $i <8 ; $i++) { 
							echo '<td>'.$carddata['staffList'][$i]['staffName'].'</td>';
						}
						echo '</tr>';
						echo '<tr>';
						for ($i=0; $i <8 ; $i++) {
							$achievement = abs($carddata['staffList'][$i]['achievement'])==0?'':abs($carddata['staffList'][$i]['achievement']);
							echo '<td>'.$achievement.'</td>';
						}
						echo '</tr>';
					?>
					<!-- <tr>
						<td>*******</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>******</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr> -->
					<tr id="backReson">
						<td>退卡原因</td>
						<td class="td2align" colspan="9" id="vipBackReson"><?php echo $carddata['applyMemo']?></td>
					</tr>
					<!-- <tr>
						<td>退卡人地址</td>
						<td class="td2align" colspan="9" id="vipBackAddress">*********</td>
					</tr> -->
					<tr>
						<td>退款支付方式</td>
						<td class="td2align" colspan="9" id="vipBackPay">
							<?php
								if($carddata["payTypeId"] == 2){
									$carddata["payTypeId"] = '支付宝';
								}elseif($carddata["payTypeId"] == 3){
									$carddata["payTypeId"] = '微信';
								}elseif($carddata["payTypeId"] == 4){
									$carddata["payTypeId"] = '银行卡';
								}elseif($carddata["payTypeId"] == 5){
									$carddata["payTypeId"] = '现金';
								}else{
									$carddata["payTypeId"] = '';
								}
								echo $carddata["payTypeId"];
							?>
						</td>
					</tr>
					<tr>
						<td>申请金额</td>
						<td class="td2align" colspan="9" id="vipApplyAmount"><?php echo $carddata['backMoney']?></td>
					</tr>
					<!-- <tr>
						<td>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</td>
						<td class="td2align" colspan="9" id="vipBankUserName"></td>
					</tr> -->
					<tr>
						<td>银行卡开户人</td>
						<td colspan="9" id="vipBankName"><?php echo $carddata['backUserName']?></td>
					</tr>
					<tr>
						<td>开户行账号</td>
						<td class="tdtd2align" colspan="9" id="vipBankNum"><?php echo $carddata['backNumber']?></td>
					</tr>
					<tr>
						<td>开户行地址</td>
						<td class="tdtd2align" colspan="9" id="vipBankAddress"><?php echo $carddata['backOpenAccountAddress']?></td>
					</tr>
					<tr>
						<td>支付宝账号</td>
						<td class="tdtd2align" colspan="9" id="vipzfbAccount"><?php echo $carddata['zfbNum']?></td>
					</tr>
					<tr>
						<td>微信账号</td>
						<td class="tdtd2align" colspan="9" id="vipzfbAccount"><?php echo $carddata['wxNum']?></td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left">门店审核：（同意退款或不同意退款）</td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left; height:80px;"class="storeSh"><?php echo $approvaluser[0]->lufs_explain;?></td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left">门店审核意见：</td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left; height:80px;" class="storeJy" ><?php echo $approvaluser[1]->lufs_explain;?></td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left">总部审核意见：</td>
					</tr>
					<tr>
						<td colspan="10" style="text-align:left; height:80px;"><?php echo $approvaluser[2]->lufs_explain;?></td>
					</tr>
					<tr>
						
						<td style="text-align:right;" colspan="10">
							<div style="display:inline-block;margin-right:30px;">
								<span>审核人：</span><span class="shMan" style="padding:0px 40px;border-bottom:1px solid #ccc;"><?php echo $zhuanyuan;?></span>
							</div>
							<div style="display:inline-block;margin-right:30px;">
								<span>审批人：</span><span style="padding:0px 40px;border-bottom:1px solid #ccc;"><?php echo $zhuguan;?></span>
							</div>
							<div style="display:inline-block">
								<span style="padding:0px 20px;"><?php echo date('Y');?></span><span>年</span>
								<span style="padding:0px 20px;"><?php echo date('m');?></span><span>月</span>
								<span style="padding:0px 20px;"><?php echo date('d');?></span><span>号</span>
							</div>
							</td>
						
						
					</tr>
				</tbody>
			</table>
			
		</div>
      
	
	</div>
	
	<!--打印页面结束-->
        <button class="btn btn-info" onclick="onClickPrint();">打印</button>
        <script src="<?php echo base_url("");?>/jslibs/print/jQuery.print.js"></script>
        <script type="text/javascript">
            function onClickPrint() {

                /*LODOP=getLodop();
                LODOP.ADD_PRINT_HTM(0,0,200,100,$("#printDetail").html());
                LODOP.SET_PRINT_PAGESIZE(1,586,35,"")
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
