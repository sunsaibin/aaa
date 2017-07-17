<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/4/17
 * Time: 17:31
 */
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('memory_limit', '-1');
class Operate_check extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    public function  bonus_check_data(){
        $this->load->model('report/staff_report_model', 'staff_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/operate_check_bonus_data_view', $return);
    }

    public function  bonus_check_data_data(){
        $this->load->model('report/Operate_check_model', 'operate_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $storeid = $this->input->get_post("seach_storeid");

        $staff_number = $this->input->get_post("seach_staff_number");
        $return["staff_number"] = $staff_number;

        $choose_type = $return["choose_type"];
        $reportData = array();
        //if($choose_type == 1){
        $reportData = $this->operate_report->operate_check_bonus_check_data_data($return["storeWhere"], $storeid, $return["start_date"], $return["end_date"],$staff_number);
        //}

        $escape = array('bonus_time','company_id','store_id','STAFFNAME','STAFFID','PTYPEID','RANKID','card_order','number','PAYNAME','pay_type','d_type','deduct_detailtype');
        $key_array = array('bonus_time','company_id','store_id','STAFFNAME','STAFFID','PTYPEID','RANKID','card_order','number','PAYNAME','pay_type','d_type','deduct_detailtype','total_performance','staff_performance','commission_ratio','commission_amount','col19',);
        $items_data = array();
        //$forData =  json_decode( json_encode($reportData),true);
        //print_r($reportData);exit;
        foreach ($reportData as $value) {
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
}

?>