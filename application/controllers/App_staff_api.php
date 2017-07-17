<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * */
class App_staff_api extends CI_Controller
{
    public function index()
    {
        echo '200';
    }


	public function set_staff_stafflogo()
    {
        $this->load->model('flow_block/flow_initiate_api_appdata_model', 'appdata');
        $this->load->model('flow_block/Flow_approval_execute_model', 'execute');
        $postdatasrc = file_get_contents("php://input");
        $postdata = urldecode($postdatasrc);
        $param_dict = json_decode($postdata,true);
        $userid = $param_dict['userid'];
        $image_url = $param_dict['image_url'];
        /*$userid = '35239';
        $image_url = "http://res.faxianbook.com/app/images/2017/01/13/thumb_2017011305062566.jpg";*/
        $return = $this->appdata->get_is_approve($image_url);
        
        if($row){
            $data = array(
                'status' => '0',
                'message' => '审核未通过',
                'data' => '',
            );
            echo json_encode($data);
            exit;
        }
        $flow_data = $this->execute->get_userdata_flow_flowform($return->luf_id);
        //echo '<pre>';var_dump($flow_data);die;
        $row = $this->appdata->set_stafflogo($flow_data, $userid);
        if($row>0){
            $data = array(
                'status' => '1',
                'message' => '设置成功！',
                'data' => '',
            );
            echo json_encode($data);exit();
        }

        $data = array(
            'status' => '0',
            'message' => '设置失败！',
            'data' => '',
        );
        echo json_encode($data);exit();
    }
}
?>