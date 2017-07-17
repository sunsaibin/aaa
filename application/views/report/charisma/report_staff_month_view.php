 <?php 
   
 $e_legendArray = array();
 $e_chartData = array();
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;


function arrayToObject($e){
    if( gettype($e)!='array' ) return;
    foreach($e as $k=>$v){
        if( gettype($v)=='array' || getType($v)=='object' )
            $e[$k]=(object)arrayToObject($v);
    }
    return (object)$e;
}
 
function objectToArray($e){
    $e=(array)$e;
    foreach($e as $k=>$v){
        if( gettype($v)=='resource' ) return;
        if( gettype($v)=='object' || gettype($v)=='array' )
            $e[$k]=(array)objectToArray($v);
    }
    return $e;
}


 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_staff_old/salary_report_month");?>" method="GET">
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
            </div><!-- 
            <div class="form-group col-xs-2">
                <label class="col-sm-12">结束日期</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control" name="queryenddate" value="<?php echo $queryenddate; ?>">
                </div>
            </div> -->
 
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
                    
                    <a href="#" onclick = "exportExcel('storePermance');" aria-controls="report-bar-charts" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>导出excel</span>
                    </a>
                </li>

                <li role="presentation" class="active">
                    <a href="#report-bar-table" aria-controls="report-bar-table" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportTable.png" alt="reportTable"/>&nbsp;
                        <span>表格</span>
                    </a>
                </li>

                <!-- <li role="presentation">
                    <a href="#report-bar-charts" aria-controls="report-bar-charts" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>图表</span>
                    </a>
                </li> -->
            </ul>
        </div> 

        <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane active" id="report-bar-table">
        <div class="table-report1">
            <table  id="storePermance" style="max-width:2600px;">
                <tbody>
                    <tr>
                        <td>员工编号</td>
                        <td>员工名称</td>
                        <td>员工职位</td>
                        <td>现金大项业绩</td>
                        <td>现金大项提成</td>						
                        <td>现金小项业绩</td>
                        <td>现金小项提成</td>						
                        <td>现金卖品业绩</td>
                        <td>现金卖品提成</td>						
                        <td>销卡大项业绩</td>
                        <td>销卡大项提成</td>						
                        <td>销卡小项业绩</td>
                        <td>销卡小项提成</td>						
                        <td>销卡卖品业绩</td>
                        <td>销卡卖品提成</td>						
                        <td>售卡业绩</td>
                        <td>售卡提成</td>					
						<td>服务现金业绩</td>
                        <td>服务总业绩</td>
                        <td>提成总额</td>
						<td>餐费补贴</td>
                        <td>指标奖励</td>
                        <td>公司扣发奖金</td>
                        <td>其他补贴</td>
                        <td>代扣保险费</td>
                        <td>代扣培训费</td>
                        <td>代扣学校扣款</td>
                        <td>代扣其他扣款</td>
                        <td>学校补贴</td>
                        <td>培训费补贴</td>
						<td>工会代扣</td>
						<td>税前工资</td>
						<td>扣税</td>
						<td>应发工资</td>

                    </tr>
                    <?php 

					$sumdata-> cash_max_performance = 0;
					$sumdata-> cash_max_commission = 0;
					$sumdata-> cash_min_performance = 0;
					$sumdata-> cash_min_commission = 0;
					$sumdata-> cash_product_performance = 0;
					$sumdata-> cash_product_commission = 0;
					$sumdata-> mem_max_performance = 0;
					$sumdata-> cash_max_performance = 0;
					$sumdata-> mem_max_commission = 0;
					$sumdata-> mem_min_performance = 0;
					$sumdata-> mem_min_commission = 0;
					$sumdata-> mem_product_performance = 0;
					$sumdata-> mem_product_commission = 0;
					$sumdata-> card_performance = 0;
					$sumdata-> card_commission = 0;
                    $sumdata-> unions = 0;
                    $sumdata-> handmade = 0;
                    $sumdata-> handmade_1 = 0;
                    $sumdata-> handmade_2 = 0;
                    $sumdata-> handmade_3 = 0;
                    $sumdata-> handmade_4 = 0;
                    $sumdata-> handmade_5 = 0;
                    $sumdata-> handmade_8 = 0;
                    $sumdata-> handmade_7 = 0;
                    $sumdata-> handmade_6 = 0;
                    $sumdata-> handmade_9 = 0;
                    $sumdata-> handmade_10 = 0;
                    $sumdata->total_income = 0;

					if(!empty($reportData))
                    {
                        foreach ($reportData as $key => $vv) {
							$v = arrayToObject($vv);
							$sumdata->storename = $v->storename ;
							$sumdata->datestr = $v->year.'/'.$v->month;
							$sumdata->staff_number = $v->staff_number.'/'.$v->staffid ;
							$sumdata->staff_name = $v->staff_name ;
							$sumdata-> cash_max_performance +=	$v->cash_max_performance;
							$sumdata-> cash_max_commission +=	$v->cash_max_commission;
							$sumdata-> cash_min_performance +=	$v->cash_min_performance;
							$sumdata-> cash_min_commission +=	$v->cash_min_commission;
							$sumdata-> cash_product_performance +=	$v->cash_product_performance;
							$sumdata-> cash_product_commission +=	$v->cash_product_commission;
							$sumdata-> mem_max_performance +=	$v->mem_max_performance;
							$sumdata-> mem_max_commission +=	$v->mem_max_commission;
							$sumdata-> mem_min_performance +=	$v->mem_min_performance;
							$sumdata-> mem_min_commission +=	$v->mem_min_commission;
							$sumdata-> mem_product_performance +=	$v->mem_product_performance;
							$sumdata-> mem_product_commission +=	$v->mem_product_commission;
							$sumdata-> card_performance +=	$v->card_performance;
							$sumdata-> card_commission +=	$v->card_commission;
                            $sumdata-> unions +=	$v->unions;
                            $sumdata-> handmade += $v-> handmade;
                            $sumdata-> handmade_1 +=	$v->handmade_1;
                            $sumdata-> handmade_2 +=	$v->handmade_2;
                            $sumdata-> handmade_3 +=	$v->handmade_3;
                            $sumdata-> handmade_4 +=	$v->handmade_4;
                            $sumdata-> handmade_5 +=	$v->handmade_5;
                            $sumdata-> handmade_8 +=	$v->handmade_8;
                            $sumdata-> handmade_7 +=	$v->handmade_7;
                            $sumdata-> handmade_6 +=	$v->handmade_6;
                            $sumdata-> handmade_9 +=	$v->handmade_9;
                            $sumdata-> handmade_10 +=	$v->handmade_10;
                            $sumdata->total_income += $v->total_income;

						 }	
					}

					//合计数
                            echo '<td>合计</td>';
                            //echo '<td><a href="'.site_url("/Report_staff_old/salary_detail/".$sumdata->staffid)."?storeid=".$sumdata->staffid."&querydate=".$querydate.'">'.$sumdata->staff_name.'</a></td>';
							echo '<td style="color:green">--</td>';
                            echo '<td style="color:green">--</td>';
							echo '<td style="color:green">'.$sumdata->cash_max_performance.'</td>';
                            echo '<td>'.$sumdata->cash_max_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->cash_min_performance.'</td>';
                            echo '<td>'.$sumdata->cash_min_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->cash_product_performance.'</td>';
                            echo '<td>'.$sumdata->cash_product_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->mem_max_performance.'</td>';
                            echo '<td>'.$sumdata->mem_max_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->mem_min_performance.'</td>';
                            echo '<td>'.$sumdata->mem_min_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->mem_product_performance.'</td>';
                            echo '<td>'.$sumdata->mem_product_commission.'</td>';
							echo '<td style="color:green">'.$sumdata->card_performance.'</td>';
                            echo '<td>'.$sumdata->card_commission.'</td>';
                            echo '<td style="color:green" >'.($sumdata->cash_max_performance+$sumdata->cash_min_performance+$sumdata->cash_product_performance).'</td>';
                            echo '<td>'.($sumdata->cash_max_performance+$sumdata->cash_min_performance+$sumdata->mem_max_performance+$sumdata->mem_min_performance).'</td>';
                            echo '<td style="color:red">'.$sumdata->total_income.'</td>';
							echo '<td>'.$sumdata->handmade_1.'</td>';
                            echo '<td>'.$sumdata->handmade_2.'</td>';
                            echo '<td>'.$sumdata->handmade_3.'</td>';
                            echo '<td>'.$sumdata->handmade_4.'</td>';
                            echo '<td>'.$sumdata->handmade_5.'</td>';
                            echo '<td>'.$sumdata->handmade_8.'</td>';
                            echo '<td>'.$sumdata->handmade_7.'</td>';
                            echo '<td>'.$sumdata->handmade_6.'</td>';
                            echo '<td>'.$sumdata->handmade_9.'</td>';
                            echo '<td>'.$sumdata->handmade_10.'</td>';
							echo '<td>'.$sumdata->unions.'</td>';
							echo '<td>'.($sumdata->total_income+$sumdata->handmade+$sumdata->unions).'</td>';
							echo '<td>0.00</td>';
							echo '<td>'.intval($sumdata->total_income+$sumdata->handmade+$sumdata->unions).'</td>';
                            echo '</tr>';


                    if(!empty($reportData))
                    {
                        foreach ($reportData as $key => $vv) {
						 $v = arrayToObject($vv);
                            //绘制表格
                            echo '<td>'.$v->staff_number.'</td>';
                            //echo '<td><a href="'.site_url("/Report_staff_old/salary_detail/".$v->staffid)."?storeid=".$v->staffid."&querydate=".$querydate.'">'.$v->staff_name.'</a></td>';
							echo '<td style="color:green">'.$v->staff_name.'</td>';
                            echo '<td style="color:green">'.$v->RANKNAME.'</td>';
							echo '<td style="color:green">'.$v->cash_max_performance.'</td>';
                            echo '<td>'.$v->cash_max_commission.'</td>';
							echo '<td style="color:green">'.$v->cash_min_performance.'</td>';
                            echo '<td>'.$v->cash_min_commission.'</td>';
							echo '<td style="color:green">'.$v->cash_product_performance.'</td>';
                            echo '<td>'.$v->cash_product_commission.'</td>';
							echo '<td style="color:green">'.$v->mem_max_performance.'</td>';
                            echo '<td>'.$v->mem_max_commission.'</td>';
							echo '<td style="color:green">'.$v->mem_min_performance.'</td>';
                            echo '<td>'.$v->mem_min_commission.'</td>';
							echo '<td style="color:green">'.$v->mem_product_performance.'</td>';
                            echo '<td>'.$v->mem_product_commission.'</td>';
							echo '<td style="color:green">'.$v->card_performance.'</td>';
                            echo '<td>'.$v->card_commission.'</td>';
                            echo '<td style="color:green" >'.($v->cash_max_performance+$v->cash_min_performance+$v->cash_product_performance).'</td>';
                            echo '<td>'.($v->cash_max_performance+$v->cash_min_performance+$v->mem_max_performance+$v->mem_min_performance).'</td>';
                            echo '<td style="color:red">'.($v->total_income).'</td>';
							echo '<td>'.$v->handmade_1.'</td>';
                            echo '<td>'.$v->handmade_2.'</td>';
                            echo '<td>'.$v->handmade_3.'</td>';
                            echo '<td>'.$v->handmade_4.'</td>';
                            echo '<td>'.$v->handmade_5.'</td>';
                            echo '<td>'.$v->handmade_8.'</td>';
                            echo '<td>'.$v->handmade_7.'</td>';
                            echo '<td>'.$v->handmade_6.'</td>';
                            echo '<td>'.$v->handmade_9.'</td>';
                            echo '<td>'.$v->handmade_10.'</td>';
							echo '<td>'.$v->unions.'</td>';
							echo '<td>'.($v->total_income+$v->handmade+$v->unions).'</td>';
							echo '<td>0.00</td>';
							echo '<td>'.intval($v->total_income+$v->handmade+$v->unions).'</td>';

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
    <script>
<?php 
// print_r($e_chartData); 
// print_r($e_legendArray); 

?>
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
                    'echarts/chart/bar',
                    'echarts/chart/line',
                    'echarts/chart/pie'
                ],
                drawEcharts
        );

        function drawEcharts(ec){
            drawBar(ec);
            drawLine(ec);
            drawPie(ec);
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
//                    itemWidth : 14,
                    data:[]
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
                xAxis : [
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
                yAxis : [
                    {
                        type : 'category',
                        data : [],
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
                series :  []
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }




        //
        function drawLine(ec){
            // 基于准备好的dom，初始化echarts实例
            var ecLine =ec.init(document.getElementById('ecLine'));

            // 指定图表的配置项和数据
            var option = {
                width:["100%"],
                //折线颜色
                color:['#04a5d9',"#6dbb45"],
                //提示框，鼠标悬浮交互时的信息提示
                tooltip : {
                    //  触发类型，默认数据触发，可选为：'item' | 'axis'
                    trigger: 'axis',
                    //坐标轴指示器，默认type为line，可选为：'line' | 'cross' | 'shadow' | 'none'(无)，指定type后对应style生效
                    backgroundColor : 'rgba(0,0,0,0.5)',
                    axisPointer: {
                        type: 'line',
                        lineStyle : {
                            color : '#ccc',
                            width : 1,
                            type : 'solid'
                        }
                    }
                },
                //图例，每个图表最多仅有一个图例
                legend: {
                    selectedMode : false,

                    //水平安放位置，默认为全图居中，可选为：'center' | 'left' | 'right' | {number}（x坐标，单位px）
                    x : 'center',
                    //垂直安放位置，默认为全图顶端，可选为：'top' | 'bottom' | 'center' | {number}（y坐标，单位px）
                    y : 'top',
                    //图例文字颜色
                    textStyle :{color : '#555'},
                    //图例内容数组，数组项通常为{string}，每一项代表一个系列的name，默认布局到达边缘会自动分行（列），传入空字符串''可实现手动分行（列）
                    data :[<?php  
                        $isFirst = true;
                        foreach ($e_legendArray as $key => $value) {
                            if (!$isFirst) {
                                echo ",";
                            }
                            $isFirst = false;

                            echo '"'.$key.'"';
                        }
                    ?>]
                },

                //工具箱，每个图表最多仅有一个工具箱
                toolbox: {
                    //显示策略，可选为：true（显示） | false（隐藏）
                    show : true,
                    orient : 'vertical',
                    x : 'right',
                    y : 'top',
                    //padding : 18,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },

                grid : {
                    borderWidth : 0  //去掉边框线
                },

                /* axis
                 *  type : 坐标轴类型，横轴默认为类目型'category'，纵轴默认为数值型'value'
                 *  data : 类目型坐标轴文本标签数组，指定label内容。 数组项通常为文本，'\n'指定换行
                 *  boundaryGap : 数值型，时间型类目， 坐标轴两端空白策略，数组内数值代表百分比，[原始数据最小值与最终最小值之间的差额，原始数据最大值与最终最大值之间的差额]
                 * */

                /*
                 * 直角坐标系中横轴数组，数组中每一项代表一条横轴坐标轴，仅有一条时可省略数组。
                 * 最多同时存在2条横轴，单条横轴时可指定安放于grid的底部（默认）或顶部，2条同时存在时位置互斥，默认第一条安放于底部，第二条安放于顶部
                 * */
                xAxis : [

                    {
                        type : 'category',
                        splitLine : {
                            lineStyle : {
                                type : 'dashed'
                            }
                        },
                        axisLine : {
                            //show : false
                            lineStyle : {
                                color : '#ccc',
                                width : 1,
                                type : 'dashed'
                            }
                        },
                        data :[<?php
                            $isFirst = true;
                            foreach ($e_chartData as $key => $value) {
                                if (!$isFirst) {
                                    echo ",";
                                }
                                $isFirst = false;
                                echo '"'.$value["staff_name"].'"';
                            }
                        ?>]
                    }
                ],
                /*
                 * 直角坐标系中纵轴数组，数组中每一项代表一条纵轴坐标轴，仅有一条时可省略数组。
                 * 最多同时存在2条纵轴，单条纵轴时可指定安放于grid的左侧（默认）或右侧，2条同时存在时位置互斥，默认第一条安放于左侧，第二条安放于右侧。
                 * */
                yAxis : [
                    {
                        type : 'value',
                        splitLine : {
                            lineStyle : {
                                type : 'dashed'
                            }
                        },
                        axisLine : {
                            //show : false,
                            lineStyle : {
                                color : '#ccc',
                                width : 1,
                                type : 'dashed'
                            }
                        },
                        boundaryGap : [0, 0.01]  // 数值型，时间型类目，坐标轴两端空白策略，数组内数值代表百分比，[原始数据最小值与最终最小值之间的差额，原始数据最大值与最终最大值之间的差额]
                    }
                ],
                /*
                 *  驱动图表生成的数据内容数组，数组中每一项为一个系列的选项及数据，其中个别选项仅在部分图表类型中有效
                 * */
                series : [<?php
                            $isFirst = true;
                            foreach ($e_legendArray as $key => $value) {
                                if (!$isFirst) {
                                    echo ",";
                                }
                                $isFirst = false;
                                echo '{ name:"'.$key.'", type:"bar", data:[';

                                //data:[18203, 23489, 29034, 104970, 131744, 630230]
                                $isFirst2 = true;
                                foreach ($e_chartData as $key2 => $value2) {
                                    if (!$isFirst2) {
                                        echo ",";
                                    }
                                    $isFirst2 = false;
                                    echo $value2[$key];
                                }
                                echo ']}';
                            }
                        ?>]
            };

            // 使用刚指定的配置项和数据显示图表。
            ecLine.setOption(option);

        }




   //环形图
    function drawPie(ec){
            var ecPie = ec.init(document.getElementById('ecPie'));

            // 指定图表的配置项和数据
            var option = {

                //折线颜色
                color:['#9fe7f5',"#fbda6e","#ffadcb","#8abe93","#f86965","#e77eff","#9bb8fc","#9d7261","#01a2d6"],

                //提示框，鼠标悬浮交互时的信息提示
                tooltip : {
                    //  触发类型，默认数据触发，可选为：'item' | 'axis'
                    trigger: 'item',
                    backgroundColor : 'rgba(0,0,0,0.5)',
                    //内容格式器：{string}（Template） | {Function}，
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },

                /* 图例
                 *  selectedMode : 选择模式，默认开启图例开关(true)，可选single，multiple
                 *  orient : 布局方式，默认为水平布局('horizontal')，可选为：'horizontal' | 'vertical'
                 *  x : 水平安放位置，默认为全图居中('center')，可选为：'center' | 'left' | 'right' | {number}（x坐标，单位px）
                 *  y : 垂直安放位置，默认为全图顶端('top')，可选为：'top' | 'bottom' | 'center' | {number}（y坐标，单位px）
                 *  itemGap : 各个item之间的间隔，单位px，默认为10，横向布局时为水平间隔，纵向布局时为纵向间隔
                 *  padding : 图例内边距，单位px，默认各方向内边距为5，接受数组分别设定上右下左边距，同css
                 *  textStyle : 默认只设定了图例文字颜色 ，更个性化的是，要指定文字颜色跟随图例，可设color为'auto'
                 * */
                legend: {
                    selectedMode : false,
                    orient : 'vertical',
                    x : 'right',
                    y : 'center',
                    itemGap : 20,
//                    itemWidth : 14,
                    padding :[30,30,30,0],
                    textStyle : {
                        color : '#333'
                    },
                    data :['销卡服务','现金服务','支付宝服务','微信服务','银行卡服务','银行卡转账','便利通产品','工会卡服务','支票服务']
                },

                //工具箱，每个图表最多仅有一个工具箱
                toolbox: {
                    //显示策略，可选为：true（显示） | false（隐藏）
                    show : true,
                    orient : 'vertical',
                    x : 'right',
                    y : 'top',
                    padding : 18,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },
                series : [
                    {
                        name:'所占比例',
                        type:'pie',
                        radius : ['50%', '70%'],
                        /*
                         *  图形样式，可设置图表内图形的默认样式和强调样式（悬浮时样式）
                         *
                         * */
                        itemStyle : {
                            normal : {
                                label : {
                                    show : false
                                },
                                labelLine : {
                                    show : false
                                }
                            },
                            emphasis : {
                                label : {
                                    show : true,
                                    position : 'center',
                                    textStyle : {
                                        fontSize : '22',
                                        fontWeight : 'bold'
                                    }
                                }
                            }
                        },
                        data:[
                            {value:335, name:'销卡服务'},
                            {value:310, name:'现金服务'},
                            {value:234, name:'支付宝服务'},
                            {value:135, name:'微信服务'},
                            {value:120, name:'银行卡服务'},
                            {value:135, name:'银行卡转账'},
                            {value:234, name:'便利通产品'},
                            {value:335, name:'工会卡服务'},
                            {value:310, name:'支票服务'}
                        ]
                    }
                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            ecPie.setOption(option);

            /* 给环形图绑定click事件 */
            var ecConfig = require('echarts/config');
            function eConsole(param) {
                alert(param.value); 　　 // 弹出当前弧块的数值
                //window.location.href = 'dailyReport5.html';
            }
            ecPie.on(ecConfig.EVENT.CLICK, eConsole);
        }
   </script>
