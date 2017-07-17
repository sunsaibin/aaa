<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 7:40
 */
?>
<!-- appli-content begin -->
<div class="appli-content">
    <!-- appli-main begin -->
    <div class="appli-main">
        <!-- appli-panel begin -->
        <div class="appli-panel">
            <h4>执行审批</h4>
            <div class="handle-info">
                <div class="input-group txtarea-group">
                    <label class="label-control">批注：</label>
                    <textarea class="txtarea-control" id="explain" name="explain"><?php  echo $userdata_flowstep_entity->lufs_explain; ?></textarea>
                </div>
            </div>
            <div class="handle-info">
                <!-- text-group begin -->
                <div class="form-actions" >
                <?php
                        if ($is_approve == "待审核" || $is_approve == "审核中") {
                            echo '<button type="button" id="btn_adopt" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;通&nbsp;&nbsp;过&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn_refuse" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;驳&nbsp;&nbsp;回&nbsp;&nbsp;&nbsp;</button>
                    <button type="button" id="btn_break" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;结&nbsp;&nbsp;束&nbsp;&nbsp;&nbsp;</button>
                    <button type="button" id="btn_return" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;返&nbsp;&nbsp;回&nbsp;&nbsp;&nbsp;</button>';
                        }else{
                            // 申请通过，拒绝，撤销等不能提交
                            echo '<button type="button" class="btn btn-success btn-lg">&nbsp;&nbsp;&nbsp;通&nbsp;&nbsp;过&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;驳&nbsp;&nbsp;回&nbsp;&nbsp;&nbsp;</button>
                    <button type="button" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;结&nbsp;&nbsp;束&nbsp;&nbsp;&nbsp;</button>
                    <button type="button" id="btn_return" class="btn btn-info-dianmei btn-lg">&nbsp;&nbsp;&nbsp;返&nbsp;&nbsp;回&nbsp;&nbsp;&nbsp;</button>';
                        }
                ?>
                    
                </div>
                <!-- text-group end -->
            </div>
        </div>
        <!-- appli-panel end -->
    </div>
    <!-- appli-main end -->

</div>
<!-- appli-content end -->
<input type="hidden" name="adopt" id="adopt" value="-1">
<input type="hidden" name="userflow_id" id="userflow_id" value="<?php echo $userflow_id;?>">
</form>

