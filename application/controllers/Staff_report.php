<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/2/3
 * Time: 11:48
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_report extends CI_Controller
{

    public function index()
    {
        echo "200";
    }

    //员工薪资日报表
    public function staff_period_daily_report()
    {
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/staff_period_daily_view', $return);
    }

    public function  staff_period_daily_report_data(){
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $staff_number = $this->input->get_post("staff_number");
        $return["staff_number"] = $staff_number;

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->staff_report->staff_period_daily_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }
        else if($choose_type == 2){
            $reportData = $this->staff_report->staff_period_daily_storesort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }

        $escape = array('storeNameOrTime',"storename");
        $key_array = array('storeNameOrTime','storename', 'col13', 'cash_max_performance','cash_max_commission', 'cash_min_performance','cash_min_commission','cash_product_performance','cash_product_commission','mem_max_performance','mem_max_commission','mem_min_performance', 'mem_min_commission','mem_product_performance','mem_product_commission', 'col16', 'card_performance', 'card_commission', 'course_performance','course_commission', 'manager_performance', 'manager_commission', 'card_untread_performance', 'card_untread', 'col25',  'col26');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);
        foreach ($forData as $value) {
            $item_data = array();
            //print_r($value);

            for($i=1;$i<count($key_array);$i++){
                $for_string = $key_array[$i-1];
                if(!empty($for_string) && count($for_string)>0 && array_key_exists($for_string,$value)){
                    if(in_array($for_string,$escape)){
                        $item_data["col".$i] = $value[$for_string];
                    }
                    else{
                        $item_data["col".$i] = sprintf("%.2f",$value[$for_string]);
                    }
                }else{
                    $item_data["col".$i] = "0.00";
                }

                $item_data["col16"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["cash_product_performance"]));
                $item_data["col3"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["cash_product_performance"] + $value["card_performance"] + $value["card_untread_performance"]));
                $item_data["col25"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["mem_max_performance"] + $value["mem_min_performance"]));
                $item_data["col26"] = sprintf("%.2f", ($value["cash_max_commission"] + $value["cash_min_commission"] + $value["cash_product_commission"] + $value["mem_max_commission"] + $value["mem_min_commission"] + $value["mem_product_commission"] + $value["card_commission"] + $value["card_untread"] + $value["manager_commission"]));
            }
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    //员工薪资明细
    public function staff_period_detail_report()
    {
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $staff_number = $this->input->get_post("staff_number");
        if(isset($staff_number)){
            $return["staff_number"] = $staff_number;
        }
        $this->load->view('report/dm/staff_period_detail_view', $return);
    }

    public function  staff_period_detail_report_data(){
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $staff_number = $this->input->get_post("staff_number");
        $return["staff_number"] = $staff_number;

        $reportData = $this->staff_report->staff_period_detail_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);

        $escape = array("bonus_time","STORENAME","STAFFNUMBER","STAFFNAME", "productname","card_orderid","bonus_time","payname");  //'订单金额','业绩比例','业绩金额','员工业绩比例','员工业绩金额','员工提成比例','提成金额'
        $key_array = array("bonus_time","STORENAME","STAFFNUMBER","STAFFNAME", "productname","card_orderid","payname","total_performance","performance_ratio","performance_amount","staff_performance_ratio","staff_performance","commission_ratio","commission_amount","col17");
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);
        foreach ($forData as $value) {
            $item_data = array();
            //print_r($value);

            for($i=1;$i<count($key_array);$i++){
                $for_string = $key_array[$i-1];
                if(!empty($for_string) && count($for_string)>0 && array_key_exists($for_string,$value)){
                    if(in_array($for_string,$escape)){
                        $item_data["col".$i] = $value[$for_string];
                    }
                    else{
                        $item_data["col".$i] = sprintf("%.2f",$value[$for_string]);
                    }
                }else{
                    $item_data["col".$i] = "0.00";
                }

            }
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }


    //员工薪资月报表
    public function staff_period_month_report()
    {
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header(); $this->load->view('report/dm/staff_period_month_view', $return);
    }

    public function staff_period_month_report_data(){
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $staff_number = $this->input->get_post("staff_number");
        $return["staff_number"] = $staff_number;

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->staff_report->staff_period_month_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }
        else if($choose_type == 2){
            $reportData = $this->staff_report->staff_period_month_storesort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }

        $escape = array('storeNameOrTime',"storename");
        $key_array = array('storeNameOrTime','storename', 'col13','mem_max_performance','mem_min_performance', 'cash_max_performance','cash_max_commission', 'cash_min_performance','cash_min_commission','cash_product_performance','cash_product_commission','mem_max_commission', 'mem_min_commission','mem_product_performance','mem_product_commission', 'col16', 'card_performance', 'card_commission', 'course_performance','course_commission', 'manager_performance', 'manager_commission', 'card_untread_performance', 'card_untread', 'col25',  'col26');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);
        foreach ($forData as $value) {
            $item_data = array();
            //print_r($value);

            for($i=1;$i<count($key_array);$i++){
                $for_string = $key_array[$i-1];
                if(!empty($for_string) && count($for_string)>0 && array_key_exists($for_string,$value)){
                    if(in_array($for_string,$escape)){
                        $item_data["col".$i] = $value[$for_string];
                    }
                    else{
                        $item_data["col".$i] = sprintf("%.2f",$value[$for_string]);
                    }
                }else{
                    $item_data["col".$i] = "0.00";
                }

                $item_data["col16"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["cash_product_performance"]));
                $item_data["col3"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["cash_product_performance"] + $value["card_performance"]));
                $item_data["col25"] = sprintf("%.2f", ($value["cash_max_performance"] + $value["cash_min_performance"] + $value["mem_max_performance"] + $value["mem_min_performance"]));
                $item_data["col26"] = sprintf("%.2f", ($value["cash_max_commission"] + $value["cash_min_commission"] + $value["cash_product_commission"] + $value["mem_max_commission"] + $value["mem_min_commission"] + $value["mem_product_commission"] + $value["card_commission"] + $value["card_untread"]));
            }
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    //员工薪资月报表
    public function staff_period_month_old_report()
    {
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');


        $return = $this->user->store_header();

        $staff_number = $this->input->get("staff_number");
        $return["staff_number"] = $staff_number;

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->staff_report->staff_period_month_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }
        else if($choose_type == 2){
            $reportData = $this->staff_report->staff_period_month_storesort_report($return["storeWhere"], $return["start_date"], $return["end_date"],$staff_number);
        }

        $return["reportData"] = $reportData;
        $this->load->view('report/dm/staff_period_month_old_view', $return);
    }


}
?>