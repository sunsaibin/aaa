<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">


    <title>营业月报表</title>


    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <!-- jqgrid-->
    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/plugins/jqgrid/ui.jqgrid.css?0820" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/laydate/need/laydate.css"/>
    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css?v=4.1.0" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/my.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/iconfont/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table-fixed-columns.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/searchnode.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/themes/default/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/content/css/dm_alert.css">

</head>
<body>
<div class="container-sum">
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
        <div class="inputd-group report-radio">
            <lable class="label-control txt-color">展示：</lable>
            <lable class="radio-inline radio-style ">
                <input type="radio" name="choose-type" <?php if($choose_type==1) echo 'checked="checked"'; ?>  value="1">按日期
            </lable>
            <lable class="radio-inline radio-style">
                <input type="radio" name="choose-type"  <?php if($choose_type==2) echo 'checked="checked"'; ?> id="choose-type"  value="2">按门店
            </lable>
            <button type="button" class="btn btn-primary" onclick="submitDmForm('seach_condition');">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/search-icon.svg" alt="search">
                <span>查询</span>
            </button>
            <button type="button" class="btn btn-primary" onclick="export_dmExcel('table_list_1')">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/export_icon.svg" alt="search">
                <span>导出</span>
            </button>
            <button type="button" class="btn btn-primary" onclick="javascript:window.open('<?php echo site_url(); ?>/Report_store_old/classify_pool','_blank');">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/oldversion_icon.svg" alt="search">
                <span>旧版本</span>
            </button>
        </div>
    </div>
    <input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    <input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">

    <!--content begin-->
    <div class="content">
        <div class="content-top">
            <span>营业日报表</span>
        </div>
        <div class="jqGrid_wrapper">
            <table id="table_list_1"></table>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/bootstrap.min.js?v=3.3.6"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/plugins/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/plugins/jqgrid/i18n/grid.locale-cn.js?0820"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/plugins/jqgrid/jquery.jqGrid.min.js?0820"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/content.js?v=1.0.0"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/laydate/laydate.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/jstree.min.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/searchnode/content/js/searchnode.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/report_param.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/excel/exportexcel.js"></script>
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

    function  callback_searchnode(selectCompId,selectStoreId){
        alert(selectCompId);
    }
</script>

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


        request_data();
        //$("#"+str_id).submit();
    }

    function request_data(){
        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var choose_type_val = $('input:radio[name="choose-type"]:checked').val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();



        $.post("<?php echo site_url(); ?>/store_report/store_period_month_report_data",
            { seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , choose_type: choose_type_val, seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val},
            function(data){
                console.debug(data);
                var json_data = eval("("+data+")"); ;
                if(json_data.code == "000"){
                    var items = json_data.items;
                    table_build_data(items);
                }
            }
        );
    }

    function  table_build_data(items_data) {
        $("#table_list_1").jqGrid("clearGridData");
        $("#table_list_1").jqGrid("setGridParam",{datatype:"local",data:items_data}).trigger("reloadGrid");
    }</script>


