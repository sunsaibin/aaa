<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 申请流程,及表单数据展示
 * flow_initiate(发起申请)
 * flow_own(自己拥有或者待自己审核的申请)
 * */
class Flow_initiate extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    /*
     * 流程模板入口,
     * flow_id 对应的数据库fw_flow_flowstep的ff_id.
     * */
    public function initiate($flowid)
    {   
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $return["store_header"] = $this->user->store_header();
        $return["seach_name"] = $return["store_header"]["seach_name"];
        $return["seach_companyid"] = $return["store_header"]["seach_companyid"];
        $return["seach_storeid"] = $return["store_header"]["seach_storeid"];
        $return["query"] = $this->initiate->get_flow_form($flowid);
        $return["message"] = "";
        $return["flowid"] = $flowid;

        $store_entity =  $this->user->getUserStore();
        $return["storeid"] =$store_entity->STOREID;

        $return["flow_user_data"] = array("dm_systable_userdata_storeid"=>$store_entity->STOREID,"dm_systable_userdata_storename"=>$store_entity->STORENAME);
        $this->load->view('viewheaders/flow/header',  $return);
        $this->load->view('flow_block/initiate/flow_initiate_view', $return);
        $this->load->view('viewfeet/flow/foot', $return);
        $this->load->view('flow_block/flow_annotation_js',$return);
        $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"show"));
    }

    /*
     * 通过from选择相应的表单
     * */
    public function  select_initiate()
    {
        $flow_flowstep = $this->input->post("flow_flowstep");
        if (!isset($flow_flowstep)) {
            $flow_flowstep = $this->input->get("flow_flowstep");
        }

        if(!isset($flow_flowstep)){
            echo "Entry is not correct!";
            exit;
        }
        $this->initiate($flow_flowstep);
    }

    //保存表单
    public function save_form()
    {   
        $data = $this->input->post();
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $fileinfo =$this->initiate->do_file();
        if(!$fileinfo) {
            $fileinfo = '';
        }

        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $ffid = $this->input->post("ffid");
        //echo "<pre>"; var_dump($return);die;
        if(!isset($ffid)){
            echo '流程数据不正确！请联系系统管理员.';
            exit;
        }

        $data["query"] = $this->initiate->save_flow_form($fileinfo, $ffid, $return["userid"], $return["type"], $return["companyid"], $return["storeid"], $return["companyname"], $return["storename"], $return["username"]);
        $data["message"] = "";
        echo "<script>alert('操作成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";// 当前页面刷新
    }
}
?>