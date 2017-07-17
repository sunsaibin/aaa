<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/11/30
 * Time: 15:48
 */
?>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-flag"></i> 审批列表</h2>

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
                        <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新建审批</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" id="example">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>流程名称</th>
                        <th>公司名称</th>
                        <th>门店名称</th>
                        <th>申请人</th>
                        <th>申请日期</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($query)) {
                        $id = 1;
                        foreach ($query as $key => $value) {
                            switch ($value->luf_is_approve) {
                                case 0:
                                    $value->luf_is_approve = "待审核";
                                    break;

                                case 1:
                                    $value->luf_is_approve = "审核中";
                                    break;

                                case 2:
                                    $value->luf_is_approve = "已通过";
                                    break;
                                case 3:
                                    $value->luf_is_approve = "已拒绝";
                                    break;
                                case 4:
                                    $value->luf_is_approve = "已撤销";
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            $store = explode('@',$info[$value->luf_id]['value'][7]);//门店名称
                            echo '<tr>';
                            /* echo '<td class="center" style="width: 80px;">'.$value->luf_id.'</td>';*/
                            echo '<td class="center" style="width: 80px;">'.$id++.'</td>';
                            echo '<td class="center">'.$value->flow_name.' &nbsp;(批注:'.$value->luf_remark.' 姓名:'.$info[$value->luf_id]['value'][0].' 门店:'.$store[1].')</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_company_name.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_store_name.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_user_name.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->luf_cdate.'</td>';
                            echo '<td class="center" style="width: 80px;"><span class="label-success label label-default">'.$value->luf_is_approve.'</span></td>';
                            echo '<td class="center" style="width: 198px;">';
                            echo '<a class="btn btn-success" href="'.site_url("flow_own/own_flowstep/".
                                    $value->luf_id).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" style="width:100px" href="'.site_url("flow_own/own_flow_print/".$value->luf_storeid.'/'.$value->luf_id.'/'.$value->flow_id).'">打印</a>';
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                            //echo '<a class="btn btn-info" href="'.site_url("del_oa/flow_edit/".$value->flow_id).'"><i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>';
                            //echo '<a class="btn btn-danger" href="#"><i class="glyphicon glyphicon-trash icon-white"></i>Delete</a>';
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
<!-- show model 弹出窗口-->
<div class="modal fade" id="newFlowDialog" name="newFlowDialog" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">请选择相应的审批</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal from-hr" method="GET" id="form1" action="<?php echo site_url("/flow_initiate/select_initiate/");?>/">
                        <input type="hidden" name="id" value="1">
                        <div class="form-group">
                            <label></label>
                            <select class="form-control" name="flow_flowstep">
                                <?php
                                if (isset($user_haveflows)) {
                                    foreach ($user_haveflows as $key => $value) {
                                        echo '<option value="'.$value->ff_id.'">'.$value->flow_name.'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
                <button type="button" class="btn btn-xs btn-green" id="showDialogSaveBtn">选 择</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="application/javascript">
    function onClickPrint(luf_id) {
        var url ="<?php echo site_url('/flow_own/own_flow_print?storeid='.$storeid); ?>";
        window.location.href=url;
    }

    $('#showDialogSaveBtn').click(function() {
        $('#form1').submit();
        return false;
    });

    $(document).ready(function() {
      $('#example').dataTable( {
        "pagingType":   "full_numbers",
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
      } );
    } );
</script>
