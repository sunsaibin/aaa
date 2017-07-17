<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/2/3
 * Time: 11:55
 */
date_default_timezone_set('Asia/Shanghai');
defined('BASEPATH') OR exit('No direct script access allowed');
class Store_cashier extends CI_Controller
{
    public function get_list()
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->seach_header();
        $jsonReturn = array();

        $fun_today = $this->input->post("today");
        $fun_index = $this->input->post("fun_index");
        $comp_id = $this->input->post("comp_id");
        $store_id = $this->input->post("store_id");
        if(!isset($store_id)){
            $store_id = $return["storeid"];
        }
        if(!isset($fun_index)){
            $jsonReturn["code"] = "001";
            $jsonReturn["message"] = "参数错误!fun_index不能为空!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        $items = null;
        // 开单收银
        if($fun_index == 1){
            $items = $this->store_cashier->query_funindex_order_list($store_id, $fun_today,$fun_index);
        }
        // 会员办卡
        elseif($fun_index == 2){
            $items = $this->store_cashier->query_funindex_order_list_card($store_id, $fun_today,$fun_index);
        }
        // 会员充值
        elseif($fun_index == 3){
            $items = $this->store_cashier->query_funindex_order_list_rechargecard($store_id, $fun_today,$fun_index);
        }
        // 购买疗程
        elseif($fun_index == 4){
            $items = $this->store_cashier->query_funindex_order_list_course($store_id, $fun_today,$fun_index);
        }
        // 会员转卡
        elseif($fun_index == 5){
            $items = $this->store_cashier->query_funindex_order_list_changecard($store_id, $fun_today,$fun_index);
        }
        // 会员并卡
        elseif($fun_index == 6){
            $items = $this->store_cashier->query_funindex_order_list_mergecard($store_id, $fun_today,$fun_index);
        }
        // 会员补卡
        elseif($fun_index == 7){
            $items = $this->store_cashier->query_funindex_order_list_repaircard($store_id, $fun_today,$fun_index);
        }
        // 会员退卡
        elseif($fun_index == 8){
            $items = $this->store_cashier->query_funindex_order_list_retreatcard($store_id, $fun_today,$fun_index);
        }
        // 开单返销
        elseif($fun_index == 9){
            $items = $this->store_cashier->query_funindex_order_list_buyback($store_id, $fun_today,$fun_index);
        }
        // 办卡返充
        elseif($fun_index ==10){
            $items = $this->store_cashier->query_funindex_order_list_rechargeback($store_id, $fun_today,$fun_index);
        }
        $jsonReturn["code"] = "000";
        $jsonReturn["message"] = "";
        $jsonReturn["items"] = $items;
        print_r(json_encode($jsonReturn));
    }

    public function get_list_item($storeid)
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->seach_header();
        $jsonReturn = array();

