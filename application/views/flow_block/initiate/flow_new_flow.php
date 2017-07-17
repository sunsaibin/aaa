<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/6
 * Time: 13:00
 */
?>

<div class="approval">
    <!-- approval-top begin -->
    <div class="weui-row weui-no-gutter approval-top">
        <a href="<?php echo site_url("flow_own_h5/own_approval"); ?>" class="weui-col-50">
            <figure>
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon01.png" alt="approval">
                <figcaption>待我审批</figcaption>
            </figure>
        </a>
        <a href="<?php echo site_url("flow_own_h5/own_flow"); ?>" class="weui-col-50">
            <figure>
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon02.png" alt="approval">
                <figcaption>我发起的</figcaption>
            </figure>
        </a>
    </div>
    <!-- approval-top end -->

    <!-- weui_grids begin -->
    <div class="weui_grids">
        <a href="<?php echo site_url("flow_initiate/initiate_h5/1"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon03.png" alt="approval">
            </div>
            <p class="weui_grid_label">入职申请</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon04.png" alt="approval">
            </div>
            <p class="weui_grid_label">离职申请</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon05.png" alt="approval">
            </div>
            <p class="weui_grid_label">重回公司</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon06.png" alt="approval">
            </div>
            <p class="weui_grid_label">本店调动</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon07.png" alt="approval">
            </div>
            <p class="weui_grid_label">跨店调动</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon08.png" alt="approval">
            </div>
            <p class="weui_grid_label">员工派遣</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon09.png" alt="approval">
            </div>
            <p class="weui_grid_label">薪资调整</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon10.png" alt="approval">
            </div>
            <p class="weui_grid_label">员工罚款</p>
        </a>
        <a href="<?php echo site_url("flow_initiate/initiate_h5/2"); ?>" class="weui_grid js_grid" data-id="button">
            <div class="weui_grid_icon">
                <img src="<?php echo base_url("");?>/jslibs/content/images/approval-icon11.png" alt="approval">
            </div>
            <p class="weui_grid_label">请假</p>
        </a>
    </div>
    <!-- weui_grids end -->
</div>
