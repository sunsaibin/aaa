<?php
/**
 * Created by Sublime.
 * User: sunsaibin
 * Date: 2017/04/21
 * Time: 09:50
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_report extends CI_Controller
{
	public function index()
    {
        echo '200';
    }
    // 人事异动统计报表
    public function flow_personnel_report()
    {
    	$this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $this->load->view('report/charisma/report_store_personne_view', $return);
    }

    public function flow_personnel_report_detail()
    {
    	$this->load->model('report/flow_report_model', 'report');
    	$this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $flow_id = $this->input->post("flow_id");
        $data = array();
        $data["staffinfo_change_detail"] = $this->report->flow_personnel_report_detail($return["storeWhere"], $return["start_date"], $return["end_date"],$flow_id);
        echo json_encode($data["staffinfo_change_detail"]);exit();
    }

    // 人事统计
    public function flow_staffrank_report()
    {
        $this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $this->load->view('report/charisma/report_store_staffrank_view', $return);
    }

    public function flow_storerank_report_detail()
    {
        $this->load->model('report/flow_report_model', 'report');
        $companyid = $this->input->post("seach_companyid");
        $data = array();
        $data["storerank_report_detail"] = $this->report->flow_storerank_report_detail($companyid);
        echo json_encode($data["storerank_report_detail"]);exit();
    }

    public function flow_staffrank_report_detail()
    {
        $this->load->model('report/flow_report_model', 'report');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $return["storeWhere"] = trim($return["storeWhere"]); // (1, 2, 3)
        $len = strlen($return["storeWhere"]);
        $return["storeWhere"] = substr($return["storeWhere"], 1,$len-2); // (1,2,3)
        $store_header = explode(',', $return["storeWhere"]);   
        $data = array();
        $companyid = $this->input->post("seach_companyid");
        if(count($store_header) > 1){
            foreach ($store_header as $key => $value) {
                if($value == -1){
                    $value = 1;
                }
                //if($value != -1){
                    $data[$key] = $this->report->flow_staffrank_report_detail($value,$companyid);
                /*}
                else{
                    $data[$key] = $this->report->flow_staffrank_report_detail($store_header);
                } */  
            }
        }
        else{
            $data[0] = $this->report->flow_staffrank_report_detail($store_header[0]);
        }
        
        foreach ($data as $key => $value) {
            $total = 0;
            foreach ($value as $k => $v) {
                $total += $v->rankid_count;
            }
            $data[$key]["total_count"] = $total;
            if($total == 0){
                unset($data[$key]);
            }
            
        }
        echo json_encode($data);exit();
    }
} 
?>