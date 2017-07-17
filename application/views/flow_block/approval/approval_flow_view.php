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
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_approval/approval_form/".$userdata_flow_entity->luf_id);?>">
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

            $htmlCode = str_ireplace($s_key_str, $s_key_str.' value="'.$d_value.'" '.$s_key, $htmlCode);
            $htmlCode = str_ireplace("#textarea_".$d_key."#", $d_value, $htmlCode);
            $htmlCode = str_ireplace("#select_".$d_key."#", $d_value, $htmlCode);
            $htmlCode = str_ireplace("#radio_".$d_key."#", $d_value, $htmlCode);
        }
        $url = base_url();
        $htmlCode = str_ireplace("#php_echo_base_url#",$url,$htmlCode);
        $htmlCode = str_ireplace("#php_echo_searchname#",$seach_name,$htmlCode);
        print_r($htmlCode);
    }

    if(isset($applyCardData)){
        //var_dump($applyCardData);die;
        foreach ($applyCardData as $key1 => $value1) {
            $c_key = strtoupper($key1);
            $c_key_str = ' name="'.$c_key.'"';
            $htmlCode = str_ireplace($c_key_str, $c_key_str.' value="'.$value1.'" ', $htmlCode);

            $htmlCode = str_ireplace("#textarea_".$c_key."#", $value1, $htmlCode);
        }
        print_r($htmlCode);
    }

?>
