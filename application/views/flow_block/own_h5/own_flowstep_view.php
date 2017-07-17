<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/15
 * Time: 14:51
 */
?>
<div class="weui_cells perhead_cells">
    <div class="weui_cell">
        <div class="weui_cell_hd">
            <img src="<?php echo base_url(); ?>/jslibs/content/images/headpor.jpg" alt="headpor">
        </div>
        <div class="weui_cell_bd weui_cell_primary">
            <div><?php echo $username;  ?></div>
            <span>申请中</span>
        </div>
    </div>
</div>


<div class="check-status">
    <div class="check-line">发起人：<span><?php echo $username; ?></span></div>
    <?php
    foreach($flowstep_data as $key => $value){
        $str_adopt = "等待审核";
        if($value->lufs_is_adopt == "1"){
            $str_adopt = "同意";
        }
        else if($value->lufs_is_adopt == "2"){
            $str_adopt = "拒绝";
        }
        else if($value->lufs_is_adopt == "3"){
            $str_adopt = "结束";
        }
        echo '<div class="weui-row weui-no-gutter">';
        echo '  <div class="weui-col-80">门店审核人：<span>'.$value->fa_name .'</span></div>';
        echo '  <div class="weui-col-20">'.$str_adopt.'</div>';
        echo '</div>';
    }
    ?>
    <div class="weui-row weui-no-gutter">
        <div class="weui-col-80"><a href="<?php echo site_url("/flow_own_h5/own_flowform/".$user_flow_id); ?>">查看详情</a></div>
    </div>
    <div class="weui_cells_title">备注</div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <textarea class="weui_textarea" placeholder="请输入备注(选填)" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="check-line check-none">等待经理审核</div>
</div>
