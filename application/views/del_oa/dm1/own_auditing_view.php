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
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_approval_h5/approval_form/".$user_flow_id);?>">
    <?php
    if (isset($userdata_flowform_entity)) {
        foreach ($userdata_flowform_entity as $key => $value) {
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
            $htmlCode = str_ireplace("#radio_".$d_key."#", $d_value, $htmlCode);
        }
        print_r($htmlCode);
    }
    ?>
    <div class="form-group col-xs-12" style="padding-top: 30px;">
        <label>批注：</label>
        <div>
            <textarea class="form-control" rows="5" id="explain" name="explain" ><?php  echo $queryflowstep->lufs_explain; ?></textarea>

        </div>
        <div style="float:right;list-style-type:none;margin-right: 200px;">
            <div class="form-actions" >
                <?php if($queryflowstep->lufs_approval_jump == 0 && $queryflowstep->lufs_is_adopt== 0){ ?>
                    <button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;通&nbsp;&nbsp;过&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn_refuse" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;拒&nbsp;&nbsp;绝&nbsp;&nbsp;&nbsp;</button>
                <?php } ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="adopt" id="adopt" value="-1">
</form>
