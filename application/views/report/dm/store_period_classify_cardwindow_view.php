<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <title>员工业绩统计表</title>
	    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/bootstrap.min.css" rel="stylesheet">
	    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/font-awesome.css?v=4.4.0" rel="stylesheet">
	    <!-- jqgrid-->
	    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/plugins/jqgrid/ui.jqgrid.css?0820" rel="stylesheet">
			
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/laydate/need/laydate.css"/>
	    <link href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css?v=4.1.0" rel="stylesheet">
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/my.css"/>

	    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/iconfont/iconfont.css"/>
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/jslibs/report/content/css/style.css"/>
	    <link rel="stylesheet" href="<?php echo base_url(); ?>jslibs/searchnode/content/css/themes/default/style.min.css" />
	</head>
	<body>
	
	 <div class="layer">
	    <div class="staff-list">
	    	<!-- <span class="iconfont icon-close"></span> -->
	    		<!-- <div class="inputd-group">
					<label class="label-control">当前查询节点：</label>
					<input type="text" class="fm-control fm-disabled" id="searchStoreId" readonly="true">
				</div> -->
				<!-- <div class="menu" onclick="showTree()"><img src="../images/menu-icon.svg" alt="menu"></div> -->
				<!-- <div class="inputd-group">
					<label class="label-control">日期：</label>
					<input type="text" class="fm-control fm-control-one date" onclick="laydate()" id="staffStartTime">
				</div>
				<div class="inputd-group inputd-group-margin">
					<label class="label-control">至</label>
					<input type="text" class="fm-control fm-control-one date" onclick="laydate()" id="staffEndTime">
				</div>
				<div class="inputd-group">
					<label class="label-control">员工编号：</label>
					<input type="text" class="fm-control" id="staffNum">
				</div>
				<button type="button" class="btn btn-primary btn-search" onclick="queryStaffDetailAjax()"><span class="iconfont icon-search" style="font-size: 12px;"></span><span class="span-set">查询</span></button> -->
			<div class="jqGrid_wrapper" style="position: relative;">
          		<table id="staffDetailTable"> </table>
          		<!--<div style="height: 20px;width: 200px; background: red; position: absolute; bottom: 20px;left: 0px;"></div>-->
      		</div>
	    </div>
    </div>
    
    <div class="nodeTreeBox"></div>
    
    <script src="<?php echo base_url(); ?>/jslibs/report/content/js/jquery.min.js?v=2.1.4"></script>
    <!--<script src="js/plugins/peity/jquery.peity.min.js"></script>-->
    <!--<script src="js/plugins/jqgrid/i18n/grid.locale-cn.js"></script>-->
    <script src="<?php echo base_url(); ?>/jslibs/report/content/js/plugins/jqgrid/jquery.jqGrid.min.js?0820"></script>
    <script src="<?php echo base_url(); ?>/jslibs/report/content/laydate/laydate.js"></script>
    <!-- <script src="../js/staffAchieve.js" ></script> -->
	<script>
	    $(document).ready(function () {
			//console.log(window.parent.gcarddata.data); // 取父窗口的变量
	        $.jgrid.defaults.styleUI = 'Bootstrap';
	        
	
			var height=$(window).height();
	        $("#staffDetailTable").jqGrid({
	            data: window.parent.gcarddata.data,
	            datatype: "local",
	            height: height - 100,
	            autowidth: true,
	            shrinkToFit: false,
	            rowNum: 100000,
	            footerrow:true,
	            //底部汇总和
	            gridComplete:function()
	            {
	            	
	       			var billamt=$("#staffDetailTable").getCol('billamt',false,'sum');  
	       			var shareamt=$("#staffDetailTable").getCol('shareamt',false,'sum');  
	       			$("#staffDetailTable").footerData('set', { "id": '合计:', billamt: billamt, shareamt: shareamt});  
	       
	            },
	            colNames: ['单据编号', '日期', '会员卡号', '可分享金额', '已分享金额',],
	            colModel: [
	                {
	                    name: 'id',
	                    index: 'id',
	                    width: 178,
	                    sorttype: "int",
	                    //search: true,
	                    //resizable:false,
	                    align:"center",
	                    frozen:true,//固定列
	                },
	                {
	                    name: 'accountdate',  
	                    index: 'accountdate',
	                    width: 178,
	                    sorttype: "int",
	                    //search: true,
	                    //resizable:false,
	                    align:"center",
	                    frozen:true,//固定列
	                },
	                {
	                    name: 'cardnum',
	                    index: 'cardnum',
	                    width: 178,
	                    sorttype: "int",
	                    //search: true,
	                    //resizable:false,
	                    align:"center",
	                    frozen:true,//固定列
	                },
	                {
	                    name: 'billamt',
	                    index: 'billamt',
	                   	//resizable:false,
	                    sorttype: "float",
	                    width: 180,
	                    align:'center'                    
	                },
	                {
	                    name: 'shareamt',
	                    index: 'shareamt',
	                    resizable:false,
	                    sorttype: "float",
	                    width: 180,
	                    align:'center'
	                },
	               
	            ],
	            viewrecords: true,
	        });

			//实现表头脚本
			/*$("#staffDetailTable").jqGrid('setGroupHeaders', {
			    useColSpanStyle: true,
			    groupHeaders:[
	
			      {startColumnName:'item1', numberOfColumns:5, titleText: '现金'},
		        {startColumnName:'item6', numberOfColumns: 5, titleText: '销卡'},
		        {startColumnName:'item11', numberOfColumns: 5, titleText: '售卡'}
			    ]
			    
			});
			$("#staffDetailTable").jqGrid('setFrozenColumns');   //固定列*/
	 	});
	    
	    function toDecimal2(x){
            var f = parseFloat(x);
            if (isNaN(f)) {
                return "0.00";
            }
            var f = Math.round(x*100)/100;
            var s = f.toString();
            var rs = s.indexOf('.');
            if (rs < 0) {
                rs = s.length;
                s += '.';
            }
            while (s.length <= rs + 2) {
                s += '0';
            }
            return s;
        }

	</script>
	<script type="text/javascript">
		/*$(function(){
			queryStaffService();
		})*/
	</script>
	</body>
</html>