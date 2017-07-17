<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/9
 * Time: 10:37
 *
 * 流程字典模块, 下拉列表及数据功能注入功能
 * model(Flow_dictionary_statics_model(不需要链接数据库)|Flow_dictionary_model(需要链接数据库))
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_dictionary extends CI_Controller
{
    public function index()
    {
        echo "200";
    }

    //获取员工信息
    public function  get_staff_entity($storeid)
    {
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('user/User_model', 'user');

        $return = array();
        $return["status"] = "001";
        $return["message"] = "err!001";

        // 添加字典数据.
        $dictionary = array();
        $dictionary["salarytype"] = $this->dictionary_data->bm_staff_salarytype();
        $return["dictionary"] = $dictionary;


        $data = $this->user->seach_header();

        $is_ajax = $this->input->is_ajax_request();

        $staff_number = $this->input->get_post("staff_number");
        
        if(!isset($staff_number)){
            $return["status"] = "001";
            $return["message"] = "staffid is null!";
        }
        else{
            $return["item"] = $this->dictionary->get_staff_entity($staff_number,$storeid);
            $return["status"] = "000";
            $return["message"] = "data success.";
        }

        print_r(json_encode($return));
    }

    public function get_staff_entity_h5($storeid)
    {
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('user/User_model', 'user');

        $return = array();
        $return["status"] = "001";
        $return["message"] = "err!001";

        // 添加字典数据.
        /*$dictionary = array();
        $dictionary["salarytype"] = $this->dictionary_data->bm_staff_salarytype();
        $return["dictionary"] = $dictionary;*/


        $data = $this->user->seach_header();

        $is_ajax = $this->input->is_ajax_request();

        $staffinfo = $this->input->get_post("staffinfo");
        $flowid = $this->input->get_post("flowid");
        
        if(!isset($staffinfo)){
            $return["status"] = "001";
            $return["message"] = "staffid is null!";
        }
        else{
            $return["item"] = $this->dictionary->get_staff_entity_h5($staffinfo,$storeid,$flowid);
            $return["status"] = "000";
            $return["message"] = "data success.";
        }

        print_r(json_encode($return));
    }

    public function  get_staff_entity_idcard($storeid)
    {
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('user/User_model', 'user');

        $return = array();
        $return["status"] = "001";
        $return["message"] = "err!001";

        // 添加字典数据.
        $dictionary = array();
        $dictionary["salarytype"] = $this->dictionary_data->bm_staff_salarytype();
        $return["dictionary"] = $dictionary;


        $data = $this->user->seach_header();

        $is_ajax = $this->input->is_ajax_request();

        $staff_idcard = $this->input->get_post("staff_idcard");

        if(!isset($staff_idcard)){
            $return["status"] = "001";
            $return["message"] = "idcard is null!";
        }
        else{
            $item = $this->dictionary->get_staff_entity_idcard($staff_idcard,$storeid);
            if($item){
                $return["status"] = "000";
                $return["message"] = "data success.";
                $return["item"] = $item;
                // 生效日志(离职日期)
                $change_date = $this->dictionary->get_change_date($return["item"]->STAFFID);
                $return["change_date"] = $change_date;
            }else{
                $return["status"] = "002";
                $return["message"] = "err!002";
            }
        }

        
        print_r(json_encode($return));
    }

    //获取员工列表 $STOREID=>
    public function  get_staff_list($storeid){
        //"SELECT * FROM STAAFF WHERE STOREID"
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $staff_number = $this->input->get_post("param");
        //var_dump($staff_number);die;
        $return['items'] = $this->dictionary->get_staff_list($storeid, $staff_number);
        print_r(json_encode($return));
    }

    public function  get_store_entity(){

    }

    public function  get_store_list($storeid){
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');

        $return = array();
        $return["status"] = "001";
        $return["message"] = "success";

        // 添加字典数据.
        $dictionary = array();
        if(!empty($storeid)){
            $dictionary["items"] = $this->dictionary->bm_store_kv($storeid);
        }else{
            $dictionary["items"] = $this->dictionary->get_store_list();
        }
        
        $return["dictionary"] = $dictionary;
        print_r(json_encode($return));
    }

    //datatype=static
    public function get_select_option($model,$storeid,$companyid)
    {
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('user/User_model', 'user');
        $data = $this->user->flow_header();

        $return = array();
        $return["status"] = "000";
        $return["message"] = "success";
        $return["model"] = $model;
        $return["param"] = $this->input->post("param");

        // 添加字典数据.
        if($this->dictionary_data->is_static_select_option($model)){
            //静态的
            $return["items"] = $this->dictionary_data->get_select_option($data,$model);
        }
        else{
            //动态的
            $return["items"] = $this->dictionary->get_select_option($companyid,$storeid, $model);
        }

        print_r(json_encode($return)); 
    }

    public function get_check_data($model,$storeid)
    {
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('user/User_model', 'user');
        $data = $this->user->flow_header();


        $check_data = $this->input->post("check_data");        

        $return = $this->dictionary->get_check_data($storeid,$model,$check_data);
        $return["param"] = $this->input->post("param");
        //echo "<pre>";var_dump($return);die;
        print_r(json_encode($return)); 
    }

    public function get_form_initdata()
    {
        $this->load->model('flow_block/Flow_dictionary_statics_model', 'dictionary_data');
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $this->load->model('user/User_model', 'user');
        $userData = $this->user->flow_header();
        $model = $this->input->post("model");
        $flow_storeid = $this->input->post("flow_storeid");
        $flow_compid = $this->input->post("flow_compid");
        $return = array();
        $return["status"] = "000";
        $return["message"] = "success";
        $return["model"] = $model;
        $return["param"] = $this->input->post("param");

        $dataJson = array();
        if($model == "user_data"){
            array_push($dataJson, array('option_key'=>'store_name', 'option_value'=>$userData['storename']));
            $return["items"] = $dataJson;
        }
        else{

            // 添加字典数据.
            if($this->dictionary_data->is_static_select_option($model)){
                //静态的
                $return["items"] = $this->dictionary_data->get_select_option($data,$model);
            }
            else{
                //动态的
                $return["items"] = $this->dictionary->get_select_option($flow_compid,$flow_storeid, $model);
            }
        }

        echo json_encode($return);
    }

    public function getStoreInfo()
    {
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $storeShortNum = $this->input->get_post("storeShortNum");
        $storeInfo = $this->dictionary->getStoreInfo($storeShortNum);
        echo json_encode($storeInfo);exit();
    }

    public function get_session()
    {
        $this->load->model('user/User_model', 'user');
        $userData = $this->user->flow_header();
        echo json_encode($userData);
    }

    //**
    public function  js($storeid)
    {
        $return = array();
        $return["storeid"] = $storeid;

        $this->output->set_content_type('application/x-javascript', 'UTF-8');
        $this->load->view('del_oa/dm1/flow_annotation_js',$return);
    }

    /*
     * js 跨域请求数据问题。使用此接口在服务端跳转数据。
     * 参数:url=>base64格式(包含get数据)
     *      postdata=>post数据
     * */
    public function getJumpUrl($urlBase64, $postdata)
    {
        $urlBase64 = str_replace(".","=",$urlBase64);
        $urlBase64 = str_replace("#","+",$urlBase64);
        $urlBase64 = str_replace("_","-",$urlBase64);


        $url = base64_decode($urlBase64);
        $data = base64_decode($postdata);

        //print_r($url);g2q4c3
        // 初始化curl
        $ch = curl_init ();
        // 设置URL参数
        curl_setopt( $ch, CURLOPT_URL, $url );
        // 设置cURL允许执行的最长秒数
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60);
        // 要求CURL返回数据
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);

        // 执行请求
        $result = curl_exec($ch);
        // 获取http状态
        $http_code = curl_getinfo ($ch, CURLINFO_HTTP_CODE );
        curl_close ( $ch );
        print_r($result);
        //print_r($http_code);
    }
}

?>