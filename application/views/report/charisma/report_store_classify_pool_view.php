<?php
$aLinkCompany = $stallCompany;
$aLinkStore = $stallStore;
?>
<div class="container-fluid report">
    <!-- report-head begin -->
    <form action="<?php echo  $roleurl =  site_url("Report_store_old/classify_pool");?>" method="GET">
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

            <li role="presentation">
                <a href="#report-bar-charts" aria-controls="report-bar-charts" role="tab" data-toggle="tab" class="active">
                    <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                    <span>图表</span>
                </a>
            </li>
        </ul>
    </div>

    <?php
    $e_title = array();
    $e_data1 = array();
    $e_data2 = array();
    ?>

    <!-- table-report1 begin -->
    <!-- Tab panes -->
    <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane" id="report-bar-table">
            <!-- table-report1 begin -->
            <div>
                <table style="width:90%;margin-left:20px;font-size:10px;" id="classify_table">
                    <tbody>
                    <tr>
                        <td>门店</td>
                        <td>日期</td>
						<td>总现金业绩<br/>(虚业绩)</td>
                    	<td>美容现金业绩<br/>(美容虚业绩)</td>
                        <td>美发现金业绩<br/>(美发虚业绩)</td>
                        <td>美甲现金业绩<br/>(美甲虚业绩)</td>
                        <td>虚业绩占比<br/>(美容/美发/美甲)</td>
                        <td>总服务业绩<br/>(实业绩)</td>
                        <td>美容服务业绩<br/>(实业绩)</td>
                        <td>美发服务业绩<br/>(实业绩)</td>
                        <td>美甲服务业绩<br/>(实业绩)</td>
                        <td>服务业绩占比<br/>(美容/美发/美甲)</td>
                        <td>总的售卡业绩</td>
                        <td>美容售卡业绩</td>
                        <td>美发售卡业绩</td>
                        <td>美甲售卡业绩</td>
                        <td>售卡业绩占比<br/>(美容/美发/美甲)</td>
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
					echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["total_cash"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($sumTotal["cosmetic_cash"]+$sumTotal["cosmetic_card"])).'</td>';
					echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($sumTotal["hairdress_cash"]+$sumTotal["hairdress_card"])).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($sumTotal["manicure_cash"]+$sumTotal["manicure_card"])).'</td>';
                    if($sumTotal["total_server"]<=0){
                        echo '<td style="text-align:right;padding-right:2px;">-/-/-</td>';
                    }else{
                        echo '<td style="text-align:right;padding-right:2px;">'.round(floatval(($sumTotal["cosmetic_cash"]+$sumTotal["cosmetic_card"]))/floatval($sumTotal["total_cash"]),2)."/".(round(floatval($sumTotal["hairdress_cash"]+$sumTotal["hairdress_card"])/floatval($sumTotal["total_cash"]),2))."/".(round(floatval($sumTotal["manicure_cash"]+$sumTotal["manicure_card"])/floatval($sumTotal["total_cash"]),2)).'</td>';
                    }
                   // echo "<td>".$sumTotal["cosmetic_cash"]."</td>";
                   // echo "<td>".$sumTotal["hairdress_cash"]."</td>";
                   // echo "<td>".round(floatval($sumTotal["cosmetic_cash"])/floatval($sumTotal["total_cash"]),2)."</td>";
				//	echo "<td>".round(floatval($sumTotal["hairdress_cash"])/floatval($sumTotal["total_cash"]),2)."</td>";


                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["total_server"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["cosmetic_server"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["hairdress_server"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["manicure_server"]).'</td>';
					if($sumTotal["total_server"]<=0){
						echo '<td style="text-align:right;padding-right:2px;">-/-/-</td>';
					}else{
						echo '<td style="text-align:right;padding-right:2px;">'.round(floatval($sumTotal["cosmetic_server"])/floatval($sumTotal["total_server"]),2)."/".(round(floatval($sumTotal["hairdress_server"])/floatval($sumTotal["total_server"]),2))."/".(round(floatval($sumTotal["manicure_server"])/floatval($sumTotal["total_server"]),2)).'</td>';
					}
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["total_card"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["cosmetic_card"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["hairdress_card"]).'</td>';
                    echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$sumTotal["manicure_card"]).'</td>';

					if($sumTotal["total_card"]<=0){
						echo '<td style="text-align:right;padding-right:2px;">-/-/-</td>';
					}else{
						echo '<td style="text-align:right;padding-right:2px;">'.round(floatval($sumTotal["cosmetic_card"])/floatval($sumTotal["total_card"]),2)."/".(round(floatval($sumTotal["hairdress_card"])/floatval($sumTotal["total_card"]),2))."/".(round(floatval($sumTotal["manicure_card"])/floatval($sumTotal["total_card"]),2)).'</td>';
					}                    

                    //echo '<td>'.$value->manager_bill).'</td>';
                    //echo '<td>'.$value->expend_record).'</td>';
                    echo '</tr>';

                    foreach ($reportData as $key => $value) {

                        array_push($e_title, '"'.$value->storename.'('.substr($value->time, 5,8).')"');//.'('.$value->time.")");
                        array_push($e_data1, $value->total_cash);
                        array_push($e_data2, $value->total_server);

                        echo "<tr>";
                        echo '<td style="text-align:left;padding-left:2px;">'.$value->storename.'</td>';
                        echo '<td style="text-align:left;padding-left:2px;">'.substr($value->time,0,10)."</td>";
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($value->total_cash)).'</td>';
						echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($value->cosmetic_cash+$value->cosmetic_card)).'</td>';
						echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($value->hairdress_cash+$value->hairdress_card)).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",($value->manicure_cash+$value->manicure_card)).'</td>';

                        if($value->total_server <=0){
                            echo '<td style="text-align:right;padding-right:2px;">-/-/-</td>';
                        }else{
                            echo '<td style="text-align:right;padding-right:2px;">'.round(floatval(($value->cosmetic_cash+$value->cosmetic_card))/floatval($value->total_cash),2)."/".(round(floatval($value->hairdress_cash+$value->hairdress_card)/floatval($value->total_cash),2))."/".round(floatval($value->manicure_cash+$value->manicure_card)/floatval($value->total_cash),2).'</td>';
                        }

                       // echo '<td>'.$value->cosmetic_cash).'</td>';
                       // echo '<td>'.$value->hairdress_cash).'</td>';
                       // echo '<td>'.round(floatval($value->cosmetic_cash)/floatval($value->total_cash),2)).'</td>';
					//	echo '<td>'.round(floatval($value->hairdress_cash)/floatval($value->total_cash),2)).'</td>';

                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->total_server).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->cosmetic_server).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->hairdress_server).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->manicure_server).'</td>';
					if($value->total_server <=0){
						echo '<td style="text-align:right;padding-right:2px;">-/-/-</td>';
					}else{
						echo '<td style="text-align:right;padding-right:2px;">'.round(floatval($value->cosmetic_server)/floatval($value->total_server),2)."/".(round(floatval($value->hairdress_server)/floatval($value->total_server),2))."/".(round(floatval($value->manicure_server)/floatval($value->total_server),2)).'</td>';
					}
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->total_card).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->cosmetic_card).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->hairdress_card).'</td>';
                        echo '<td style="text-align:right;padding-right:2px;">'.sprintf("%.2f",$value->manicure_card).'</td>';

					if($value->total_card <=0){
						echo '<td style="text-align:right;padding-right:2px;">-/-</td>';
					}else{
						echo '<td style="text-align:right;padding-right:2px;">'.round(floatval($value->cosmetic_card)/floatval($value->total_card),2)."/".(round(floatval($value->hairdress_card)/floatval($value->total_card),2))."/".(round(floatval($value->manicure_card)/floatval($value->total_card),2)).'</td>';
					}

                        //echo '<td>'.$value->manager_bill).'</td>';
                        //echo '<td>'.$value->expend_record).'</td>';
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
    <script language="javascript" type="text/javascript">
		window.onload = function()
		{
			new TableSorter("classify_table");
	//		new TableSorter("tb2", 0, 2 , 5, 6);
		/*	new TableSorter("tb3").OnSorted = function(c, t)
			{
				alert("table is sorted by " + c.innerHTML + " " + (t ? "Asc" : "Desc"));
			}
			*/
		}
    </script>

