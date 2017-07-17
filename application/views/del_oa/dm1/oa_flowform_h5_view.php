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
}
?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("del_oa/oa_form");?>">
    <?php echo $flowFormHtml; ?>
    <input type="hidden" name="adopt" id="adopt" value="0">
    <input type="hidden" name="usertype" value="1">
    <input type="hidden" name="company" value="1">
    <input type="hidden" name="flowid" value="<?php echo $flowid;?>">
    <input type="hidden" name="flowstepid" value="<?php echo $flowstepid; ?>">
    <input type="hidden" name="flowformid" value="<?php echo $flowformid; ?>">
    <input type="hidden" name="formitems" value="<?php echo $flowFormitems; ?>">
    <input type="hidden" name="userid" value="<?php echo $_SESSION["userid"];?>">
    <input type="hidden" name="randid" id="randid" value="<?php echo md5(uniqid("",true)); ?>">
    <input type="hidden" name="url" id="url" value="<?php echo  $url =  site_url('Oa/staff_ajax?type=');?>">
    <input type="hidden" name="roleurl " id="roleurl" value="<?php echo  $roleurl =  site_url('Flow_block/role_url?type=');?>">
</form>