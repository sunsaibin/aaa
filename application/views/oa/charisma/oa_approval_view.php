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
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>编号</th>
        <th>审核类型</th>
        <th><?php if($_SESSION["type"] == 2){
            echo "订单信息";
         }else{
             echo "备注";
         }

         ?></th> 
        <th>审核状态</th> 
        <th>申请日期</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        if (isset($query)) {
            foreach ($query as $key => $value) {

    switch ($value->is_approve) {
    case 0:
        $value->is_approve = "待审核";
        $color='';
        break;

    case 1:
        $value->is_approve = "已通过";
        $color='';
        break;

    case 2:
        $value->is_approve = "已拒绝";
        $color = 'style="background-color:red;"';
        break;
     case 3:
        $value->is_approve = "已撤销";
        $color='';
        break;         
    default:
        # code...
        break;
}
                if($_SESSION['type']==2)
                {
                    $info = explode(',', $value->luf_remark);
                    $vremark = " 订单号: ".$info[0]." 门店 : ".$info[1];

                }else
                { 
                    $vremark = '备注:';
                }


                echo '<tr>';
                echo '<td class="center" style="width: 80px;">'.$value->luf_id.'</td>';
/*                echo '<td class="center" style="width: 80px;">'.$value->ffs_step_order.'</td>';*/
                echo '<td class="center" style="width: 80px;">'.$value->flow_name.'</td>';
                echo '<td class="center">&nbsp;'.$vremark.'</td>';
                echo '<td class="center"><span class="label-success label label-default" '.$color.'>'.$value->is_approve.'</span></td>';
                echo '<td class="center" style="width: 180px;">'.$value->luf_cdate.'</td>';
            /*    echo '<td class="center" style="width: 80px;"><span class="label-success label label-default">'.($value->lufs_is_adopt==1?"批准通过":($value->lufs_is_adopt==2?"批准拒绝":"等待审核")).'</span></td>';*/
                echo '<td class="center" style="width: 198px;">';
                echo '<a class="btn btn-success" href="'.site_url("oa/oa_user_approval_form?id=".$value->luf_id)."&userid=".$_GET['userid']."&type=".$_SESSION['type'].'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看表单</a>';
                //echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                //echo '<a class="btn btn-info" href="'.site_url("oa/flow_edit/".$value->flow_id).'"><i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>';
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