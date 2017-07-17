<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 15:18
 */

//print_r($query);

$flowFormHtml = "";
$flowFormItmes = "";
$ff_id = "-1";
if (isset($query)) {
    foreach ($query as $key => $value) {
        $flowFormHtml .= $value->flowform_html;
        $flowFormItmes .= $value->flowform_formitems;
        $ff_id = $value->ff_id;
    }

    $tem_itmes = explode(",",$flowFormItmes);
    foreach ($tem_itmes as $key => $value) {
        $flowFormHtml = str_ireplace("#textarea_".$value."#", "", $flowFormHtml);
        $flowFormHtml = str_ireplace("#select_".$value."#", "", $flowFormHtml);

    }

    foreach ($flow_user_data as $key => $value) {
        $flowFormHtml = str_ireplace($key.'=""', ' value="'.$value.'" ', $flowFormHtml);
    }
    $url = base_url();
    $flowFormHtml = str_ireplace("#php_echo_base_url#",$url,$flowFormHtml);
    $flowFormHtml = str_ireplace("#php_echo_searchname#",$seach_name,$flowFormHtml);
    //flw_storeid
}

?>
<form class="form-horizontal" enctype="multipart/form-data" id="formflow" method="POST" action="<?php echo site_url("flow_initiate/save_form");?>">
    <?php echo $flowFormHtml; ?>
    <input type="hidden" name="flowid" value="<?php echo $flowid;?>">
    <input type="hidden" name="ffid" value="<?php echo $ff_id;?>">
    <input type="hidden" name="randid" value="<?php echo md5(uniqid("",true)); ?>">
    <input type="hidden" name="explain" value="">
    <div style=" width:960px; text-align: center; padding-bottom: 20px;">
        <button type="button" id="btn_entry" class="btn btn-primary" onclick="dm_verify()">提交申请</button>
    </div>

</form>
