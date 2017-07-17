<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/11/30
 * Time: 14:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * */
class Flow_own_h5 extends CI_Controller
{
    public function index()
    {
        echo 'ok..';
    }

    public function  own_new_flow(){
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/own_h5/flow_new_flow', $return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
    }

    //创建流程
    public function  own_flow()
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["query"] = $this->own->get_user_flow($return["userid"], $return["type"]);
        $return["info"] = $this->own->get_form_value($return["userid"]);
        $return["user_haveflows"] = $this->own->get_user_have_flows($return["level"], $return["type"]);
        $return["message"] = "";

        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/own_h5/flow_own_sponsor', $return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
    }

    /*
     * 查看步骤. 审批步骤
     * */
    public function own_flowstep($user_flow_id)
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["flowstep_data"] = $this->own->get_user_flowstep($user_flow_id);
        $return["message"] = "";
        $return["user_flow_id"] = $user_flow_id;

        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/own_h5/own_flowstep_view', $return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
    }

    /*
     * 查看表单
     * */
    public function own_flowform($user_flow_id)
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["flowform"] = $this->own->get_user_flow_form($user_flow_id);
        //var_dump($return["flowform"]);die;
        $return["userdataflowform"] = $this->own->get_userdata_flow_form($user_flow_id,$user_flow_id);
        $return["userdataflowstep"] = $this->own->get_user_flowstep_entity($user_flow_id);
        $return["user_flow_id"] = $user_flow_id;

        $this->load->view('viewheaders/h5/header_h5', $return);
        $this->load->view('flow_block/own_h5/own_flowform_view', $return);
        $this->load->view('viewfeet/h5/foot_h5', $return);
        $this->load->view('flow_block/flow_annotation_js',array("submit_hide"=>"hide"));
        $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"hide"));

    }
}

?>