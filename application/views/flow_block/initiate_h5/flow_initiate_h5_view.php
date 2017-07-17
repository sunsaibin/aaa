<?php

//print_r($query);

$flowFormHtml = "";
$flowFormitems = "";
$flowformid = "";
$flowstepid = "5";
$flowid = "";
if (isset($query)) {
    foreach ($query as $key => $value) {
        $flowFormHtml .= $value->flowform_h5;
        $flowFormitems .= $value->flowform_formitems;
        $flowformid = $value->flowform_id;
        $flowstepid = $value->flowstep_id;
        $flowid = $value->ff_flow;
    }
    $tem_itmes = explode(",",$flowFormitems);
    foreach ($tem_itmes as $key => $value) {
        $flowFormHtml = str_ireplace("#textarea_".$value."#", "", $flowFormHtml);
        $flowFormHtml = str_ireplace("#select_".$value."#", "", $flowFormHtml);

    }
}
?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_initiate_h5/save_form");?>">
    <?php echo $flowFormHtml; ?>
    <input type="hidden" name="flowid" value="<?php echo $flowid;?>">
    <input type="hidden" name="ffid" value="<?php echo $ff_id;?>">
    <input type="hidden" name="randid" value="<?php echo md5(uniqid("",true)); ?>">
    <input type="hidden" name="explain" value="">
</form>