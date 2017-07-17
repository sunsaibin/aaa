<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/1/9
 * Time: 11:06
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    private function wpjam_strip_control_characters($str){
        return preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $str);
    }

    function base_encode($str) {
        $src  = array("/","+","=");
        $dist = array("_a","_b","_c");
        $old  = base64_encode($str);
        $new  = str_replace($src,$dist,$old);
        return $new;
    }

    function base_decode($str) {
        $src = array("_a","_b","_c");
        $dist  = array("/","+","=");
        $old  = str_replace($src,$dist,$str);
        $new = base64_decode($old);
        return $new;
    }

    public function  get_user_data_api(){
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $user = array();
        $user["companyId"] = $return["companyid"];
        $user["companyame"] = $return["companyname"];
        $user["storeId"] = $return["storeid"];
        $user["storeName"] = $return["storename"];
        $user["id"] = $return["userid"];

        $data = array();
        $data["user"] = $user;
        print_r(json_encode($data));
    }

    public function get_server_get_api($base64)
    {
        $this->load->model('api/api_data_model', 'api');
        $url_data = base64_decode($base64);

        $get_data = "tem_dm_none=1";
        foreach ($_REQUEST as $key => $value) {
            $get_data = $get_data . "&" . $key . "=" . $value;
        }

        $url_data = trim($url_data);
        $url_data = $this->wpjam_strip_control_characters($url_data);
        if((bool)strpos($url_data, "?")){
            $url = $url_data."&".$get_data;
        }
        else{
            $url = $url_data."?".$get_data;
        }

        $return = $this->api->get_url($url);
        print_r($return);
    }

    public function get_server_post_api($base64)
    {
        $this->load->model('api/api_data_model', 'api');
        $base64_url_data = $this->base_decode($base64);
        $url_data = substr($base64_url_data,38);
        $post_data = file_get_contents("php://input");

        $url = 'http://10.0.3.35:8089/venus/'.$url_data;
        
        $return = $this->api->post_url($url, $post_data);
        print_r($return);
        //post_url
    }

    public function get_server_get_api_noneurl($base64)
    {
        $this->load->model('api/api_data_model', 'api');
        $base64_url_data = base64_decode($base64);
        $url_data = substr($base64_url_data,38);
        $get_data = "tem_dm_none=1";
        foreach ($_REQUEST as $key => $value) {
            $get_data = $get_data . "&" . $key . "=" . $value;
        }

        $url_data = trim($url_data);
        if((bool)strpos($url_data, "?")){
            $url = 'http://10.0.3.35:8089/venus/'.$url_data."&".$get_data;
        }
        else{
            $url = 'http://10.0.3.35:8089/venus/'.$url_data."?".$get_data;
        }
        $return = $this->api->get_url($url);
        print_r($return);
    }

    // 唐存调用接口
    public function add_task_change()
    {
        $this->load->model('api/api_data_model', 'api');
        /*$chage_before_time = $this->input->get_post("chage_before_time");
        $chage_after_time = $this->input->get_post("chage_after_time");
        $chage_type = $this->input->get_post("chage_type");
        $message = $this->input->get_post("message");
        $staff_id = $this->input->get_post("staff_id");
        $chage_storeid = $this->input->get_post("chage_storeid");
        $chage_companyid = $this->input->get_post("chage_companyid");*/


        $orderId = $this->input->get_post("orderId");
        $orderTime = $this->input->get_post("orderTime");
        $serverTimeNow = $this->input->get_post("serverTimeNow");
        $operationId = $this->input->get_post("operationId");
        $chage_type = $this->input->get_post("changeType");
        //echo "orderId:".$orderId."orderTime:".$orderTime."serverTimeNow:".$serverTimeNow."operationId:".$operationId."type:".$type;
        
        $orderTime = strtotime($orderTime);
        $orderTime = date('Y-m-d H:i:s',$orderTime);

        $serverTimeNow = strtotime($serverTimeNow);
        $serverTimeNow = date('Y-m-d H:i:s',$serverTimeNow);

        $sysinfo = $this->api->get_sys_info($operationId);
        $chage_storeid = $sysinfo[0]->storeId;
        $chage_companyid = $sysinfo[0]->companyid;
        $staffid = $sysinfo[0]->staffid;

        $row = $this->api->add_task_change($chage_storeid,$chage_companyid,$orderTime,$serverTimeNow,$chage_type,$orderId,$staffid);

        if($row>0){
            $data = array(
                'status' => '1',
                'message' => '添加成功',
                'data' => '',
            );
            echo json_encode($data);
            exit;
        }

        $data = array(
            'status' => '0',
            'message' => '添加失败！',
            'data' => '',
        );
        echo json_encode($data);exit();
    }

    public function store_period_classify_report_api()
    {
        $this->load->model('user/User_model', 'user');
        $return = $this->user->store_header();
        $this->load->view("api/store_period_classify_api_view",$return);
    }

    // 调接口 处理分类业绩数据
    public function store_period_classify_report_data_api()
    {
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $storeid = $this->input->get_post("seach_storeid");
        $start_date = $this->input->get_post("start_date");
        $end_date = $this->input->get_post("end_date");

        $url = "http://op.faxianbook.com/dtmaster/calsalary/calCompanyClassPerf?storeId=".$storeid."&fromdate=".$start_date."&todate=".$end_date."";
        $my_curl = curl_init();    //初始化一个curl对象
        curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
        curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
        $str = curl_exec($my_curl);    //执行请求
        //echo $str;    //输出抓取的结果
        curl_close($curl);    //关闭url请求

        $dataAarray = json_decode($str,true);
        //echo "<pre>";var_dump($dataAarray);die;
        if($dataAarray["status"] == 1){
            // 请求成功, 处理数据
            $items_data = array();
            $item_data = array();
            foreach ($dataAarray["data"] as $key => $value) {
                if($key == "storename"){
                    $item_data["col1"] = $value;
                }elseif($key == "totalxperf"){ // 总虚业绩
                    $item_data["col2"] = $value;
                }elseif($key == "beautyxperf"){ // 美容虚业绩
                    $item_data["col3"] = $value;
                }elseif($key == "hairxperf"){ // 美发虚业绩
                    $item_data["col4"] = $value;
                }elseif($key == "manicurexperf"){ // 美甲虚业绩
                    $item_data["col5"] = $value;
                }elseif($key == "otherxperf"){ // 其他虚业绩
                    $item_data["col6"] = $value;
                }elseif($key == "totalsperf"){ // 总实业绩
                    $item_data["col8"] = $value;
                }elseif($key == "beautysperf"){ // 美容实业绩
                    $item_data["col9"] = $value;
                }elseif($key == "hairsperf"){ // 美发实业绩
                    $item_data["col10"] = $value;
                }elseif($key == "manicuresperf"){ // 美甲实业绩
                    $item_data["col11"] = $value;
                }elseif($key == "othersperf"){ // 其他实业绩
                    $item_data["col12"] = $value;
                }elseif($key == "totalsaleperf"){ // 总售卡业绩
                    $item_data["col14"] = $value;
                }elseif($key == "beautysaleperf"){ // 美容售卡业绩
                    $item_data["col15"] = $value;
                }elseif($key == "hairsaleperf"){ // 美发售卡业绩
                    $item_data["col16"] = $value;
                }elseif($key == "manicuressaleperf"){ // 美甲售卡业绩
                    $item_data["col17"] = $value;
                }elseif($key == "othersaleperf"){ // 其他售卡业绩
                    $item_data["col18"] = $value;
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
        $return_data = array();
        $return_data["code"]="000";
        $return_data["message"]="success";
        $return_data["items"] = $items_data;
        print_r(json_encode($return_data));
    }

    // 调接口 获取卡金分配情况
    public function store_period_classify_report_checkcard_api()
    {
        $this->load->model('user/User_model', 'user');

        $return = $this->user->store_header();

        $storeid = $this->input->get_post("seach_storeid");
        $start_date = $this->input->get_post("start_date");
        $end_date = $this->input->get_post("end_date");

        $url = "http://op.faxianbook.com/dtmaster/calsalary/getNoCardShare?storeId=".$storeid."&fromdate=".$start_date."&todate=".$end_date."";
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
    public function store_period_classify_report_cardwindow_api()
    {
        $this->load->view("api/store_period_classify_cardwindow_view",$return);
    }
}

?>