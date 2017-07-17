<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 7:26
 */

?>
<div class="weui_tab myapproval">
    <!-- weui_navbar begin -->
    <div class="weui_navbar">
        <a href="#myApprovalTab1" class="weui_navbar_item weui_bar_item_on">待我审批(<span><?php echo $waitCount;?></span>)</a>
        <a href="#myApprovalTab12" class="weui_navbar_item">我已审批(<span><?php echo $throughCount;?></span>)</a>
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
                    <?php
                    if (isset($waitme)) {
                        foreach ($waitme as $key => $value) {
                            if($value->luf_flow == 1){
                                $value->luf_flow = '请假申请';
                            }else if($value->luf_flow == 2){
                                $value->luf_flow = '入职申请';
                            }else if($value->luf_flow == 3){
                                $value->luf_flow = '本店调动';
                            }else if($value->luf_flow == 4){
                                $value->luf_flow = '跨店调动';
                            }else if($value->luf_flow == 5){
                                $value->luf_flow = '重回公司';
                            }else if($value->luf_flow == 6){
                                $value->luf_flow = '离职申请';
                            }else if($value->luf_flow == 7){
                                $value->luf_flow = '薪资调整';
                            }else if($value->luf_flow == 12){
                                $value->luf_flow = '返充申请';
                            }else if($value->luf_flow == 13){
                                $value->luf_flow = '返销申请';
                            }else if($value->luf_flow == 14){
                                $value->luf_flow = '会员退卡';
                            }else if($value->luf_flow == 15){
                                $value->luf_flow = '会员卡补卡';
                            }else if($value->luf_flow == 18){
                                $value->luf_flow = '加班申请';
                            }
                            if($value->luf_is_approve == 0 || $value->luf_is_approve == 1 || $value->luf_is_approve == 4){
                                switch ($value->luf_is_approve) {
                                    case 0:
                                        $value->luf_is_approve = "待审核";
                                        $color='';
                                        break;

                                    case 1:
                                        $value->luf_is_approve = "审核中";
                                        $color='';
                                        break;

                                    case 4:
                                        $value->luf_is_approve = "已撤销";
                                        $color='';
                                        break;

                                    default:
                                        break;
                                }
                                echo '<a href="'.site_url('flow_approval_h5/approval_flow/'.$value->luf_id).'" class="weui_media_box weui_media_appmsg"><div class="weui_media_hd"><img class="weui_media_appmsg_thumb" src="'.base_url().'/jslibs/content/images/headpor.jpg" alt="headpor" style="background-col:#c4e1fc"></div><div class="weui_media_bd"><div class="weui_media_desc weui_media_date">'.$value->luf_cdate.'</div><h4 class="weui_media_title">'.$value->luf_flow.'</h4><span>申请人：'.$value->luf_user_name.'</span><span class="weui_media_desc weui_media_status">'.$value->luf_is_approve.'</span></div></a>';
                            }
                            
                        }
                    }
                    ?>
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
                    <?php
                    if (isset($throughme)) {
                        foreach ($throughme as $key => $value) {
                            if($value->luf_flow == 1){
                                $value->luf_flow = '请假申请';
                            }else if($value->luf_flow == 2){
                                $value->luf_flow = '入职申请';
                            }else if($value->luf_flow == 3){
                                $value->luf_flow = '本店调动';
                            }else if($value->luf_flow == 4){
                                $value->luf_flow = '跨店调动';
                            }else if($value->luf_flow == 5){
                                $value->luf_flow = '重回公司';
                            }else if($value->luf_flow == 6){
                                $value->luf_flow = '离职申请';
                            }else if($value->luf_flow == 7){
                                $value->luf_flow = '薪资调整';
                            }else if($value->luf_flow == 12){
                                $value->luf_flow = '返充申请';
                            }else if($value->luf_flow == 13){
                                $value->luf_flow = '返销申请';
                            }else if($value->luf_flow == 14){
                                $value->luf_flow = '会员退卡';
                            }else if($value->luf_flow == 15){
                                $value->luf_flow = '会员卡补卡';
                            }else if($value->luf_flow == 18){
                                $value->luf_flow = '加班申请';
                            }
                            if($value->luf_is_approve == 1 || $value->luf_is_approve == 2 || $value->luf_is_approve == 3){
                                switch ($value->luf_is_approve) {
                                    case 1:
                                        $value->luf_is_approve = "审核中";
                                        $color='';
                                        break;

                                    case 2:
                                        $value->luf_is_approve = "已通过";
                                        $color='';
                                        break;

                                    case 3:
                                        $value->luf_is_approve = "已拒绝";
                                        $color='';
                                        break;

                                    default:
                                        break;
                                }
                                echo '<a href="'.site_url('flow_approval_h5/approval_flow/'.$value->luf_id).'" class="weui_media_box weui_media_appmsg"><div class="weui_media_hd"><img class="weui_media_appmsg_thumb" src="'.base_url().'/jslibs/content/images/headpor.jpg" alt="headpor"></div><div class="weui_media_bd"><div class="weui_media_desc weui_media_date">'.$value->luf_cdate.'</div><h4 class="weui_media_title">'.$value->luf_flow.'</h4><span>申请人：'.$value->luf_user_name.'</span><span class="weui_media_desc weui_media_status">'.$value->luf_is_approve.'</span></div></a>';
                            }
                            
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- weui_panel begin -->
        </div>
    </div>
    <!-- weui_tab_bd end -->
</div>
