 <?php 
 $e_legendArray = array();
 $e_chartData = array();
 ?>
          
        <!-- table-report1 begin -->
        <button onclick="javascript:printDetail();">print</button>
        <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane active" id="report-bar-table">
        <div align="center">
            <table width="4000">
                <tbody>
                    <tr>
                        <td>操作</td>
                        <td>公司名称</td>
                        <td>门店名称</td>
                        <td>总收入</td>
                        <td>订单数</td>
                        <td>项目总数</td>
                        <td>日结账状态</td>
                        <td>现金(服务)</td>
                        <td>现金(产品)</td>
                        <td>现金(卡异动)</td>
                        <td>现金(退卡)</td>
                        <td>现金(合计)</td>
                        <td>银联(服务)</td>
                        <td>银联(产品)</td>
                        <td>银联(卡异动)</td>
                        <td>银联(合计)</td>
                        <td>支付宝(服务)</td>
                        <td>支付宝(产品)</td>
                        <td>支付宝(卡异动)</td>
                        <td>支付宝(退卡)</td>
                        <td>支付宝(合计)</td>
                        <td>微信(服务)</td>
                        <td>微信(产品)</td>
                        <td>微信(卡异动)</td>
                        <td>微信(退卡)</td>
                        <td>微信合计</td>
                        <td>支票(服务)</td>
                        <td>支票(产品)</td>
                        <td>支票(卡异动)</td>
                        <td>支票(退卡)</td>
                        <td>支票(合计)</td>
                        <td>销卡(服务)</td>
                        <td>销卡(产品)</td>
                        <td>销卡合计</td>
                        <td>经理签单</td>
                        <td>打印时间</td>
                        <td>打印次数</td>
                    </tr>
                    <?php 
                    if(!empty($orderTaill))
                    {
                       // print_r($orderTaill);
                        $frist = true;
                        foreach ($orderTaill as $key => $v) {

                            //绘制表格
                            echo '<td><button onclick="printDetail();">打印</button></td>';
                            echo '<td>'.$v->COMPANYNAME.'</td>';
                            echo '<td>'.$v->STORENAME.'</td>';
                            echo '<td>'.$v->STORENAME.'</td>';//总收入
                            echo '<td>'.$v->STORENAME.'</td>';
                            echo '<td>'.$v->STORENAME.'</td>';//项目总数</td>
                            echo '<td>'.$v->STORENAME.'</td>'; //<td>日结账状态</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>现金(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>现金(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>现金(卡异动)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>现金(退卡)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>现金(合计)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>银联(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>银联(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>银联(卡异动)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>银联(合计)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支付宝(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支付宝(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支付宝(卡异动)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支付宝(退卡)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支付宝(合计)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>微信(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>微信(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>微信(卡异动)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>微信(退卡)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>微信合计</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支票(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支票(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支票(卡异动)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支票(退卡)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>支票(合计)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>销卡(服务)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>销卡(产品)</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>销卡合计</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>经理签单</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>打印时间</td>
                            echo '<td>'.$v->STORENAME.'</td>';//<td>打印次数</td>
                            echo '</tr>';
                        }
                    }?>
                </tbody>
            </table>
         </div>
        <!-- table-report1 end -->
        <nav class="report-page">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">上一页</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li>
                    <a href="#" aria-label="Next">下一页</a>
                </li>
            </ul>
        </nav>
    </div>
        <input type="hidden" name="url" id="url" value="<?php echo  $url =  site_url('Report/post_curl?type=');?>">
        <!-- table-report1 end -->
    <div role="tabpanel" class="tab-pane" id="report-line-charts">
        <div id="ecBar" style="height:600px; width:900px"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="report-bar-charts">
        
        <div id="ecPie" style="height: 600px; width:900px;"></div>
    </div> 
</div>

 <div id="printDetail">
    <div class="trad-info">
    <?php 
        if ($dayTaill) {
    ?>
    <div class="trow">
        <div class="tcol-3">交易号</div>
        <div class="tcol-7" id="printOrderId">*****</div>
    </div>
    <div class="trow">
        <div class="tcol-3">公司名称</div>
        <div class="tcol-7" id="printOrderId"><?php echo $dayTaill->store_name; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">总收入</div>
        <div class="tcol-7" id="cashierPay"><?php echo "0"; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">订单数</div>
        <div class="tcol-7" id="cashierPay"><?php echo "0"; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">项目总数</div>
        <div class="tcol-7" id="cashierPay"><?php echo "0"; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">日结账状态</div>
        <div class="tcol-7" id="cashierPay"><?php echo ($dayTaill->account_status=="1"?"结账":"未结账"); ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">现金(服务)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->cash_service_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">现金(产品)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->cash_product_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">现金(卡异动)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->cash_card_add; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">现金(退卡)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->cash_card_reduce; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">现金(合计)</div>
        <div class="tcol-7" id="cashierPay"><?php echo (floatval($dayTaill->cash_service_amount)+floatval($dayTaill->cash_product_amount)+floatval($dayTaill->cash_card_add)+floatval($dayTaill->cash_card_reduce)); ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">银联(服务)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->bank_service_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">银联(产品)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->bank_product_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">银联(卡异动)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->bank_card_add; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">银联(退卡)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->bank_card_reduce; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">银联(合计)</div>
        <div class="tcol-7" id="cashierPay"><?php echo ; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">支付宝(服务)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->ali_service_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">支付宝(产品)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->ali_product_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">支付宝(卡异动)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->ali_card_add; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">支付宝(退卡)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->ali_card_reduce; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">支付宝(合计)</div>
        <div class="tcol-7" id="cashierPay"><?php echo ; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">微信(服务)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->wx_service_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">微信(产品)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->wx_product_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">微信(卡异动)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->wx_card_add; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">微信(退卡)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->wx_card_reduce; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">微信合计</div>
        <div class="tcol-7" id="cashierPay"><?php echo ; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">销卡(服务)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->card_service_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">销卡(产品)</div>
        <div class="tcol-7" id="cashierPay"><?php echo $dayTaill->card_product_amount; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">销卡合计</div>
        <div class="tcol-7" id="cashierPay"><?php echo ; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">经理签单</div>
        <div class="tcol-7" id="cashierPay"><?php echo ""; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">打印时间</div>
        <div class="tcol-7" id="cashierPay"><?php echo ""; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">打印次数</div>
        <div class="tcol-7" id="cashierPay"><?php echo "1"; ?></div>
    </div>
    <div class="trow">
        <div class="tcol-3">收银员</div>
        <div class="tcol-7" id="cashierPay"><?php echo ""; ?></div>
    </div>
    <?php }?>
</div>


<script type="text/javascript">
    
    function printDetail() {
        alert(123456);
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