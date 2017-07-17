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
<?php if($_GET['type'] == 1){ ?>

   <div style="float:right;list-style-type:none;">
    <div class="btn-group">
        <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新建审批</a>
    </div>
</div>
<?php } ?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>编号</th>
        <th>流程名称</th>
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
switch ($value->is_approve) {
    case 0:
        $value->is_approve = "待审核";
        break;

    case 1:
        $value->is_approve = "已通过";
        break;

    case 2:
        $value->is_approve = "已拒绝";
        break;
     case 3:
        $value->is_approve = "已撤销";
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
                echo '<td class="center" style="width: 180px;">'.$value->luf_cdate.'</td>';
                echo '<td class="center" style="width: 80px;"><span class="label-success label label-default">'.$value->is_approve.'</span></td>';
                echo '<td class="center" style="width: 198px;">';
                echo '<a class="btn btn-success" href="'.site_url("del_oa/oa_user_flowstep?id=".
                    $value->luf_id).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
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
                        <form class="form-horizontal from-hr" method="POST" id="form1" action="<?php echo site_url("del_oa/oa_user_flowform");?>/">
                        <input type="hidden" name="id" value="1">
                            <!-- <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">流程：</label>
                                <div class="col-xs-8 ">
                                    <input type="email" class="form-control input-sm duiqi" id="name" name="name" placeholder="">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label></label>
                                <select class="form-control" name="flow_flowstep">
                                <?php 
          /*                      print_r($user_haveflows);
*/                                    if (isset($user_haveflows)) {
                                        foreach ($user_haveflows as $key => $value) {
                                            echo '<option value="'.$value->ff_id.'">'.$value->flow_name.'</option>';
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                            <input type="hidden" name="userid" value="<?php echo  $_GET["userid"]?>">
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

  $('#showDialogSaveBtn').click(function() {
        $('#form1').submit();
        return false;
    });
</script>