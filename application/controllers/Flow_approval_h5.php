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
class Flow_approval_h5 extends CI_Controller
{
    public function index()
    {
        echo '200';
    }

    //等待我审批
    public  function approval(){
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('flow_block/flow_approval_model','approval');
        $this->load->model('user/User_model', 'user');
        $flow_header = $this->user->flow_header();
        $userid = $flow_header["userid"];
        $type = $flow_header["type"];

        $return = $this->user->store_header();
        $return["query"] = $this->approval->get_user_approval($return["storeWhere"], $return["seach_companyid"], $return["stallInfo"]->username, $return["stallInfo"]->id, $type);

        $return["waitme"] = array();
        $return["throughme"] = array();
        foreach ($return["query"] as $key => $value) {
            $lufs_approval_users = explode(',',$value->lufs_approval_user);
            
            if($value->luf_is_approve == 0 || $value->luf_is_approve == 1 || $value->luf_is_approve == 4){
                if(!in_array($userid,$lufs_approval_users)){
                    array_push($return["waitme"],$value);
                }
            }
            if($value->luf_is_approve == 1 || $value->luf_is_approve == 2 || $value->luf_is_approve == 3){
                if(in_array($userid,$lufs_approval_users)){
                    array_push($return["throughme"],$value);

                }
            }
        }
        $return["waitCount"] = count($return["waitme"]);
        $return["throughCount"] = count($return["throughme"]);
        $return["message"] = "";

        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/approval_h5/approval_view', $return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
    }

    // 查看其中单个流程
    public function  approval_flow($user_flow_id)
    {
        $this->load->model('flow_block/Flow_approval_model', 'approval');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        if(!isset($user_flow_id)){
            echo "Entry is not correct!";
            exit;
        }

        /*$tid = $this->input->post("tid");
        if (!isset($tid)) {
            $tid = $this->input->get("tid");
        }

        if(!isset($tid)){
            echo "Entry is not correct!";
            exit;
        }*/

        $flowform = $this->approval->get_user_flow_form($user_flow_id);
        $userdata_flow_entity = $this->approval->get_userdata_flow_entity();
        $userdata_flowform_entity = $this->approval->get_userdata_flow_form($user_flow_id);
        $userdata_flowstep_entity = $this->approval->get_userdata_flowstep_entity($user_flow_id);

        $return["user_flow_id"] = $user_flow_id;
        $return["flowform"] = $flowform;
        $return["userdata_flowform_entity"] = $userdata_flowform_entity;
        $return["userdata_flowstep_entity"] = $userdata_flowstep_entity;
        $return["userdata_flow_entity"] = $userdata_flow_entity;

        //表单展示
         $this->load->view('viewheaders/h5/header_h5', $return);
        if($userdata_flow_entity->luf_type == 2){
            $this->load->view('del_oa/dm1/own_auditing_frame_view', $return);
        }
        else{
            $this->load->view('del_oa/dm1/own_auditing_view', $return);
        }

        //审批步骤展示
        //$this->load->view('del_oa/dm1/own_auditing_view', $return);

        $this->load->view('viewfeet/h5/foot_h5', $return);
        $this->load->view('flow_block/flow_annotation_js',array("submit_hide"=>"hide"));
        $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"hide"));
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
            redirect("flow_approval_h5/approval_flow/".$user_flow_id);
        }
        $this->execute->execute_flow($return["userid"], $return["type"],$user_flow_id,$adopt,$explain);
        echo "<script>alert('操作成功');location.href='".site_url().'/flow_approval_h5/approval'."';</script>";// 跳转到审核列表页
    }
}

?>
