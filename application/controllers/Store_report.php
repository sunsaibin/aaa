<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/2/3
 * Time: 11:46
 */

date_default_timezone_set('Asia/Shanghai');
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_report extends CI_Controller
{
    public function index()
    {
        $this->load->view('report/dm/store_report_test_view');
    }

    public function  index_data()
    {
        $data = array();
        $data["code"] = "000";
        $data["message"] = "success";

        $items = array();
        for($i=0;$i<10;$i++){
            $item = array();
            for($j=0;$j<5;$j++){
                array_push($item,($i+$j).'1');
            }
            array_push($items,$item);
        }

        $data["thead"] = array("col1","col2","col3","col4","col5","col6","col7","col8","col9","col10");
        $data["thead"] = array("col1","col2","col3","col4","col5");
        $data["tbody"]=$items;
        print_r(json_encode($data));
    }

    //日报表
    public function store_period_daily_report()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/store_period_daily_view', $return);
    }

    //data
    public function  store_period_daily_report_data(){
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->store_report->store_period_daily_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else if($choose_type == 2){
            $reportData = $this->store_report->store_period_daily_storesort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }

        //
        $escape = array("storeNameOrTime");
        $key_array = array('storeNameOrTime','total_cash','total_server','order_count','total_server','total_product','total_card','cash_server_money','cash_product_money','cash_salecard_money','cash_cancel_money','cash_total_money','unionpay_server_money','unionpay_product__money','unionpay_salecard_money','unionpay_cancel_money','unionpay_total_money','alipay_server_money','alipay_produc_money','alipay_salecard_money','alipay_cancel_money','alipay_total_money','weixin_server_money','weixin_product_money','weixin_salecard_money','weixin_cancel_money','weixin_total_money','third_dianping_server_money',"baidu_pay",'third_total_money','card_server_money','card_product_money','card_total_money','coupon_server_money','coupon_product_money','coupon_total_money', 'transfer_server_money','transfer_product_money','transfer_total_money','card_salecard_money', 'card_cancel_money','total_card','manager_bill','expend_record','course_exchange','stored_exchange');
        $items_data = array();
        $forData =  json_decode(json_encode( $reportData),true);
        foreach ($forData as $value) {
            $item_data = array();
            //print_r($value);

            for($i=1;$i<count($key_array)+1;$i++){
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

                $item_data["col31"] = sprintf("%.2f",$value["card_server_money"]+$value["card_course_server_money"]);
                $item_data["col37"] = sprintf("%.2f",$value["transfer_changes_money"]+$value["transfer_cancel_money"]);
                $item_data["col40"] = sprintf("%.2f",$value["weixin_salecard_money"]+$value["cash_salecard_money"]+$value["alipay_salecard_money"]+$value["unionpay_salecard_money"]);
            }
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    //月报表
    public function store_period_month_report()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/store_period_month_view', $return);
    }

    //data
    public function store_period_month_report_data()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->store_report->store_period_month_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else if($choose_type == 2){
            $reportData = $this->store_report->store_period_month_storesort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }

        //
        $escape = array("storeNameOrTime");
        $key_array = array('storeNameOrTime','total_cash','total_server','order_count','total_server','total_product','total_card','cash_server_money','cash_product_money','cash_salecard_money','cash_cancel_money','cash_total_money','unionpay_server_money','unionpay_product__money','unionpay_salecard_money','unionpay_cancel_money','unionpay_total_money','alipay_server_money','alipay_produc_money','alipay_salecard_money','alipay_cancel_money','alipay_total_money','weixin_server_money','weixin_product_money','weixin_salecard_money','weixin_cancel_money','weixin_total_money','third_dianping_server_money',"baidu_pay",'third_total_money','card_server_money','card_product_money','card_total_money','coupon_server_money','coupon_product_money','coupon_total_money', 'transfer_server_money','transfer_product_money','transfer_total_money','card_salecard_money', 'card_cancel_money','total_card','manager_bill','expend_record','course_exchange','stored_exchange');
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

                $item_data["col31"] = sprintf("%.2f",$value["card_server_money"]+$value["card_course_server_money"]);
                $item_data["col37"] = sprintf("%.2f",$value["transfer_changes_money"]+$value["transfer_cancel_money"]);
                $item_data["col40"] = sprintf("%.2f",$value["weixin_salecard_money"]+$value["cash_salecard_money"]+$value["alipay_salecard_money"]+$value["unionpay_salecard_money"]);
            }
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    //分类业绩
    public function  store_period_classify_report(){
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/store_period_classify_view', $return);
    }

    public function store_period_classify_report_data(){
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $choose_type = $return["choose_type"];
        $reportData = array();
        if($choose_type == 1){
            $reportData = $this->store_report->store_period_classify_daysort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else if($choose_type == 2){
            $reportData = $this->store_report->store_period_classifystoresort_report($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }

        $escape = array("storeNameOrTime");
        $key_array = array('storeNameOrTime','total_cash','col3','col4','cl5','col6','total_server','cosmetic_server','hairdress_server','manicure_server','col11','total_card','cosmetic_card','hairdress_card','manicure_card','col16');
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

                $item_data["col3"] = sprintf("%.2f",($value["cosmetic_cash"]+$value["cosmetic_card"]));
                $item_data["col4"] = sprintf("%.2f",($value["hairdress_cash"]+$value["hairdress_card"]));
                $item_data["col5"] = sprintf("%.2f",($value["manicure_cash"]+$value["manicure_card"]));
                if($value["total_server"] <=0) {
                    $item_data["col6"] = sprintf("%.2f",'-/-/-');
                }
                else{
                    $item_data["col6"] = round(floatval(($value["cosmetic_cash"]+$value["cosmetic_card"]))/floatval($value["total_cash"]),2)."/".(round(floatval($value["hairdress_cash"]+$value["hairdress_card"])/floatval($value["total_cash"]),2))."/".round(floatval($value["manicure_cash"]+$value["manicure_card"])/floatval($value["total_cash"]),2);
                }

                if($value["total_server"] <=0){
                    $item_data["col11"] = sprintf("%.2f",'-/-/-');
                }else{
                    $item_data["col11"] = round(floatval($value["cosmetic_server"])/floatval($value["total_server"]),2)."/".(round(floatval($value["hairdress_server"])/floatval($value["total_server"]),2))."/".(round(floatval($value["manicure_server"])/floatval($value["total_server"]),2));
                }

                if($value["total_card"] <=0) {
                    $item_data["col16"] = sprintf("%.2f",'-/-/-');
                }else{
                    $item_data["col16"] = round(floatval($value["cosmetic_card"])/floatval($value["total_card"]),2)."/".(round(floatval($value["hairdress_card"])/floatval($value["total_card"]),2))."/".(round(floatval($value["manicure_card"])/floatval($value["total_card"]),2));
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

    //收购卡统计
    public function  store_purchase_card()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/store_purchase_card_view', $return);
    }

    public function  store_purchase_card_data()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $choose_type = $this->input->get_post("choose_type");
        $collect_card = $this->input->get_post("collect_card");

        $reportData = "";
        if($choose_type == "1"){
            if($collect_card == "0"){
                $reportData = $this->store_report->purchase_card_report_1_0($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
            else{
                $reportData = $this->store_report->purchase_card_report_1_1($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
        }
        else if($choose_type == "2"){
            if($collect_card == "0"){
                $reportData = $this->store_report->purchase_card_report_2_0($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
            else{
                $reportData = $this->store_report->purchase_card_report_2_1($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
        }
        else if($choose_type == "3"){
            if($collect_card == "0"){
                $reportData = $this->store_report->purchase_card_report_3_0($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
            else{
                $reportData = $this->store_report->purchase_card_report_3_1($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
        }else{
            if($collect_card == "0"){
                $reportData = $this->store_report->purchase_card_report_4_0($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }else {
                $reportData = $this->store_report->purchase_card_report_4_1($return["storeWhere"], $return["start_date"], $return["end_date"]);
            }
        }

        //['序号','收购时间', '卡归属门店', '会员卡号','收购金额', '期初卡余额', '消费金额', '期末卡余额','实际卡余额'],
        $escape = array('purchase_date','store_date','purchase_time',"card_number", 'card_id');
        $key_array = array( 'card_id','store_date','purchase_date','card_number','card_balance','card_amonut1','card_amonut2','card_amonut3','card_amonut4','period_start','consume','period_end','col3');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);

        foreach ($forData as $value) {
            $item_data = array();

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

//            $tem_float_11 = $item_data["col11"];
//
//            $tem_float_6 = floatval($item_data["col10"]-$tem_float_11);
//            if($tem_float_6 < 0){
//                $item_data["col6"] = $item_data["col10"];
//            }
//
//            $tem_float_7 = $item_data["col11"];
//            $item_data["col7"] = $tem_float_7;
//            if($tem_float_7 < 0){
//                $item_data["col7"] = $item_data["col11"]-$item_data["col10"];
//            }
//
//            $item_data["col8"] =  $item_data["col6"]-$item_data["col7"];
//            $item_data["col9"] =  $item_data["col11"]-$item_data["col10"];

            //$item_data["col10"] = sprintf("%.2f",(floatval( $item_data["col7"] )- $item_data["col8"]));
//            $item_data["col6"] = sprintf("%.2f",(floatval( $item_data["col5"] )-floatval( $item_data["col6"] )));
//            $item_data["col8"] = sprintf("%.2f",(floatval( $item_data["col6"] )- $item_data["col7"]));
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    //收购卡统计明细
    public function  store_purchase_card_detail_data()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $cardid = $this->input->get_post("card_id");
        if(!isset($cardid)){
            $return_data = array();
            $return_data["code"]="001";
            $return_data["message"]="cardid is null!";
            $return_data["items"] = null;
            print_r(json_encode($return_data));
            return;
        }

        $return = $this->user->store_header();
        $reportData = $this->store_report->purchase_card_detail_report($cardid, $return["start_date"], $return["end_date"]);

        $escape = array("store_name","ORDERNUMBER","PRODUCTNAME","pay_name",'server_time');
        $key_array = array('store_name', 'ORDERNUMBER','real_amount', 'PRODUCTNAME', 'pay_name', 'server_time',"dm_none_data");
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);

        foreach ($forData as $value) {
            $item_data = array();

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

    //cross
    public  function  store_period_cross_store_report()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();
        $this->load->view('report/dm/store_cross_store_view', $return);
    }

    public  function  store_period_cross_store_report_company_data()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $choose_type = $this->input->get_post("choose_type");
        $return = $this->user->store_header();

        if($choose_type == "1"){
            $reportData = $this->store_report->period_cross_daily_repor_company($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }
        else{
            $reportData = $this->store_report->period_cross_store_repor_company($return["storeWhere"], $return["start_date"], $return["end_date"]);
        }

        $escape = array('col1','p_date_companyname', 'p_gcompanyname','p_tcompanyname','p_gcompanyid','p_tcompanyid');
        $key_array = array('col1','p_date_companyname', 'p_gcompanyname','p_tcompanyname','p_amount','p_gcompanyid','p_tcompanyid');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);

        foreach ($forData as $value) {
            $item_data = array();

            for($i=1;$i<count($key_array)+1;$i++){
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
            $item_data["col1"] = $item_data["col6"]."_".$item_data["col7"];
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
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

        $reportData = $this->store_report->period_cross_store_repor_store($return["storeWhere"],$s_company,$e_company, $return["start_date"], $return["end_date"]);

        $escape = array('col1', 'p_gstorname','p_gcompanyname','p_date','p_tstorname','p_tcompanyname','STORESHORTNUM');
        $key_array = array('col1', 'p_gstorname','p_gcompanyname','p_date','p_tstorname','p_tcompanyname','STORESHORTNUM','p_amount');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);

        foreach ($forData as $value) {
            $item_data = array();

            for($i=1;$i<count($key_array)+1;$i++){
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
            $item_data["col1"] = $i;
            array_push($items_data, $item_data);
        }

        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }


    public  function  store_period_cross_store_report_card_datal()
    {
        $this->load->model('report/store_report_model', 'store_report');
        $this->load->model('user/User_model', 'user');

        $table_store_id = $this->input->get_post("table_store_id");

        $return = $this->user->store_header();
        $reportData = $this->store_report->period_cross_store_repor_card($return["storeWhere"],$table_store_id, $return["start_date"], $return["end_date"]);

        $escape = array('col1','p_cardnum', 'p_gstorname','p_date','p_tstorname');
        $key_array = array('col1','p_cardnum', 'p_gstorname','p_date','p_tstorname','p_amount');
        $items_data = array();
        $forData =  json_decode( json_encode( $reportData),true);

        foreach ($forData as $value) {
            $item_data = array();

            for($i=1;$i<count($key_array)+1;$i++){
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
            $item_data["col1"] = $i;
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