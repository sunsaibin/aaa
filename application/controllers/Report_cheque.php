<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_cheque extends CI_Controller {

	public function index()
	{
		//echo "200";
		/*$array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19);
		$newarr = array_chunk($array,3);
		echo "<pre>";var_dump($newarr);*/
		$array = array(1,1,2,3,3,3,4,5,5);
		$newarr = array_unique($array);
		$newarr = array_values($newarr);
		echo "<pre>";var_dump($newarr);die;
	}

	// 记账报表
	public function cheque_book()
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		$this->load->model('user/User_model', 'user');
		$return = $this->user->store_header();
		$return["staffid"] = $return["stallInfo"]->staffid;
	/*	$start_date = "2016-09-01";
		$end_date = "2016-09-10";
		$return = array();
		$return["cheque_data"] = $this->cheque_book->query_cheque_book($start_date,$end_date);
		$return["cheque_name_data"] = $this->cheque_book->query_cheque_book_name();*/
		//echo "<pre>";var_dump($return);die;
		$this->load->view("report/charisma/report_cheque_book_view",$return);
	}

	// 查询凭证记录
	public function get_cheque_book_data()
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		$this->load->model('user/User_model', 'user');
		$return = $this->user->store_header();
		//$cheque_book_data = $this->cheque_book->get_cheque_book_data($return["seach_storeid"],$return["start_date"],$return["end_date"]);
		$choose_type = $return["choose_type"];
		$cheque_book_data = array();
        if($choose_type == 1){
            $cheque_book_data = $this->cheque_book->get_cheque_book_daysort_data($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else if($choose_type == 2){
            $cheque_book_data = $this->cheque_book->get_cheque_book_storesort_data($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
		print_r(json_encode($cheque_book_data));
	}

	// 生成凭证单
	public function generate_cheque_book_evidence()
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		$insert_id = $this->cheque_book->insert_cheque_book_evidence();
		
		// 修改凭证记录状态 已生成凭证单的记录不能再次生成
		$this->cheque_book->update_cheque_book();

		if($insert_id > 0){
			$data = array(
				'code' => '000',
				'msg' => 'success',
				'data' => $insert_id
			);
		}else{
			$data = array(
				'code' => '001',
				'msg' => 'error',
				'data' => ''
			);
		}
		echo json_encode($data);
		exit();
	}

	// 凭证列表
	public function cheque_book_evidence()
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		$this->load->model('user/User_model', 'user');
		$return = $this->user->store_header();
		$this->load->view("report/charisma/report_cheque_book_evidence_view", $return);
	}

	// 获取凭证列表
	public function query_cheque_book_evidence_data($pagenum)
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		$this->load->model('user/User_model', 'user');
		$this->load->library('pagination');

		$return = $this->user->store_header();

		$evidence_count = $this->cheque_book->query_cheque_book_evidence_count($return["storeWhere"], $return["start_date"], $return["end_date"]);

		$config['base_url'] = base_url().'index.php/report_cheque/query_cheque_book_evidence_data/';
        $config['total_rows'] = $evidence_count[0]->count;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $total_page = ceil($config['total_rows']/$config['per_page']);

        if($pagenum > $total_page){
            $pagenum = $total_page;//页码不能大于总页数
        }
        if($pagenum<1){
            $pagenum = 1;// 页码不能小于1
        }
        $offset = ($pagenum-1)*$config['per_page'];
        $this->pagination->initialize($config);

        $evidence_data = $this->cheque_book->query_cheque_book_evidence_data($return["storeWhere"], $return["start_date"], $return["end_date"],$config['per_page'],$offset);
        $return = array();
        $return["evidence_data"] = $evidence_data;
        $return["pagenum"] = intval($pagenum);
		print_r(json_encode($return));exit();
	}

	// 凭证单及科目明细(打印页面)
	public function cheque_book_print($cbe_id, $createdate)
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");
		/*$this->load->model('user/User_model', 'user');
		$return = $this->user->store_header();*/
		$createdate = urldecode($createdate);

		$return = array();
		$return["year"] = date('Y',strtotime($createdate));
		$return["month"] = date('m',strtotime($createdate));
		$return["day"] = date('d',strtotime($createdate));
		$return["evidence_detail"] = $this->cheque_book->query_cheque_evidence_detail($cbe_id);
		$this->load->view("report/charisma/report_cheque_book_print_view",$return);
	}

	// 获取、插入凭证数据
	public function cheque_data()
	{
		$this->load->model("report/cheque_book_report_model","cheque_book");

		// 其他应收款
		$receivable_data = $this->cheque_book->get_receivable_cheque_data();
		//var_dump($data);die;
		$sqlArray = array();
		foreach ($receivable_data as $key => $value) {

			if($value->cash_total_money > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 113302; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '其他应收款'; // 一级科目
				$sqlArray["cb_particulars"] = '现金'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $value->cash_total_money; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}

			if($value->alipay_total_money > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 113304; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '其他应收款'; // 一级科目
				$sqlArray["cb_particulars"] = '刷卡-支付宝'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $value->alipay_total_money; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}

			if($value->weixin_total_money > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 113305; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '其他应收款'; // 一级科目
				$sqlArray["cb_particulars"] = '刷卡-微信'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $value->weixin_total_money; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}

			if($value->third_dianping_server_money > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 113307; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '其他应收款'; // 一级科目
				$sqlArray["cb_particulars"] = '刷卡-大众点评'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $value->third_dianping_server_money; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}
			// 主营业务收入 美容 美发 美甲 等
			$cosmetic_total = $value->cosmetic_cash+$value->cosmetic_server+$value->cosmetic_card;
			$hairdress_total = $value->hairdress_cash+$value->hairdress_server+$value->hairdress_card;
			$manicure_total = $value->manicure_cash+$value->manicure_server+$value->manicure_card;
			// 美容业绩
			if($cosmetic_total > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 510101; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '主营业务收入'; // 一级科目
				$sqlArray["cb_particulars"] = '美容业绩'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $cosmetic_total; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}

			// 美发业绩
			if($hairdress_total > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 510102; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '主营业务收入'; // 一级科目
				$sqlArray["cb_particulars"] = '美发业绩'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $hairdress_total; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}

			// 美甲业绩
			if($manicure_total > 0){
				$sqlArray["cb_store"] = $value->storeid;
				$sqlArray["cb_code"] = 510103; // 科目编码
				$sqlArray["cb_summary"] = ''; // 摘要
				$sqlArray["cb_accounts"] = '主营业务收入'; // 一级科目
				$sqlArray["cb_particulars"] = '美发业绩'; // 二级科目
				$sqlArray["cb_posting"] = ''; // 过账
				$sqlArray["cb_debit"] = $manicure_total; // 借方
				$sqlArray["cb_credit"] = 0; // 贷方
				$sqlArray["cb_happendate"] = $value->time; // 发生时间
				$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
				echo "<br>insert_id:".$insert_id;
			}
			
		}

		// 支出: 营业费用,主营业务成本
		$cost_data = $this->cheque_book->get_cost_cheque_data();
		$accounts = '';
		foreach ($cost_data as $key1 => $value1) {

			if($value1->entrytype == '12211002'){
				$value1->entrytypename = '宿舍押金';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '160101'){
				$value1->entrytypename = '美容设备';
				$accounts = '主营业务成本';
			}elseif($value1->entrytype == '160102'){
				$value1->entrytypename = '美发设备';
				$accounts = '主营业务成本';
			}elseif($value1->entrytype == '160103A'){
				$value1->entrytypename = '经营用设备A';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '160103B'){
				$value1->entrytypename = '经营用设备B';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '64010101'){
				$value1->entrytypename = '美容产品';
				$accounts = '主营业务成本';
			}elseif($value1->entrytype == '64010201'){
				$value1->entrytypename = '美发产品';
				$accounts = '主营业务成本';
			}elseif($value1->entrytype == '6601016'){
				$value1->entrytypename = '快递费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660101A'){
				$value1->entrytypename = '办公用品A';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660101B'){
				$value1->entrytypename = '办公用品B';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660102'){
				$value1->entrytypename = '通讯费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660103'){
				$value1->entrytypename = '柴油费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660105'){
				$value1->entrytypename = '车辆费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660106'){
				$value1->entrytypename = '业务招待费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010701'){
				$value1->entrytypename = '能源费(公司)';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010702'){
				$value1->entrytypename = '能源费(后勤)';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010801'){
				$value1->entrytypename = '房租费(公司)';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010802'){
				$value1->entrytypename = '房租费(后勤)';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010901'){
				$value1->entrytypename = '地方税费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66010902'){
				$value1->entrytypename = '治安管理费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66011203'){
				$value1->entrytypename = '员工活动费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660115'){
				$value1->entrytypename = '物业管理费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '66011702'){
				$value1->entrytypename = '后勤用品';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660117A'){
				$value1->entrytypename = '日用品A';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660117B'){
				$value1->entrytypename = '日用品B';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660123'){
				$value1->entrytypename = '绿化费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660124'){
				$value1->entrytypename = '广告费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '671102'){
				$value1->entrytypename = '赔偿金';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '550105'){
				$value1->entrytypename = '餐费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '550130'){
				$value1->entrytypename = '洗涤费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '660110'){
				$value1->entrytypename = '维修费';
				$accounts = '营业费用';
			}elseif($value1->entrytype == '691101'){
				$value1->entrytypename = '保洁费';
				$accounts = '营业费用';
			}

			if($value1->applytime == null){
				$value1->applytime = $value1->entrydate;
			}
			
			$sqlArray["cb_store"] = $value1->storeid;
			$sqlArray["cb_company"] = $value1->companyid;
			$sqlArray["cb_code"] = $value1->entrytype; // 科目编码
			$sqlArray["cb_summary"] = $value1->entrymemo; // 摘要
			$sqlArray["cb_accounts"] = $accounts; // 一级科目
			$sqlArray["cb_particulars"] = $value1->entrytypename; // 二级科目
			$sqlArray["cb_posting"] = ''; // 过账
			$sqlArray["cb_debit"] = ''; // 借方
			$sqlArray["cb_credit"] = $value1->entryamount; // 贷方
			$sqlArray["cb_happendate"] = $value1->applytime; // 发生时间
			$insert_id = $this->cheque_book->add_cheque_book($sqlArray);
			echo "<br>insert_id:".$insert_id;
		}
	}
}
?>