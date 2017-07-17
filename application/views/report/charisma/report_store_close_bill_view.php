<style>
    .sealDayAnalysisTetarea{padding:10px;border: 1px solid #cccccc; height: 80px; overflow: auto;}
    .sealDayAnalysisTetarea div{ color: #f00; margin-bottom: 6px;}
</style>
<div class="bill-container">
		
		<!-- bill-query begin -->
		<div class="row bill-query">
			<form action="<?php echo site_url(); ?>/Report_store_old/close_bill" method="get">
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>公司</label>
			    <select class="form-control">
                <?php
                    if ($stallCompany) {
                        echo '<option>'.$stallCompany->COMPANYNAME.'</option>';
                    }
                ?>
                </select>
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>门店</label>
			    <select class="form-control" name="storeid">
                <?php
                    //print_r($stallStore);
                    foreach ($selectStore as $key => $value) {
                        if ($stallStore->STOREID == $value->STOREID) {
                             echo '<option value="'.$value->STOREID.'" selected=selected>'.$value->STORENAME.'</option>';
                        }
                        else{
                             echo '<option value="'.$value->STOREID.'">'.$value->STORENAME.'</option>';
                        }
                       
                    }
                ?>
                </select>
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>日期</label>
			    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
				<div class="form-group btn-form-group">
			    <button type="submit" class="btn btn-info">查询</button>
			  </div>
			</div>
			<!-- col-xs-3 end -->
			</form>
		</div>
		<!-- bill-query end -->

		<!-- seal-handle begin -->
		<div class="row seal-handle">
			<a href="javascript:;" class="btn btn-default btn-sm btn-blue">营业汇总</a>
			<a href="javascript:;" class="btn btn-default btn-sm" id="btnAnalysis">单据分析</a>
			<a href="javascript:;" class="btn btn-default btn-sm disabled" id="btnSettle" data-toggle="modal" data-target="#myAlertModal">结算封账</a>
			<a href="<?php echo site_url(); ?>/Report_store_old/close_bill_log" class="btn btn-default btn-sm">封账日志</a>
			<!--<a href="javascript:;" class="btn btn-default btn-sm">取消封账</a>-->
		</div>
		<!-- seal-handle end -->

		<!-- seal-pay-count end -->
		
		<!-- seal-business-summary begin -->
		<table class="table table-bordered seal-business-summary">
			<caption>营业汇总</caption>
			<thead>
				<tr>
					<th>现金业绩合计</th>
					<th>服务业绩合计</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><center><?php print_r($reportData->total_cash); ?></center></td>
					<td><center><?php print_r($reportData->total_server); ?></center></td>
				</tr>
			</tbody>
		</table>

		<!-- seal-day-analysis begin -->
		<div class="seal-day-analysis" id="sealDayAnalysis">
			<h5>当日单据分析</h5>
            <div class="sealDayAnalysisTetarea" id="sealDayAnalysisTetarea"></div>
			<!--<textarea class="form-control" disabled="disabled" id="sealDayAnalysisTetarea">
			系统初步核对正常,只做参考！请在封帐操作前确定项目分配比例,封帐后不可以修改!
			</textarea>-->
		</div>

		<!-- seal-business-summary end -->
		<div class="bill-day-book">

            <!-- day-book-row begin -->
            <div class="day-book-row">
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">现金合计</div>
                        <div class="col-xs-4"><?php echo $reportData->cash_total_money;?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金服务</div>
                        <div class="col-xs-4"><?php echo  $reportData->cash_server_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金产品</div>
                        <div class="col-xs-4"><?php echo  $reportData->cash_product_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金退卡</div>
                        <div class="col-xs-4"><?php echo  $reportData->cash_cancel_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金(卡异动)</div>
                        <div class="col-xs-4"><?php echo  $reportData->cash_changes_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">银行卡合计</div>
                        <div class="col-xs-4"><?php echo  $reportData->unionpay_total_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡服务</div>
                        <div class="col-xs-4"><?php echo  $reportData->unionpay_server_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡产品</div>
                        <div class="col-xs-4"><?php echo  $reportData->unionpay_product__money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡退卡</div>
                        <div class="col-xs-4"><?php echo  $reportData->unionpay_cancel_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡(卡异动)</div>
                        <div class="col-xs-4"><?php echo  $reportData->unionpay_changes_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">支付宝合计</div>
                        <div class="col-xs-4"><?php echo  $reportData->alipay_total_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝服务</div>
                        <div class="col-xs-4"><?php echo  $reportData->alipay_server_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝产品</div>
                        <div class="col-xs-4"><?php echo  $reportData->alipay_produc_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝退卡</div>
                        <div class="col-xs-4"><?php echo  $reportData->alipay_cancel_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝(卡异动)</div>
                        <div class="col-xs-4"><?php echo  $reportData->alipay_changes_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">微信合计</div>
                        <div class="col-xs-4"><?php echo $reportData->weixin_total_money;  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信服务</div>
                        <div class="col-xs-4"><?php echo  $reportData->weixin_server_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信产品</div>
                        <div class="col-xs-4"><?php echo  $reportData->weixin_product_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信退卡</div>
                        <div class="col-xs-4"><?php echo  $reportData->weixin_cancel_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信(卡异动)</div>
                        <div class="col-xs-4"><?php echo  $reportData->weixin_changes_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
            </div>
            <!-- day-book-row end -->

            <!-- day-book-row begin -->
            <div class="day-book-row">
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">销卡合计</div>
                        <div class="col-xs-4"><?php echo $reportData->card_total_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">销卡（服务）</div>
                        <div class="col-xs-4"><?php echo  $reportData->card_server_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">销卡（产品）</div>
                        <div class="col-xs-4"><?php echo  $reportData->card_product_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">转账合计</div>
                        <div class="col-xs-4"><?php echo  $reportData->transfer_total_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">转账（卡异动）</div>
                        <div class="col-xs-4"><?php echo  $reportData->transfer_changes_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">转账(退卡)</div>
                        <div class="col-xs-4"><?php echo  $reportData->transfer_cancel_money; ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">优惠券合计</div>
                        <div class="col-xs-4"><?php echo $reportData->coupon_total_money; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券（服务金额）</div>
                        <div class="col-xs-4"><?php echo  floatval($reportData->coupon_server_money); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券 (商品金额)</div>
                        <div class="col-xs-4"><?php echo  floatval($reportData->coupon_product_money); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券 (数量)</div>
                        <div class="col-xs-4"><?php echo  floatval($reportData->count_coupon); ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row normal-row">
                        <div class="col-xs-8">卡异动(金额)</div>
                        <div class="col-xs-4"><?php echo $reportData->total_card; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">开卡数</div>
                        <div class="col-xs-4"><?php echo intval($reportData->card_count); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">客单数合计</div>
                        <div class="col-xs-4"><?php echo intval($reportData->order_count); ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
            </div>
            <!-- day-book-row end -->
            
            <!-- day-book-row begin -->
            <div class="day-book-row">
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row normal-row">
                        <div class="col-xs-8">经理签单</div>
                        <div class="col-xs-4"><?php echo $manager_bill;?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支出登记</div>
                        <div class="col-xs-4"><?php echo $expend_record;?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">产品合计</div>
                        <div class="col-xs-4"><?php echo $product_total;?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
            </div>
            <!-- day-book-row end -->

        </div>
        <!-- bill-day-book end -->

        <!-- Modal -->
		<div class="modal fade" id="myAlertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="myModalLabel">重要提示</h4>
		      </div>
		      <div class="modal-body" style="color:red;">
		        您确认要对<?php echo '"'.$storename.'" '.$querydate; ?>,进行结账封帐操作吗?封帐之后不能修改单据！
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="close_bill_store();">确认结账</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<!-- seal-day-analysis end -->
		<script type="text/javascript">
$(function(){
	/*
	 *单据分析 操作
	 */
	$("#btnAnalysis").click(function(){
        $.post("<?php echo site_url(); ?>/Report_store_old/get_bill_check",{storeid:<?php echo $stallStore->STOREID; ?>},function(result){
            console.log(result);
            var tem="";
            var isError = false;
            //$("#btnSettle").prop("disabled",true);
            //$("#btnSettle").removeClass("disabled");
            for(var i = 0; i<result.length; i++){
                if(parseFloat(result[i].already_performance) !=parseFloat(result[i].amount)){
                    isError = true;
                    tem = tem + "<div>会员卡:"+result[i].card_num+"&nbsp;&nbsp;金额:"+result[i].amount+" 已分配&nbsp;&yen;"+result[i].already_performance+"元!   数据异常!</div>";
                }
                else{
                    //$("#sealDayAnalysisTetarea").html("<div>数据业绩数据分析正常!</div>");
                    tem = tem + "<div  style='color: #00A000;'>会员卡:"+result[i].card_num+"&nbsp;&nbsp;金额:"+result[i].amount+" 已分配&nbsp;&yen;"+result[i].already_performance+"元!  数据正常!</div>";
                }
            }
            $("#sealDayAnalysisTetarea").html(tem);
            //$("span").html(result);
            if(isError == false){
                $("#btnSettle").removeClass("disabled");
                //$("#btnSettle").prop("disabled",false);
            }
        },"json");

		$("#sealDayAnalysis").slideDown();
		//$("#sealDayAnalysis").show();
	});
});

function close_bill_store() {
	window.location.href="<?php echo site_url(); ?>/Report_store_old/exec_close_bill/?querydate=<?php echo $querydate; ?>&storeid=<?php echo $storeid;?>";
}
		</script>
	</div>