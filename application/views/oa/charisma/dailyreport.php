 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report/day_report");?>" method="GET">
        <div class="report-head">
            <div class="form-group col-xs-2">
                <label class="col-sm-12">公司</label>
                <div class="col-sm-12">
                    <select class="form-control" name="brand" id="brand_change">
                            <?php 
                            foreach ($brand_id as $k => $v) {
                             ?>
                             <option value="<?php echo $v->COMPANYID; ?>" <?php if($v->COMPANYID == $_GET['brand']){ echo "selected='selected'";} ?>> <?php echo $v->COMPANYNAME; ?></option>
                             <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group col-xs-2">
                <label class="col-sm-12">事业部</label>
                <div class="col-sm-12">
                    <select class="form-control" name="company" id ="fengongsi" >
                    <?php 
                    foreach ($fen_company as $k => $v) {
                    
                     ?>
                     <option value="<?php echo $v->COMPANYID; ?>" <?php if($v->COMPANYID==4){echo "selected='selected'";}?>> <?php echo $v->COMPANYNAME; ?></option>
                     <?php } ?>

                    </select>
                </div>
            </div>
            <?php
                $isBody = false;
                $t_str_divBody = "";
                foreach ($quyu as $k => $v) {
                    $isBody = true;
                    $t_str_divBody .= '<option value="'.$v->COMPANYID.'" ';

                    if($v->COMPANYID == $_GET['city']){
                        $t_str_divBody .= " selected='selected' ";
                    }

                    $t_str_divBody .= ">" .$v->COMPANYNAME . '</option>';
                }

                $t_str_divFoot = '</select></div>';

                $t_str_divHead = '<div class="form-group col-xs-2" style="display:none;"><label class="col-sm-12">区域</label><div class="col-sm-12"><select class="form-control" name="city" id="quyu"><option value="*">所有</option>';
                if ($isBody == true) {
                    $t_str_divHead = '<div class="form-group col-xs-2"><label class="col-sm-12">区域</label><div class="col-sm-12"><select class="form-control" name="city" id="quyu"><option value="*">所有</option>';
                }
                echo $t_str_divHead.$t_str_divBody.$t_str_divFoot;
            ?>
                         
                    
            </div>

            <div class="form-group col-xs-2">
                <label class="col-sm-12">门店</label>
                <div class="col-sm-12">
                    <select class="form-control" name="storeid" id="storeid">
                    <option value="*">*</option>
                    <?php foreach ($storeid as $key => $v) {  
                     ?>
                     <option value="<?php echo $v->STOREID; ?>" <?php if($v->STOREID == $_GET['storeid']){ echo "selected='selected'";} ?>><?php echo $v->STORENAME; ?></option>
                     <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-2">
                <label class="col-sm-12">开始日期</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="date_start" value="<?php if($_GET['date_start']){echo $_GET['date_start'];}?>"/>
                </div>
            </div>
              
            <div class="form-group col-xs-2">
                <label class="col-sm-12">结束时间</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="date_end" value="<?php if($_GET['date_end']){echo $_GET['date_end'];}?>"/>
                </div>
            </div>  

            <div class="form-group col-xs-2">
                <label class="col-sm-12">显示类型</label>
                <div class="col-sm-12">
                    <select class="form-control" name="infotype">
                        <option value="1" <?php if($_GET['infotype']=='1'){echo "selected='selected'";} ?>>按门时间排序</option>
                        <option value="2" <?php if($_GET['infotype']=='2'){echo "selected='selected'";} ?>>按门店编号排序</option>
                        <option value="3" <?php if($_GET['infotype']=='3'){echo "selected='selected'";} ?>>按总金额排序</option>
                    </select>
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
                <a href="#">永琪</a> &gt;
                <a href="#">上海</a> &gt;
                <a href="#">徐汇区</a> &gt;
                <a href="#">门店A</a>
            </div>
            <ul class="nav nav-pills report-tableCharts pull-right" role="tablist">
                <li role="presentation" class="active">
                    <a href="#report-bar-table" aria-controls="report-bar-table" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportTable.png" alt="reportTable"/>&nbsp;
                        <span>表格</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#report-line-charts" aria-controls="report-line-charts" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>折线</span>
                    </a>
                </li>

                <li role="presentation">
                    <a href="#report-bar-charts" aria-controls="report-bar-charts" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>图表</span>
                    </a>
                </li>
            </ul>
            
        </div>   
        <!-- table-report1 begin -->
        <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane active" id="report-bar-table">
        <div class="table-report1">
            <table>
                <tbody>
                    <tr>
                        <td>门店</td>
                        <td>日期</td>
                        <td>总收入</td>
                        <td>实业绩</td>
                        <td class="tdGroup tdGroupOpen">现金合计</td>
                        <td class="tdSub">现金产品</td>
                        <td class="tdSub">现金退卡</td>
                        <td class="tdSub rowBg">现金(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">银行卡合计</td>
                        <td class="tdSub">银行卡产品</td>
                        <td class="tdSub">银行卡退卡</td>
                        <td class="tdSub rowBg">银行卡(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">银行卡转账合计</td>
                        <td class="tdSub rowBg">银行转账</td>
                        <td class="tdGroup tdGroupOpen">便利通产品合计</td>
                        <td class="tdSub">便利通产品</td>
                        <td class="tdSub">便利通退卡</td>
                        <td class="tdSub rowBg">便利通(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">工会卡合计</td>
                        <td class="tdSub">工会卡产品</td>
                        <td class="tdSub">工会卡退卡</td>
                        <td class="tdSub rowBg">工会卡(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">支付宝合计</td>
                        <td class="tdSub">支付宝产品</td>
                        <td class="tdSub">支付宝退卡</td>
                        <td class="tdSub rowBg">支付宝(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">微信合计</td>
                        <td class="tdSub">微信产品</td>
                        <td class="tdSub">微信退卡</td>
                        <td class="tdSub rowBg">微信(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">支票合计</td>
                        <td class="tdSub">支票产品</td>
                        <td class="tdSub">支票退卡</td>
                        <td class="tdSub rowBg">支票(卡异动)</td>
                        <td class="tdGroup tdGroupOpen">销卡合计</td>
                        <td class="tdSub">销卡服务</td>
                        <td class="tdSub">销卡产品</td>
                        <td class="tdSub rowBg">卡异动</td>
                        <td>够卡服务</td>
                        <td>经理签单</td>
                        <td>支出登记</td>
                        <td>储值卡疗程</td>
                        <td>疗程话储值</td>
                        <td>疗程消费</td>
                    </tr>
                    <?php 
                    if(!empty($query))
                    {
                      foreach ($query as $key => $v) {
                        
                    ?>
                        <tr>
                            <td><?php echo $v->STORENAME; ?></td>
                            <td><?php echo date('Y/m/d',$v->DATETIME); ?></td>
                            <td><?php echo $v->TOTALVALUE; ?></td>
                            <td><?php echo $v->REALVALUE; ?></td>
                            <td class="tdGroup"><?php echo $v->CASH_SUM; ?></td>
                            <td class="tdSub"></td>
                            <td class="tdSub"></td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->BANKPAY_SUM; ?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->BANK_TRAN; ?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->PASSCARD_SUM; ?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->GUILDCARD_SUM; ?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->ALIPAY_SUM;?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->WXPAY_SUM;?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->CHECK_SUM;?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdGroup"><?php echo $v->PINCARD_SUM;?></td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td class="tdSub">***</td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                            <td><?php echo $v->PINCARD_SUM;?></td>
                        </tr>
                    
                    <?php }} ?>
                    
                </tbody>
            </table>
         </div>
               <nav class="report-page">
            <ul class="pagination">
                <li>
                    <!-- <a href="#" aria-label="Previous"> -->
                    <?php echo $page;?>
                </li>
            </ul>
        </nav>  
    </div>
        <input type="hidden" name="url" id="url" value="<?php echo  $url =  site_url('Report/post_curl?type=');?>">
        <!-- table-report1 end -->
    <div role="tabpanel" class="tab-pane" id="report-line-charts">
        <div id="ecLine" style="height: 600px; width:1200px;"></div>
        <div id="ecPie" style="height: 600px; width:900px;"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="report-bar-charts">
        <div id="ecBar" style="height:600px; "></div>
    </div> 
</div>
    <?php 
    $arr = array();
    foreach ($query as $k => $v) {
    $arr['name'][] ="'".date('Y/m/d',$v->DATETIME)."'";
    $arr['total'][] = $v->TOTALVALUE;
    $arr['real'][] = $v->REALVALUE;
    $arr['case'] += $v->CASH_SUM;
    $arr['weixin'] += $v->WXPAY_SUM;
    $arr['alipay'] += $v->ALIPAY_SUM;
    $arr['pincard'] += isset($v->PINCARD_SUM)?$v->PINCARD_SUM:'0';
    $arr['bank'] += $v->BANKPAY_SUM;
    }
    $name = implode(",",$arr['name']);
    $total = implode(",",$arr['total']);
    $real = implode(",",$arr['real']);
    ?>
    <script>
     var brandurl = "<?php  echo site_url('Report/ajax_query');?>";
/*    $("#brand_change").change(function(){
        var company =$(this).children('option:selected').val();
        $("#fengongsi").empty(); //清楚option
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":company,"type":"company"},
            dataType:'json',
            async: false,
            success:function(msg){
               if(msg)
                {
                   $("#fengongsi").empty(); //清楚option 
                }                
                $.each(msg,function(index,info){
                    var COMPANYID = info.COMPANYID;
                    var COMPANYNAME =info.COMPANYNAME;
                    var option =$("<option></option>");
                    option.val(COMPANYID);
                    option.text(COMPANYNAME);
                    $("#fengongsi").append(option);  
                });             
            }
        });
    });*/

    $("#fengongsi").change(function(){
        var fen_company =$(this).children('option:selected').val();
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":fen_company,"type":"company"},
            dataType:'json',
            async: false,
            success:function(msg){
               if(msg == false)
                {
                   $("#quyu").empty(); //清楚option 
                   $("#storeid").empty(); //清楚option 
                }

                $.each(msg,function(index,info){
                    var COMPANYID = info.COMPANYID;
                    var COMPANYNAME =info.COMPANYNAME;
                    var option =$("<option></option>");
                    option.val(COMPANYID);
                    option.text(COMPANYNAME);
                    $("#quyu").append(option);  
                });             
            }
        });
    });


        $("#quyu").change(function(){
            var fen_company =$(this).children('option:selected').val();
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":fen_company,"type":"store"},
            dataType:'json',
            async: false,
            success:function(msg){
                $("#storeid").empty(); //清楚option 
                $.each(msg,function(index,info){
                    var STOREID = info.STOREID;
                    var STORENAME =info.STORENAME;
                    var option =$("<option></option>");
                    option.val(STOREID);
                    option.text(STORENAME);
                    $("#storeid").append(option); 
                });             
            }
        });
    });


    $(":input").each(function(){ 
        var tem = $(this).attr("type");
        if(tem =="text")
        {
            $(this).click(function(){
                var start = {
                    format: 'YYYY/MM/DD',
/*                    min: laydate.now(), //设定最小日期为当前日期*/
                    istime: false,
                    istoday: false,
                    choose: function(datas){
                    }
                }; 
 

                laydate(start);
            })
        }
    });

var url = $("#url").attr("value");


function dispData(obj, arr){
   console.log(obj);
    for (var i = 1; i < arr.length; i++) {
        for (var j = 0; j < arr[i].data.length; j++) {
            var option =$("<option></option>");
            var name1 = arr[i].data[j].name;
            option.val(arr[i].data[j].value);
            option.text(arr[i].data[j].name);
            obj.append(option);
        }
    }
};
    

function  loadingSelectData() {
    $("select[attr]").each(function(){//表单select数据
        var attr = $(this).attr("attr");
        var info = $(this);
        if(attr!="undefined")
        {
            var page=1;
            var arr = Array();
            function getJsonStore(page){
                $.ajax({
                    type:'get',
                    url: url +attr+'&page='+page+"&att="+attr,
                    dataType:'json',
                    async: true
                })
                .success(function(data) {
                    var _data = data.data;
                    var _status = data.status;
                    //console.log(data);
                    if (_status == "success") {
                        arr[page] = Array();
                        arr[page].data = Array();
                        $.each(_data,function(index,infor){
                            arr[page].data[index] = Array();
                            arr[page].data[index].name = infor.name;
                            arr[page].data[index].value = infor.value;
                        });

                        if (_data.length > 0) {
                            getJsonStore(page+1);
                        }
                        else{
                            dispData(info, arr);
                        }
                    }
                    else{
                        dispData(info, arr);
                    }
                }) 
                .error(function() {
                    dispData(info, arr);
                 });   

            }
            getJsonStore(1);
        }
    });
}
/*  setTimeout("loadingSelectData();",500);*/



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
                    data:['总业绩', '实业绩']
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
                        data : [<?php echo $name; ?>],
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
                        name:'总业绩',
                        type:'bar',
                        data:[<?php echo $total; ?>]

                    },
                    {
                        name:'实业绩',
                        type:'bar',
                        data:[<?php echo $real; ?>]
                    }
                ]
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
                    data :['总业绩','实业绩']
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
                        data :[<?php echo $name; ?>]
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
                series : [
                    {
                        name:'总业绩',
                        type:'line',
                        data:[<?php echo $total; ?>]

                    },
                    {
                        name:'实业绩',
                        type:'line',
                        data:[<?php echo $real; ?>]
                    }
                ]
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
                    data :['销卡服务','现金服务','支付宝服务','微信服务','银行卡服务']
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
                            <?php if($arr['pincard']){
                                echo "{value:".$arr['pincard']." , name:'销卡服务'},";
                            } ?>
                            <?php if($arr['case']){
                                echo "{value:".$arr['case']." , name:'现金服务'},";
                            } ?>
                            <?php if($arr['alipay']){
                                echo "{value:".$arr['alipay']." , name:'支付宝服务'},";
                            } ?>
                             <?php if($arr['weixin']){
                                echo "{value:".$arr['weixin']." , name:'微信服务'},";
                            } ?>
                             <?php if($arr['bank']){
                                echo "{value:".$arr['bank']." , name:'银行卡服务'}";
                            } ?> 
                        ]
                    }
                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            ecPie.setOption(option);

            /* 给环形图绑定click事件 */
            var ecConfig = require('echarts/config');
            function eConsole(param) {
                //alert(param.value); 　　 // 弹出当前弧块的数值
                /*window.location.href = 'dailyReport5.html';*/
            }
            ecPie.on(ecConfig.EVENT.CLICK, eConsole);
        }        

    </script>