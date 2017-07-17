<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-flag"></i> 待审批列表</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            
            <div class="box-content">
                <div style="float:right;list-style-type:none;">
                    <div class="btn-group">
                    </div>
                </div>
                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" id="example">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>审核类型</th>
                        <th><?php if($type == 2){
                                echo "订单信息";
                            }else{
                                echo "备注";
                            }
                            ?></th>
                        <th>公司名称</th>
                        <th>门店名称</th>
                        <th>申请人</th>
                        <th>审核状态</th>
                        <th>申请日期</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($query)) {
                        //echo "<pre>";var_dump($query);die;
                        foreach ($query as $key => $value) {
                            //var_dump($value->luf_cdate);die;
                            switch ($value->luf_is_approve) {
                                case 0:
                                    $value->luf_is_approve = "待审核";
                                    $color='';
                                    break;

                                case 1:
                                    $value->luf_is_approve = "审核中";
                                    $color='';
                                    break;

                                case 2:
                                    $value->luf_is_approve = "已通过";
                                    $color = '';
                                    break;
                                case 3:
                                    $value->luf_is_approve = "已拒绝";
                                    $color='style="background-color:red;"';
                                    break;
                                case 4:
                                    $value->luf_is_approve = "已撤销";
                                    $color='';
                                    break;
                                default:
                                    break;
                            }
                            if($type==2)
                            {
                                $info = explode(',', $value->luf_remark);
                                $vremark = " 订单号: ".$info[0]." 门店 : ".$info[1];

                            }else
                            {
                                $vremark = '备注:';
                            }


                            echo '<tr>';
                            echo '<td class="center" style="width: 80px;">'.$value->luf_id.'</td>';
                            echo '<td class="center" style="width: 80px;">'.$value->flow_name.'</td>';
                            echo '<td class="center">&nbsp;'.$vremark.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_company_name.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_store_name.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_user_name.'</td>';
                            echo '<td class="center"><span class="label-success label label-default" '.$color.'>'.$value->luf_is_approve.'</span></td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_cdate.'</td>';
                            echo '<td class="center" style="width: 198px;">';
                            echo '<a class="btn btn-success" href="'.site_url("flow_approval/approval_flow/".$value->luf_id."/".$value->luf_is_approve).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看审批流程</a>';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" style="width:50px" href="'.site_url("flow_own/own_flow_print/".$value->luf_storeid.'/'.$value->luf_id.'/'.$value->flow_id).'">打印</a>';
                            echo '</td>';
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <!--/span-->

    <!-- end show model -->

</div><!--/row-->
<script type="application/javascript">

    $('#showDialogSaveBtn').click(function() {
        $('#showDialogSaveBtn').submit();
        return false;
    });

    $(document).ready(function(){
      $('#example').DataTable({
        "pagingType":   "full_numbers",
        "ordering": false,
        language: {
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ 项结果",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首页  ",
                "sPrevious": "上页  ",
                "sNext": "下页  ",
                "sLast": "末页"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }    
      });
    });

</script>