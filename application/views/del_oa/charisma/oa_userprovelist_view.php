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
        <th>步骤</th>
        <th>审核部门</th>
        <th>申请日期</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        if (isset($info)) {
            foreach ($info as $key => $value) {
                if($value->lufs_is_adopt==1)
                {
                    $color='';
                    $value->lufs_is_adopt="通过";
                }elseif($value->lufs_is_adopt==2)
                {
                    $value->lufs_is_adopt="拒绝";
                    $color = 'style="background-color:red;"';
                }elseif($value->lufs_is_adopt==0)
                {
                    $color='';
                    $value->lufs_is_adopt="待审核";
                }elseif($value->lufs_is_adopt==3)
                {
                    $color='style="background-color:red;"';
                    $value->lufs_is_adopt="已撤销";
                }


                echo '<tr>';
                echo '<td class="center" style="width: 80px;">'.$value->lufs_id.'</td>';
                echo '<td class="center" style="width: 80px;">'.$value->ffs_step_order.'</td>';
                echo '<td class="center">'.$value->fa_name.' &nbsp;(备注:'.$value->lufs_explain.')</td>';
                echo '<td class="center" style="width: 180px;">'.$value->lufs_cdate.'</td>';
                echo '<td class="center" style="width: 80px;"><span class="label-success label label-default"'.$color.'>'.$value->lufs_is_adopt.'</span></td>';
                echo '<td class="center" style="width: 198px;">';
/*                if($value->fau_userid == $_GET["userid"])
                {*/
                    echo '<a class="btn btn-success" href="'.site_url("del_oa/oa_list_form_approve?id=".
                    $value->lufs_id."&tid=".$value->lufs_userflow).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看表单</a>';  
/*                }else{
                     echo '<a class="btn btn-success" href=" # " onclick=zuzhichakan()><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看表单</a>';  
                }*/

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


  function zuzhichakan()
  {
    alert("没有权限查看")
  }
</script>