        $fun_today = $this->input->post("today");
        $fun_index = $this->input->post("fun_index");
        if(!isset($fun_index)){
            $jsonReturn["code"] = "001";
            $jsonReturn["message"] = "参数错误!fun_index不能为空!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        $list_index = $this->input->post("list_index");
        if(!isset($list_index)){
            $jsonReturn["code"] = "002";
            $jsonReturn["message"] = "参数错误!list_index不能为空!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        $items = null;
        // 开单收银
        if($fun_index == 1){
            $items["order"] = $this->store_cashier->query_funindex_order_list_item($list_index);
            $items["orderproduct"] = $this->store_cashier->query_funindex_orderproduct_list_item($list_index);
            //echo json_encode($items["orderproduct"]);exit();
            foreach ($items["orderproduct"] as $key => $value) {
                $max_staff_num = $this->store_cashier->get_staff_num($value->staff_id);
                $min_staff_num = $this->store_cashier->get_staff_num($value->staff_min_id);
                $items["orderproduct"][$key]->max_staff_num = $max_staff_num[0]->STAFFNUMBER;
                $items["orderproduct"][$key]->min_staff_num = $min_staff_num[0]->STAFFNUMBER;
            }
            
            $items["workorder"] = $this->store_cashier->query_funindex_workorder_list_item($list_index);
        }
        // 会员办卡
        else if($fun_index == 2){
            $items["order"] = $this->store_cashier->query_funindex_card_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
            $items["bonus_data"] = $this->store_cashier->query_function_bouns_item($storeid,$list_index);
        }
        // 会员充值
        else if($fun_index == 3){
            $items["order"] = $this->store_cashier->query_funindex_rechargecard_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
            $items["bonus_data"] = $this->store_cashier->query_function_bouns_item($storeid,$list_index);
        }
        // 购买疗程
        elseif($fun_index == 4){
            $items["order"] = $this->store_cashier->query_funindex_course_list_item($list_index);
            $items["orderproduct"] = $this->store_cashier->query_funindex_courseproduct_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
        }
        // 会员转卡
        elseif($fun_index == 5){
            $items["order"] = $this->store_cashier->query_funindex_changecard_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
        }
        // 会员并卡
        elseif($fun_index == 6){
            $items["order"] = $this->store_cashier->query_funindex_mergecard_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
        }
        // 会员补卡
        elseif($fun_index == 7){
            $items["order"] = $this->store_cashier->query_funindex_repaircard_list_item($list_index);
        }
        // 会员退卡
        elseif($fun_index == 8){
            $items["order"] = $this->store_cashier->query_funindex_retreatcard_list_item($list_index);
            $items["orderproduct"] = $this->store_cashier->query_funindex_courseproduct_list_item($list_index);
            $items["workorder"] = $this->store_cashier->query_funindex_workinfo_item($list_index);
            $items["returncard_info"] = $this->store_cashier->query_bouns_retreatcard($list_index);
            $items["bonus_data"] = $this->store_cashier->query_function_bouns_item($storeid,$list_index);
        }
        // 开单返销
        elseif($fun_index == 9){
            $items["order"] = $this->store_cashier->query_funindex_buyback_list_item($list_index);
            $items["orderproduct"] = $this->store_cashier->query_funindex_buybackproduct_list_item($list_index);
        }
        // 办卡返充
        elseif($fun_index == 10){
            $items["order"] = $this->store_cashier->query_funindex_rechargeback_list_item($list_index);
        }
        $key_array = array();
        foreach ($items["order"][0] as $key => $value) {
            $key_array[] = $key;
        }
        foreach ($items["orderproduct"][0] as $key => $value) {
            $key_array[] = $key;
        }
        foreach ($items["bonus_data"][0] as $key => $value) {
            $key_array[] = $key;
        }
        foreach ($items["workorder"][0] as $key => $value) {
            $key_array[] = $key;
        }
        foreach ($items["returncard_info"][0] as $key => $value) {
            $key_array[] = $key;
        }
        $jsonReturn["code"] = "000";
        $jsonReturn["message"] = "";
        $jsonReturn["key"] = $key_array;
        $jsonReturn["items"] = $items;

        print_r(json_encode($jsonReturn));exit();
    }

    // 获取员工列表
    public function get_staff_list($storeid)
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        $return['items'] = $this->store_cashier->get_staff_list($storeid);
        print_r(json_encode($return));exit();
    }
    // 点客 轮排
    public function is_specify()
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        //$return['items'] = $this->store_cashier->get_payname_list();
        $specify= array();
        $specify[0] = array("specify_name"=>"点客","specify_id"=>"0");
        $specify[1] = array("specify_name"=>"轮排","specify_id"=>"1");

