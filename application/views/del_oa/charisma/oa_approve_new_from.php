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
        <?php  if($_SESSION['type'] == 2){
            $url = "http://op.faxianbook.com/dtmaster/house/storehouse/buy/".$user_flow->luf_randid;

            ?>    
        <iframe src=<?php echo $url; ?> frameborder="0" width="100%" height="50%"></iframe>
        <?php }?>
        <form class="form-horizontal" id="formflow" method="POST" action="<?php echo site_url("del_oa/oa_user_unset?id=$_GET[id]");?>">
            <?php 
                if (isset($query)) {
                    $is_readkey =!empty($approval_info->is_read)?explode(',', $approval_info->is_read):'';
                    $is_writekey =!empty($approval_info->is_write)?explode(',', $approval_info->is_write):'';
                    $is_reckey = !empty($approval_info->rec_key)?explode(',', $approval_info->rec_key):'';
                    foreach ($query as $key => $value) {
                        $htmlCode = $value->flowform_html;

                        if (isset($querydata)) {

                            foreach ($querydata as $key2 => $value2) {
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
                    <textarea class="form-control" rows="5" id="explain" name="explain" readonly="readonly" ><?php  echo $queryflowstep->lufs_explain; ?></textarea>

                </div>
            <div style="float:right;list-style-type:none;margin-right: 200px;">
                <div class="form-actions" >
<!--             <?php if(isset($queryflowstep) && $queryflowstep->fau_userid == $_SESSION["userinfo"]->staffId){ ?>   
                        <button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;通&nbsp;&nbsp;过&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" id="btn_refuse" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;拒&nbsp;&nbsp;绝&nbsp;&nbsp;&nbsp;</button>
                  <?php }?>   -->                  
                </div>
            </div>
            </div>
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
            $('#formflow').submit();
            return true;
    });

/*     $('#btn_refuse').click(function(){
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
    });*/

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