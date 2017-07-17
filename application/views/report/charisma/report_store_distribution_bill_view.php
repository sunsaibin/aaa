<?php
$orderno = "";
//print_r($reportOrderData);
?>
<div class="bill-container">

    <!-- bill-query begin -->
    <div class="row bill-query">
        <form action="<?php site_url("/Report_store_old/store_day_bill"); ?>" method="get">
            <div class="col-xs-4">
                <div class="form-group">
                    <label>快速单号查找</label>

                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?php echo $seachkey;?>">
				      <span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
                            <img src="<?php echo base_url(); ?>/jslibs/content/images/searchIcon.png" alt="search">
                        </button>
				      </span>
                    </div>
                </div>
            </div>
        </form>
        <form action="<?php site_url("/Report_store_old/store_day_bill"); ?>" method="get">
            <div class="col-xs-4">
                <div class="form-group">
                    <label>员工工号查询</label>

                    <div class="input-group">
                        <input type="text" class="form-control" name="search2" value="<?php echo $seachkey2;?>">
				      <span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
                            <img src="<?php echo base_url(); ?>/jslibs/content/images/searchIcon.png" alt="search2">
                        </button>
				      </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- bill-query end -->
    <div class="row bill-query">
        <form action="<?php site_url("/Report_store_old/store_day_bill"); ?>" method="get">
            <!-- col-xs-3 begin -->
            <div class="col-xs-3">
                <div class="form-group">
                    <label>公司</label>
                    <select class="form-control">
                        <?php
                        if ($stallCompany) {
                            echo '<option>' . $stallCompany->COMPANYNAME . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- col-xs-3 end -->
            <!-- col-xs-3 begin -->
            <div class="col-xs-3">
                <div class="form-group">
                    <label>门店</label>
                    <select class="form-control" name="storeid">
                        <?php
                        //print_r($stallStore);
                        foreach ($selectStore as $key => $value) {
                            if ($stallStore->STOREID == $value->STOREID) {
                                echo '<option value="' . $value->STOREID . '" selected=selected>' . $value->STORENAME . '</option>';
                            } else {
                                echo '<option value="' . $value->STOREID . '">' . $value->STORENAME . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- col-xs-3 end -->
            <!-- col-xs-3 begin -->
            <div class="col-xs-3">
                <div class="form-group">
                    <label>日期</label>
                    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
                </div>
            </div>
            <!-- col-xs-3 end -->
            <!-- col-xs-3 begin -->
            <div class="col-xs-2">
                <div class="form-group btn-form-group">
                    <!-- <label>日期</label>
                    <input type="date" class="form-control"> -->
                    <button type="submit" class="btn btn-info">查询</button>
                </div>
            </div>
            <!-- col-xs-3 end -->
        </form>
    </div>
    <!-- bill-query end -->

    <!-- bill-handle begin -->
    <div class="bill-handle">
        <!-- bill-item-class begin -->
        <ul class="bill-item-class">
            <li  class="openCardBtn active"><a href="<?php echo site_url("/Report_store_old/distribution");  ?>">订单(<span><?php echo count($reportOrderData); ?></span>)</a></li>
            <li><a href="<?php echo site_url("/Report_store_old/distribution_card");  ?>">卡类业务(<span><?php echo count($reportData); ?></span>)</a></li>
        </ul>
        <!-- bill-item-class end -->
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>序号</th>
                <th>单号</th>
                <th>服务时间</th>
                <th>项目名称</th>
                <th>支付类型</th>
                <th>支付状态</th>
                <th>销售金额</th>
                <th>大工</th>
                <th>小工</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $tem_i = 0;
            foreach ($reportOrderData as $key => $value) {
                $tem_i++;

                //1,已经下单，2，已经付款，待发货 3，已经发货，4,发货完成或服务完成，待评价，5，已经完成 6:取消订单
                $pay_state_title = "未完成".$pay_state;
                $pay_state = $value->PAYSTATUS;
                if(intval($pay_state) == 1){
                    $pay_state_title="已经下单";
                }
                else if(intval($pay_state) ==2){
                    $pay_state_title="已经付款，待发货";
                }
                else if(intval($pay_state) == 3){
                    $pay_state_title="已经发货";
                }
                else if(intval($pay_state) == 4){
                    $pay_state_title="发货完成或服务完成，待评价";
                }
                else if(intval($pay_state) == 5){
                    $pay_state_title="已经完成";
                }
                else if(intval($pay_state) == 6){
                    $pay_state_title="取消订单";
                }

                if(intval($value->is_delete) == 1){
                    $pay_state_title="已删除";
                }


                echo "<tr>";
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'" delete="'.$value->is_delete.'">' . $value->store_order_number." - ".$value->HANDNUMBER . "</a></td>";
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->OPID . " - " . $value->ORDERNUMBER . "</a></td>";
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->server_time . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->PRODUCTNAME . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->pay_name . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $pay_state_title . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->real_amount . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' . $value->staff_name . '</a></td>';
                echo '<td><a href="#billsOrderset" class="orderno" oid="'.$value->OPID.'">' .(isset($value->staff_min_name)? $value->staff_min_name:"无") . '</a></td>';
                echo "</tr>";
            }


            if (count($reportData) == 0) {
                echo '<tr><td colspan="6"><center>没有记录</center></td></tr>';
            }

            ?>

            </tbody>
        </table>
    </div>
    <!-- bill-handle end -->

    <!-- bills-order-set begin -->
    <div class="bills-order-set" id="billsOrderset">
        <!-- bills-order-box begin -->
        <div class="bills-order-box">
            <span>订单号:	<span id="see_order_id"></span></span>
            <button class="btn btn-default btn-sm" id="billsModifyOrder">修改单据</button>
            <button class="btn btn-default btn-sm" id="billSaveOrder">保存修改</button>
        </div>
        <!-- bills-order-box end -->
        <!-- bills-order-payinfo begin -->
        <ul class="bills-order-payinfo">
            <li>单号: <span id="see_order_opid"></span></li>
            <li>支付类型: <span id="see_order_payname"></span></li>
            <li>订单金额: <span id="see_order_money"></span></li>
        </ul>
        <!-- bills-order-payinfo end -->

        <div class="row bill-set-box">
            <div class="col-xs-5 bill-set-pay">
                <table class="table">
                    <thead>
                    <tr>
                        <th>支付方式</th>
                        <th>金额</th>
                        <th>项目名称</th>
                    </tr>
                    </thead>
                    <tbody id="paytypeTable">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-7 bill-set-server">
                <table class="table">
                    <thead>
                    <tr>
                        <th>工种</th>
                        <th>工号</th>
                        <th>姓名</th>
                    </tr>
                    </thead>
                    <tbody id="peopleLists">
                    <tr>
                        <td>大工</td>
                        <td id="work_max_number">0001</td>
                        <td>
                            <select id='work_max' class="form-control" disabled="disabled" onchange="onSelectMax();">
                              <option value="-1">无</option>
                                <?php
                                foreach ($staffList as $value){
                                    echo '<option value="'.$value->STAFFID.'" pnumber="'.$value->STAFFNUMBER.'">'.$value->STAFFNAME.'</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>小工</td>
                        <td id="work_min_number">0001</td>
                        <td>
                            <select id='work_min' class="form-control" disabled="disabled" onchange="onSelectMin();">
                                <option value="-1">无</option>
                                <?php
                                foreach ($staffList as $value){
                                    echo '<option value="'.$value->STAFFID.'" pnumber="'.$value->STAFFNUMBER.'">'.$value->STAFFNAME.'</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- bills-order-set end -->

</div>
<script type="text/javascript">
    $(function () {
        /*
         *  请求
         */
        function queryOrderDetail(oid) {
            $("#see_order_id").text(oid);
            $("#billsOrderset select,#billsOrderset input,#billaddServer").prop("disabled", true);
            $("input[nonupdate=true]").prop("disabled", false);

            $.post('<?php echo site_url("Report_store_old/query_distribution_order/".$storeid); ?>', {"oid": oid},
                function (data) {
                    console.log(data); //  2pm
                    //var tem_obj = eval("(" + data+ ")");

                    //$(".selector").find("option[text='pxx']").attr("selected",true);

                    var tem_obj_items = data.items;
                    console.log(tem_obj_items);
                    //$("#peopleLists").children('tr').remove();
                    $("#paytypeTable").children("tr").remove();

                    var orderPaytypeList = tem_obj_items;

                    for (var prop in orderPaytypeList) {
                        if (orderPaytypeList.hasOwnProperty(prop)) {
                            var t_key = prop;
                            var t_value = orderPaytypeList[prop];
                            //alert("prop: " + prop + " value: " + orderPaytypeList[prop]);

                            var tr = $("<tr></tr>");
                            var td1 = $("<td></td>");
                            var td2 = $('<td>&yen;&nbsp;<input type="text" class="form-control" value="' + t_value.real_amount + '" disabled="disabled"  nonupdate="true"></td>');
                            var td3 = $('<td><input type="text" class="form-control" disabled="disabled" value="'+t_value.PRODUCTNAME+'" nonupdate="true"></td>');

                            var select1 = $('<select class="form-control" disabled="disabled" id="update_new_paytype"></select>');

                            var optionArray = new Array();
                            optionArray["4"] = "银行卡POS支付"
                            optionArray["5"] = "现金";

                            if (optionArray.hasOwnProperty(t_value.paytype)) {
                                for (var prop_j in optionArray) {
                                    if (optionArray.hasOwnProperty(prop_j)) {
                                        var t_key_j = prop_j;
                                        var t_value_j = optionArray[prop_j];
                                        var tem_option = $('<option value="' + t_key_j + '">' + t_value_j + '</option>');

                                        if(t_value.paytype == t_key_j){
                                            var tem_option = $('<option value="' + t_key_j + '" selected>' + t_value_j + '</option>');
                                            $("#see_order_payname").text(t_value.pay_name);
                                            $("#see_order_money").text(t_value.real_amount);
                                            $("#see_order_opid").text(t_value.OPID);
                                            $("#see_order_opid").attr("isupdate",true);
                                        }
                                        select1.append(tem_option);
                                    }
                                }
                            }
                            else{
                                var tem_option = $('<option value="' + t_value.paytype + '" selected>' + t_value.pay_name + '</option>');
                                select1.append(tem_option);
                                $("#see_order_payname").text(t_value.pay_name);
                                $("#see_order_money").text(t_value.real_amount);
                                $("#see_order_opid").text(t_value.OPID);
                            }


                            td1.append(select1);

                            tr.append(td1);
                            tr.append(td2);
                            tr.append(td3);

                            if ($("#paytypeTable tr").length == 0) {
                                $("#paytypeTable").append(tr);
                            } else {
                                $("#paytypeTable tr:first-child").before(tr);
                            }
                        }
                    }


                    //人员
                    console.debug(data);
                    console.debug(data.workorder);
                    var tem_workorder = data.workorder;
                    for (var i=0;i<tem_workorder.length;i++){
                        var prop_work = tem_workorder[i];
                       // $("#work_max_number").find("option[value='5']").attr("selected",true);
                        $("#work_max").find("option[value="+prop_work.staff_id+"]").prop("selected",true);
                        $("#work_max_number").html(prop_work.staff_id);

                        if (prop_work.staff_min_id > 0) {
                            $("#work_min").find("option[value=" + prop_work.staff_min_id + "]").prop("selected", true);
                            $("#work_min_number").html(prop_work.staff_min_id);

//                            $("#work_min option").each(function(i,n){
//                                console.debug($(n).val());
//                                if($(n).val()==prop_work.staff_min_id)
//                                {
//                                    console.debug($(n).text());
//                                    $(n).prop("selected",true);
//                                }
//                            });
                        }
                        else{
                            $("#work_min").get(0).selectedIndex = 0;
                            $("#work_min_number").html('无');
                        }
                    }
                }
                , "json");
        }

        /*
         * 单击单号(如：601420160905006)，显示单号详情
         */
        $(".orderno").click(function (event) {
            $("#billsOrderset").show();
            var clickedNode = event.target;
            var NodeType = event.target.nodeName;
            console.log(event);
            console.log(NodeType);

            if (NodeType == "A") {
                //alert(clickedNode.getAttribute("oid"));
                var data = queryOrderDetail(clickedNode.getAttribute("oid"));
                return;
            }
            //
        });

        /*
         * 单击选择，如(收银（100）、积分消费（0）、充值（0）、反充（0）)的当前状态
         */
        $(".bill-item-class li").click(function () {
            $(this).addClass("active").siblings("li").removeClass("active");
            $("#billsOrderset").hide();
        });

        //修改单据
        $("#billsModifyOrder").click(function () {
            $("#billsOrderset select,#billsOrderset input,#billaddServer").prop("disabled", false);
            $("input[nonupdate=true]").prop("disabled", true);
            //$("input['nonupdate'='true']").prop("disabled",true);
            //console.debug("1111");
            //console.debug($("input[nonupdate=true]").prop("disabled",true));
            //$("#billsModifyOrder").attr("disabled",true);
        });

        //保存修改
        $("#billSaveOrder").click(function () {
            $("#billsOrderset select,#billsOrderset input").prop("disabled", true);

            if($("#see_order_opid").attr("isupdate")!="true"){
                console.log("isupdate is not true");
                //return;
            }

            $.post('<?php echo site_url("Report_store_old/update_order_payte/".$storeid); ?>', {"oid": $("#see_order_opid").text(),"paytype":$("#update_new_paytype").val(),"maxid": $("#work_max").val(),"minid": $("#work_min").val()},
                function (data) {
                    console.log(data); //  2pm
                    //var tem_obj = eval("(" + data+ ")");
                    alert(data.message);
                    window.location.href="<?php echo site_url("/Report_store_old/distribution");  ?>";
                }
             , "json");
        });

        /*
         *单据分析 操作
         */
        $("#btnAnalysis").click(function () {
            $("#btnSettle").removeClass("disabled");
            $("#sealDayAnalysis").slideDown();
            //$("#sealDayAnalysis").show();
        });
    });

    function  onSelectMax(){
        var t_selected = $('#work_max').val();
        $("#work_max").find("option[value="+t_selected+"]").prop("selected",true);

        //var t_selected_text = $("#work_max").find("option:selected").text();
        $("#work_max_number").html(t_selected);

    }

    function  onSelectMin(){
        var t_selected = $('#work_min').val();
        $("#work_min").find("option[value="+t_selected+"]").prop("selected",true);

        //var t_selected_text = $("#work_max").find("option:selected").text();
        $("#work_min_number").html(t_selected);

    }

</script>


<script type="text/javascript">
    var data = [{id: 0, text: 'enhancement'}, {id: 1, text: 'bug'}, {id: 2, text: 'duplicate'}, {
        id: 3,
        text: 'invalid'
    }, {id: 4, text: 'wontfix'}];
    var temobj = $(".js-example-data-array");
    if (temobj.hasOwnProperty("select2")) {
        temobj.select2({
            data: data
        })
    }
</script>
