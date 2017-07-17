<?php
    date_default_timezone_set('Asia/Shanghai');

//print_r($reportData);

?>
<div class="bill-container">

        <!-- bill-query begin -->
        <div class="row bill-query">
        <form action="<?php echo site_url("/Report_store_old/store_day_bill"); ?>" method="get">
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
                <!-- <label>日期</label>
                <input type="date" class="form-control"> -->
                <button type="submit" class="btn btn-info">查询</button>
              </div>
            </div>
            <!-- col-xs-3 end -->
        </form>
        </div>
        <!-- bill-query end -->
        
        <!-- bill-day-book begin -->
        <div class="bill-day-book">

            <!-- day-book-row begin -->
            <div class="day-book-row">
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">现金合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->cash_total_money);?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金服务</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->cash_server_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金产品</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->cash_product_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金退卡</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->cash_cancel_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">现金(卡异动)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->cash_changes_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">银行卡合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->unionpay_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡服务</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->unionpay_server_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡产品</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->unionpay_product__money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡退卡</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->unionpay_cancel_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">银行卡(卡异动)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->unionpay_changes_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">支付宝合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->alipay_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝服务</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->alipay_server_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝产品</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->alipay_produc_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝退卡</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->alipay_cancel_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支付宝(卡异动)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->alipay_changes_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">微信合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->weixin_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信服务</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->weixin_server_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信产品</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->weixin_product_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信退卡</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->weixin_cancel_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">微信(卡异动)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->weixin_changes_money);  ?></div>
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
                        <div class="col-xs-8">第三方平台合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->third_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">大众点评</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->third_dianping_server_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">销卡合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->card_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">销卡（服务）</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->card_server_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">销卡（产品）</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->card_product_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">疗程（服务）</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->card_course_server_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">转账合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->transfer_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">转账（卡异动）</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->transfer_changes_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">转账(退卡)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->transfer_cancel_money);  ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row">
                        <div class="col-xs-8">优惠券合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->coupon_total_money);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券（服务金额）</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo  floatval($reportData->coupon_server_money); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券 (商品金额)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo  floatval($reportData->coupon_product_money); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">优惠券 (数量)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo  floatval($reportData->count_coupon); ?></div>
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
                        <div class="col-xs-8">卡异动(金额)</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->total_card);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">开卡数</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo intval($reportData->card_count); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">客单数合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo intval($reportData->order_count); ?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
                <!-- day-book-box begin -->
                <div class="day-book-box">
                    <div class="row normal-row">
                        <div class="col-xs-8">经理签单</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->manager_bill);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">支出登记</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->expend_record);  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">产品合计</div>
                        <div class="col-xs-4" style="text-align:right;"><?php echo sprintf("%.2f",$reportData->total_product);?></div>
                    </div>
                </div>
                <!-- day-book-box end -->
            </div>
            <!-- day-book-row end -->

        </div>
        <!-- bill-day-book end -->
        
        <!-- day-book-sum begin -->
        <div class="day-book-sum">
            <div class="db-sum">现金业绩合计：<span>&yen;<span><?php echo sprintf("%.2f", $reportData->total_cash);?></span></span></div>
            <div class="db-sum">服务业绩合计：<span>&yen;<span><?php echo sprintf("%.2f", $reportData->total_server); ?></span></span></div>
            <button class="btn btn-info" onclick="onClickPrint();">打印</button>
            <script type="text/javascript">
                function onClickPrint() {
                    var url ="<?php echo site_url('/Report_store_old/store_day_bill_print?storeid='.$stallStore->STOREID.'&querydate='.urlencode($querydate)); ?>";
                    window.location.href=url;

                }
            </script>
        </div>
        <!-- day-book-sum end -->
    </div>