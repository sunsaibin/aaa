<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 3:46
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 审批流程
 * */
class Flow_approval extends CI_Controller
{
    public function index()
    {   
        //echo phpinfo();
        $arr = array();
        $arr[0] = '';
        var_dump(isset($arr));var_dump(empty($arr));var_dump(in_array('',$arr));die;
    }

    //等待我审批
    /*public  function approval(){
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["query"] = $this->approval->get_user_approval($return["userid"], $return["type"]);
        //echo "<pre>"; var_dump($return["query"]);die;
        $return["message"] = "";

        //echo "<pre>";print_r($return);die;
        $this->load->view('viewheaders/charisma/header', $return);
        $this->load->view('flow_block/approval/approval_view', $return);
        $this->load->view('viewfeet/charisma/foot', $return);
    }*/
    //等待我审批
    public  function approval($companyid,$storeid){
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $this->load->model('flow_block/Flow_initiate_model', 'initiate');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["store_header"] = $this->user->store_header();
        //echo "<pre>";print_r($return["store_header"]);die;
        $return["seach_name"] = $return["store_header"]["seach_name"];
        $return["seach_companyid"] = $return["store_header"]["seach_companyid"];
        $return['id'] = $return["store_header"]["stallInfo"]->id;
        // 返回按钮 返回时保持原界面不变
        if(isset($storeid)){
            if($storeid == 0){
                $return["seach_storeid"] = $storeid;
                $seach_name = $this->initiate->get_seach_name($companyid);
                $return["seach_companyid"] = $seach_name[0]->COMPANYID;
                $return["seach_name"] = $seach_name[0]->COMPANYNAME;
            }else{
                $return["seach_storeid"] = $storeid;
                $seach_name = $this->initiate->get_store_name($storeid);
                $return["seach_companyid"] = $seach_name[0]->COMPANYID;
                $return["seach_name"] = $seach_name[0]->STORENAME;
            }
        }else{
            $return["seach_storeid"] = $return["store_header"]["seach_storeid"];
        }
        //$return["query"] = $this->approval->get_user_approval($return["userid"], $return["type"]);
        //echo "<pre>"; var_dump($return["query"]);die;
        $return["message"] = "";

        //echo "<pre>";print_r($return);die;
        $this->load->view('viewheaders/charisma/header', $return);
        //$this->load->view('flow_block/approval/approval_view', $return);
        $this->load->view('flow_block/approval/approval_new_view', $return);
        $this->load->view('viewfeet/charisma/foot', $return);
        $this->load->view('flow_block/flow_ownlist_js');
    }

