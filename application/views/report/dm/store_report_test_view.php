<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>报表</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/iconfont/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/laydate/need/laydate.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap-table-fixed-columns.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/searchnode.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/themes/default/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/content/css/dm_alert.css">
    <style>
        .table-condensed tbody tr td{
            padding:0px;
            line-height: 60px;
            width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            white-space: nowrap;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            word-wrap:break-word;
        }
        table thead tr th{
            height: 60px;
            text-align: center;
            vertical-align: middle;
            line-height: 60px;
        }
        table tbody tr td{
            /*width:200px;*/
            height: 60px;
            text-align: center;
            vertical-align: middle;
            line-height: 60px;
            /*text-align: center;*/
            /*vertical-align: middle;*/
            /*line-height: 60px;*/
        }
    </style>
</head>
<body>
<div class="container-sum">
    <!--content begin-->
    <div class="content">
        <div class="content-top">
            <span>报表</span>
        </div>
        <div class="report-table">
            <table class="table table-bordered table-condensed" data-toggle="table" data-height="900" id="table" >
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!--content end-->
</div>
<div class="nodeTreeBox"></div>

<script src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/laydate/laydate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/jslibs/report/content/bootstrap/bootstrap.min.js" ></script>
<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--/jslibs/report/content/bootstrap/bootstrap-table.js" ></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--/jslibs/report/content/bootstrap/bootstrap-table-fixed-columns.js" ></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--/jslibs/searchnode/content/js/jstree.min.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--/jslibs/searchnode/content/js/searchnode.js"></script>-->
<script src="<?php echo base_url(); ?>/jslibs/content/js/dm_alert.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/report/content/js/report_param.js"></script>
<script src="<?php echo base_url(); ?>/jslibs/excel/exportexcel.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.getJSON("<?php echo site_url(); ?>/store_report/index_data",function(result){
            if(result == null || result.code != "000"){
                $.AlertDialog.CreateAlert("警告","数据格式不正确!");
                return;
            }

            if(result.tbody == null || result.tbody.length<1){
                $.AlertDialog.CreateAlert("警告","没有数据!");
                return;
            }

            if(result.thead != null){
                console.debug(result.thead);
                $(".table thead").empty();

                var tr_obj = $("<tr></tr>");
                for(var j=0;j<result.thead.length;j++){
                    tr_obj.append("<th>"+result.thead[j]+"</th>");
                }

                $(".table thead").append(tr_obj);
            }

            $.each( result.tbody, function(i, field){
                var tr_obj = $("<tr></tr>");
                for(var j=0;j<field.length;j++){
                    tr_obj.append("<td>"+field[i]+"</td>");
                }

                $(".table tbody").append(tr_obj);
                console.debug(field);
            });

//            $('#table').bootstrapTable({
//                toolbar: '.toolbar',
//                fixedColumns: true,
//                width:100,
//                showExport: true,                     //是否显示导出
//                fixedNumber: +"1"
//            });
        });
    });


</script>
</body>
</html>
