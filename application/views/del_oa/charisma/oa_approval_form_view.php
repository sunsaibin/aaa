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
        <form class="form-horizontal" id="formflow" method="POST" action="<?php echo site_url("del_oa/oa_user_unset?id=$_GET[id]");?>">
            <?php 
                if (isset($query)) {
                    foreach ($query as $key => $value) {
                        $htmlCode = $value->flowform_html;

                        if (isset($querydata)) {
                            foreach ($querydata as $key2 => $value2) {
                                $d_key = $value2->lfuff_key;
                                $d_key = strtoupper($d_key);
                                $d_value = $value2->lfuff_value;
                                $s_key = ' '.$d_key.'=';
                                $pos = strpos($s_key,'FORMFILE');
                                if ($pos) {
                                    $s_key2 = $d_key.'="img"'; //="img"
                                    $htmlCode = str_replace($s_key2, ' src="'.$d_value.'" ', $htmlCode);
                                }

                                $htmlCode = str_replace($s_key, 'readonly="readonly" value="'.$d_value.'" '.$s_key, $htmlCode);
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
      <?php if($queryflowstep->lufs_approval_jump == 0 && $queryflowstep->lufs_is_adopt== 0){ ?>
                  <button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;撤&nbsp;&nbsp;销&nbsp;&nbsp;申&nbsp;&nbsp;请&nbsp;</button>&nbsp;&nbsp;&nbsp;
      <?php } ?>
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


    $("#formflow textarea").each(function(){ 
        var tem = $(this).attr("value");
        if(typeof(tem)!="undefined")
        {
            $(this).html(tem);
        }
    });


    $('select').each(function(){
        var value = $(this).attr("value");
        if(value.indexOf('@') >=0){
             value = value.split('@');
             value = value[1];
        }
         var option = $("<option><option>")
             option.text(value);
             option.attr("selected","selected");
             $(this).append(option);
/*        $(this).find("option").each(function(){


        if(value == $(this).val()){
            alert($(this).val())
            $(this).attr("selected","selected");
        }
     });*/

    });



</script>