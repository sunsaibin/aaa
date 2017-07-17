<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/13
 * Time: 18:12
 */
?>
<div class="weui_tab myapproval">
    <!-- weui_navbar begin -->
    <div class="weui_navbar">
        <a href="#myApprovalTab1" class="weui_navbar_item weui_bar_item_on">待我审批(<span>2</span>)</a>
        <a href="#myApprovalTab12" class="weui_navbar_item">我已审批(<span>2</span>)</a>
    </div>
    <!-- weui_navbar end -->
    <!-- weui_tab_bd begin -->
    <div class="weui_tab_bd">
        <div id="myApprovalTab1" class="weui_tab_bd_item weui_tab_bd_item_active">
            <!-- search-box begin -->
            <div class="search-box">
                <input class="weui_input" type="text" placeholder="搜索申请人工号、姓名或手机">
                <button type="button">搜索</button>
            </div>
            <!-- search-box end -->

            <!-- weui_panel begin -->
            <div class="weui_panel weui_panel_access">
                <div class="weui_panel_bd">
                    <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb" src="../content/images/headpor.jpg" alt="headpor">
                        </div>
                        <div class="weui_media_bd">
                            <div class="weui_media_desc weui_media_date">2016-11-13 15:00</div>
                            <h4 class="weui_media_title">刘杰的本店调动申请</h4>
                            <span class="weui_media_desc weui_media_status">待审批</span>
                        </div>
                    </a>
                    <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb"  src="../content/images/headpor.jpg" alt="headpor">
                        </div>
                        <div class="weui_media_bd">
                            <div class="weui_media_desc weui_media_date">2016-11-13 15:00</div>
                            <h4 class="weui_media_title">刘杰的请假单</h4>
                            <span class="weui_media_desc weui_media_status">待审批</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- weui_panel begin -->
        </div>
        <div id="myApprovalTab12" class="weui_tab_bd_item">
            <!-- search-box begin -->
            <div class="search-box">
                <input class="weui_input" type="text" placeholder="搜索申请人工号、姓名或手机">
                <button type="button">搜索</button>
            </div>
            <!-- search-box end -->

            <!-- weui_panel begin -->
            <div class="weui_panel weui_panel_access">
                <div class="weui_panel_bd">
                    <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb" src="../content/images/headpor.jpg" alt="headpor">
                        </div>
                        <div class="weui_media_bd">
                            <div class="weui_media_desc weui_media_data">2016-11-13 15:00</div>
                            <h4 class="weui_media_title">刘杰的本店调动申请</h4>
                            <span class="weui_media_desc">审批完成(同意)</span>
                        </div>
                    </a>
                    <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb"  src="../content/images/headpor.jpg" alt="headpor">
                        </div>
                        <div class="weui_media_bd">
                            <div class="weui_media_desc weui_media_data">2016-11-13 15:00</div>
                            <h4 class="weui_media_title">刘杰的请假单</h4>
                            <span class="weui_media_desc">审批完成(驳回)</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- weui_panel begin -->
        </div>
    </div>
    <!-- weui_tab_bd end -->
</div>
<script src="<?php echo base_url();?>/content/js/jquery-2.1.4.js"></script>
<script src="../content/js/jquery-weui.js"></script>
<script src="../content/js/checkflow.js"></script>
