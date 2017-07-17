<?php date_default_timezone_set('Asia/Shanghai'); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_store extends CI_Controller {

	public function index()
	{
		$this->load->model('report/store_report_model', 'store_report');
		$reportData = $this->store_report->get_store_day_total_money(1570,'2016-09-03');
		print_r($reportData);

		print_r("***********************");
		$reportData = $this->store_report->get_store_day_total_orderCount(1570,'2016-09-03');
		print_r($reportData);
		
		print_r("***********************");
		$reportData = $this->store_report->get_store_day_taill(1570,'2016-09-03');
		print_r($reportData);
	}

	//日统计
	public function store_day_report()
	{	
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_store($return["storeid"],$return["querydate"]);
		$return["reportData"]=$reportData;

		$this->load->view('viewheaders/charisma/header_print');
	    $this->load->view('report/charisma/report_store_day_checkout_data_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}


	//月统计
	public function store_month_report()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_store($return["storeid"],$return["querydate"]);
		$return["reportData"]=$reportData;

		$this->load->view('viewheaders/charisma/header_print');
	    //$this->load->view('report/charisma/report_store_day_bill_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}

	//
	public function store_day_checkout_from($storeid)
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');

	    $stallInfo = $this->user->dealUserUrl();
	    $dayData = $this->store_report->store_day_query($storeid);
	    if (isset($dayData) && count($dayData)>0) {
	    	echo '<script language="javascript" type="text/javascript">alert("今日已经结过帐!");window.location.href="'.site_url("/report_store/store_day_checkout").'";</script>';
	    }

	    $dayCheck = $this->store_report->store_day_checkout($storeid);
	    if ($dayCheck>-1) {
	    	echo '<script language="javascript" type="text/javascript">alert("创建结过帐成功!");window.location.href="'.site_url("/report_store/store_day_checkout").'";</script>';
	    }
	    else{
	    	echo '<script language="javascript" type="text/javascript">alert("创建结过帐失败!");window.location.href="'.site_url("/report_store/store_day_checkout").'";</script>';
	    	exit;
	    }
	}

	//日记账
	public function store_day_bill()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');

	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_store($return["storeid"], $return["querydate"]);
		$return["reportData"]=$reportData;
		$this->load->view('viewheaders/charisma/header');
	    $this->load->view('report/charisma/report_store_day_bill_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}

	//日记账打印
	public function store_day_bill_print()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');

	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_store($return["storeid"], $return["querydate"]);
		$return["reportData"]=$reportData;

//		print_r($return);
//		exit;


		$this->load->view('viewheaders/charisma/header_print');
	    $this->load->view('report/charisma/report_store_day_bill_print_view', $return);
	    $this->load->view('viewfeet/charisma/foot_print');
	}

	//日报表
	public function store_day_pool()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

	    $querydate = $this->input->get('querydate');
	   	if (!isset($querydate)) {
	   		$querydate = $this->input->post('querydate');
	   		if (!isset($querydate)) {
	   			$return["querydate"] = date("Y-m-01",time());
	   		}
	   	}
		$storeid = $this->input->get('storeid');
	   	if (!isset($storeid)) {
	   		$storeid = $this->input->post('storeid');
	   	}

		if (isset($storeid) && $storeid >0) {
			$return["storeWhere"] = " (".$storeid.") ";
		}

		$addkind = $this->input->get('addkind');
	   	if (!isset($storeid)) {
	   		$storeid = $this->input->post('addkind');
	   	}
		

		$reportData = $this->store_report->store_day_period_query_sum($return["storeWhere"], $return["querydate"], $return["queryenddate"],$addkind);
	    $return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header_chart');
	    $this->load->view('report/charisma/report_store_day_pool_view', $return);
	    $this->load->view('report/charisma/report_store_day_pool_data_view', $return);
	    $this->load->view('viewfeet/charisma/foot_chart');
	}

	//月报表
	public function store_month_pool()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

	    $querydate = $this->input->get('querydate');
	   	if (!isset($querydate)) {
	   		$querydate = $this->input->post('querydate');
	   		if (!isset($querydate)) {
	   			$return["querydate"] = date("Y-01-01",time());
	   		}
	   	}

	    $reportData = $this->store_report->store_month_period_query($return["storeWhere"], $return["querydate"], $return["queryenddate"]);
	    $return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header_chart');
	    $this->load->view('report/charisma/report_store_month_pool_data_view', $return);
	    $this->load->view('viewfeet/charisma/foot_chart');
	}


	//业绩分配
	public function distribution()
	{
		$this->load->model('user/User_model', 'user');
		$this->load->model('report/Store_distribution_model', 'store_distribution');
		$return = $this->user->seach_header();
		$seachkey = $this->input->post("search");
		if(!isset($seachkey)){
			$seachkey = $this->input->get("search");
		}

		$seachkey2 = $this->input->post("search2");
		if(!isset($seachkey2)){
			$seachkey2 = $this->input->get("search2");
		}

		$reportData = $this->store_distribution->query_card_divide($return["storeid"], $return["querydate"],$seachkey,$seachkey2);
		$reportOrderData = $this->store_distribution->query_order_paytype($return["storeid"], $return["querydate"],$seachkey,$seachkey2);
		$staffList = $this->store_distribution->query_store_staffs($return["storeid"]);

		$return["reportData"] = $reportData;
		$return["reportOrderData"] = $reportOrderData;
		$return["staffList"] = $staffList;
		$return["seachkey"] = $seachkey;
		$return["seachkey2"] = $seachkey2;

		$this->load->view('viewheaders/charisma/header');
	    $this->load->view('report/charisma/report_store_distribution_bill_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}

	public function distribution_card()
	{
		$this->load->model('user/User_model', 'user');
		$this->load->model('report/Store_distribution_model', 'store_distribution');
		$return = $this->user->seach_header();

		$seachkey = $this->input->post("search");
		if(!isset($seachkey)){
			$seachkey = $this->input->get("search");
		}

		$seachkey2 = $this->input->post("search2");
		if(!isset($seachkey2)){
			$seachkey2 = $this->input->get("search2");
		}

		$reportData = $this->store_distribution->query_card_divide($return["storeid"], $return["querydate"],$seachkey,$seachkey2);
		$reportOrderData = $this->store_distribution->query_order_paytype($return["storeid"], $return["querydate"],$seachkey,$seachkey2);
		$storesData = $this->store_distribution->query_store_staff($return["storeid"]);

		$return["reportData"] = $reportData;
		$return["reportOrderData"] = $reportOrderData;
		$return["storesData"] = $storesData;
		$return["seachkey"] = $seachkey;
		$return["seachkey2"] = $seachkey2;

		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_store_distribution_card_bill_view', $return);
		$this->load->view('viewfeet/charisma/foot');
	}

	public function query_distribution($storeid)
	{
		$this->load->model('report/Store_distribution_model', 'store_distribution');

		$oid = $this->input->post("oid");
		$card = $this->input->post("card");
		$reportData = $this->store_distribution->query_card_divide_detail($storeid,$oid,$card);
		$jsonReturn = array();
		$jsonReturn["code"] = "000";
		$jsonReturn["message"] = "";
		$jsonReturn["items"] = $reportData;
		print_r(json_encode($jsonReturn));
	}

	public function query_distribution_order($storeid)
	{
		$this->load->model('report/Store_distribution_model', 'store_distribution');

		$oid = $this->input->post("oid");
		$reportData = $this->store_distribution->query_order_divide_detail($storeid,$oid);
		$reportworkData = $this->store_distribution->query_order_workorder_detail($storeid,$oid);
		$jsonReturn = array();
		$jsonReturn["code"] = "000";
		$jsonReturn["message"] = "";
		$jsonReturn["items"] = $reportData;
		$jsonReturn["workorder"] = $reportworkData;
		print_r(json_encode($jsonReturn));
	}

	
	//封帐
	public function close_bill()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_store($return["storeid"],$return["querydate"]);
		$return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header');
	    $this->load->view('report/charisma/report_store_close_bill_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}

	//封账
	public function get_bill_check()
	{
		$this->load->model('report/store_report_model', 'store_report');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$reportData = $this->store_report->check_bill($return["storeid"],$return["querydate"]);
		print_r(json_encode($reportData));
		//check_bill
	}


	//封帐结算
	public function exec_close_bill()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

	    $dayData = $this->store_report->store_day_query($return["storeid"], $return["querydate"]);

	    if (count($dayData)<1) {

	    	if(strtotime(date("Y-m-d",strtotime()))>strtotime(date("Y-m-d",strtotime($return["querydate"])))){
	    		echo '<script language="javascript" type="text/javascript">alert("操作时间不能大于当前时间!");window.location.href="'.site_url("/report_store/close_bill_log").'";</script>';
	    		return;
	    	}

	    	$reportData = $this->store_report->bill_date_store($return["storeid"],$return["querydate"],$return["userid"]);
	    	$return["reportData"] = $reportData;

	    	if (count($reportData) >0) {
	    		echo '<script language="javascript" type="text/javascript">alert("'.$return["querydate"].', 封帐成功! 操作人:'.$return["username"].'");window.location.href="'.site_url("/report_store/close_bill_log").'";</script>';
	    		return;
	    	}
	    }
	    else{
	    	echo '<script language="javascript" type="text/javascript">alert("'.$return["querydate"].'已经封过帐! 不可以重复封帐!");window.location.href="'.site_url("/report_store/close_bill").'";</script>';
	    	return;
	    }

	    echo '<script language="javascript" type="text/javascript">alert("封帐失败! 请联系系统管理员!");window.location.href="'.site_url("/report_store/close_bill").'";</script>';
	}

	public function close_bill_log()
	{
		$this->load->model('report/store_report_model', 'store_report');
	    $this->load->model('user/User_model', 'user');
	    
	    $return = $this->user->seach_header();

		$reportData = $this->store_report->query_date_bill_store_log($return["storeid"],$return["querydate"]);
		$return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header');
	    $this->load->view('report/charisma/report_store_close_bill_log_view', $return);
	    $this->load->view('viewfeet/charisma/foot');
	}

	public function classify_performance()
	{
		$this->load->model('report/store_report_model', 'store_report');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$reportData = $this->store_report->query_classify_performance($return["storeid"],$return["querydate"], $return["queryenddate"]);
		$return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_classify_performance_view', $return);
		$this->load->view('viewfeet/charisma/foot');
	}

	public function  update_order_payte($storeid)
	{
		$this->load->model('report/Store_distribution_model', 'store_distribution');

		$oid = $this->input->post("oid");
		$paytype = $this->input->post("paytype");
		$maxid= $this->input->post("maxid");
		$minid= $this->input->post("minid");

		if(intval($storeid) < 1){
			$jsonReturn = array();
			$jsonReturn["code"] = "001";
			$jsonReturn["message"] = "参数错误!store不能为空!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		if(intval($oid) < 1){
			$jsonReturn = array();
			$jsonReturn["code"] = "002";
			$jsonReturn["message"] = "参数错误!OPID不能为空!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		if(intval($paytype) < 1){
			$jsonReturn = array();
			$jsonReturn["code"] = "003";
			$jsonReturn["message"] = "参数错误!PYTE不能为空!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		$is_close_bill = $this->store_distribution->query_store_close_bill($storeid,$oid);
		if(!isset($is_close_bill) || count($is_close_bill) > 0){
			$jsonReturn = array();
			$jsonReturn["code"] = "006";
			$jsonReturn["message"] = "门店已经封过账，不可以调整业绩，请填写申请单总部统一做调整！";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		//更新员工 maxid

		$this->store_distribution->update_orderwork_staff($storeid,$oid,$maxid,$minid);
		$reportData = $this->store_distribution->update_order_divide_detail($storeid,$oid,$paytype,$maxid,$minid);
		$jsonReturn = array();
		$jsonReturn["code"] = "000";
		$jsonReturn["message"] = "更新成功";
		$jsonReturn["data"] = $reportData;
		print_r(json_encode($jsonReturn));
	}

	public function  update_store_staff_card($storeid)
	{
		$this->load->model('report/Store_distribution_model', 'store_distribution');

		$data = $this->input->post("data");
		if(!isset($data)){
			$jsonReturn = array();
			$jsonReturn["code"] = "001";
			$jsonReturn["message"] = "参数错误!data不能为空!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		$objs = json_decode($data);
		$items = $objs->items;
		$accountid = $objs->opid ;
		$paytype = $objs->paytype ;
		$paytype_name = $objs->paytype_name ;

		//查询
		$accountObject = $this->store_distribution->query_fn_account($accountid);
		if(!isset($accountObject) || count($accountObject) < 1){
			$jsonReturn = array();
			$jsonReturn["code"] = "002";
			$jsonReturn["message"] = "参数错误!accountid不合法传入!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		$is_close_bill = $this->store_distribution->query_store_card_close_bill($storeid,$accountid);
		if(!isset($is_close_bill) || count($is_close_bill) > 0){
			$jsonReturn = array();
			$jsonReturn["code"] = "006";
			$jsonReturn["message"] = "门店已经封过账，不可以调整业绩，请填写申请单总部统一做调整！";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		if($paytype != $accountObject->paytype_id)
		{
			$sqlArray = array();
			$sqlArray["paytype_id"] = $paytype;
			$sqlArray["paytype_name"] = $paytype_name;

			$sqlWhereArray = array();
			$sqlWhereArray["id"] = $accountObject->id;
			$this->store_distribution->update_account_paytype($sqlArray,$sqlWhereArray);
		}

		//判断金额
		$total_amout = 0.0;
		foreach ($items as $index => $item) {
			$total_amout = $total_amout + floatval($item->amount);
		}

		if($total_amout > floatval($accountObject->amount))
		{
			$jsonReturn = array();
			$jsonReturn["code"] = "005";
			$jsonReturn["message"] = "操作失败! 分配金额不能超过".floatval($accountObject->amount)."元!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		//删除
		$this->store_distribution->remove_store_card_staff($storeid,$accountObject->id);

		foreach ($items as $index => $item) {
			$sqlArray = array();
			$sqlArray["staff_id"] = $item->staffid;
			$sqlArray["store_id"] = $accountObject->store_id;
			$sqlArray["company_id"] = $accountObject->company_id;
			$sqlArray["deduct_type"] = "1";
			$sqlArray["deduct_detailtype"] = "2";
			$sqlArray["deduct_source"] = $accountObject->operator_function;
			$sqlArray["order_id"] = "0";
			//$sqlArray["order_number"] = "0";
			$sqlArray["orderproduct_id"] = "0";
			$sqlArray["product_id"] = "0";
			$sqlArray["is_norm"] = "0";
			$sqlArray["account_id"] = $accountObject->id;
			$sqlArray["card_id"] = $accountObject->card_id;
			$sqlArray["card_number"] = $accountObject->CARDNUM;
			$sqlArray["total_performance"] =  $accountObject->amount;
			$sqlArray["performance_ratio"] = floatval($item->amount)/ floatval($accountObject->amount);
			$sqlArray["performance_amount"] = $item->amount;
			$sqlArray["staff_performance"] = "0";
			$sqlArray["staff_performance_ratio"] = "0";
			$sqlArray["commission_ratio"] = "0";
			$sqlArray["commission_amount"] = "0";
			$sqlArray["bonus_time"] = $accountObject->create_date;
			$sqlArray["bonus_year"] =  date("Y",strtotime($accountObject->create_date));
			$sqlArray["bonus_month"] = date("M",strtotime($accountObject->create_date));
			$sqlArray["bonus_day"] = date("D",strtotime($accountObject->create_date));
			$sqlArray["province"] = "0";
			$sqlArray["city"] = "0";
			//$sqlArray["district"] = "";
			//$sqlArray["memo"] = "";
			//$sqlArray["user_id"] = "";
			$sqlArray["pay_type"] = $accountObject->paytype_id;
			$sqlArray["allowance"] = "0";

			$this->store_distribution->add_store_card_staff($sqlArray);
		}

		$jsonReturn = array();
		$jsonReturn["code"] = "000";
		$jsonReturn["message"] = "操作成功!";
		$jsonReturn["data"] = $total_amout;
		print_r(json_encode($jsonReturn));
	}

	public function  query_card_distribution($storeid)
	{
		$this->load->model('report/Store_distribution_model', 'store_distribution');

		$accountid = $this->input->post("oid");
		if(!isset($accountid)){
			$jsonReturn = array();
			$jsonReturn["code"] = "001";
			$jsonReturn["message"] = "参数错误!data不能为空!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		$accountObject = $this->store_distribution->query_fn_accounts($accountid);
		if(!isset($accountObject) || count($accountObject) < 1){
			$jsonReturn = array();
			$jsonReturn["code"] = "002";
			$jsonReturn["message"] = "参数错误!accountid不合法传入!";
			$jsonReturn["items"] ="";
			print_r(json_encode($jsonReturn));
			return;
		}

		$jsonReturn = array();
		$jsonReturn["code"] = "000";
		$jsonReturn["message"] = "查询成功";
		$jsonReturn["items"] = $accountObject;
		print_r(json_encode($jsonReturn));
	}

	//分类业绩统计
	public function classify_pool()
	{
		$this->load->model('report/store_report_model', 'store_report');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$querydate = $this->input->get('querydate');
		if (!isset($querydate)) {
			$querydate = $this->input->post('querydate');
			if (!isset($querydate)) {
				$return["querydate"] = date("Y-m-01",time());
			}
		}

		$reportData = $this->store_report->store_day_period_query($return["storeid"], $return["querydate"], $return["queryenddate"]);
		$return["reportData"] = $reportData;

		$this->load->view('viewheaders/charisma/header_chart');
		$this->load->view('report/charisma/report_store_classify_pool_view', $return);
		$this->load->view('viewfeet/charisma/foot_chart');
	}

}?>