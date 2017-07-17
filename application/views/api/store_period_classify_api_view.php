<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">


    <title>营业日报表</title>


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
            <button type="button" class="btn btn-primary" onclick="exportExcel('table_list_1')">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/export_icon.svg" alt="search">
                <span>导出</span>
            </button>
            <button type="button" class="btn btn-primary" onclick="submitDmForm_checkcard()">
                <img src="<?php echo base_url(); ?>/jslibs/report/content/images/oldversion_icon.svg" alt="search">
                <span>检查卡金</span>
            </button>
        </div>
    </div>
    <input type="hidden" id="seach_storeid" name="seach_storeid" value="<?php echo $seach_storeid; ?>">
    <input type="hidden" id="seach_companyid" name="seach_companyid" value="<?php echo $seach_companyid; ?>">
    <!--content begin-->
    <div class="content">
        <div class="content-top" style="margin: 0px">
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
<script src="<?php echo base_url(); ?>/jslibs/content/layer/layer.min.js"></script>
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
    var gcarddata=null;
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

        if(selectStoreId == 0){
            $.AlertDialog.CreateAlert("警告","请选择查询门店!");
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



        $.post("<?php echo site_url(); ?>/api_data/store_period_classify_report_data_api",
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
    }

    // 检查卡金
    function submitDmForm_checkcard()
    {
        var stroe_val = $("#searchStoreId").val();
        var default_value = "<?php echo $seach_name; ?>";
        if(default_value != stroe_val || stroe_val.length<1){
            $("#seach_companyid").val(selectCompId);
            $("#seach_storeid").val(selectStoreId);
        }

        if(selectStoreId == 0){
            $.AlertDialog.CreateAlert("警告","请选择查询门店!");
            return;
        }

        var seach_name_val = $("#searchStoreId").val();
        var start_date_val = $("#start_date").val();
        var end_date_val = $("#end_date").val();
        var choose_type_val = $('input:radio[name="choose-type"]:checked').val();
        var seach_storeid_val = $("#seach_storeid").val();
        var seach_companyid_val = $("#seach_companyid").val();

        $.post("<?php echo site_url(); ?>/api_data/store_period_classify_report_checkcard_api", {seach_name: seach_name_val, start_date: start_date_val,end_date: end_date_val , choose_type: choose_type_val, seach_storeid: seach_storeid_val, seach_companyid: seach_companyid_val}, function(data){
            //console.debug(data);
            var json_data = eval("("+data+")"); ;
            gcarddata=json_data;
            if(json_data.data != null){
                // iframe窗
                layer.open({
                   type: 2,
                   title: '卡金分配明细',
                   shadeClose: true,
                   shade: false,
                   maxmin: true, //开启最大化最小化按钮
                   area: ['900px', '500px'],
                   content: '<?php echo site_url(); ?>/api_data/store_period_classify_report_cardwindow_api'
                });
            }else{
                $.AlertDialog.CreateAlert("提示","卡金已全部分配!");
                return;
            }
        });
    }
</script>





<script>
    $(document).ready(function () {
        $.jgrid.defaults.styleUI = 'Bootstrap';
        var mydata = [];
        var height=$(window).height();

        $("#table_list_1").jqGrid({
            //data: mydata,
            datatype: "local",
            height: height-250,
            autowidth: true,
            shrinkToFit: false,
            rowNum: 100000,
            footerrow:true,
            gridComplete:function()
            {
                var exclude_array = ["1","7","13","19"];
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
            colNames: ['日期/门店',"  (虚业绩)  ", ' (美容虚业绩) ',
                ' (美发虚业绩) ',' (美甲虚业绩) ',' (其他虚业绩) ',' (美容/美发/美甲/其他) ',
                '(实业绩)','(实业绩)','(实业绩)','(实业绩)','(实业绩)',
                '(美容/美发/美甲/其他)', '总的售卡业绩', '美容售卡业绩','美发售卡业绩','美甲售卡业绩','其他售卡业绩',
                '(美容 / 美发 / 美甲/其他)'],
            colModel: [
                {name:'col1',index: 'col1', width: 150, resizable:false},
                {name:'col2',index:'col2',width:100,sorttype:"int",align:"right"},
                {name:'col3',index:'col3',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col4',index:'col4',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col5',index:'col5',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col6',index:'col6',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col7',index:'col7',resizable:false,align:"right",width:130},
                {name:'col8',index:'col8',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col9',index:'col9',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col10',index:'col10',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col11',index:'col11',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col12',index:'col12',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col13',index:'col13',resizable:false,align:"right",width:130},
                {name:'col14',index:'col14',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col15',index:'col15',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col16',index:'col16',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col17',index:'col17',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col18',index:'col18',sorttype:"float",resizable:false,align:"right",width:130},
                {name:'col19',index:'col19',resizable:false,align:"right",width:130}
            ],
            viewrecords: true,
        });

        $("#table_list_1").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
                {startColumnName: 'col2', numberOfColumns:1, titleText: '总现金业绩'},
                {startColumnName: 'col3', numberOfColumns: 1, titleText: '美容现金业绩'},
                {startColumnName: 'col4', numberOfColumns: 1, titleText: '美发现金业绩'},
                {startColumnName: 'col5', numberOfColumns: 1, titleText: '美甲现金业绩'},
                {startColumnName: 'col6', numberOfColumns: 1, titleText: '其他现金业绩'},
                {startColumnName: 'col7', numberOfColumns: 1, titleText: '虚业绩占比'},
                {startColumnName: 'col8', numberOfColumns: 1, titleText: '总服务业绩'},
                {startColumnName: 'col9', numberOfColumns: 1, titleText: '美容服务业绩'},
                {startColumnName: 'col10', numberOfColumns: 1, titleText: '美发服务业绩'},
                {startColumnName: 'col11', numberOfColumns: 1, titleText: '美甲服务业绩'},
                {startColumnName: 'col12', numberOfColumns: 1, titleText: '其他服务业绩'},
                {startColumnName: 'col13', numberOfColumns: 1, titleText: '服务业绩占比'},
                {startColumnName: 'col19', numberOfColumns: 1, titleText: '售卡业绩占比'}
            ]
        });

        $("#table_list_1").jqGrid('setFrozenColumns');
    });

</script>
</body>
</html>
