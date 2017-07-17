<div class="container-fluid report">
        <!-- report-head begin -->
<form action="<?php echo  $roleurl =  site_url("Report/achievement_report");?>" method="GET">
        <div class="report-head">
            <div class="form-group col-xs-1">
                <label class="col-sm-12">公司</label>
                <div class="col-sm-12">
                    <select class="form-control" name="brand" id="brand_change">
                            <?php 
                            foreach ($brand_id as $k => $v) {
                            
                             ?>
                             <option value="<?php echo $v->COMPANYID; ?>" <?php if($v->COMPANYID == $_GET['brand']){ echo "selected='selected'";} ?>> <?php echo $v->COMPANYNAME; ?></option>
                             <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-1">
                <label class="col-sm-12">事业部</label>
                <div class="col-sm-12">
                    <select class="form-control" name="company" id ="fengongsi">
                    <?php 
                    foreach ($fen_company as $k => $v) {
                    
                     ?>
                     <option value="<?php echo $v->COMPANYID; ?>" <?php if($v->COMPANYID==4){echo "selected='selected'";}?>> <?php echo $v->COMPANYNAME; ?></option>
                     <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-xs-2">
                <label class="col-sm-12">区域</label>
                <div class="col-sm-12">
                    <select class="form-control" attr="storeinfo" name="city" id="quyu">
                    <option value="*">*</option>
                    <?php 
                    foreach ($quyu as $k => $v) {
                     ?>
                     <option value="<?php echo $v->COMPANYID; ?>"<?php if($v->COMPANYID == $_GET['city']){ echo "selected='selected'";} ?>> <?php echo $v->COMPANYNAME; ?></option>
                     <?php } ?>  
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-2">
                <label class="col-sm-12">门店</label>
                <div class="col-sm-12">
                    <select class="form-control" name="storeid" id="storeid">
                    <option value="*">*</option>
                    <?php foreach ($storeid as $key => $v) {  
                     ?>
                     <option value="<?php echo $v->STOREID; ?>" <?php if($v->STOREID == $_GET['storeid']){ echo "selected='selected'";} ?>><?php echo $v->STORENAME; ?></option>
                     <?php } ?>
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
                        <option value="2" <?php if($_GET['infotype']=='2'){echo "selected='selected'";} ?>>按员工编号排序</option>
                        <option value="3" <?php if($_GET['infotype']=='3'){echo "selected='selected'";} ?>>按总金额排序</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-2">
                <label class="col-sm-12">员工编号</label>
                <div class="col-sm-12">
                    <input class="form-control" name="staffnumber" value="<?php if($_GET['staffnumber']){echo $_GET['staffnumber'];}?>"/>
                </div>
            </div>
            <div class="form-group col-xs-1">
                <label class="col-sm-12">&nbsp;</label>
                <div class="col-sm-12">
                    <button class="btn btn-info">查询</button>
                </div>
            </div>
        </div>
    </form>
        <!-- report-head end -->
        <!-- table-emp-per begin -->
        <div class="table-emp-per">
            <table class="table-striped">
                <thead>
                    <tr>
                        <th>员工</th>
                        <th colspan="2">总业绩</th>
                        <th colspan="2">现金消费</th>
                        <th colspan="2">指纹消费</th>
                        <th colspan="2">便利通消费</th>
                        <th colspan="2">工会卡消费</th>
                        <th colspan="2">支付宝消费</th>
                        <th colspan="2">微信消费</th>
                        <th colspan="2">销卡消费</th>
                        <th>疗程消费</th>
                        <th colspan="2">收购卡消费</th>
                        <th colspan="2">纸卡消费</th>
                        <th colspan="2">原价卡消费</th>
                        <th colspan="2">经理签单</th>
                        <th>积分消费</th>
                        <th colspan="7">售产品</th>
                        <th>售卡合计</th>
                        <th>开卡</th>
                        <th>充值</th>
                        <th>还款</th>
                        <th>折扣转卡</th>
                        <th>收购转卡</th>
                        <th>竞争转卡</th>
                        <th>并卡</th>
                        <th>退卡</th>
                    </tr>
                    <tr>
                        <th>张三</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>xxx</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>大项</th>
                        <th>小项</th>
                        <th>xxx</th>
                        <th>现金</th>
                        <th>指纹</th>
                        <th>便利通</th>
                        <th>工会卡</th>
                        <th>支付宝</th>
                        <th>销卡</th>
                        <th>合计</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                        <th>xxx</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>业绩</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                    </tr>
                    <tr>
                        <td>提成</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                        <td>***</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <nav class="report-page">
            <ul class="pagination">
                <li>
                    <!-- <a href="#" aria-label="Previous"> -->
<!--                         <span aria-hidden="true">上一页</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">下一页</a> -->
                    <?php echo $page; ?>
                </li>
            </ul>
        </nav>


        
        <!-- table-emp-per end -->
    </div>
        <script>

    var brandurl = "<?php  echo site_url('Report/ajax_query');?>";
/*    $("#brand_change").change(function(){
        var company =$(this).children('option:selected').val();
        $("#fengongsi").empty(); //清楚option
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":company,"type":"company"},
            dataType:'json',
            async: false,
            success:function(msg){
               if(msg)
                {
                   $("#fengongsi").empty(); //清楚option 
                }                
                $.each(msg,function(index,info){
                    var COMPANYID = info.COMPANYID;
                    var COMPANYNAME =info.COMPANYNAME;
                    var option =$("<option></option>");
                    option.val(COMPANYID);
                    option.text(COMPANYNAME);
                    $("#fengongsi").append(option);  
                });             
            }
        });
    });*/

    $("#fengongsi").change(function(){
        var fen_company =$(this).children('option:selected').val();
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":fen_company,"type":"company"},
            dataType:'json',
            async: false,
            success:function(msg){
               if(msg == false)
                {
                   $("#quyu").empty(); //清楚option 
                   $("#storeid").empty(); //清楚option 
                }

                $.each(msg,function(index,info){
                    var COMPANYID = info.COMPANYID;
                    var COMPANYNAME =info.COMPANYNAME;
                    var option =$("<option></option>");
                    option.val(COMPANYID);
                    option.text(COMPANYNAME);
                    $("#quyu").append(option);  
                });             
            }
        });
    });


        $("#quyu").change(function(){
            var fen_company =$(this).children('option:selected').val();
        $.ajax({
            type:'POST',
            url: brandurl,
            data:{"company":fen_company,"type":"store"},
            dataType:'json',
            async: false,
            success:function(msg){
                $("#storeid").empty(); //清楚option 
                $.each(msg,function(index,info){
                    var STOREID = info.STOREID;
                    var STORENAME =info.STORENAME;
                    var option =$("<option></option>");
                    option.val(STOREID);
                    option.text(STORENAME);
                    $("#storeid").append(option); 
                });             
            }
        });
    });
















    $(":input").each(function(){ 
        var tem = $(this).attr("type");
        if(tem =="text")
        {
            $(this).click(function(){
                var start = {
                    format: 'YYYY/MM/DD hh:mm',
/*                    min: laydate.now(), //设定最小日期为当前日期*/
                    istime: true,
                    istoday: false,
                    choose: function(datas){
                    }
                }; 
 

                laydate(start);
            })
        }
    });

    </script>