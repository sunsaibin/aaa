<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * 文件名称包含h5字符，表示手机端界面
 * */
class Flow_initiate_h5 extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    public function initiate($flow_id)
    {
        $this->load->model('flow_block/flow_initiate_model', 'flow');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        //echo "<pre>";var_dump($return);die;
        $return["query"] = $this->flow->get_flow_form($flow_id);
        $return["message"] = "";
        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/initiate_h5/flow_initiate_h5_view',$return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
        $this->load->view('flow_block/flow_annotation_js',$return);
        $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"show"));
    }

    //保存数据
    public function save_form()
    {
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $fileinfo =$this->initiate->do_file();
        if(!$fileinfo) {
            $fileinfo = '';
        }

        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $ffid = $this->input->post("flowid");
        if(!isset($ffid)){
            echo '流程数据不正确！请联系系统管理员.';
            exit;
        }

        $data["query"] = $this->initiate->save_flow_form($fileinfo, $ffid, $return["userid"], $return["type"], $return["companyid"],$return["storeid"],$return["companyname"],$return["storename"],$return["username"]);
        //var_dump($data["query"]);die;
        $data["message"] = "";
        redirect('flow_own_h5/own_flow');
    }
}


?>