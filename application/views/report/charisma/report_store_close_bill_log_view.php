<div class="bill-container">

		<!-- bill-query begin -->
		<div class="row bill-query">
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>公司</label>
			    <select class="form-control">
                <?php
                    if ($stallCompany) {
                        echo '<option>'.$stallCompany->COMPANYNAME.'</option>';
                    }
                ?>
                </select>
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>门店</label>
			    <select class="form-control" name="storeid">
                <?php
                    //print_r($stallStore);
                    foreach ($selectStore as $key => $value) {
                        if ($stallStore->STOREID == $value->STOREID) {
                             echo '<option value="'.$value->STOREID.'" selected=selected>'.$value->STORENAME.'</option>';
                        }
                        else{
                             echo '<option value="'.$value->STOREID.'">'.$value->STORENAME.'</option>';
                        }
                       
                    }
                ?>
                </select>
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
			  <div class="form-group">
			    <label>日期</label>
			    <input type="date" class="form-control" name="querydate" value="<?php echo $querydate; ?>">
			  </div>
			</div>
			<!-- col-xs-3 end -->
			<!-- col-xs-3 begin -->
			<div class="col-xs-3">
				<div class="form-group btn-form-group">
			    <button type="submit" class="btn btn-info">查询</button>
			  </div>
			</div>
			<!-- col-xs-3 end -->
		</div>
		<!-- bill-query end -->
		
		<!-- seal-handle begin -->
		<div class="row seal-handle">
			<a href="<?php echo site_url(); ?>/Report_store_old/close_bill" class="btn btn-default btn-sm btn-blue">营业汇总</a>
		</div>
		<!-- seal-handle end -->

		<!-- seal-handle begin -->
		<div class="seal-handle">
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th>编号</th>
						<th>门店编号</th>
						<th>门店名称</th>
						<th>封账日期</th>
						<th>用户编号</th>
						<th>操作人</th>
						<th>操作日期</th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($reportData as $key => $value) {
						echo '<tr>';
						echo '<td>'.$value->id.'</td>';
						echo '<td>'.$value->storeid.'</td>';
						echo '<td>'.$value->storename.'</td>';
						echo '<td>'.$value->time.'</td>';
						echo '<td>'.$value->operator.'</td>';
						echo '<td>'.$value->username.'</td>';
						echo '<td>'.$value->time.'</td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
		</div>
		<!-- seal-handle end -->

	</div>