<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-flag"></i> 审批表</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>

    <div class="box-content">
        <!-- <div style="float:right;list-style-type:none;">
            <div class="btn-group">
                <a class="btn btn-default" data-toggle="modal" data-target="#newFlowDialog"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;新建审批</a>
            </div>
        </div> -->
        <div class="container-fluid">
        <?php  if($type == 2){
            $url = "http://op.faxianbook.com/dtmaster/house/storehouse/buy/".$user_flow->luf_randid;
        ?>
        <iframe src=<?php echo $url; ?> frameborder="0" width="100%" height="50%"></iframe>
        <?php }?>
        <form class="form-horizontal" id="formflow" method="POST" action="<?php echo site_url("del_oa/oa_auditing_form?id=$_GET[id]");?>">
            <?php 
                if (isset($query)) {
                    $is_readkey =!empty($querydata->is_read)?explode(',', $querydata->is_read):'';
                    $is_writekey =!empty($querydata->is_write)?explode(',', $querydata->is_write):'';
                    $is_reckey = !empty($querydata->rec_key)?explode(',', $querydata->rec_key):'';
                   
                    foreach ($query as $key => $value) {
                        $htmlCode = $value->flowform_html;
                        if (isset($allkey)) {
                            foreach ($allkey as $key2 => $value2) {
                                $d_key = $value2->lfuff_key;
                                $d_key = strtoupper($d_key);
                                $d_value = $value2->lfuff_value;
                                $s_key = ' '.$d_key.'=';

                                if(in_array($value2->lfuff_key,$is_readkey) && $is_readkey)
                                {
                                    $htmlCode = str_replace($s_key, 'readonly="readonly" value="'.$d_value.'" '.$s_key, $htmlCode);
                                }elseif(in_array($value2->lfuff_key, $is_writekey) && $is_writekey)
                                {
                                    $htmlCode = str_replace($s_key, 'value="'.$d_value.'" '.$s_key, $htmlCode);
                                }elseif(in_array($value2->lfuff_key, $is_reckey) && $is_reckey)
                                {
                                    $htmlCode = str_replace($s_key, 'hid="yes" value=""'.$s_key, $htmlCode);
                                }else{
                                    $htmlCode = str_replace($s_key, 'readonly="readonly" value="'.$d_value.'" '.$s_key, $htmlCode);
                                }
                              
                            }

                        }

                        echo $htmlCode;
                    }
                }   
            ?>
            <div class="form-group col-xs-12">
                <label>批注：</label>
                <div>
                    <textarea class="form-control" rows="5" id="explain" name="explain"></textarea>
                </div>
            </div>
            <div style="float:right;list-style-type:none;margin-right: 32px;">
                <div class="form-actions" >
            <?php if(isset($queryflowstep) && $queryflowstep->fau_userid == $_SESSION["userid"]){ ?>        
                  <button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;通&nbsp;&nbsp;过&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
                  <button type="button" id="btn_refuse" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;拒&nbsp;&nbsp;绝&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
            <?php } ?>
            <input type="hidden" name="adopt" id="adopt" value="0">
            <input type="hidden" name="setid"  value="<?php echo $_GET["id"] ?>">

<!--             <?php 
    if (isset($queryflowstep)) {
        foreach ($queryflowstep as $key => $value) {
            echo '<input type="hidden" name="approval" value="'.$value->ffs_approval.'">';
            echo '<input type="hidden" name="step_pre" value="'.$value->ffs_step_pre.'">';
            echo '<input type="hidden" name="step_next" value="'.$value->ffs_step_next.'">';
            echo '<input type="hidden" name="userflowid" value="2">';
            echo '<input type="hidden" name="flowstepid" id="flowstepid" value="'.$value->ffs_id.'">';
            echo '<input type="hidden" name="sequence" id="sequence" value="'.$value->ffs_step_order.'">';
            break;
        }
    }
?> -->
        </form>
        </div>
    </div>

    
    </div>
    </div>
    <!--/span-->
    
    <!-- end show model -->

    </div><!--/row-->
<script type="application/javascript">   

$('select').attr("disabled","desabled");

    $('#btn_adopt').click(function(){
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            $("#adopt").val("1");
            $('#formflow').submit();
            return true;
        }else{
            alert("批注不能为空");
            return false;
        }
    });

     $('#btn_refuse').click(function(){
        var str_tem = $("#explain").val();
        str_tem = str_tem.replace(' ','');
        if(str_tem.length > 0){
            $("#adopt").val("2");
            $('#formflow').submit();
            return true;
        }else{
            alert("批注不能为空");
            return false;
        }
    });

    $("#formflow textarea").each(function(){ 
        var tem = $(this).attr("value");
        if(typeof(tem)!="undefined")
        {
            $(this).html(tem);
        }
    });

    $("#formflow").find("input,select").each(function(){
        var hid = $(this).attr("hid");
        if(hid == "yes")
        {
          $(this).closest(".form-group").hide();
        // $(this).parents('.form-group').hide();
        }
    });

</script>