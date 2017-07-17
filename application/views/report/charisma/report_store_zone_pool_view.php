 <?php
    $aLinkCompany = $stallCompany;
    $aLinkStore = $stallStore;
 ?>
 <div class="container-fluid report">
        <!-- report-head begin -->
        <form action="<?php echo  $roleurl =  site_url("Report_store_old/report_zone/");?>" method="GET">
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
            <div class="form-group col-xs-2">
                <label class="col-sm-12">开始日期</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="date_start" value="<?php if($_GET['date_start']){echo $_GET['date_start'];}?>"/>
                </div>
            </div>
              
            <div class="form-group col-xs-2">
                <label class="col-sm-12">结束时间</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="date_end" value="<?php if($_GET['date_end']){echo $_GET['date_end'];}?>"/>
                </div>
            </div>  

            <div class="form-group col-xs-2">
                <label class="col-sm-12">显示类型</label>
                <div class="col-sm-12">
                    <select class="form-control" name="infotype">
                        <option value="1" <?php if($_GET['infotype']=='1'){echo "selected='selected'";} ?>>按门时间排序</option>
                        <option value="2" <?php if($_GET['infotype']=='2'){echo "selected='selected'";} ?>>按门店编号排序</option>
                        <option value="3" <?php if($_GET['infotype']=='3'){echo "selected='selected'";} ?>>按总金额排序</option>
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
            </ul>
        </div> 