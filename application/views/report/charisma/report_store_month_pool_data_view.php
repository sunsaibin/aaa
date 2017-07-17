 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;

     $e_title = array();
     $e_data1 = array();
     $e_data2 = array();
 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_store_old/store_day_pool");?>" method="GET">
        <div class="report-head">
            <div class="form-group col-xs-2">
                <label class="col-sm-12">公司</label>
                <div class="col-sm-12">
                <select class="form-control">
                <?php
                    if ($stallCompany) {
                        echo '<option>'.$stallCompany->COMPANYNAME.'</option>';
                    }
                ?>
                </select>
                </div>
            </div>

            <div class="form-group col-xs-2">
                <label class="col-sm-12">门店</label>
                <div class="col-sm-12">
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
            <div class="form-group col-xs-2">
                <label class="col-sm-12">开始日期</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
                </div>
            </div>
              
            <div class="form-group col-xs-2">
                <label class="col-sm-12">结束时间</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control" name="queryenddate" value="<?php echo $queryenddate; ?>">
                </div>
            </div>  
 
            <div class="form-group col-xs-1">
                <label class="col-sm-12">&nbsp;</label>
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-info" id="do_query" value="查询" />
                </div>
            </div>
        </div>           

        </form>

        <!-- report-head end -->
        <div class="report-bar clearfix">
            <div class="report-bar-zoneline pull-left">
                <a href="#">全部</a> &gt;
                <?php
                    if (isset($aLinkCompany)) {
                        echo ' <a href="#">'.$aLinkCompany->COMPANYNAME.'</a>&gt;';
                    }

                    if (isset($aLinkCompany)) {
                        echo ' <a href="#">'.$aLinkStore->STORENAME.'</a>';
                    }
                ?>
            </div>
            <ul class="nav nav-pills report-tableCharts pull-right" role="tablist">
                <li role="presentation">
                    <a href="#report-bar-table" aria-controls="report-bar-table" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportTable.png" alt="reportTable"/>&nbsp;
                        <span>表格</span>
                    </a>
                </li>

                <li role="presentation" class="active">
                    <a href="#report-bar-charts" aria-controls="report-bar-charts" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>图表</span>
                    </a>
                </li>
            </ul>
        </div> 

        <!-- table-report1 begin -->
        <!-- Tab panes -->
        <div class="tab-content report-content">
            <div role="tabpanel" class="tab-pane" id="report-bar-table">
                <!-- table-report1 begin -->
                <div class="table-report1">
                    <table>
                        <tbody>
                        <tr>
                            <td>门店</td>
                            <td>日期</td>
                            <td>现金业绩合计</td>
                            <td>服务业绩合计</td>
                            <td>订单总数</td>
                            <td>卡异动(金额)</td>
                            <td>产品业绩合计</td>
                            <td>开卡数</td>
                            <td class="tdGroup tdGroupOpen">现金合集</td>
                            <td class="tdSub">现金服务</td>
                            <td class="tdSub">现金产品</td>
                            <td class="tdSub">现金(卡异动)</td>
                            <td class="tdSub rowBg">现金退卡</td>
                            <td class="tdGroup tdGroupOpen">银行卡合集</td>
                            <td class="tdSub">银行卡服务</td>
                            <td class="tdSub">银行卡产品</td>
                            <td class="tdSub">银行卡(卡异动)</td>
                            <td class="tdSub rowBg">银行卡退卡</td>
                            <td class="tdGroup tdGroupOpen">支付宝服务</td>
                            <td class="tdSub">支付宝服务</td>
                            <td class="tdSub">支付宝产品</td>
                            <td class="tdSub">支付宝(卡异动)</td>
                            <td class="tdSub rowBg">支付宝退卡</td>
                            <td class="tdGroup tdGroupOpen">微信服务</td>
                            <td class="tdSub">微信服务</td>
                            <td class="tdSub">微信产品</td>
                            <td class="tdSub">微信(卡异动)</td>
                            <td class="tdSub rowBg">微信退卡</td>
                            <td class="tdGroup tdGroupOpen">销卡合计</td>
                            <td class="tdSub">销卡服务</td>
                            <td class="tdSub rowBg">销卡产品</td>
                            <td class="tdGroup tdGroupOpen">优惠券合计</td>
                            <td class="tdSub">优惠券服务</td>
                            <td class="tdSub">优惠券产品</td>
                            <td class="tdSub rowBg">优惠券数量</td>
                            <td class="tdGroup tdGroupOpen">转账合计</td>
                            <td class="tdSub">转账（卡异动）</td>
                            <td class="tdSub rowBg">转账（退卡）</td>
                        </tr>
                        <?php 

								$sumTotal = array();
								echo "<tr style='background-color:#99D9EA'>";
                                echo "<td>合计</td>";
                                echo "<td>-</td>";

								foreach ($reportData as $key => $value) {
									foreach ($value as $k => $v) {
										if(is_numeric($v)){
										  if(empty($sumTotal[$k])){
											$sumTotal[$k]=0;
										  }
											$sumTotal[$k] += $v;
										}
									}
								}
