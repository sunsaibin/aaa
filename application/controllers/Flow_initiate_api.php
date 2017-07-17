<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * flow_initiate(发起申请)
 * flow_own(自己拥有或者待自己审核的申请)
 * */
class Flow_initiate_api extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    public function test()
    {
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
/*        $sql = "select * from fw_flow_flowstep where ff_id=15";
        $query = $this->db->query($sql);
        $status = $query->result_array();
        print_r($status);die;*/
        $flowid = "15";
        $return["query"] = $this->initiate->get_flow_flowstep_entity($flowid);
        $return["message"] = "";
        $return["flowid"] = $flowid;

        print_r($return["query"]);
        
    }

    /*
     * 流程模板入口,
     * flow_id 对应的数据库fw_flow_flowstep的ff_id.
     * */
    public function initiate_test($flowid)
    {
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["query"] = $this->initiate->get_flow_form_api_test($flowid);
        $return["message"] = "";
        $return["flowid"] = $flowid;

        $this->load->view('viewheaders/flow/header',  $return);
        $this->load->view('flow_block/initiate/flow_initiate_view', $return);
        $this->load->view('viewfeet/flow/foot', $return);
        $this->load->view('flow_block/flow_annotation_js',$return);
        $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"show"));
    }

    //统一编码
    function fixEncoding($in_str)
    {
        $cur_encoding = mb_detect_encoding($in_str);
        if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8"))
            return $in_str;
        else
            return utf8_encode($in_str);
    } // fixEncoding

    public function save_form()
    {
        header('Access-Control-Allow-Origin:*');    
        header('Access-Control-Allow-Methods:POST');    
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $fileinfo =$this->initiate->do_file();
        if(!$fileinfo) {
            $fileinfo = '';
        }
        //echo '123';exit();

        $postdatasrc = file_get_contents("php://input");
        //print_r($postdatasrc);exit();
        $postdata = urldecode($postdatasrc);
        //print_r($postdata);exit();
        //$postdata  = $this->fixEncoding($postdata);
        /*if( $postdata.strpos("=") == 0 ){
            $postdata = substr($postdata, 1);
        }*/
        //print_r($postdata);exit();
        
        $param_dict = json_decode($postdata,true);
        //print_r($param_dict);exit();
        /*print_r(json_last_error());
        print_r($postdata);
        exit();*/

        $ffid = $param_dict["flowid"];
        $userid = $param_dict["staffid"];
        $companyid = $param_dict["companyid"];
        $storeid = $param_dict["storeid"];
        // $ffid = $this->input->post("flowid");
        $storename = $param_dict["storename"];
        $companyname = $param_dict["companyname"];
        $username = $param_dict["userName"];
        $usertype = "1";
        if(isset($param_dict["userflow_id"])){
            $userflow_id = $param_dict["userflow_id"];
        }else{
            $userflow_id = 0;
        } 

        //测试数据
        /*$ffid = '17';
        $userid = '40';
        $companyid = '5';
        $storeid = $param_dict["storeid"];
        // $ffid = $this->input->post("flowid");
        $storename = '克罗心|金汇店';
        $companyname = '克罗心';
        $username = 'ssbin';
        $usertype = "1";*/

        $client_param = array();
        $cf_key_array = array("flowid","staffid","companyid","storeid","storename","companyname","username");//必须要传的值
        foreach ($param_dict as $key => $value) {
            if(!array_key_exists($key, $cf_key_array)){
               $client_param["#".$key] = $value;
            }
        }


        // $imgData = array();
        // $imgData['img_big'] = $param_dict["api_app_user_headimg_update_img_big"];
        // $imgData['img_mid'] = $param_dict["api_app_user_headimg_update_img_mid"];
        // $imgData['img_min'] = $param_dict["api_app_user_headimg_update_img_min"];
        

        //print_r($ffid."_".$userid."_".$companyid."_".$storeid."_".$storename."_".$companyname ."_".$username);
        //exit;
        /*$ffid = "16";
        $userid = "3";
        $img_big = $param_dict["api_app_user_headimg_update_img_big"];
        $img_mid = $param_dict["api_app_user_headimg_update_img_mid"];
        $img_min = $param_dict["api_app_user_headimg_update_img_min"];
        $companyid = "3";
        $storeid = "3";
        $storename = "天玥桥店";
        $companyname = "<null>";
        $username = "蒋雯";
        $usertype = "1";*/

        /*$ffid = $this->input->post("flowid");
        $userid = $this->input->post("userid");
        $companyid = $this->input->post("companyid");
        $storeid = $this->input->post("storeid");
        $storename = $this->input->post("storename");
        $companyname = $this->input->post("companyname");
        $username = $this->input->post("username");
        $usertype = "1";*/
        if(!isset($ffid)){
            $json = array(
                'status' => "0",
                'message' => '没有flowid',
                'data' => '',
            ); 
            echo json_encode($json);exit();       
        }

    

        /*print_r($ffid."_".$userid."_".$companyid."_".$storeid."_".$storename."_".$companyname ."_".$username);
        exit;*/

        //申请进店校验
        if($ffid==17){
            $return = $this->initiate->get_exists_initiate_api($userid, $storeid);
            if($return){
                $json = array(
                    'status' => "0",
                    'message' => '申请已经存在！',
                    'data' => '',
                );
                echo json_encode($json);exit();
            }
        }
        
        $data["query"] = $this->initiate->save_flow_form_api($fileinfo, $ffid, $userid,  $usertype, $companyid, $storeid, $companyname, $storename, $username, $client_param, $userflow_id);
        $data["message"] = "";

        $json = array(
            'status' => "1",
            'message' => 'success',
            'data' => '', 
        );
        echo json_encode($json);exit();
    }
}
?>