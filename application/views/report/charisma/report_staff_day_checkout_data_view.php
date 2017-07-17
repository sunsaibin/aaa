 <?php 
 $e_legendArray = array();
 $e_chartData = array();
 ?>
          
        <!-- table-report1 begin -->
        <div class="tab-content report-content">
        <div role="tabpanel" class="tab-pane active" id="report-bar-table">
        <div align="center">
            <table>
                <tbody>
                    <tr>
                        <td>公司名称</td>
                        <td>门店名称</td>
                        <td>总收入</td>
                        <td>订单数</td>
                        <td>项目总数</td>
                        <td>员工名称</td>
                        <td>服务项目</td>
                        <td>金额</td>
                        <td>支付方式</td>
                        <td>日期</td>
                    </tr>
                    <?php 
                    if(!empty($orderTaill))
                    {
                       // print_r($orderTaill);
                        $frist = true;
                        foreach ($orderTaill as $key => $v) {

                            //绘制表格
                            echo '<td>'.$v->COMPANYNAME.'</td>';
                            echo '<td>'.$v->STORENAME.'</td>';
                            if ($frist) {
                                echo '<td rowspan='.count($orderTaill).'>'.$tatolMoney->totalprice.'</td>';
                                echo '<td rowspan='.count($orderTaill).'>'.$tatolCount->orderCount.'</td>';
                                echo '<td rowspan='.count($orderTaill).'>'.$tatolMoney->proCount.'</td>';
                                $frist = false;
                            }
                            
                            echo '<td>'.$v->staff_max_name.'</td>';
                            echo '<td>'.$v->PRODUCTNAME.'</td>';
                            echo '<td>'.$v->price.'</td>';
                            echo '<td>'.$v->PAYNAME.'</td>';
                            echo '<td>'.$tatolMoney->currDate.'</td>';
                            echo '</tr>';
                        }
                    }?>
                </tbody>
            </table>
         </div>
        <!-- table-report1 end -->
        <nav class="report-page">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">上一页</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li>
                    <a href="#" aria-label="Next">下一页</a>
                </li>
            </ul>
        </nav>
    </div>
        <input type="hidden" name="url" id="url" value="<?php echo  $url =  site_url('Report/post_curl?type=');?>">
        <!-- table-report1 end -->
    <div role="tabpanel" class="tab-pane" id="report-line-charts">
        <div id="ecBar" style="height:600px; width:900px"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="report-bar-charts">
        
        <div id="ecPie" style="height: 600px; width:900px;"></div>
    </div> 
</div>
