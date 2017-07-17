<?php

//print_r($query);

$htmlCode = "";
$flowFormitems = "";
if (isset($flowform)) {
    foreach ($flowform as $key => $value) {
        $htmlCode .= $value->flowform_h5;
        $flowFormitems .= $value->flowform_formitems;
    }
}
?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_initiate/save_form");?>">
    <?php
    if (isset($userdataflowform)) {
        foreach ($userdataflowform as $key => $value) {
            $d_key = $value->lfuff_key;
            $d_key = strtoupper($d_key);
            $d_value = $value->lfuff_value;
            $s_key_str = ' name="'.$d_key.'"';
            $pos = strpos($s_key,'FORMFILE');
            if ($pos) {
                $htmlCode = str_ireplace($s_key_str, $s_key_str.' src="'.$d_value.'" ', $htmlCode);
            }
            $htmlCode = str_ireplace($s_key_str, $s_key_str.' readonly="readonly"  value="'.$d_value.'" '.$s_key, $htmlCode);

            $htmlCode = str_ireplace("#textarea_".$d_key."#", $d_value, $htmlCode);
            $htmlCode = str_ireplace("#select_".$d_key."#", $d_value, $htmlCode);
        }
        print_r($htmlCode);
    }
    ?>
    <div class="form-group col-xs-12" style="padding-top: 30px;">
        <label>批注：</label>
        <div>
            <textarea class="form-control" rows="5" id="explain" name="explain" readonly="readonly" ><?php  echo $queryflowstep->lufs_explain; ?></textarea>

        </div>
        <div style="float:right;list-style-type:none;margin-right: 200px;">
            <div class="form-actions" >
                <?php if($queryflowstep->lufs_approval_jump == 0 && $queryflowstep->lufs_is_adopt== 0){ ?>
                    <a  id="btn_adopt" class="btn btn-success btn-lg" href="<?php echo site_url("del_oa/oa_user_unset?id=$_GET[id]");?>">&nbsp;撤&nbsp;&nbsp;销&nbsp;&nbsp;申&nbsp;&nbsp;请&nbsp;</a>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
