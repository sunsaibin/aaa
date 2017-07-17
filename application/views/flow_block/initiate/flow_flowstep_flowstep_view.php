
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-flag"></i> 流程列表</h2>

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
                        <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新增</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>上一步</th>
                    <th>下一步</th>
                    <th>排序号</th>
                    <th>创建日期</th>
                    <th>是否激活</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    if (isset($query)) {
                        foreach ($query as $key => $value) {
                            echo '<tr>';
                            echo '<td class="center" style="width: 80px;">'.$value->ffs_id.'</td>';
                            echo '<td class="center">'.$value->ffs_step_pre.'</td>';
                            echo '<td class="center">'.$value->ffs_step_next.'</td>';
                            echo '<td class="center">'.$value->ffs_step_order.'</td>';
                            echo '<td class="center" style="width: 180px;">'.$value->ffs_cdate.'</td>';
                            echo '<td class="center" style="width: 80px;"><span class="label-success label label-default">激活</span></td>';
                            echo '<td class="center" style="width: 368px;">';
                             echo '<a class="btn btn-success" href="'.site_url("flow_block/flow_trigger/".$value->ffs_id).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>触发条件</a>';
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo '<a class="btn btn-success" href="'.site_url("flow_block/flow_carry/".$value->ffs_step_pre).'"><i class="glyphicon glyphicon-zoom-in icon-white"></i>执行管理</a>';
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo '<a class="btn btn-info" href="'.site_url("flow_block/flow_edit/".$value->ffs_id).'"><i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>';
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
</div>
    <!-- end show model -->
    <!-- /.modal -->