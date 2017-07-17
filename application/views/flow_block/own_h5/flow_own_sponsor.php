<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/6
 * Time: 16:28
 */
?>
<div class="myfq">
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
            if (isset($query)) {
                $id = 1;
                $str_approve ="";
                foreach ($query as $key => $value) {
                    switch ($value->is_approve) {
                        case 0:
                            $str_approve = "待审核";
                            break;

                        case 1:
                            $str_approve = "已通过";
                            break;

                        case 2:
                            $str_approve = "已拒绝";
                            break;
                        case 3:
                            $str_approve = "已撤销";
                            break;
                        default:
                            $str_approve = "";
                            break;
                    }

                    $store = explode('@',$info[$value->luf_id]['value'][7]);//门店名称
                    echo '<a href="'.site_url('flow_own_h5/own_flowstep/'.$value->luf_id).'" class="weui_media_box weui_media_appmsg">';
                    echo ' <div class="weui_media_hd">';
                    echo '<img class="weui_media_appmsg_thumb" src="'.base_url("").'/jslibs/content/images/headpor.jpg" alt="headpor">';
                    echo '</div>';
                    echo '<div class="weui_media_bd">';
                    echo '<div class="weui_media_desc weui_media_date">'.$value->luf_cdate.'</div>';
                    echo '<h4 class="weui_media_title">'.$value->flow_name.'</h4>';
                    echo '<span class="weui_media_desc weui_media_status">'.$str_approve.'</span>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>
    <!-- weui_panel begin -->
</div>
