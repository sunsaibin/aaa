 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;
 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report/day_report");?>" method="GET">
        <div class="report-head">
            <div class="form-group col-xs-2">
                <label class="col-sm-12">公司</label>
                <div class="col-sm-12">
                    <select class="form-control" name="brand" id="brand_change">
                        <?php 
                        foreach ($selectCompany as $k => $v) {
                            if ($v->COMPANYID == $stallInfo->COMPANYID) {
                                echo '<option value="'.$v->COMPANYID.' selected="selected">'.$v->COMPANYNAME.'</option>';
                                $aLinkCompany = $v;
                            }
                            else{
                                echo '<option value="'.$v->COMPANYID.'">'.$v->COMPANYNAME.'</option>';
                            }
                        }
                         ?>
                    </select>
                </div>
            </div>

            <?php 
                if ($stallCompany->ADMINID == 1) {
                    echo '<div class="form-group col-xs-2"><label class="col-sm-12">事业部</label><div class="col-sm-12"><select class="form-control" name="company" id ="fengongsi" >';
                    foreach ($selectCompany2 as $k => $v) {
                        if ($v->COMPANYID == $stallInfo->COMPANYID) {
                            echo '<option value="'.$v->COMPANYID.' selected="selected">'.$v->COMPANYNAME.'</option>';
                        }
                        else{
                            echo '<option value="'.$v->COMPANYID.'">'.$v->COMPANYNAME.'</option>';
                        }
                    }
                    echo '</select></div></div>';
                }
            ?>
                

            <div class="form-group col-xs-2">
                <label class="col-sm-12">门店</label>
                <div class="col-sm-12">
                    <select class="form-control" name="storeid" id="storeid">
                    <?php 
                        if ($stallCompany->ADMINID == 1) {
                            echo '<option value="*">所有门店</option>';
                            foreach ($selectStore as $key => $v) {  
                                if ($v->STOREID == $stallInfo->STOREID) {
                                    echo '<option value="'.$v->STOREID.' selected="selected">'.$v->STORENAME.'</option>';
                                    $aLinkStore = $v;
                                }
                                else{
                                    echo '<option value="'.$v->STOREID.'">'.$v->STORENAME.'</option>';
                                }
                            }
                        }
                        else{
                            echo '<option value="'.$stallStore->STOREID.'">'.$stallStore->STORENAME.'</option>';
                        }
                    ?>
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