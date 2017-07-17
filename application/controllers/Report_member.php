<?php
/**
 * Created by Sublime.
 * User: sunsaibin
 * Date: 2017/06/27
 * Time: 09:50
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_member extends CI_Controller {

	public function index() {
		echo "200";
	}

	// 会员疏远分析
	public function report_memmber_alienation() {
		$this->load->model('report/Member_report_model', 'member');
		$this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        //$return['cardType'] = $this->member->getCardType($return['seach_companyid'],$return['seach_storeid']);

		$this->load->view("report/charisma/report_member_alienation_view", $return);
	}

	// 获取卡类型
	public function getCardType() {
		$this->load->model('report/Member_report_model', 'member');

		$companyid = $this->input->get_post('seach_companyid');
		$storeid = $this->input->get_post('seach_storeid');
		$cardtype = $this->member->getCardType($companyid,$storeid);
		echo json_encode($cardtype);exit();
	}

	public function member_alienation_detail() {
		$this->load->model('report/Member_report_model', 'member');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->store_header();
		//echo "<pre>";var_dump($return);die;
		$seach_storeid = $this->input->get_post('seach_storeid');
		$card_typeid = $this->input->get_post('card_typeid');
		$cardnum = $this->input->get_post('card_number');
		$fromdays = $this->input->get_post('start_date');
		$todays = $this->input->get_post('end_date');

		$memberData = $this->member->call_sp_get_card_reprot($seach_storeid,$card_typeid,$cardnum,$fromdays,$todays);

		$items_data = array();
		$keyArray = array('companyid','COMPANYNAME','cardnum','cardtypename','membername','phone','sex','totalconnamt','totalrechange','cardbalance','days');
		foreach ($memberData as $key => $value) {
			$item_data = array();
			for ($i=0; $i < count($keyArray) ; $i++) { 
				$colKey = $keyArray[$i];
				$item_data["col".$i] = $value->$colKey;
			}
			array_push($items_data, $item_data);
		}
		//echo "<pre>";var_dump($items_data);die;
		$return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
	}

}