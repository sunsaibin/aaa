<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_staff_old extends CI_Controller {

	public function index()
	{
		echo "200";
	}

	//员工薪资统计
	public function salary_report()
	{
		$this->load->model('report/store_report_old_model', 'store_report_old');
		$this->load->model('report/staff_report_old_model', 'staff_report_old');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		// $reportData = $this->store_report_old->query_date_store($return["storeid"], $return["querydate"]);
		// $return["reportData"]=$reportData;

		$reportData = $this->staff_report_old->query_staff_salary($return["storeid"], $return["querydate"], $return["queryenddate"]);
		$return["reportData"]=$reportData;


		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_staff_salary_view', $return);
		$this->load->view('report/charisma/report_staff_data_view', $return);
		$this->load->view('viewfeet/charisma/foot');
	}

	public function salary_detail($staffid)
	{
		$this->load->model('report/staff_report_old_model', 'staff_report_old');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$querydate = $this->input->get('querydate');
		if (!isset($querydate)) {
			$querydate = $this->input->post('querydate');
			if (!isset($querydate)) {
				$return["querydate"] = date("Y-m-01",time());
			}
		}

		$query_enddate = $this->input->get('queryend');
		$return["queryend"] = $query_enddate;
		if (empty($query_enddate)) {
			$query_enddate = $this->input->post('queryend');
			if (empty($query_enddate)) {
				$return["queryend"] = $return["querydate"];
			}
		}

		$reportData = $this->staff_report_old->query_staff_salary_detail($staffid, $return["querydate"],$return["queryend"]);

		$return["reportData"]=$reportData;
		$return["staffid"] = $staffid;

		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_staff_salary_detail_view', $return);
		$this->load->view('viewfeet/charisma/foot');

	}

	public function salary_month_detail($staffid)
	{
		$this->load->model('report/staff_report_old_model', 'staff_report_old');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$querydate = $this->input->get('querydate');
		if (!isset($querydate)) {
			$querydate = $this->input->post('querydate');
			if (!isset($querydate)) {
				$return["querydate"] = date("Y-m-01",time());
			}
		}

		$reportData = $this->staff_report_old->query_staff_salary_month_detail($staffid, $return["querydate"]);

		$return["reportData"]=$reportData;
		$return["staffid"] = $staffid;

		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_staff_salary_detail_view', $return);
		$this->load->view('viewfeet/charisma/foot');

	}

	//员工薪资月统计
	public function salary_report_month()
	{
		$this->load->model('report/store_report_old_model', 'store_report_old');
		$this->load->model('report/staff_report_old_model', 'staff_report_old');
		$this->load->model('user/User_model', 'user');

		$return = $this->user->seach_header();

		$querydate = $this->input->get('querydate');
		if (!isset($querydate)) {
			$querydate = $this->input->post('querydate');
			if (!isset($querydate)) {
				$return["querydate"] = date("Y-m-01",time());
			}
		}

		$reportData = $this->staff_report_old->query_staff_salary_month($return["storeid"], $return["querydate"], $return["queryenddate"]);
		$return["reportData"]=$reportData;


		$this->load->view('viewheaders/charisma/header');
		$this->load->view('report/charisma/report_staff_month_view', $return);
		$this->load->view('viewfeet/charisma/foot');
	}


	//员工薪资统计日报表
	public function salary_day_report()
	{
		$this->load->model('report_staff/day_report_model', 'day_report');
		$this->load->library('pagination');
	}



}?>