<script>
    $(document).ready(function () {
        $.jgrid.defaults.styleUI = 'Bootstrap';
        var mydata = [];
        var height=$(window).height();

        $("#table_list_1").jqGrid({
            data: mydata,
            datatype: "local",
            height: height-300,
            autowidth: true,
            shrinkToFit: false,
            rowNum: 100000,
            footerrow:true,
            gridComplete:function()
            {
                var exclude_array = ["1"];
                var col_array = new Array();
                for(var i=1;i<47;i++){
                    if($.inArray(i+"", exclude_array)>-1){
                        continue;
                    }
                    var total_col_value =0.00;
                    var total_col_tem = $("#table_list_1").getCol('col'+i,true);
                    for(var n=0;n<total_col_tem.length;n++){
                        if(total_col_tem[n] == undefined ){
                            continue;
                        }

                        var for_n_item = total_col_tem[n].value;
                        if(!isNaN(for_n_item)){
                            total_col_value =Number(total_col_value)+ Number(for_n_item);
                        }
                        else{
                            var for_n_obj = $(for_n_item);
                            total_col_value = total_col_value + Number(for_n_obj.text());
                        }
                    }
                    total_col_value = formatCurrency(total_col_value);
                    col_array["col"+i] = total_col_value;
                }
                col_array["col1"] = '合计:';
                $("#table_list_1").footerData('set',col_array);

            },
            //rowList: [10, 20, 30],
            colNames: ['日期/门店', '总收入', '实业绩', '总订单数', '服务业绩', '产品业绩', '卡异动业绩','服务','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','大众点评 ','百度糯米','合计','服务','产品','合计','服务','产品','合计','服务','产品','合计','售卡','退卡','合计','经理签单','支出登记','疗程兑换','储值兑换'],
            colModel: [
                {name:'col1',index: 'col1', width: 150, resizable:false, frozen:true},
                {name:'col2',index:'col2',width:100,sorttype:"int",align:"right",frozen:true},
                {name:'col3',index:'col3',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col4',index:'col4',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col5',index:'col5',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col6',index:'col6',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col7',index:'col7',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col8',index:'col8',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col9',index:'col9',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col10',index:'col10',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col11',index:'col11',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col12',index:'col12',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col13',index:'col13',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col14',index:'col14',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col15',index:'col15',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col16',index:'col16',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col17',index:'col17',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col18',index:'col18',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col19',index:'col19',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col20',index:'col20',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col21',index:'col21',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col22',index:'col22',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col23',index:'col23',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col24',index:'col24',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col25',index:'col25',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col26',index:'col26',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col27',index:'col27',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col28',index:'col28',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col29',index:'col29',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col30',index:'col30',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col31',index:'col31',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col32',index:'col32',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col33',index:'col33',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col34',index:'col34',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col35',index:'col35',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col36',index:'col36',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col37',index:'col37',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col38',index:'col38',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col39',index:'col39',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col40',index:'col40',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col41',index:'col41',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col42',index:'col42',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col43',index:'col43',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col44',index:'col43',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col45',index:'col43',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col46',index:'col43',sorttype:"float",resizable:false,align:"right",width:130}
            ],
            viewrecords: true,
        });

        $("#table_list_1").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
                {startColumnName: 'col8', numberOfColumns:5, titleText: '现金支付'},
                {startColumnName: 'col13', numberOfColumns: 5, titleText: '银行卡支付'},
                {startColumnName: 'col18', numberOfColumns: 5, titleText: '支付宝支付'},
                {startColumnName: 'col23', numberOfColumns: 5, titleText: '微信支付'},
                {startColumnName: 'col28', numberOfColumns: 3, titleText: '第三方支付'},
                {startColumnName: 'col31', numberOfColumns: 3, titleText: '销卡支付'},
                {startColumnName: 'col34', numberOfColumns: 3, titleText: '优惠券'},
                {startColumnName: 'col37', numberOfColumns: 3, titleText: '转账'},
                {startColumnName: 'col40', numberOfColumns: 3, titleText: '卡异动'}
            ]
        });

        $("#table_list_1").jqGrid('setFrozenColumns');
    });
</script>
<script>
    function export_dmExcel(tableId)
    {
        var tableObj = $("#"+tableId);
        var tableData = tableObj.jqGrid('getRowData');
        var tableHeader =  ['日期/门店', '总收入', '实业绩', '总订单数', '服务业绩', '产品业绩', '卡异动业绩','服务','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','服务 ','产品','售卡','退卡','合计','大众点评 ','百度糯米','合计','服务','产品','合计','服务','产品','合计','服务','产品','合计','售卡','退卡','合计','经理签单','支出登记','疗程兑换','储值兑换'];

        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();

        $("#expor_seach_name").val(seach_name_val);
        $("#expor_start_date").val(start_date_val);
        $("#expor_end_date").val(end_date_val);
        $("#expor_table_data").val(JSON.stringify(tableData));
        $("#expor_table_header").val(JSON.stringify(tableHeader));

        $("#export_form_id").submit();
    }
</script>
<form id="export_form_id" name="export_form" action='<?php echo site_url(); ?>/data_report/print_form_report' method="post"  target="_blank" >
    <input type="hidden" name="seach_name" id="expor_seach_name" value="">
    <input type="hidden" name="start_date" id="expor_start_date"  value="">
    <input type="hidden" name="end_date" id="expor_end_date" value="">
    <input type="hidden" name="table_data" id="expor_table_data" value="">
    <input type="hidden" name="table_header" id="expor_table_header" value="">
</form>

</body>
</html>
