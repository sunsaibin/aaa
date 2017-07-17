 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;
   
    $addkind=$_GET["addkind"];
	if(empty($addkind)){
	  $addkind=0;
	}


 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_store_old/store_day_pool");?>" method="GET">
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
                    <select class="form-control" name="storeid">
                <?php
                    //print_r($stallStore);
					$store_num = 0;
                    foreach ($selectStore as $key => $value) {
						$store_num +=1;
                        if ($stallStore->STOREID == $value->STOREID) {
                             echo '<option value="'.$value->STOREID.'" selected=selected>'.$value->STORENAME.'</option>';
                        }
                        else{
                             echo '<option value="'.$value->STOREID.'">'.$value->STORENAME.'</option>';
                        }
                    }
					if($store_num>1){
					  if(isset($_GET["storeid"]) && $_GET["storeid"]==0)
					  echo '<option value="0" selected = selected>全部</option>';
					else
					  echo '<option value="0" >全部</option>';
					}
                ?>
                </select>
                </div>
            </div>
            <div class="form-group col-xs-2">
                <label class="col-sm-12">开始日期</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
                </div>
            </div>
              
            <div class="form-group col-xs-2">
                <label class="col-sm-12">结束时间</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control" name="queryenddate" value="<?php echo $queryenddate; ?>">
                </div>
            </div>  

			 <div class="form-group col-xs-2">
                <label class="col-sm-12">合计方式</label>
                <div class="col-sm-12">
                  <select class="form-control" name="addkind">
					<option value="0" <?php if($addkind ==0) echo "selected=selected";  ?>>明细</option>
					<option value="1" <?php if($addkind ==1) echo "selected=selected";  ?>>店合计</option>
					<option value="2" <?php if($addkind ==2) echo "selected=selected";  ?>>时间合计</option>
					<option value="3" <?php if($addkind ==3) echo "selected=selected";  ?>>全合计</option>
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
                    <a href="#report-bar-table" aria-controls="report-bar-table" role="tab" data-toggle="tab">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportTable.png" alt="reportTable"/>&nbsp;
                        <span>表格</span>
                    </a>
                </li>

                <li role="presentation">
                    <a href="#report-bar-charts" aria-controls="report-bar-charts" role="tab" data-toggle="tab" class="active">
                        <img src="<?php echo base_url("");?>/jslibs/charisma/img/reportCharts.png" alt="reportTable"/>&nbsp;
                        <span>图表</span>
                    </a>
                </li>
            </ul>
        </div> 