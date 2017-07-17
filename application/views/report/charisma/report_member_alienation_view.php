<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>会员疏远报表</title>
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
            <label class="label-control">间隔天数：</label>
            <input type="text" class="fm-control fm-control-one" name="start_date" id="start_date" value="">
        </div>
        <div class="inputd-group inputd-group-margin">
            <label class="label-control">至</label>
            <input type="text" class="fm-control fm-control-one" name="end_date" id="end_date" value="">
            <label class="label-control">天</label>
        </div>
        <div class="inputd-group" style="margin-left:20px;">
			<lable class="label-control">卡类型：</lable>
			<select class="fm-control fm-control-one" id="cardtype" name="cardtype">
            
			</select>
		</div>
        <div class="inputd-group report-radio">
            <lable class="label-control txt-color">关键词：</lable>
            <input type="text" class="fm-control" id="cardnumber" name="cardnumber" placeholder="可输入卡号">
            <button type="button" class="btn btn-primary" onclick="submitDmForm('seach_condition');">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/search-icon.svg" alt="search">
                <span>查询</span>
            </button>
            <button type="button" class="btn btn-primary" onclick="export_dmExcel('table_list_1')">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/export_icon.svg" alt="search">
                <span>导出</span>
            </button>
	  <!-- <button type="button" class="btn btn-primary" onclick="javascript:window.open('http://op.faxianbook.com/php/webroot/index.php/Report_staff_old/salary_report','_blank');">
                <img src="http://op.faxianbook.com/php/webroot//jslibs/report/content/images/oldversion_icon.svg" alt="search">
                <span>旧版本</span>
            </button>-->
        </div>
    </div>
    <input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    <input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">

    <!--content begin-->
    <div class="content">
        <div class="content-top">
            <span>会员疏远报表</span>
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

    set_tree_callback(function(t,c,s){
        $("#seach_companyid").val(c);
        $("#seach_storeid").val(s);
        getCardType();
    });
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

        if(parseInt($("#seach_storeid").val()) <= 0){
            $.AlertDialog.CreateAlert("警告","请选择查询门店!");
            return;
        }

        if(parseInt($("#cardtype").val()) <= 0){
            $.AlertDialog.CreateAlert("警告","请选择卡类型!");
            return;
        }

        /*var start_date = $("#start_date").val();
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
        }*/

        request_data();
        //$("#"+str_id).submit();
    }

    function request_data(){
        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();
        var card_typeid_val = $("#cardtype").val();
        var card_number_val = $("#cardnumber").val();



        $.post("<?php echo site_url(); ?>/report_member/member_alienation_detail",
            { seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val,card_typeid:card_typeid_val,card_number:card_number_val},
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
        getCardType();

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
                var exclude_array = ["1","2"];
                var col_array = new Array();
                for(var i=7;i<=9;i++){
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
                col_array["col0"] = '合计:';
                $("#table_list_1").footerData('set',col_array);

            },
            //rowList: [10, 20, 30],
            colNames: ['公司编号','公司名称','会员卡号','会员卡类型','会员姓名','手机号码','性别','总消费金额','总充值金额','剩余金额','间隔天数'],
            colModel: [
                {name:'col0',index:'col0', align:"center", width: 147, resizable:false, frozen:true},
                {name:'col1',index:'col1',align:"center",width:148,frozen:true},
                {name:'col2',index:'col2',sorttype:"float",resizable:false,align:"center",width:150},
                {name:'col3',index:'col3',sorttype:"float",resizable:false,align:"center",width:150},
                {name:'col4',index:'col4',sorttype:"float",resizable:false,align:"center",width:150},
                {name:'col5',index:'col5',sorttype:"float",resizable:false,align:"center",width:150},
                {name:'col6',index:'col6',sorttype:"float",resizable:false,align:"center",width:147},
                {name:'col7',index:'col7',sorttype:"float",resizable:false,align:"right",width:150},
                {name:'col8',index:'col8',sorttype:"float",resizable:false,align:"right",width:150},
                {name:'col9',index:'col9',sorttype:"float",resizable:false,align:"right",width:150},
                {name:'col10',index:'col10',sorttype:"float",resizable:false,align:"center",width:147},
            ],
            viewrecords: true,
        });

        $("#table_list_1").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
            ]
        });

        $("#table_list_1").jqGrid('setFrozenColumns');
    });

    function getCardType() {
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();

        $.post("<?php echo site_url(); ?>/report_member/getCardType",
            {seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val},
            function(data){
                //console.debug(data);
                var cardTypeSelectObj = $("#cardtype");
                cardTypeSelectObj.children().remove();
                var cardTypeHtml = '<option value="0">请选择</option>';
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    cardTypeHtml += '<option value="'+item.CARDTYPEID+'">'+item.CARDTYPENAME+'</option>'
                }
                cardTypeSelectObj.append(cardTypeHtml);
            }
        ,'json');
    }

</script>
<script>
    function export_dmExcel(tableId)
    {
        var tableObj = $("#"+tableId);
        var tableData = tableObj.jqGrid('getRowData');
        var tableHeader = ['公司编号','公司名称','会员卡号','会员卡类型','会员姓名','手机号码','性别','总消费金额','总充值金额','剩余金额','间隔天数'];
        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var choose_type_val = $('input:radio[name="choose-type"]:checked').val();

        var t_data = new Object();
        if(choose_type_val==2){
            for(var i= 0; i<tableData.length ;i++){
                var c_cell = tableData[i];
                c_cell.col1 = $(c_cell.col1).text();
                t_data[i] = c_cell;
            }
        }
        else{
            t_data = tableData;
        }


        $("#expor_seach_name").val(seach_name_val);
        $("#expor_start_date").val(start_date_val);
        $("#expor_end_date").val(end_date_val);
        $("#expor_table_data").val(JSON.stringify(t_data));
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