        $return['items'] = $specify;
        print_r(json_encode($return));exit();
    }
    // 支付方式
    public function get_payname_list()
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        $return['items'] = $this->store_cashier->get_payname_list();
        $payname= array();
        /*$payname[0] = array("pay_name"=>"现金","paytype"=>"5");
        $payname[1] = array("pay_name"=>"银联POS","paytype"=>"4");

        $return['items'] = $payname;*/
        print_r(json_encode($return));exit();
    }

    //日记账
    public function store_day_bill()
    {
        $this->load->model('store/store_cashier_model', 'store_cashier');
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $reportData = $this->store_cashier->query_date_store($return["storeid"], $return["querydate"]);
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

        $this->load->view('viewheaders/charisma/header_print');
        $this->load->view('report/charisma/report_store_day_bill_print_view', $return);
        $this->load->view('viewfeet/charisma/foot_print');
    }

    //业绩分配/订单
    public function distribution()
    {
        $this->load->model('user/User_model', 'user');
        $this->load->model('report/Store_distribution_new_model', 'store_distribution_new');
        $return = $this->user->store_header();
//echo "<pre>";var_dump($return);die;
        //$reportData = $this->store_distribution_new->query_card_divide($return["storeWhere"], $return["end_date"]);
        //$reportOrderData = $this->store_distribution_new->query_order_paytype($return["storeWhere"], $return["end_date"]);
        //$staffList = $this->store_distribution_new->query_store_staffs($return["storeWhere"]);
//echo "<pre>";var_dump($reportOrderData);die;
        //$return["reportData"] = $reportData;
        //$return["reportOrderData"] = $reportOrderData;
        //$return["staffList"] = $staffList;
        //$seach_name = $return['seach_name'];
        //$storeid = $return["storeid"];
        //$storename = $return["storename"];
        //$this->load->view('viewheaders/charisma/header');
        //$this->load->view('report/charisma/report_store_distribution_bill_view', $return);
        $this->load->view('report/charisma/modifBusiDoc_view', $return);
        //$this->load->view('viewfeet/charisma/foot');
    }

    //原來的頁面
    public function distribution_old()
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

    //业绩分配/卡
    public function distribution_card()
    {
        $this->load->model('user/User_model', 'user');
        $this->load->model('report/Store_distribution_new_model', 'store_distribution');
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

    //查询业绩分配
    public function query_distribution($storeid)
    {
        $this->load->model('report/Store_distribution_new_model', 'store_distribution');

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
        $this->load->model('report/Store_distribution_new_model', 'store_distribution');

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

    //封帐日志
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

    //分配业绩比列
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

    //更新分配业绩比列
    public function  update_order_payte($storeid)
    {
        $this->load->model('report/Store_distribution_new_model', 'store_distribution_new');

        $data = $this->input->post("data");
        $explain = $this->input->post("explain",TRUE);
        $ordernumber = $this->input->post("ordernumber");
        $data_obj = json_decode($data);
        /*$paytype = $this->input->post("paytype");
        $maxid= $this->input->post("maxid");
        $minid= $this->input->post("minid");*/

        if(intval($storeid) < 1){
            $jsonReturn = array();
            $jsonReturn["code"] = "001";
            $jsonReturn["message"] = "参数错误!store不能为空!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }
        $data_items = $data_obj->items;
        foreach ($data_items as $key => $value) {
            $opid = $value->opid;
            $payid = $value->payid;
            $maxid = $value->maxstaffid;
            $minid = $value->minstaffid;
            $payname = $value->payname;
            $specifyid = $value->specify_id;
            $specifyid_min = $value->specify_id_min;

            if($maxid<0){
                $maxid = '';
            }
            if($minid<0){
                $minid = '';
            }
            if($specifyid<0){
                $specifyid = '';
            }
            if($specifyid_min<0){
                $specifyid_min = '';
            }

            if(intval($opid) < 1){
                $jsonReturn = array();
                $jsonReturn["code"] = "002";
                $jsonReturn["message"] = "参数错误!OPID不能为空!";
                $jsonReturn["items"] = $data;
                print_r(json_encode($jsonReturn));
                return;
            }

            if(intval($payid) < 1){
                $jsonReturn = array();
                $jsonReturn["code"] = "003";
                $jsonReturn["message"] = "参数错误!PYTE不能为空!";
                $jsonReturn["items"] ="";
                print_r(json_encode($jsonReturn));
                return;
            }

            /*$is_close_bill = $this->store_distribution_new->query_store_close_bill($storeid,$opid);
            if(!empty($is_close_bill) || count($is_close_bill) > 0){
                $jsonReturn = array();
                $jsonReturn["code"] = "006";
                $jsonReturn["message"] = "门店已经封过账，不可以调整业绩，请填写申请单总部统一做调整！";
                $jsonReturn["items"] ="";
                print_r(json_encode($jsonReturn));
                return;
            }
            */
            $this->store_distribution_new->update_orderwork_staff($storeid,$opid,$maxid,$minid,$specifyid,$specifyid_min);
            $reportData = $this->store_distribution_new->update_order_divide_detail($storeid,$opid,$payid,$maxid,$minid);

            // 获取获取删除前此条数据
            $accountDataOld = $this->store_distribution_new->query_account_by_opid($opid);
            // 修改 作废单据      
            $this->store_distribution_new->update_account_paystaftus($opid);
            // 作废单据后,生成新的单据
            $this->store_distribution_new->add_account_paytype($opid,$accountDataOld[0]->card_id);
            /*$sqlArray = array();
            $sqlArray["paytype_id"] = $payid;
            $sqlArray["paytype_name"] = $payname;

            $sqlWhereArray = array();
            foreach ($accountid as $key => $value) {
                $id = $value->id;
            }
            $sqlWhereArray["id"] = $id;
            $this->store_distribution->update_account_paytype($sqlArray,$sqlWhereArray);*/
        }
        $this->store_distribution_new->update_order_explain($explain, $ordernumber);
        //更新员工 maxid
        $jsonReturn = array();
        $jsonReturn["code"] = "000";
        $jsonReturn["message"] = "更新成功";
        $jsonReturn["data"] = $reportData;
        print_r(json_encode($jsonReturn));exit();
    }

    //更新员工卡金分配
    public function  update_store_staff_card($storeid)
    {
        $this->load->model('report/Store_distribution_new_model', 'store_distribution_new');

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
        foreach ($items as $key => $value) {

            //if($key%2 != 0){
                
                if($objs->fun_index == 8){
                    $amount = $value->amount;
                    $items[$key]->amount = 0-$amount;
                }else{
                   $items[$key]->amount = $value->amount; 
                }
                //unset($items[$key]);
            //}
        }

        $accountid = $objs->opid ;
        $paytype = $objs->paytype_id ;
        $paytype_name = $objs->paytype_name ;

        //查询
        $accountObject = $this->store_distribution_new->query_fn_account($accountid);
        if(!isset($accountObject) || count($accountObject) < 1){
            $jsonReturn = array();
            $jsonReturn["code"] = "002";
            $jsonReturn["message"] = "参数错误!accountid不合法传入!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        $is_close_bill = $this->store_distribution_new->query_store_card_close_bill($storeid,$accountid);
        if(!empty($is_close_bill) || count($is_close_bill) > 0){
            $jsonReturn = array();
            $jsonReturn["code"] = "006";
            $jsonReturn["message"] = "门店已经封过账，不可以调整业绩，请填写申请单总部统一做调整！";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        if($paytype != $accountObject->paytype_id)
        {
            if($paytype != -1){
                $sqlArray = array();
                $sqlArray["paytype_id"] = $paytype;
                $sqlArray["paytype_name"] = $paytype_name;

                $sqlWhereArray = array();
                $sqlWhereArray["id"] = $accountObject->id;
                $this->store_distribution_new->update_account_paytype($sqlArray,$sqlWhereArray);
            }
            
        }

        //判断金额
        $total_amout = 0.0;
        foreach ($items as $index => $item) {
            $total_amout = $total_amout + floatval($item->amount);
        }

        if($total_amout > abs(floatval($accountObject->amount)))
        {
            $jsonReturn = array();
            $jsonReturn["code"] = "005";
            $jsonReturn["message"] = "操作失败! 分配金额不能超过".floatval($accountObject->amount)."元!";
            $jsonReturn["items"] ="";
            print_r(json_encode($jsonReturn));
            return;
        }

        //删除
        $this->store_distribution_new->remove_store_card_staff($storeid,$accountObject->id);

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

            $row = $this->store_distribution_new->add_store_card_staff($sqlArray);
        }

        $jsonReturn = array();
        $jsonReturn["code"] = "000";
        $jsonReturn["message"] = "操作成功!";
        $jsonReturn["data"] = $total_amout;
        $jsonReturn["row"] = $row;
        print_r(json_encode($jsonReturn));
    }

    public function  query_card_distribution($storeid)
    {
        $this->load->model('report/Store_distribution_new_model', 'store_distribution');

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

    // 分类业绩统计新
    public function store_period_classify_report_new()
    {
        $this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $this->load->view("report/dm/store_period_classify_new_view",$return);
    }

    // 调接口 处理分类业绩数据
    public function store_period_classify_report_data_new()
    {
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $storeid = $this->input->get_post("seach_storeid");
        $start_date = $this->input->get_post("start_date");
        $end_date = $this->input->get_post("end_date");
        $choose_type = $this->input->get_post("choose_type");
        if($choose_type == 1){
            $url = "http://10.0.3.35:8089/venus/calsalary/calCompanyClassPerfByDate?storeId=".$storeid."&fromdate=".$start_date."&todate=".$end_date."";
        }else{
            $url = "http://10.0.3.35:8089/venus/calsalary/calCompanyClassPerf?storeId=".$storeid."&fromdate=".$start_date."&todate=".$end_date."";
        }
        
        $my_curl = curl_init();    //初始化一个curl对象
        curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
        curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
        $str = curl_exec($my_curl);    //执行请求
        //echo $str;    //输出抓取的结果
        curl_close($curl);    //关闭url请求
        $dataAarray = json_decode($str,true);
        //echo "<pre>";var_dump($dataAarray);die;
        if($dataAarray["status"] == 1 && $choose_type != 1){
            // 按门店 请求成功, 处理数据
            $items_data = array();
            $item_data = array();
            foreach ($dataAarray["data"] as $key => $value) {
                if($key == "storename"){
                    $item_data["col1"] = $value;
                }elseif($key == "totalxperf"){ // 总虚业绩
                    $item_data["col2"] = sprintf("%.2f",$value);
                }elseif($key == "beautyxperf"){ // 美容虚业绩
                    $item_data["col3"] = sprintf("%.2f",$value);
                }elseif($key == "hairxperf"){ // 美发虚业绩
                    $item_data["col4"] = sprintf("%.2f",$value);
                }elseif($key == "manicurexperf"){ // 美甲虚业绩
                    $item_data["col5"] = sprintf("%.2f",$value);
                }elseif($key == "otherxperf"){ // 其他虚业绩
                    $item_data["col6"] = sprintf("%.2f",$value);
                }elseif($key == "totalsperf"){ // 总实业绩
                    $item_data["col8"] = sprintf("%.2f",$value);
                }elseif($key == "beautysperf"){ // 美容实业绩
                    $item_data["col9"] = sprintf("%.2f",$value);
                }elseif($key == "hairsperf"){ // 美发实业绩
                    $item_data["col10"] = sprintf("%.2f",$value);
                }elseif($key == "manicuresperf"){ // 美甲实业绩
                    $item_data["col11"] = sprintf("%.2f",$value);
                }elseif($key == "othersperf"){ // 其他实业绩
                    $item_data["col12"] = sprintf("%.2f",$value);
                }elseif($key == "totalsaleperf"){ // 总售卡业绩
                    $item_data["col14"] = sprintf("%.2f",$value);
                }elseif($key == "beautysaleperf"){ // 美容售卡业绩
                    $item_data["col15"] = sprintf("%.2f",$value);
                }elseif($key == "hairsaleperf"){ // 美发售卡业绩
                    $item_data["col16"] = sprintf("%.2f",$value);
                }elseif($key == "manicuressaleperf"){ // 美甲售卡业绩
                    $item_data["col17"] = sprintf("%.2f",$value);
                }elseif($key == "othersaleperf"){ // 其他售卡业绩
                    $item_data["col18"] = sprintf("%.2f",$value);
                }
            }
            // 虚业绩占比
            $item_data["col7"] = round(floatval($item_data["col3"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col4"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col5"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col6"])/floatval($item_data["col2"]),2);

            // 实业绩占比
            $item_data["col13"] = round(floatval($item_data["col9"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col10"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col11"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col12"])/floatval($item_data["col8"]),2);

            // 售卡业绩占比
            $item_data["col19"] = round(floatval($item_data["col15"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col16"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col17"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col18"])/floatval($item_data["col14"]),2);

           array_push($items_data, $item_data);
        }elseif($dataAarray["status"] == 1 && $choose_type == 1){
            // 按日期
            $items_data = array();
            $item_data = array();
            foreach ($dataAarray["data"] as $key => $value) {
                foreach ($value as $k => $v) {
                    if($k == "accountdate"){
                        $item_data["col1"] = $v;
                    }elseif($k == "totalxperf"){ // 总虚业绩
                        $item_data["col2"] = sprintf("%.2f",$v);
                    }elseif($k == "beautyxperf"){ // 美容虚业绩
                        $item_data["col3"] = sprintf("%.2f",$v);
                    }elseif($k == "hairxperf"){ // 美发虚业绩
                        $item_data["col4"] = sprintf("%.2f",$v);
                    }elseif($k == "manicurexperf"){ // 美甲虚业绩
                        $item_data["col5"] = sprintf("%.2f",$v);
                    }elseif($k == "otherxperf"){ // 其他虚业绩
                        $item_data["col6"] = sprintf("%.2f",$v);
                    }elseif($k == "totalsperf"){ // 总实业绩
                        $item_data["col8"] = sprintf("%.2f",$v);
                    }elseif($k == "beautysperf"){ // 美容实业绩
                        $item_data["col9"] = sprintf("%.2f",$v);
                    }elseif($k == "hairsperf"){ // 美发实业绩
                        $item_data["col10"] = sprintf("%.2f",$v);
                    }elseif($k == "manicuresperf"){ // 美甲实业绩
                        $item_data["col11"] = sprintf("%.2f",$v);
                    }elseif($k == "othersperf"){ // 其他实业绩
                        $item_data["col12"] = sprintf("%.2f",$v);
                    }elseif($k == "totalsaleperf"){ // 总售卡业绩
                        $item_data["col14"] = sprintf("%.2f",$v);
                    }elseif($k == "beautysaleperf"){ // 美容售卡业绩
                        $item_data["col15"] = sprintf("%.2f",$v);
                    }elseif($k == "hairsaleperf"){ // 美发售卡业绩
                        $item_data["col16"] = sprintf("%.2f",$v);
                    }elseif($k == "manicuressaleperf"){ // 美甲售卡业绩
                        $item_data["col17"] = sprintf("%.2f",$v);
                    }elseif($k == "othersaleperf"){ // 其他售卡业绩
                        $item_data["col18"] = sprintf("%.2f",$v);
                    } 
                }
                // 虚业绩占比
                $item_data["col7"] = round(floatval($item_data["col3"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col4"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col5"])/floatval($item_data["col2"]),2)."/".round(floatval($item_data["col6"])/floatval($item_data["col2"]),2);

                // 实业绩占比
                $item_data["col13"] = round(floatval($item_data["col9"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col10"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col11"])/floatval($item_data["col8"]),2)."/".round(floatval($item_data["col12"])/floatval($item_data["col8"]),2);

                // 售卡业绩占比
                $item_data["col19"] = round(floatval($item_data["col15"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col16"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col17"])/floatval($item_data["col14"]),2)."/".round(floatval($item_data["col18"])/floatval($item_data["col14"]),2);
                array_push($items_data, $item_data);
            }
           
        }

        $return_data = array();
        if($item_data){
            $return_data["code"]="000";
            $return_data["message"]="success";
            $return_data["items"] = $items_data;
        }else{
            $return_data["code"]="001";
            $return_data["message"]="error";
            $return_data["items"] = '';
        }      
        
        print_r(json_encode($return_data));
    }

    // 调接口 获取卡金分配情况
    public function store_period_classify_report_checkcard_new()
    {
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $storeid = $this->input->get_post("seach_storeid");
        $start_date = $this->input->get_post("start_date");
        $end_date = $this->input->get_post("end_date");

        $url = "http://10.0.3.35:8089/venus/calsalary/getNoCardShare?storeId=".$storeid."&fromdate=".$start_date."&todate=".$end_date."";
        //echo $url;
        $my_curl = curl_init();    //初始化一个curl对象
        curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
        curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
        $str = curl_exec($my_curl);    //执行请求
        //echo $str;    //输出抓取的结果
        curl_close($curl);    //关闭url请求
        $dataAarray = json_decode($str,true);
        print_r(json_encode($dataAarray));
    }

    // 卡金分配明细 窗口页面
    public function store_period_classify_report_cardwindow_new()
    {
        $this->load->view("report/dm/store_period_classify_cardwindow_view",$return);
    }
}
?>