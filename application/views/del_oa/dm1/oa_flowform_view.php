<?php

//print_r($query);

$flowFormHtml = "";
$ff_id = "-1";
if (isset($query)) {
    foreach ($query as $key => $value) {
        $flowFormHtml .= $value->flowform_html;
        $ff_id = $value->ff_id;
    }
}

?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_initiate/save_form");?>">
    <?php echo $flowFormHtml; ?>
    <input type="hidden" name="flowid" value="<?php echo $flowid;?>">
    <input type="hidden" name="ffid" value="<?php echo $ff_id;?>">
    <input type="hidden" name="randid" value="<?php echo md5(uniqid("",true)); ?>">
    <input type="hidden" name="explain" value="">
</form>