<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/2/3
 * Time: 11:46
 */

date_default_timezone_set('Asia/Shanghai');
defined('BASEPATH') OR exit('No direct script access allowed');

class App_store_report extends CI_Controller
{
    public  function  store_period_cross_store_report_company_data()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $choose_type = $this->input->get_post("choose_type");
        $return = $this->user->store_header();

        if($choose_type == "1"){
            $reportData = $this->store_report->period_cross_daily_repor_company_app($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else{
            $reportData = $this->store_report->period_cross_daily_repor_company_app($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }

        $return_data = array();
        $return_data["status"]=1;
        $return_data["message"]="success";
        $return_data["data"] = $reportData;
        print_r(json_encode($return_data));
    }

    public  function  store_period_cross_store_report_store_data_detail()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $storeid = $this->input->get_post("storeid");

        $return = $this->user->store_header();

        $s_company = $this->input->get_post("s_company");
        $e_company = $this->input->get_post("e_company");

        //print_r($return);
        $reportData = $this->store_report->period_cross_store_repor_store($return["storeWhere"],$s_company,$e_company, $return["start_date"], $return["end_date"]);
        $return_data = array();
        $return_data["status"]=1;
        $return_data["message"]="success";
        $return_data["data"] = $reportData;
        print_r(json_encode($return_data));
    }


    public  function  store_period_cross_store_report_card_detail()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $table_store_id = $this->input->get_post("table_store_id");

        $return = $this->user->store_header();
        $reportData = $this->store_report->period_cross_store_repor_card($return["storeWhere"],$table_store_id, $return["start_date"], $return["end_date"]);

        $return_data = array();
        $return_data["status"]=1;
        $return_data["message"]="success";
        $return_data["data"] = $reportData;
        print_r(json_encode($return_data));
    }
}

?>