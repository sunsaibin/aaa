<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>报表</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/iconfont/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/laydate/need/laydate.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/my.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table-fixed-columns.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/searchnode.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/themes/default/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/content/css/dm_alert.css">
    <style>
        td{
            /*width: 320px!important;*/
            height: 60px!important;
            text-align: center!important;
            vertical-align: middle;
        }
        th{
            width: 120px!important;
        }
    </style>
</head>
<body>
<div class="container-sum">
    <form method="get" action="<?php echo site_url(); ?>/staff_report/staff_period_month_old_report" id="seach_condition">
        <div class="container-top">
            <div class="inputd-group">
                <label class="label-control">查询节点：</label>
                <input type="text" class="fm-control fm-disabled" value="<?php echo $seach_name; ?>" readonly="true"  id="searchStoreId" name="seach_name">
            </div>
            <div class="menu inputd-group-margin" onclick="showTree()"><img src="<?php echo base_url(); ?>/jslibs/report/content/images/menu-icon.svg" alt="menu"></div>
            <div class="inputd-group">
                <label class="label-control">日期：</label>
                <input type="text" class="fm-control fm-control-one date" onclick="laydate()" name="start_date" id="start_date" value="<?php echo $start_date; ?>">
            </div>
            <div class="inputd-group inputd-group-margin">
                <label class="label-control">至</label>
                <input type="text" class="fm-control fm-control-one date" onclick="laydate()" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
            </div>
            <div class="inputd-group inputd-group-margin">
                <label class="label-control">员工编号</label>
                <input type="text" class="fm-control fm-control-one"  name="staff_number" id="staff_number" value="<?php echo $staff_number; ?>">
            </div>
            <div class="inputd-group report-radio">
                <lable class="label-control txt-color">展示：</lable>
                <lable class="radio-inline">
                    <input type="radio" name="choose_type"  <?php if($choose_type==1) echo 'checked="checked"'; ?>  value="1">按日期
                </lable>
                <lable class="radio-inline">
                    <input type="radio" name="choose_type"  <?php if($choose_type==2) echo 'checked="checked"'; ?>  value="2">按员工
                </lable>
                <button type="button" class="btn btn-primary" onclick="submitDmForm('seach_condition');">
                    <img src="<?php echo base_url(); ?>/jslibs/report/content/images/search-icon.svg" alt="search">
                    <span>查询</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="exportExcel('table')">
                    <img src="<?php echo base_url(); ?>/jslibs/report/content/images/export_icon.svg" alt="search">
                    <span>导出</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="javascript:window.open('<?php echo site_url(); ?>/Report_staff_old/salary_report_month','_blank')";">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/oldversion_icon.svg" alt="search">
                <span>旧版本</span>
                </button>
            </div>
        </div>
        <input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
        <input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
    </form>
    <!--content begin-->
    <div class="content">
        <div class="content-top">
            <span>营业日报表</span>
        </div>
        <div class="report-table">
            <table class="table table-bordered table-condensed" data-toggle="table" data-height="600" id="table" >
                <thead>
                <tr>
                    <th class="middle top-first">日期/员工名称</th>
                    <th>门店</th>
                    <th>销卡大项业绩</th>
                    <th>销卡小项业绩</th>
                    <th>疗程业绩</th>
                    <th>现金大项业绩</th>
                    <th>现金大项提成</th>
                    <th>现金小项业绩</th>
                    <th>现金小项提成</th>
                    <th>现金卖品业绩</th>
                    <th>现金卖品提成</th>
                    <th>销卡大项提成</th>
                    <th>销卡小项提成</th>
                    <th>销卡卖品业绩</th>
                    <th>销卡卖品提成</th>
                    <th>现金项目业绩</th>
                    <th>售卡业绩</th>
                    <th>售卡提成</th>
                    <th>虚业绩(含卡)</th>
                    <th>疗程提成</th>
                    <th>经理签单业绩</th>
                    <th>经理签单提成</th>
                    <th>退卡业绩</th>
                    <th>退卡提成</th>
                    <th>服务业绩</th>
                    <th>提成总额</th>

                </tr>
                </thead>
                <tbody>
                <?php

                if(!empty($reportData)) {
                    foreach ($reportData as $key => $v) {
                        //绘制表格
                        echo '<tr><td>' . $v->storeNameOrTime . '</td>';
                        echo '<td>' . $v->storename . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_max_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_min_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->course_performance) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->cash_max_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->cash_max_commission) . '</td>';

                        echo '<td style="color:green;;text-align:right;">' . sprintf("%.2f", $v->cash_min_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->cash_min_commission) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->cash_product_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->cash_product_commission) . '</td>';


                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_max_commission) . '</td>';


                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_min_commission) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_product_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->mem_product_commission) . '</td>';

                        echo '<td style="color:green;text-align:right;" >' . sprintf("%.2f", ($v->cash_max_performance + $v->cash_min_performance + $v->cash_product_performance)) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->card_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->card_commission) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", ($v->cash_max_performance + $v->cash_min_performance + $v->cash_product_performance + $v->card_performance - $v->card_untread_performance)) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->course_commission) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->manager_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->manager_commission) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->card_untread_performance) . '</td>';
                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", $v->card_untread) . '</td>';

                        echo '<td style="color:green;text-align:right;">' . sprintf("%.2f", ($v->cash_max_performance + $v->cash_min_performance + $v->mem_max_performance + $v->mem_min_performance)) . '</td>';
                        echo '<td style="color:red;text-align:right;">' . sprintf("%.2f", ($v->cash_max_commission + $v->cash_min_commission + $v->cash_product_commission + $v->mem_max_commission + $v->mem_min_commission + $v->mem_product_commission + $v->card_commission - $v->card_untread)) . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--content end-->