    // 查看其中单个流程  $userflow_id卡操作流程获取数据需要的id
    public function  approval_flow($user_flow_id, $is_approve, $companyid, $storeid, $userflow_id)
    {
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $return["seach_companyid"] = $companyid;
        $return["seach_storeid"] = $storeid;
        if(!isset($user_flow_id)){
            echo "Entry is not correct! user_flow_id is null!";
            exit;
        }

        $flowform = $this->approval->get_user_flow_form($user_flow_id);
        $userdata_flow_entity = $this->approval->get_userdata_flow_entity($user_flow_id);
        // 人事/卡操作流程分别获取表单数据
        if($flowform[0]->flowform_id == 14){
            // 表单id为14 会员退卡
            //$url = "http://10.1.8.171:8000/appAPI/card/return/searchLcBackCard?applyId=".$userflow_id;
            $url = "http://10.0.3.35:8089/venus/card/return/searchLcBackCard?applyId=".$userflow_id;
            $my_curl = curl_init();    //初始化一个curl对象
            curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            //echo $str;    //输出抓取的结果
            curl_close($curl);    //关闭url请求
            $json = json_decode($str,true);
            if($json["status"] == 1){
                $applyCardData = $json["data"];
                setcookie("subMsg",json_encode($applyCardData["subMsg"]), time()+3600*24);
                setcookie("cardMethod",$applyCardData["cardMethod"], time()+3600*24);
                setcookie("cardType",$applyCardData["cardType"], time()+3600*24);
                setcookie("payTypeId",$applyCardData["payTypeId"], time()+3600*24);
            }else{
                $return["flag"] = 0;
            }
            
        }
        elseif($flowform[0]->flowform_id == 16){
            // 表单id为16 会员卡补卡
            //$url = "http://10.1.8.171:8000/appAPI/card/return/searchLcBackCard?applyId=".$userflow_id;
            $url = "http://10.0.3.35:8089/venus/card/return/searchLcBackCard?applyId=".$userflow_id;
            $my_curl = curl_init();    //初始化一个curl对象

            curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            //echo $str;    //输出抓取的结果
            curl_close($curl);    //关闭url请求
            $json = json_decode($str,true);
            //echo "<pre>";var_dump($json);die;
            if($json["status"] == 1){
                $applyCardData = $json["data"];
                setcookie("subMsg",json_encode($applyCardData["subMsg"]), time()+3600*24);
                /*setcookie("cardMethod",$applyCardData["cardMethod"], time()+3600*24);
                setcookie("cardType",$applyCardData["cardType"], time()+3600*24);
                setcookie("payTypeId",$applyCardData["payTypeId"], time()+3600*24);*/
            }else{
                $return["flag"] = 0;
            }
        }
        elseif($flowform[0]->flowform_id == 17){
            // 表单id为17 返充申请
            //$url = "http://10.1.8.167:8000/appAPI/web/storecosthandmade/getstorecardconfirm?applyId=".$userflow_id;
            $url = "http://10.0.3.35:8089/venus/card/return/searchLcBackCard?applyId=".$userflow_id;
            $my_curl = curl_init();    //初始化一个curl对象

            curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            //echo $str;    //输出抓取的结果
            curl_close($curl);    //关闭url请求
            $json = json_decode($str,true);
            //echo "<pre>";var_dump($json);die;
            if($json["status"] == 1){
                $applyCardData = $json["data"];
                setcookie("cardSubs",json_encode($applyCardData["cardSubs"]), time()+3600*24);
                /*setcookie("cardMethod",$applyCardData["cardMethod"], time()+3600*24);
                setcookie("cardType",$applyCardData["cardType"], time()+3600*24);
                setcookie("payTypeId",$applyCardData["payTypeId"], time()+3600*24);*/
            }else{
                $return["flag"] = 0;
            }
        }
        elseif($flowform[0]->flowform_id == 18){
            // 表单id为18 返销申请
            //$url = "http://10.1.8.167:8000/appAPI/web/storecosthandmade/getstorecardconfirm?applyId=".$userflow_id;
            $url = "http://10.0.3.35:8089/venus/card/return/searchLcBackCard?applyId=".$userflow_id;
            $my_curl = curl_init();    //初始化一个curl对象

            curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            //echo $str;    //输出抓取的结果
            curl_close($curl);    //关闭url请求
            $json = json_decode($str,true);
            //echo "<pre>";var_dump($json);die;
            if($json["status"] == 1){
                $applyCardData = $json["data"];
                setcookie("productList",json_encode($applyCardData["prducts"]), time()+3600*24);
                /*setcookie("cardMethod",$applyCardData["cardMethod"], time()+3600*24);
                setcookie("cardType",$applyCardData["cardType"], time()+3600*24);
                setcookie("payTypeId",$applyCardData["payTypeId"], time()+3600*24);*/
            }else{
                $return["flag"] = 0;
            }
        }
        else{
            $userdata_flowform_entity = $this->approval->get_userdata_flow_form($user_flow_id);
        }
        
        $userdata_flowstep_entity = $this->approval->get_userdata_flowstep_entity($user_flow_id);

        foreach ($userdata_flowform_entity as $k => $v) {
            $store_name_key = $v->lfuff_key;
            if(strpos($store_name_key, 'store_name') != false){
                $store_name_value = $v->lfuff_value;               
            }

        }
        $is_approve = urldecode($is_approve);
        $return["is_approve"] = $is_approve; // 审核状态
        $return['store_name_value'] = $store_name_value;
        $return["flowform"] = $flowform;
        $return["userdata_flowform_entity"] = $userdata_flowform_entity; //人事流程表单信息
        $return["userdata_flowstep_entity"] = $userdata_flowstep_entity;
        $return["userdata_flow_entity"] = $userdata_flow_entity;
        $return["applyCardData"] = $applyCardData; // 卡操作流程表单信息
        $return["userflow_id"] = $userflow_id; // 卡操作流程申请id
    //echo "<pre>";print_r($userdata_flowstep_entity);die;
        $return["storeid"] = $userdata_flow_entity->luf_storeid;
        $return["flow_user_data"] = array("dm_systable_userdata_storeid"=> $userdata_flow_entity->storeid);

        $this->load->view('viewheaders/flow/header', $return);

        //表单展示
        if($userdata_flow_entity->luf_type == 2){
            $this->load->view('flow_block/approval/approval_frame_view', $return);
        }
        else{
            $this->load->view('flow_block/approval/approval_flow_view', $return);
        }

        //审批步骤展示
        $this->load->view('flow_block/approval/approval_auditing_detail_view', $return);

        //审批操作
        $this->load->view('flow_block/approval/approval_auditing_execute_view', $return);

        $this->load->view('viewfeet/flow/foot_own_form', $return);
        if($flowform[0]->flowform_id == 14 || $flowform[0]->flowform_id == 16 || $flowform[0]->flowform_id == 17 || $flowform[0]->flowform_id == 18){
            $this->load->view('flow_block/cardCheckAPiJs',array("submit_hide"=>"hide"));
        }else{
            $this->load->view('flow_block/flow_annotation_js',array("submit_hide"=>"hide"));
            $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"show"));
        }
        
    }

    public function approval_form($user_flow_id)
    {
        $data = $this->input->post();

        $explain = $this->input->get_post("explain");
        $adopt = $this->input->get_post("adopt");

        $this->load->model('flow_block/Flow_approval_execute_model', 'execute');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        if(!isset($user_flow_id)){
            echo "Entry is not correct! user_flow_id is null!";
            exit;
        }

        if(!isset($adopt)){
            echo "Entry is not correct! adopt is null!";
            exit;
        }
        if($adopt == -1){
            redirect("flow_approval/approval_flow/".$user_flow_id);
        }
        $this->execute->execute_flow($return["userid"], $return["type"],$user_flow_id,$adopt,$explain);
       echo "<script>alert('操作成功');location.href='".site_url().'/flow_approval/approval'."';</script>";// 跳转到审核列表页
    }


    public function exec_approval_sql($id)
    {
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $this->approval->exec_approval_sql_task($id);
        // table sql 
        // exec sql
    }

    // 员工异动插入请假申请 (执行请假申请未加入异动前的数据)
    public function exec_staffinfo_change()
    {
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $formData = $this->approval->exec_staffinfo_change();
        $formDataArray = array();
        $user_flow_id = '';
        foreach ($formData as $key => $value) {
            $user_flow_id = $value->lfuff_userflow;

            if($user_flow_id == $value->lfuff_userflow){
                $formDataArray[$user_flow_id][$value->lfuff_key] = $value->lfuff_value;
            }
        }
        foreach ($formDataArray as $k => $v) {
           $id =  $this->approval->add_staffchange_info($v);
           echo "<pre>";var_dump($id);
        }
    }
}

?>
