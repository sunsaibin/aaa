<?php

//print_r($query);

$htmlCode = "";
$flowFormitems = "";
if (isset($flowform)) {
    foreach ($flowform as $key => $value) {
        $htmlCode .= $value->flowform_html;
        $flowFormitems .= $value->flowform_formitems;
    }
}
?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_initiate/save_form");?>">
    <?php
    if (isset($userdataflowform)) {
        // echo "<pre>";
        // var_dump($userdataflowform);die;
        foreach ($userdataflowform as $key => $value) {

            $d_key = $value->lfuff_key;
            $d_key = strtoupper($d_key);
            $d_value = $value->lfuff_value;
            $s_key_str = ' name="'.$d_key.'"';
            //echo $s_key_str.'|';
            $pos = strpos($s_key,'FORMFILE');
            if ($pos) {
                $htmlCode = str_ireplace($s_key_str, $s_key_str.' src="'.$d_value.'" ', $htmlCode);
            }
            $htmlCode = str_ireplace($s_key_str, $s_key_str.' readonly="readonly" value="'.$d_value.'" '.$s_key, $htmlCode);
            
            //textarea select_entryAppli_staff_educationalBackground radio_checked
            $htmlCode = str_ireplace("#textarea_".$d_key."#", $d_value, $htmlCode);
            $htmlCode = str_ireplace("#select_".$d_key."#", $d_value, $htmlCode);
        }
        $url = base_url();
        $htmlCode = str_ireplace("#php_echo_base_url#",$url,$htmlCode);
        $htmlCode = str_ireplace("#php_echo_searchname#",$seach_name,$htmlCode);
        print_r($htmlCode);
        //print_r($textareaCode);
    }
    // if(isset($performancetype)){
    //     foreach ($performancetype as $key => $value) {
    //         $d_key = $value->lfuff_key;
    //         $d_key = strtoupper($d_key);
    //         $d_value = $value->lfuff_value;
    //         $s_key_str = ' name="'.$d_key.'"';
    //         $pos = strpos($s_key,'FORMFILE');
    //         if ($pos) {
    //             $htmlCode = str_ireplace($s_key_str, $s_key_str.' src="'.$d_value.'" ', $htmlCode);
    //         }
    //         $htmlCode = str_ireplace($s_key_str, $s_key_str.' readonly="readonly"  value="'.$d_value.'" '.$s_key, $htmlCode);
    //     }
    // }
    ?>
    <div class="form-group col-xs-12">
        <label>批注：</label>
        <div>
            <textarea class="form-control" rows="5" id="explain" name="explain" readonly="readonly" ><?php  echo $userdataflowstep->lufs_explain; ?></textarea>

        </div>
        <div style="float:right;list-style-type:none;margin-right: 200px;">
            <div class="form-actions" >
                <?php 
                if($userdataflowstep->lufs_approval_jump == 0 && $userdataflowstep->lufs_is_adopt== 0){ ?>
                    <a  id="btn_repeal" class="btn btn-success btn-lg" href="<?php echo site_url('flow_own/own_flow_revocation/'.$userdata_flow_entity->luf_id);?>">&nbsp;撤&nbsp;&nbsp;销&nbsp;&nbsp;申&nbsp;&nbsp;请&nbsp;</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="adopt" id="adopt" value="-1">
</form>
