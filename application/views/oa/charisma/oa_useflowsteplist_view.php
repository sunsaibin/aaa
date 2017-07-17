<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-flag"></i> 审批步骤</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>

    <div class="box-content">
    <div style="float:right;list-style-type:none;">
<!--         <div class="btn-group">
    <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新增流程</a>
</div> -->
    </div>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>编号</th>
        <th>审批</th>
        <th>审批人</th>
        <th>审批日期</th>
        <th>批注</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        if (isset($query)) {
            foreach ($query as $key => $value) {
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
                    $color='';
                    $value->lufs_is_adopt="已撤销";
                }
                echo '<tr>';
                echo '<td class="center" style="width: 80px;">'.$value->lufs_id.'</td>';
                echo '<td class="center">'.$value->fa_name.'</td>';
                echo '<td class="center">'.$value->fau_user_name.'</td>';
                echo '<td class="center" style="width: 190px;">'.$value->lufs_cdate.'</td>';
                echo '<td class="center">'.$value->lufs_explain.'</td>';
                echo '<td class="center" style="width: 80px;"><span class="label-success label label-default" '.$color.'>'.$value->lufs_is_adopt.'</span></td>';
                echo '<td class="center" style="width: 198px;">';
                echo '<a class="btn btn-success" href="'.site_url("oa/oa_list_form?id=".$value->lufs_id."&tid=".$value->lufs_userflow).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看表单</a>';
                //echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                //echo '<a class="btn btn-info" href="'.site_url("flow_block/flow_edit/".$value->lufs_id).'"><i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>';
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
                    <h4 class="modal-title" id="gridSystemModalLabel">新增流程</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form class="form-horizontal" id="newFlow" action="<?php echo site_url("form/form/from/tem");?>">
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">流程名称：</label>
                                <div class="col-xs-8 ">
                                    <input type="email" class="form-control input-sm duiqi" id="name" name="name" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company" class="col-xs-3 control-label">所属公司</label>
                                <div class="col-xs-8 ">
                                    <input type="" class="form-control input-sm duiqi" id="company" name="company" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sOrd" class="col-xs-3 control-label">备注：</label>
                                <div class="col-xs-8">
                                    <textarea id="remarks" name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sKnot" class="col-xs-3 control-label">是否激活使用：</label>
                                <div class="switch switch-large">
                                    <input type="checkbox" checked />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
                    <button type="button" class="btn btn-xs btn-green" id="showDialogSaveBtn">保 存</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<script type="application/javascript">   

  $('#showDialogSaveBtn').click(function() {
        
        //var jsonuserinfo = $('#newFlow').serializeArray();  
        //var jsonFormData = //JSON.stringify(jsonuserinfo);
        // alert(jsonFormData);  
        var formData = $('#newFlow').serialize();
        $.post("flow_add_form",formData,
            function(data){
                //$('#msg').html("please enter the email!");
                var obj = JSON.parse(data);
                if (obj.status == 0) {
                    alert(obj.status);
                }
                else if (obj.message != "") {
                    alert(obj.message);
                };
                //$('#msg').html(data);
        },"text") .complete(function() { 
            $('#newFlowDialog').modal('hide');
        });//这里返回的类型有：json,html,xml,text
        
        return false;
    });
</script>