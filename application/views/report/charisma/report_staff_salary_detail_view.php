 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;


//print_r($reportData);

 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_staff_old/salary_detail/".$staffid);?>" method="GET">
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
				<?php 
				
				if(isset($selectStore) && isset($selectStore[0]))
				{
					?>
                    <select class="form-control" name="storeid">
                <?php

                    foreach ($selectStore as $key => $value) {
                        if ($stallStore->STOREID == $value->STOREID) {
							$storeIdd = $value->STOREID ;
                             echo '<option value="'.$value->STOREID.'" selected=selected>'.$value->STORENAME.'</option>';
                        }
                        else{
                             echo '<option value="'.$value->STOREID.'">'.$value->STORENAME.'</option>';
                        }
                    }
                ?>
                </select>
				<?php }
				else{
					 if(!empty($reportData))
                    {

					 echo $reportData[0]->store_name;
					 }
				
				}
				?>
                </div>
            </div>
            <div class="form-group col-xs-2" style="width:25%;">
                <label class="col-sm-12" style="width:35%">开始日期</label>
                <div class="col-sm-12" style="width:60%">
                    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
                </div>
            </div>
			<div class="form-group col-xs-2" style="width:25%;">
                <label class="col-sm-12" style="width:35%">结束日期</label>
                <div class="col-sm-12" style="width:60%">
                    <input type="date" class="form-control" name="queryend" value="<?php 
					$queryend=$_GET["queryend"];
					if(empty($queryend))
					 $queryend = $querydate;
					
					echo $queryend; ?>">
                </div>
            </div>

            <div class="form-group col-xs-2" style="width:auto;">
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
                    echo ' <a href="'.site_url("Report_staff_old/salary_report?querydate=".$querydate).'">返回上一级</a>&gt;';
                ?>
            </div>
            <ul class="nav nav-pills report-tableCharts pull-right" role="tablist">
 
                 <li role="presentation">
                    
					<a href="#" onclick = "exportExcel('report-bar-table');" aria-controls="report-bar-charts" role="tab" data-toggle="tab">
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
     <?php 
        //员工编号, 员工名称, 公司名称，门店名称，项目, 项目总金, 提成金额, 提成比例,日期, 
 // stdClass Object ( [id] => 1 [staff_id] => 34908 [store_id] => 1570 [company_id] => 5 [deduct_type] => 1 [deduct_detailtype] => 2 [deduct_source] => 开卡提成 [order_id] => 0 [order_number] => [orderproduct_id] => 0 [account_id] => 24 [card_id] => 6017 [card_number] => 2001 [total_performance] => 100.00 [performance_ratio] => 0.00 [performance_amount] => 0.00 [commission_ratio] => 0.00 [commission_amount] => 0.00 [bonus_time] => 2016-08-25 15:57:48 [bonus_year] => 0 [bonus_month] => 0 [bonus_day] => 0 [province] => 0 [city] => 0 [district] => 0 [memo] => [user_id] => 0 ) 

 $e_legendArray = array();
 $e_chartData = array();

 ?>
          
        <!-- table-report1 begin -->
        <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane active" id="report-bar-table">
        <div class="table-report1">
            <table width="90%">
                <tbody>
                    <tr>
                        <td>工号/ID</td>
						<td>员工姓名</td>
                        <td>产品名称/卡号</td>
                        <td>项目服务时间</td>
                        <td>订单号</td>                       
                        <td>订单金额</td>
                        <td>业绩比例</td>
						<td>业绩金额</td>
                        <td>员工业绩比例</td>
						<td>员工金额</td>
                        <td>提成比例</td>
						<td>提成金额</td>

                    </tr>
                    <?php 
						$sumdata->total_performance=0;
						$sumdata->performance_amount=0;
						$sumdata->staff_performance=0;
						$sumdata->commission_amount=0;


					 if(!empty($reportData))
                    {
                        foreach ($reportData as $key => $v) {
							$sumdata->staff = $v->STAFFNUMBER.' / '.$v->STAFFID;
							$sumdata->total_performance += $v->total_performance;
							$sumdata->performance_amount += $v->performance_amount;
							$sumdata->staff_performance  += $v->staff_performance;
							$sumdata->commission_amount += $v->commission_amount;

						}
					}
							echo '<tr><td style="font-size:10px;color:red;">'.$sumdata->staff.'</td>';
                            echo '<td style="font-size:10px;color:red;">合计</td>';
                            echo '<td style="font-size:10px;color:red;">服务/卖品/售卡</td>';
                            echo '<td>--</td>';
                            echo '<td>--</td>';
                            echo '<td style="font-size:10px;color:red;text-align:right;">'.sprintf("%.2f",$sumdata->total_performance).'</td>';
							echo '<td style="font-size:10px;color:red;">--</td>';
                            echo '<td style="font-size:10px;color:red;text-align:right;">'.sprintf("%.2f",$sumdata->performance_amount).'</td>';
							echo '<td style="font-size:10px;color:black;">--</td>';
							echo '<td style="font-size:10px;color:red;text-align:right;">'.sprintf("%.2f",$sumdata->staff_performance).'</td>';
                            echo '<td style="font-size:10px;color:black;">--</td>';
							echo '<td style="font-size:10px;color:red;text-align:right;">'.sprintf("%.3f",$sumdata->commission_amount).'</td>';

                            echo '</tr>';

                    if(!empty($reportData))
                    {
                        foreach ($reportData as $key => $v) {
                            
                            //绘制表格
                            echo '<tr><td>'.$v->STAFFNUMBER.' / '.$v->STAFFID.'</td>';
                            echo '<td style="font-size:10px;color:black;">'.$v->STAFFNAME.'</td>';
                            if ($v->deduct_type == 0) {
                                echo '<td style="font-size:10px;color:black;">'.$v->product_name.'</td>';
                            }
							else{
                                echo '<td style="font-size:10px;color:black;">'.$v->card_number.'</td>';
                            }
                            echo '<td>'.$v->bonus_time.'</td>';
                            echo '<td>'.$v->orderproduct_id.'/'.$v->order_id.'</td>';
                            echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.2f",$v->total_performance).'</td>';
							echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.3f",$v->performance_ratio).'</td>';
                            echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.2f",$v->performance_amount).'</td>';
							echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.3f",$v->staff_performance_ratio).'</td>';
							echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.2f",$v->staff_performance).'</td>';
                            echo '<td style="font-size:10px;color:black;text-align:right;padding-right:2px;">'.sprintf("%.3f",$v->commission_ratio).'</td>';
							echo '<td style="font-size:10px;color:red;text-align:right;padding-right:2px;">'.sprintf("%.3f",$v->commission_amount).'</td>';

                            echo '</tr>';
                        }
                    }
                    ?>
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