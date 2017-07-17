<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 6:55
 */
?>
<!-- appli-content begin -->
<div class="appli-content">
    <!-- appli-main begin -->
    <div class="appli-main">
        <!-- appli-panel begin -->
        <div class="appli-panel">
            <h4>操作信息</h4>
            <div class="handle-info">
                <!-- text-group begin -->
                <div class="input-group">
                    <label class="label-control">操作时间：</label>
                    <input type="text" class="fm-control" id="applytime" name="applytime" value="<?php echo date("Y-m-d H:i:s", time());?>" readonly="true">
                </div>
                <!-- text-group end -->
                <!-- text-group begin -->
                <div class="input-group">
                    <label class="label-control">操作员工：</label>
                    <input type="text" class="fm-control" id="applyuser" name="applyuser" value="<?php echo $stallInfo->username;?>" readonly="true">
                    <input type="hidden" id="applystate" name="applystate" value="0" >
                </div>
            </div>
        </div>
        <!-- appli-panel end -->
    </div>
    <!-- appli-main end -->

</div>
<!-- appli-content end -->