<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/10/31
 * Time: 16:45
 */
$orderno = "";
?>
<div class="bill-container">

    <!-- bill-query begin -->
    <div class="row bill-query">
        <form action="<?php site_url("/Report_store_old/store_day_bill"); ?>" method="get">
            <div class="col-xs-4">
                <div class="form-group">
                    <label>会员卡号查找</label>

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
            <li>
                <a href="<?php echo site_url("/Report_store_old/distribution"); ?>">订单(<span><?php echo count($reportOrderData); ?></span>)</a>
            </li>
            <li class="openCardBtn active"><a
                    href="<?php echo site_url("/Report_store_old/distribution_card"); ?>">卡类业务(<span><?php echo count($reportData); ?></span>)</a>
            </li>
        </ul>
        <!-- bill-item-class end -->
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>序号</th>
                <th>单号</th>
                <th>时间</th>
                <th>会员卡类型</th>
                <th>会员卡号</th>
                <th>销售金额</th>
                <th>未分配金额</th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($reportData as $key => $value) {
                $orderno = $value->card_id;
                $comm_amount = (floatval($value->amount) - floatval($value->total_commission_amount));
                if ($comm_amount < 0) {
                    $comm_amount = 0;
                }

                echo "<tr>";
                echo "<td>" . $value->id .'-'.$value->back. "</td>";
                if(intval($value->back)>0){
                    echo '<td><a href="javascript:alert(\'反冲单据不可以修改!\');">' . $value->id . '</a></td>';
                }
                else {
                    echo '<td><a href="#billsOrderset" class="orderno" oid="' . $value->oid . '" >' . $value->id . '</a></td>';
                }
                echo '<td>' . $value->create_date . '</td>';
                if(intval($value->back)>0){
                    echo '<td><a href="javascript:alert(\'反冲单据不可以修改!\');" style="color: red;">' . $value->operator_function . '-反冲单据</a></td>';
                }
                else{
                    echo '<td><a href="#billsOrderset" class="orderno" oid="' . $value->oid . '">' . $value->operator_function . '</a></td>';
                }
                echo '<td>' . $value->card_num . '</td>';
                echo '<td>' . $value->amount . '</td>';
                echo '<td>' . $comm_amount . '</td>';
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
            <span>序号:	<span id="see_order_id"></span></span>
            <button class="btn btn-default btn-sm" id="billsModifyOrder">修改单据</button>
            <button class="btn btn-default btn-sm" id="billaddServer" disabled="disabled">增加服务人员</button>
            <button class="btn btn-default btn-sm" id="billSaveOrder">保存修改</button>
        </div>
        <!-- bills-order-box end -->
        <!-- bills-order-payinfo begin -->
        <ul class="bills-order-payinfo">
            <li>卡类型: <span id="see_CARDNAME">综合七折卡</span></li>
            <li>会员卡号: <span id="see_CARDNUM">1234567890</span></li>
            <li>储值金额: <span id="see_CARDBALANCE">100</span></li>
            <li>欠款金额: <span id="see_liability">0</span></li>
        </ul>
        <!-- bills-order-payinfo end -->

        <div class="row bill-set-box">
            <div class="col-xs-5 bill-set-pay">
                <table class="table">
                    <thead>
                    <tr>
                        <th>支付方式</th>
                        <th>金额</th>
                        <th>项目</th>
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
                        <th>销售</th>
                        <th>工号</th>
                        <th>姓名</th>
                        <th>金额</th>
                    </tr>
                    </thead>
                    <tbody id="peopleLists">
                    <!-- <tr>
                        <td>第一销售</td>
                        <td>
                            <select id='div1' class="form-control" disabled="disabled">
                              <option>01234</option>
                              <option>01234</option>
                              <option>01234</option>
                            </select>
                        </td>
                        <td>张三</td>
                        <td>&yen;&nbsp;<input type="text" class="form-control" value="1000.00" disabled="disabled"></td>
                    </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- bills-order-set end -->

</div>
<script type="text/javascript">
    var data_staff = '<?php print_r(json_encode($storesData)); ?>';
    var data_staffs_obj = eval("(" + data_staff + ")");
    console.log(data_staffs_obj);

    $(function () {

        /*
         *  请求
         */
        function queryOrderDetail(oid) {
            $("#see_order_id").text(oid);

            $.post('<?php echo site_url("Report_store_old/query_card_distribution/".$storeid); ?>', {"oid": oid},
                function (data) {
                    console.log(data); //  2pm
                    var tem_obj = data;//eval("(" + data+ ")");

                    if(tem_obj.code != "000"){
                        alert(tem_obj.message);
                        return;
                    }

                    $("#paytypeTable").children("tr").remove();

                    for (var i=0; i<tem_obj.items.length;i++) {
                        var forObj = tem_obj.items[i];
                        var tr = $("<tr></tr>");
                        var td1 = $("<td></td>");
                        var td2 = $('<td>&yen;&nbsp;<input type="text" class="form-control" value="' + forObj.amount + '" disabled="disabled"  nonupdate="true"></td>');
                        var td3 = $('<td><input type="text" class="form-control" disabled="disabled"  nonupdate="true" value="'+ forObj.operator_function + '"></td>');

                        var select1 = $('<select class="form-control" disabled="disabled" id="update_new_paytype"></select>');

                        var optionArray = new Array();
                        optionArray["4"] = "银行卡POS支付"
                        optionArray["5"] = "现金";

                        if (optionArray.hasOwnProperty(forObj.paytype_id)) {
                            for (var prop_j in optionArray) {
                                if (optionArray.hasOwnProperty(prop_j)) {
                                    var t_key_j = prop_j;
                                    var t_value_j = optionArray[prop_j];

                                    var tem_option = $('<option value="' + t_key_j + '">' + t_value_j + '</option>');
                                    if (forObj.paytype_id == t_key_j ){
                                        tem_option = $('<option value="' + t_key_j + '" selected>' + t_value_j + '</option>');
                                    }

                                    select1.append(tem_option);
                                }
                            }
                        }else{
                            var tem_option = $('<option value="' + forObj.paytype_id + '" selected>' + forObj.paytype_name + '</option>');
                            console.info("selected:tem_option:"+tem_option+ " v:"+t_value_j);
                            select1.append(tem_option);
                        }

                        $("#see_order_payname").text(forObj.paytype_name);
                        $("#see_order_money").text(forObj.amount);
                        $("#see_order_opid").text(forObj.id);
                        $("#see_CARDNAME").text(forObj.CARDNAME);
                        $("#see_CARDNUM").text(forObj.CARDNUM);
                        $("#see_CARDBALANCE").text(forObj.CARDBALANCE);
                        $("#see_liability").text(forObj.liability);

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
                , "json");

            //销售人员
            $.post('<?php echo site_url("Report_store_old/query_distribution/".$storeid); ?>', {"oid": oid},
                function (data) {
                    if(data.code != "000"){
                        alert(data.message);
                        return;
                    }

                    var delTagJson = new Array(); // $("#see_order_id"
                    var tem_obj_items = data.items;
                    $("#peopleLists").children('tr').remove();


                    for (var i = tem_obj_items.length - 1; i >= 0; i--) {
                        var for_item = tem_obj_items[i];
                        var tr = $("<tr></tr>");
                        var td1 = $('<td onclick="del_remove_server(this);">第' + chinanum(i + 1) + "销售</td>");
                        var td2 = $("<td></td>");
                        var td3 = $("<td></td>");
                        var td3select = $('<select class="form-control" disabled="disabled" id="update_new_state"></select>');
                        td3.append(td3select);

                        selectedOption = false;
                        for (var tem_foritem in data_staffs_obj) {
                            if (data_staffs_obj.hasOwnProperty(tem_foritem)) {
                                var tem_obj = data_staffs_obj[tem_foritem];

                                var tem_option = $('<option value="' + tem_obj.STAFFID + '">' +tem_obj.STAFFNUMBER+" - "+ tem_obj.STAFFNAME + '</option>');
                                if (for_item.staff_id == tem_obj.STAFFID) {
                                    selectedOption = true;
                                    tem_option = $('<option value="' + tem_obj.STAFFID + '" selected="selected">' + tem_obj.STAFFNAME + '</option>');
                                }
                                td3select.append(tem_option);
                            }
                        }

                        if(selectedOption == false){
                            tem_option = $('<option value="0" selected="selected">未分配</option>');
                            td3select.prepend(tem_option);
                        }


                        var td4 = $('<td>&yen;&nbsp;</td>');
                        var td_input = $('<input type="text" class="form-control" value="' + for_item.performance_amount + '" disabled="disabled">');
                        td4.append(td_input);
                        tr.append(td1);
                        tr.append(td2);
                        tr.append(td3);
                        tr.append(td4);
                        if ($("#peopleLists tr").length == 0) {
                            $("#peopleLists").append(tr);
                        } else {
                            $("#peopleLists tr:first-child").before(tr);
                        }
                        //console.log(for_item);
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
            $("#billsOrderset select,#billsOrderset input,#billaddServer").attr("disabled", false);
            $("input[nonupdate=true]").attr("disabled", true);
            //$("input['nonupdate'='true']").attr("disabled",true);
            //console.debug("1111");
            //console.debug($("input[nonupdate=true]").attr("disabled",true));
            //$("#billsModifyOrder").attr("disabled",true);
        });

        //增加服务人员
        $("#billaddServer").click(function () {
            var isDisabled = $("#billsOrderset select").attr("disabled");
            if (isDisabled) {
                return;
            }

            var tr = $("<tr></tr>");
            var td1 = $('<td onclick="del_remove_server(this);">第' + chinanum($("#peopleLists tr").length + 1) + "销售</td>");
            var td2 = $("<td></td>");
            var td3 = $("<td></td>");
            var td3select = $('<select class="form-control"  id="update_new_state"></select>');
            td3.append(td3select);

            for (var tem_foritem in data_staffs_obj) {
                if (data_staffs_obj.hasOwnProperty(tem_foritem)) {
                    var tem_obj = data_staffs_obj[tem_foritem];
                    console.log(tem_obj);
                    var tem_option = $('<option value="' + tem_obj.STAFFID + '">' + tem_obj.STAFFNAME + '</option>');
                    td3select.append(tem_option);
                }
            }


            var td4 = $('<td>&yen;&nbsp;</td>');
            var td_input = $('<input type="text" class="form-control" value="0">');
            td4.append(td_input);
            tr.append(td1);
            tr.append(td2);
            tr.append(td3);
            tr.append(td4);
            if ($("#peopleLists tr").length == 0) {
                $("#peopleLists").append(tr);
            } else {
                $("#peopleLists tr:first-child").before(tr);
            }

            //var trModule = '<tr><td onclick="del_remove_server(this);">第'+chinanum($("#peopleLists tr").length+1)+'销售</td><td>1</td><td><select class="js-example-data-array"></select></td><td>¥&nbsp;<input type="text" class="form-control" value="3000.00"></td></tr>';
            // $("#peopleLists").append(trModule);

            //$("#billsModifyOrder").attr("disabled",true);
        });

        //保存修改
        $("#billSaveOrder").click(function () {
            $("#billsOrderset select,#billsOrderset input").attr("disabled", true);

            var jsonObj = new Object;
            jsonObj.opid = $("#see_order_id").text();
            jsonObj.paytype = $("#update_new_paytype").find("option:selected").val();
            jsonObj.paytype_name = $("#update_new_paytype").find("option:selected").text();
            jsonObj.items = new Array();

            //$("#peopleLists tr")[0]
            var trItems = $("#peopleLists tr");
            for (var i = 0; i < trItems.length; i++) {
                var t_obj = trItems.get(i);
                var t_select = $(t_obj).find("select");// option:selected
                // var t_select_option = t_select.options[t_select.selectedIndex];

                var t_input = $(t_obj).find("input");
                var c_object = new Object;
                c_object.staffid = t_select.find("option:selected").val();
                c_object.staffname = t_select.find("option:selected").text();
                c_object.amount = t_input.val();

                jsonObj.items.push(c_object);
            }

            //保存更新部分
            //ddd
            $.post('<?php echo site_url("Report_store_old/update_store_staff_card/".$storeid); ?>', {"data":JSON.stringify(jsonObj) },
                function (data) {
                    console.log(data); //  2pm
                    var tem_obj = eval("(" + data+ ")");
                    if(tem_obj.code != "000"){
                        alert(tem_obj.message);
                        $("#billsOrderset select,#billsOrderset input").attr("disabled", false);
                        return;
                    }

                    alert(tem_obj.message);
                    window.location.href="<?php echo site_url("/Report_store_old/distribution_card");  ?>";
                }
            );
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

    function del_remove_server(obj) {
        var isDisabled = $("#billsOrderset select").attr("disabled");
        if (isDisabled) {
            return;
        }

        $(obj).parent().remove();

        $("#peopleLists tr").each(function (i) {
            //var title = $(this).text();
            $(this).children(":first").text("第" + chinanum(i + 1) + "销售");
            //alert($(this).text());
        });
        /*var len = $("#peopleLists tr").length;*/
    }

    function chinanum(num) {
        var china = new Array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        var arr = new Array();
        var english = num + "";//.split("");
        for (var i = 0; i < english.length; i++) {
            arr[i] = china[parseInt(english[i])];
        }
        return arr.join("");
    }

    function DX(n) {
        if (!/^(0|[1-9]\d*)(\.\d+)?$/.test(n))
            return "数据非法";
        var unit = "千百拾亿千百拾万千百拾元角分", str = "";
        n += "00";
        var p = n.indexOf('.');
        if (p >= 0)
            n = n.substring(0, p) + n.substr(p + 1, 2);
        unit = unit.substr(unit.length - n.length);
        for (var i = 0; i < n.length; i++)
            str += '零壹贰叁肆伍陆柒捌玖'.charAt(n.charAt(i)) + unit.charAt(i);
        return str.replace(/零(千|百|拾|角)/g, "零").replace(/(零)+/g, "零").replace(/零(万|亿|元)/g, "$1").replace(/(亿)万|壹(拾)/g, "$1$2").replace(/^元零?|零分/g, "").replace(/元$/g, "元整");
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
