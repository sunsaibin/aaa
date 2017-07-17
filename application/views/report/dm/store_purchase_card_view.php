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
                <input type="radio" name="choose-type" <?php if($choose_type==1) echo 'checked="checked"'; ?>  value="1">按日
            </lable>
            <lable class="radio-inline radio-style ">
                <input type="radio" name="choose-type" <?php if($choose_type==2) echo 'checked="checked"'; ?>  value="2">按月
            </lable>
            <lable class="radio-inline radio-style ">
                <input type="radio" name="choose-type" <?php if($choose_type==3) echo 'checked="checked"'; ?>  value="3">按年
            </lable>
            <lable class="radio-inline radio-style">
                <input type="radio" name="choose-type"  <?php if($choose_type==4) echo 'checked="checked"'; ?> id="choose-type"  value="4">按门店
            </lable>
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" id="collect_card" <?php if($collect_card==1) echo 'checked="checked"'; ?>>
                按卡号汇总
            </label>
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
            <span>收购卡统计</span>
        </div>
        <div class="jqGrid_wrapper">
            <table id="table_list_1"></table>
        </div>
    </div>
    <div class="content">
        <div class="content-top">
            <span>收购卡消费明细</span>
        </div>
        <div class="jqGrid_wrapper">
            <table id="table_list_2"></table>
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
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();
        var choose_type_val = $('input:radio[name="choose-type"]:checked').val();
        var collect_card_val = 0;
        if($('#collect_card').is(':checked')) {
            collect_card_val = 1;
        }


        $.post("<?php echo site_url(); ?>/store_report/store_purchase_card_data",
            { seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val,choose_type:choose_type_val,collect_card:collect_card_val},
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
            height: (height-300)/2,
            autowidth: true,
            shrinkToFit: false,
            rowNum: 100000,
            footerrow:true,
            gridComplete:function()
            {
                var exclude_array = ["1","2","3",'4'];
                var col_array = new Array();
                for(var i=1;i<20;i++){
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
            colNames: ['序号','日期/门店','收购时间', '会员卡号','收购金额','收购卡余额被消费金额','收购卡历史消费','收购卡余额','再充值消费金额', '期初卡余额', '消费金额', '期末卡余额'],
            colModel: [
                {name:'col1',index: 'col1', width: 150, resizable:false, frozen:true,width:50,formatter:function(cellvalue, options, rowObject){
                    return "<div colval='"+cellvalue+"'>"+options.rowId+"</div>";
                }},
                {name:'col2',index: 'col2', width: 150, resizable:false, frozen:true,width:150},
                {name:'col3',index: 'col3', width: 150},
                {name:'col4',index:'col4',  width:160},
                {name:'col5',index:'col5', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col6',index:'col6', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col7',index:'col7', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col8',index:'col8', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col9',index:'col9', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col10',index:'col10', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col11',index:'col11', sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col12',index:'col12', sorttype:"float",resizable:false,align:"right",width:160}
            ],
            viewrecords: true,
            onSelectRow: function(id){
                var gridData= $("#table_list_1").jqGrid("getRowData",id);
                //console.info(gridData);
                var cardid = $(gridData.col1).attr("colval")
                request_data_detail(cardid);
            }
        });

        $("#table_list_1").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
            ]
        });

        $("#table_list_1").jqGrid('setFrozenColumns');
    });

</script>

<script>
    function request_data_detail(card_id){
        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();

        jQuery("#table_list_2").clearGridData();
        $.post("<?php echo site_url(); ?>/store_report/store_purchase_card_detail_data",
            { card_id: card_id, start_date: start_date_val,end_date: end_date_val},
            function(data){
                console.debug(data);
                var json_data = eval("("+data+")"); ;
                if(json_data.code == "000"){
                    var items = json_data.items;
                    table_build_detail_data(items);
                }
            }
        );
    }

    function  table_build_detail_data(items_data) {
        $("#table_list_2").jqGrid("clearGridData");
        $("#table_list_2").jqGrid("setGridParam",{datatype:"local",data:items_data}).trigger("reloadGrid");
    }

    $(document).ready(function () {
        $.jgrid.defaults.styleUI = 'Bootstrap';
        var mydata = [];
        var height=$(window).height();

        $("#table_list_2").jqGrid({
            data: mydata,
            datatype: "local",
            height: (height-300)/2-100,
            autowidth: true,
            shrinkToFit: false,
            rowNum: 100000,
            footerrow:true,
            gridComplete:function()
            {
                var exclude_array = ["1","2","4","5","6"];
                var col_array = new Array();
                for(var i=1;i<7;i++){
                    if($.inArray(i+"", exclude_array)>-1){
                        continue;
                    }
                    var total_col_tem = $("#table_list_2").getCol('col'+i,false,'sum');
                    col_array["col"+i] = total_col_tem;
                }
                col_array["col1"] = '合计:';
                $("#table_list_2").footerData('set',col_array);

            },
            //rowList: [10, 20, 30],
            colNames: ['消费门店','订单编号', '项目价格','服务/产品名称', '支付类型', '服务时间'],
            colModel: [
                {name:'col1',index: 'col1', width: 150, resizable:false, frozen:true,width:250},
                {name:'col2',index:'col2',width:100,frozen:true,width:250},
                {name:'col3',index:'col3',sorttype:"float",resizable:false,align:"right",width:160},
                {name:'col4',index:'col4',resizable:false,align:"left",width:160},
                {name:'col5',index:'col5',resizable:false,align:"left",width:160},
                {name:'col6',index:'col6',resizable:false,align:"left",width:160}
            ],
            viewrecords: true,
        });

        $("#table_list_2").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
            ]
        });

        $("#table_list_2").jqGrid('setFrozenColumns');
    });

</script>
<script>
    function export_dmExcel(tableId)
    {
        var tableObj = $("#"+tableId);
        var tableData = tableObj.jqGrid('getRowData');
        var tableHeader =   ['序号','日期/门店','收购时间', '会员卡号','收购金额','收购卡余额被消费金额','收购卡历史消费','收购卡余额','再充值消费金额', '期初卡余额', '消费金额', '期末卡余额'];

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