//合计栏
								 echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["total_cash"])."</td>";
                                echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["total_server"])."</td>";
                                echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["order_count"])."</td>";
                                echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["total_card"])."</td>";
                                echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["total_product"])."</td>";
                                echo '<td style="text-align:right">'.sprintf("%.2f",$sumTotal["card_count"])."</td>";

                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["cash_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["cash_server_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["cash_product_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["cash_changes_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["cash_cancel_money"]).'</td>';
                                
                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["unionpay_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["unionpay_server_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["unionpay_product__money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["unionpay_changes_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["unionpay_cancel_money"]).'</td>';
                                
                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["alipay_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["alipay_server_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["alipay_product__money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["alipay_changes_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["alipay_cancel_money"]).'</td>';

                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["weixin_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["weixin_server_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["weixin_product__money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["weixin_changes_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["weixin_cancel_money"]).'</td>';

                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["card_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["card_cancel_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["card_product_money"]).'</td>';

                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["coupon_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["coupon_server_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["coupon_product_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["count_coupon"]).'</td>';
                                
                                echo '<td class="tdGroup" style="text-align:right">'.sprintf("%.2f",$sumTotal["transfer_total_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["transfer_changes_money"]).'</td>';
                                echo '<td class="tdSub" style="text-align:right">'.sprintf("%.2f",$sumTotal["transfer_cancel_money"]).'</td>';

                                //echo '<td class="tdGroup">'.$value->manager_bill.'</td>';
                                //echo '<td class="tdSub">'.$value->expend_record.'</td>';
                                echo '</tr>';


                            foreach ($reportData as $key => $value) {

                                array_push($e_title, '"'.$value->storename.'('.$value->year."-".$value->month.')"');//.'('.$value->time.")");
                                array_push($e_data1, $value->total_cash);
                                array_push($e_data2, $value->total_server);

                                echo "<tr>";
                                echo "<td>".$value->storename."</td>";
                                echo "<td>".$value->year."-".$value->month."</td>";
                                echo "<td>".$value->total_cash."</td>";
                                echo "<td>".$value->total_server."</td>";
                                echo "<td>".$value->order_count."</td>";
                                echo "<td>".$value->total_card."</td>";
                                echo "<td>".$value->total_product."</td>";
                                echo "<td>".$value->card_count."</td>";

                                echo '<td class="tdGroup">'.$value->cash_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->cash_server_money.'</td>';
                                echo '<td class="tdSub">'.$value->cash_product_money.'</td>';
                                echo '<td class="tdSub">'.$value->cash_changes_money.'</td>';
                                echo '<td class="tdSub">'.$value->cash_cancel_money.'</td>';
                                
                                echo '<td class="tdGroup">'.$value->unionpay_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->unionpay_server_money.'</td>';
                                echo '<td class="tdSub">'.$value->unionpay_product__money.'</td>';
                                echo '<td class="tdSub">'.$value->unionpay_changes_money.'</td>';
                                echo '<td class="tdSub">'.$value->unionpay_cancel_money.'</td>';
                                
                                echo '<td class="tdGroup">'.$value->alipay_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->alipay_server_money.'</td>';
                                echo '<td class="tdSub">'.$value->alipay_product__money.'</td>';
                                echo '<td class="tdSub">'.$value->alipay_changes_money.'</td>';
                                echo '<td class="tdSub">'.$value->alipay_cancel_money.'</td>';

                                echo '<td class="tdGroup">'.$value->weixin_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->weixin_server_money.'</td>';
                                echo '<td class="tdSub">'.$value->weixin_product__money.'</td>';
                                echo '<td class="tdSub">'.$value->weixin_changes_money.'</td>';
                                echo '<td class="tdSub">'.$value->weixin_cancel_money.'</td>';

                                echo '<td class="tdGroup">'.$value->card_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->card_cancel_money.'</td>';
                                echo '<td class="tdSub">'.$value->card_product_money.'</td>';


                                echo '<td class="tdGroup">'.$value->coupon_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->coupon_server_money.'</td>';
                                echo '<td class="tdSub">'.$value->coupon_product_money.'</td>';
                                echo '<td class="tdSub">'.$value->count_coupon.'</td>';

                                
                                echo '<td class="tdGroup">'.$value->transfer_total_money.'</td>';
                                echo '<td class="tdSub">'.$value->transfer_changes_money.'</td>';
                                echo '<td class="tdSub">'.$value->transfer_cancel_money.'</td>';

                                //echo '<td class="tdGroup">'.$value->manager_bill.'</td>';
                                //echo '<td class="tdSub">'.$value->expend_record.'</td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- table-report1 end -->
                <!--<nav class="report-page">
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">上一页</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">下一页</a>
                        </li>
                    </ul>
                </nav>-->
            </div>
            <div role="tabpanel" class="tab-pane active" id="report-bar-charts">
                <div id="ecBar" style="height:600px; "></div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>content/js/report.js"></script>
    <script type="text/javascript">

        // 路径配置
        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        // 使用
        require(
                [
                    'echarts',
                    'echarts/chart/bar'
                ],
                drawEcharts
        );

        function drawEcharts(ec){
            drawBar(ec);
        }

        function drawBar(ec){
            // 基于准备好的dom，初始化echarts实例
            var myChart = ec.init(document.getElementById('ecBar'));

            // 指定图表的配置项和数据
            var option = {

                color:['#4eceff','#8dd069'],
                tooltip : {
                    trigger: 'axis',
                    backgroundColor : 'rgba(0,0,0,0.5)',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    selectedMode : false,
                    itemWidth : 14,
                    data:['现金业绩', '服务业绩']
                },
                toolbox : {
                    show : true,
                    orient : 'vertical',
                    x : 'right',
                    y : 'top',
                    padding : 18,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },
                grid : {
                    borderWidth : 0  //去掉边框线
                },
                yAxis : [
                    {
                        type : 'value',
                        boundaryGap : [0, 0.01],
                        splitLine : {
                            lineStyle : {
                                type : 'dashed'
                            }
                        },
                        axisLine : {
                            show : false
                        }
                    }

                ],
                xAxis : [
                    {
                        type : 'category',
                        data : [<?php $isAdd = false;
                             foreach ($e_title as $key => $value) {
                                if ($isAdd) { echo ',';}
                                $isAdd = true;
                                print_r($value);
                        } ?>],
                        splitLine : {
                            lineStyle : {
                                type : 'dashed'
                            }
                        },
                        axisLine : {
                            show : false,
                            lineStyle : {
                                color : '#ccc',
                                width : 1,
                                type : 'dashed'
                            }
                        }

                    }

                ],
                series : [
                    {
                        name:'现金业绩',
                        type:'bar',
                        data:[<?php $isAdd = false;
                             foreach ($e_data1 as $key => $value) {
                                if ($isAdd) { echo ',';}
                                $isAdd = true;
                                print_r($value);
                        } ?>]

                    },
                    {
                        name:'服务业绩',
                        type:'bar',
                        data:[<?php $isAdd = false;
                             foreach ($e_data2 as $key => $value) {
                                if ($isAdd) { echo ',';}
                                $isAdd = true;
                                print_r($value);
                        } ?>]
                    }
                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }

    </script>

   
