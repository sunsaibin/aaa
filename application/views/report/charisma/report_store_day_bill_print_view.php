<?php
date_default_timezone_set('Asia/Shanghai');
?>
<div class="print" id="order" style="width: 300px; padding-top:16px; padding-bottom: 30px;">
    <div class="title" style="text-align: center; line-height: 20px; font-size: 14px; font-family: '微软雅黑'; margin-left: -10px;" >
        <span style="display:block;"><?php echo $stallStore->brandname; ?></span>
        <span style="display:block;"><?php echo $stallStore->STORENAME; ?></span>
        <span style="display:block; ">日记账</span>
    </div>
    <div class="content">
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">结账日期:</span><span style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo $querydate;?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">打印日期:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo date('Y-m-d',time()); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">打印时间:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo date('H:i:s',time()); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">现金业绩合计:</span><span  style="display:inline-block ; width: 36%; font-size: 10px; text-align: right;font-weight: bold;"><?php echo number_format($reportData->total_cash,2);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">服务业绩合计:</span><span style="display:inline-block ; width: 36%;font-size: 10px; text-align: right; font-weight: bold;"><span><?php echo number_format($reportData->total_server,2); ?></span>
            </div>

        </div>
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">现金服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->cash_server_money);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">现金产品:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->cash_product_money,2);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">现金退卡:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;" ><?php echo number_format($reportData->cash_cancel_money,2);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">现金(卡异动):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->cash_changes_money,2);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">现金合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo number_format($reportData->cash_total_money,2);?></span>
            </div>
        </div>
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">银行卡服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->unionpay_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">银行卡产品:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->unionpay_product__money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">银行卡退卡:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->unionpay_cancel_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">银行卡(卡异动):</span><span style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->unionpay_changes_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">银行卡合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo  number_format($reportData->unionpay_total_money,2); ?></span>
            </div>
        </div>
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">支付宝服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->alipay_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">支付宝产品:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->alipay_produc_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">支付宝退卡:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->alipay_cancel_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">支付宝(卡异动):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->alipay_changes_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">支付宝合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo  number_format($reportData->alipay_total_money,2); ?></span>
            </div>
        </div>
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">微信服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->weixin_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">微信产品:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->weixin_product_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">微信退卡:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->weixin_cancel_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">微信(卡异动):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->weixin_changes_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">微信合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo  number_format($reportData->weixin_total_money,2);  ?></span>
            </div>
        </div>
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">销卡服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->card_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">销卡产品:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->card_product_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">疗程服务:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->card_course_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">销卡合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo number_format($reportData->card_total_money,2);?></span>
            </div>
        </div>

        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">优惠券(服务金额):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->coupon_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">优惠券(商品金额):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->coupon_product_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">优惠券(数量):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->count_coupon,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">优惠券(合计):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo  number_format($reportData->coupon_total_money,2); ?></span>
            </div>
        </div>

        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">大众点评:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo  number_format($reportData->third_dianping_server_money,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">第三方平台(合计):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo  number_format($reportData->third_total_money,2); ?></span>
            </div>
        </div>

        <div class="list" style=" padding-bottom: 6px; padding-top: 6px;">
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">卡异动(金额):</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->total_card,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">开卡数:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo intval($reportData->card_count); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">客单数合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo intval($reportData->order_count); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">经理签单:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->manager_bill,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">支出登记:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo number_format($reportData->expend_record,2); ?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 12px; font-weight: bold;">产品合计:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right; font-weight: bold;"><?php echo number_format($reportData->total_product,2);?></span>
            </div>
            <div>
                <span style="display:inline-block ; width: 52%; font-size: 11px;">打印人员:</span><span  style="display:inline-block ; width: 36%;  font-size: 10px; text-align: right;"><?php echo $username; ?></span>
            </div>
        </div>
        <!--        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;height: 5px"></div>-->
        <div class="list" style="border-bottom: 1px dashed #000; padding-bottom: 6px; padding-top: 6px;height: 50px;border-top: 1px dashed #000;"></div>
    </div>
</div>
<!-- print-bill end -->

<!-- print-btn-box begin -->
<div class="print-btn-box">
    <button class="btn btn-info" onclick="onClickPrint();">打印</button>
    <script type="text/javascript">
        function onClickPrint() {

            LODOP=getLodop();
            LODOP.ADD_PRINT_HTM(0,0,200,200,$("#order").html());
            LODOP.SET_PRINT_PAGESIZE(3,586,35,"")
            LODOP.PRINT();

            /*$("#printDetail").print({
             globalStyles: true,
             mediaPrint: false,
             stylesheet: null,
             noPrintSelector: ".no-print",
             iframe: true,
             append: null,
             prepend: null,
             manuallyCopyFormValues: true,
             deferred: $.Deferred()*/
            //});
        }
    </script>
</div>
</div>