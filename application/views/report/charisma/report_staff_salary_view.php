 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;
 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_staff_old/salary_report");?>" method="GET">
        <div class="report-head">
            <div class="form-group col-xs-2">
                <label class="col-sm-3">公司</label>
                <div class="col-sm-9">
                <select class="form-control">
                <?php
                    if ($stallCompany) {
                        echo '<option>'.$stallCompany->COMPANYNAME.'</option>';
                    }
                ?>
                </select>
                </div>
            </div>

            <div class="form-group col-xs-3">
                <label class="col-sm-2">门店</label>
                <div class="col-sm-10">
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
            <div class="form-group col-xs-2" style="width:auto;">
                <label class="col-sm-4">开始日期</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
                </div>
            </div>
            <div class="form-group col-xs-2" style="width:auto;">
                <label class="col-sm-4">结束日期</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="queryenddate" value="<?php  echo $queryenddate; ?>">
                </div>
            </div>
            <div class="form-group col-xs-2" style="width:auto;">
                <input type="submit" class="btn btn-info" id="do_query" value="查询" />
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