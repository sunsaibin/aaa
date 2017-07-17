<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * */
class Flow_own_api extends CI_Controller
{
    public function index()
    {
        echo '200';
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

    //app形象照伪删除
    public function fake_delete()
    {
        $this->load->model('flow_block/flow_own_model', 'own');

        $postdatasrc = file_get_contents("php://input");
        $postdata = urldecode($postdatasrc);
        $param_dict = json_decode($postdata,true);

        $data = array(
                    'status' => '0',
                    'message' => '删除失败！',
                    'data' => '',
                );
        //print_r($param_dict);exit();
        foreach ($param_dict['items'] as $key => $value) {
            $luf_id = $value["luf_id"];
            $userid = $value["userid"];
            $row = $this->own->get_fake_delete($luf_id, $userid);
            if($row>0){
                $data["status"] = "1";
                $data["message"] = "success";
                $data['data'] = '';
            }
        }
        echo json_encode($data);exit();   
    }

    public function get_user_flow_app($flowid){  
        $this->load->model('flow_block/flow_initiate_model', 'initiate');
        $query = $this->initiate->get_user_flow_app($flowid);

        //echo "<pre>"; var_dump($query);die;
        //{"status":"000","msg":"success","items":[{"lfuff_key":"","lfuff_value":"","lfuff_key2":"","lfuff_value2":"","luf_id":"","luf_is_approve":"","imag1":"imag1"},{"lfuff_key":"","lfuff_value":"","luf_id":"","luf_is_approve":""}]}
        $items = array(); //{"16":{}}
        $i=0;

        foreach ($query as $key => $value) {
            $luf_id = $value->luf_id;

            $item = array();
            if(array_key_exists($luf_id,$items)){
                $item = $items[$luf_id];
            }
            else{
                $item['luf_id'] = $value->luf_id;
                $item['flowid'] = $value->luf_flow;
                $item['userid'] = $value->luf_user;
                $item['username'] = $value->luf_user_name;
                $item['storeid'] = $value->luf_storeid;
                $item['storename'] = $value->luf_store_name;
                $item['companyid'] = $value->luf_company;
                $item['companyname'] = $value->luf_company_name;
                $item['is_approve'] = $value->luf_is_approve;
                $item['is_delete'] = $value->luf_isdelete;

                //判断审核中
                // select * from luf_userdata_flowstep where luf_id
                // count(quers)>1 {
                //   $item['is_approve'] = 5;
                // }
            }
            $key = $value->lfuff_key;
            $key = str_replace("#", "", $key);
            $item[$key] = $value->lfuff_value;
            $items[$luf_id] = $item;

            // $items[$key]['flowid'] = $value->luf_flow;
            // $items[$key]['userid'] = $value->luf_user;
            // $items[$key]['username'] = $value->luf_user_name;
            // $items[$key]['storeid'] = $value->luf_storeid;
            // $items[$key]['storename'] = $value->luf_store_name;
            // $items[$key]['companyid'] = $value->luf_company;
            // $items[$key]['companyname'] = $value->luf_company_name;
            // $items[$key]['is_approve'] = $value->luf_is_approve;



            //foreach ($query as $k => $v) {



                // if(array_key_exists('lfuff_key',$v) && array_key_exists('lfuff_key',$v)){
                //     $lfuff_key = $v->lfuff_key;
                //     $luf_id = $v->luf_id;
                //     $items_key = $luf_id . "-" . $lfuff_key;
                //     $items[$key+$i][$items_key] = $v->lfuff_value;
                // }
                /*$luf_id = $value->luf_id;
                $items[$luf_id] = $luf_id;
                $item = array();
                if (array_key_exists($luf_id,$items)) {
                    $item = $items[$luf_id];
                }
                $item['luf_id'] = $luf_id;
                array_push($items,$item);*/
                //$items[$key] = $value->lfuff_value;
            //}
        }
        //print_r(json_encode(array_values($items)));
        //$flowid = $param_dict["flowid"];
      
        return array_values($items);//返回所有值，不包含键

    }


    public function  own_flow()
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('flow_block/Flow_initiate_api_appdata_model', 'appdata');


        $postdatasrc = file_get_contents("php://input");
        $postdata = urldecode($postdatasrc);
        //print_r($postdata);die;
        //$postdata  = $this->fixEncoding($postdata );
        $param_dict = json_decode($postdata,true);
        //print_r($param_dict);die;
        $flowid = $param_dict["flowid"];
        $userid = $param_dict["userid"];

        /*$flowid = '16';
        $userid = '34959';*/

        if(!isset($flowid)){
            $json = array(
                'status' => "0",
                'message' => '没有flowid',
                'data' => '',
            ); 
            echo json_encode($json);exit();       
        }

        $return['query'] = $this->own->get_user_flow_api($flowid);
        $return["userdata"] =$this->appdata->api_flow_16($userid);
        //echo "<pre>";print_r($return['query']);die;
        //$return["info"] = $this->own->get_form_value($return["userid"]);
        //$return["user_haveflows"] = $this->own->get_user_have_flows($return["level"], $return["type"]);
        $return["message"] = "";

        $this->load->view('viewheaders/charisma/header', $return);
        $this->load->view('flow_block/own/own_flowlist_view', $return);
        $this->load->view('viewfeet/charisma/foot', $return);
        $items = $this->get_user_flow_app(array($flowid,$userid));
        $json = array(
            'status' => "1",
            'message' => 'success',
            'data' => $items,
        );
        echo json_encode($json);exit;
    }

}
?>