</div>
<div class="nodeTreeBox"></div>
<script type="application/javascript">
    var isfirLoad = true;
    function initDataByNodeId(selectCompId,selectStoreId){
        var stroe_val = $("#searchStoreId").val();
        if(isfirLoad){
            isfirLoad = false;
            var default_value = "<?php echo $seach_name; ?>";
            if(stroe_val.length>0 && default_value.length>0){
                $("#searchStoreId").val(default_value);
                selectCompId = <?php echo $seach_storeid; ?>;
                selectStoreId = <?php echo $seach_companyid; ?>;
                return;
            }
        }
    }
</script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/laydate/laydate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table-fixed-columns.js" ></script>
<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/report_param.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/excel/exportexcel.js"></script>

<script type="text/javascript">
    function  submitDmForm(str_id){
        var stroe_val = $("#searchStoreId").val();
        var default_value = "<?php echo $seach_name; ?>";
        if(default_value != stroe_val || stroe_val.length<1){
            $("#seach_companyid").val(selectCompId);
            $("#seach_storeid").val(selectStoreId);
        }

        if(parseInt($("#seach_companyid").val()) < 0){
            $.AlertDialog.CreateAlert("警告","请选择查询节点!");
            return;
        }

        if(parseInt($("#seach_storeid").val()) < 0){
            $.AlertDialog.CreateAlert("警告","请选择查询节点!");
            return;
        }

        var start_date = $("#start_date").val();
        if(start_date.length < 1){
            $.AlertDialog.CreateAlert("警告","请选择起始日期!");
            return;
        }

        var end_date = $("#end_date").val();
        if(end_date.length < 1){
            $.AlertDialog.CreateAlert("警告","请选择结束日期!");
            return;
        }

        if(compare_tab(start_date,end_date)){
            $.AlertDialog.CreateAlert("警告","起始时间不可以大于结束时间!");
            return;
        }

        $("#"+str_id).submit();
    }
</script>
<script type="text/javascript">

    $('#table').bootstrapTable({
//        columns: columns,
        toolbar: '.toolbar',
        fixedColumns: true,
//        sortable: true, //是否启用排序
//        sortOrder:"asc",
        showExport: true,                     //是否显示导出
        fixedNumber: +"2"
    });
    $('.table tbody td').click(function(){
        $(this).parent().css('backgroundColor','#ebebe5');
        $(this).parent().siblings().css('backgroundColor','#fff');
    });
</script>
</body>
</html>