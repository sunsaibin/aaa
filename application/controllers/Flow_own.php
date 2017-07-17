<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/11/30
 * Time: 14:42
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 申请流程,及表单数据展示
 * */
class Flow_own extends CI_Controller
{
    public function index()
    {
        //echo '200';

        //以下设置Email参数  
        $config['protocol'] = 'smtp';  
        $config['smtp_host'] = 'smtp.163.com';  
        $config['smtp_user'] = 'ssb280040021';  
        $config['smtp_pass'] = 'as19890126';  
        $config['smtp_port'] = '25';  
        $config['charset'] = 'utf-8';  
        $config['wordwrap'] = TRUE;  
        $config['mailtype'] = 'html';
        $config['send_multipart'] = FALSE;
        $config ['mailpath'] ='/usr/sbin/sendmail';

        /*$config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'smtp.163.com';
        $config['smtp_user'] = 'zx23324592';//这里写上你的163邮箱账户
        $config['smtp_pass'] = 'ssb1989201728';//这里写上你的163邮箱密码
        $config['mailtype'] = 'html';
        $config['validate'] = true;
        $config['priority'] = 1;
        $config['crlf']  = "\\r\\n";
        $config['smtp_port'] = '465';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;*/

        $this->load->library('email');            //加载CI的email类  
        $this->email->initialize($config);           
          
        //以下设置Email内容  
        $this->email->from('ssb280040021@163.com', 'ssb280040021');  
        $this->email->to('280040021@qq.com');  
        $this->email->subject('Email Test');  
        $this->email->message('<font color=red>Testing the email class.</font>');   

        $state = $this->email->send();
        echo $this->email->print_debugger();
        echo "<div style='width:300px; margin:36px auto;'>"; 
        if($state==""){
            echo "对不起，邮件发送失败！请检查邮箱填写是否有误。";
            exit();
        }
        echo "恭喜！邮件发送成功！！";
        echo "</div>";
  
        //echo $this->email->print_debugger();        //返回包含邮件内容的字符串，包括EMAIL头和EMAIL正文。用于调试。
    }

    /*
     * 自己提交待审批流程,新页面
     * */
    public function  own_flow()
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();
        $return["store_header"] = $this->user->store_header();
        $return["seach_name"] = $return["store_header"]["seach_name"];
        $return["seach_companyid"] = $return["store_header"]["seach_companyid"];
        $return["seach_storeid"] = $return["store_header"]["seach_storeid"];
//echo "<pre>";var_dump($return);die;
        $return["query"] = $this->own->get_user_flow($return["userid"], $return["type"]);
        $return["info"] = $this->own->get_form_value($return["userid"]);
        $return["user_haveflows"] = $this->own->get_user_have_flows($return["level"], $return["type"]);
        $return["message"] = "";

      
        $this->load->view('viewheaders/charisma/header', $return);
        $this->load->view('flow_block/own/own_flowlist_new_view', $return);
        //$this->load->view('flow_block/own/own_flowlist_view', $return);
        $this->load->view('viewfeet/charisma/foot', $return);
        $this->load->view('flow_block/flow_ownlist_js');
    }

    /*
     * 自己提交待审批流程,分页
     * */
    public function own_flow_info($pagenum)
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $this->load->library('pagination');
        $url_pathname = $this->input->post("url_pathname");
        $return['flow_header'] = $this->user->flow_header();
        $type = $return["flow_header"]["type"];
        $return = $this->user->store_header();
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        $staff_number = $this->input->post("staff_number");
        $luf_is_approve = $this->input->post("approval");
        
        if(strpos($url_pathname,'flow_approval') != false){
            // 审核页面
            $userdata = $this->own->get_userdata_flow($return["storeWhere"],$return["seach_companyid"],$start_date,$end_date,$luf_is_approve,$return["stallInfo"]->username,$return["stallInfo"]->id,$type);
        }else{
            // 自己查看页面
            $userdata = $this->own->get_userdata_flow_own($return["storeWhere"],$return["seach_companyid"],$start_date,$end_date,$luf_is_approve,$return["stallInfo"]->username,$return["stallInfo"]->id,$type);
        }

        $config['base_url'] = base_url().'index.php/flow_own/own_flow_info/';
        $config['total_rows'] = $userdata[0]->count;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $total_page = ceil($config['total_rows']/$config['per_page']);

        if($pagenum > $total_page){
            $pagenum = $total_page;//页码不能大于总页数
        }
        if($pagenum<1){
            $pagenum = 1;// 页码不能小于1
        }
        $offset = ($pagenum-1)*$config['per_page'];

        $this->pagination->initialize($config);
        if(strpos($url_pathname,'flow_approval') != false){
            // 审核页面
            $userdata_flow = $this->own->get_userdata_flow_limit($return["storeWhere"],$return["seach_companyid"],$start_date,$end_date,$luf_is_approve,$config['per_page'],$offset,$return["stallInfo"]->username,$return["stallInfo"]->id,$type);
        }else{
            // 自己查看页面
            $userdata_flow = $this->own->get_userdata_flow_own_limit($return["storeWhere"],$return["seach_companyid"],$start_date,$end_date,$luf_is_approve,$config['per_page'],$offset,$return["stallInfo"]->username,$return["stallInfo"]->id,$type);
        }

        foreach ($userdata_flow as $key => $value) {
            if($value->luf_flow == 14 || $value->luf_flow == 15){
                $form_carddata = $this->own->get_form_carddata($value->luf_id);
                foreach ($form_carddata as $key1 => $value1) {
                    if($value1->lfuff_key == '#userflow_id'){
                        $userflow_id = $value1->lfuff_value;
                        $userdata_flow[$key]->userflow_id = $userflow_id;
                    }elseif($value1->lfuff_key == '#cardnumber'){
                        $cardnumber = $value1->lfuff_value;
                        $userdata_flow[$key]->number = $cardnumber;
                    }
                }
                // 退卡,返销等审核
                continue;
            }
            if($staff_number != ''){
                $form_info = $this->own->get_userdata_flowform_staffnumber($value->luf_id,$value->luf_flow,$staff_number);
            }else{
                $form_info = $this->own->get_userdata_flowform_staffnumber($value->luf_id,$value->luf_flow);
            }
            if($form_info){
                $staffname = $this->own->get_userdata_flowform_staffname($form_info[0]->lfuff_userflow,$form_info[0]->lfuff_formid);
                //$cdate = $this->own->get_userdata_flowform_cdate($form_info[0]->lfuff_userflow,$form_info[0]->lfuff_formid);
                $cdate = $this->own->get_userdata_flowstep_cdate($form_info[0]->lfuff_user_flowstep);
                $userdata_flow[$key]->number = $form_info[0]->lfuff_value;
                $userdata_flow[$key]->staff_name = $staffname[0]->lfuff_value;
                $userdata_flow[$key]->approval_cdate = $cdate[0]->lufs_approval_cdate;
            }else{
                unset($userdata_flow[$key]);
            }
        }
        $userdata_flow = array_values($userdata_flow);

        $data = array();
        $data["userdata_flow"] = $userdata_flow;
        $data["pagenum"] = intval($pagenum);
        $data["total_page"] = $total_page;
        echo json_encode($data);exit();
    }
    // 审核信息
    public function ownflow_step()
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $user_flowid = $this->input->post("user_flowid");
        $userdata_flowstep = $this->own->get_userdata_flowstep($user_flowid);
        echo json_encode($userdata_flowstep);exit();
    }

    //人事申请打印
    public function own_flow_print($approvalview_companyid,$approvalview_storeid,$userflow_id,$flow_id,$applyId)
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $this->load->model('flow_block/flow_dictionary_model', 'dictionary');
        $return = $this->user->seach_header();
        $model = "get_store_companyrank";

        if($flow_id == 14){
            $url = "http://10.0.3.35:8089/venus/card/return/printBackMsg?applyId=".$applyId;
            $my_curl = curl_init();    //初始化一个curl对象
            curl_setopt($my_curl, CURLOPT_URL, $url);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            //echo $str;    //输出抓取的结果
            curl_close($curl);    //关闭url请求
            $json = json_decode($str,true);
            $return["carddata"] = $json["data"];
            //echo "<pre>";var_dump($return["carddata"]);die;
        }else{
            $return["userdata"] = $this->own->get_userdata_flow_form($userflow_id);
            foreach ($return["userdata"] as $key => $value) {
                if($value->lfuff_key == 'askForLeave_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_staff_info($staffid);
                    $storeid = $return["staffinfo"]->STOREID;
                }

                if($value->lfuff_key == 'entryAppli_staff_storeid_old'){
                     $storeid = $value->lfuff_value;
                }

                if($value->lfuff_key == 'storeTransfer_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_staff_info($staffid);
                    $storeid = $return["staffinfo"]->STOREID;
                }

                if($value->lfuff_key == 'crossStoreTransfer_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_staff_info($staffid);
                }

                if($value->lfuff_key == 'departure_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_user_info($staffid);
                    $storeid = $return["staffinfo"]->STOREID;
                }

                // 重回公司由于员工已提交离职申请，staff表storeid改为2，需要从user表获取原来的storeid
                if($value->lfuff_key == 'backCompany_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_user_info($staffid);
                    $storeid = $return["staffinfo"]->STOREID;
                }

                if($value->lfuff_key == 'salaryAdjustment_staff_staffid'){
                    $staffid = $value->lfuff_value;
                    $return["staffinfo"] = $this->own->get_staff_info($staffid);
                    $storeid = $return["staffinfo"]->STOREID;
                }
                $return["storenum"] = $this->own->get_store_num($storeid);
                // 跨店调动 原门店 新门店分别取
                if($value->lfuff_key == 'crossStoreTransfer_staff_storeid_old'){
                    $storeid_old = $value->lfuff_value;
                    $return["storenum_old"] = $this->own->get_store_num($storeid_old);
                }
                if($value->lfuff_key == 'crossStoreTransfer_staff_storeid_new'){
                    $storeid_new = $value->lfuff_value;
                    $return["storenum_new"] = $this->own->get_store_num($storeid_new);
                }
            }
        }

        

        $return["approvaluser"] = $this->own->get_user_flowstep($userflow_id);
        foreach ($return["approvaluser"] as $k => $v) {
            if(($v->lufs_approval == 3 && $v->fau_approval==3) || ($v->lufs_approval == 8 && $v->fau_approval==8) || ($v->lufs_approval == 2 && $v->fau_approval==2)){
                $return["zhuanyuan"] = $v->fau_user_name;
                /*$zhuanyuan = $v->fau_user_name;
                $zhuanyuan_id = $this->own->get_sys_staffid($zhuanyuan);
                if ($zhuanyuan_id) {
                    $return["zhuanyuan"] = $this->own->get_staff_name($zhuanyuan_id->staffid);
                }*/
                
            }
            if(($v->lufs_approval == 4 && $v->fau_approval==4) || ($v->lufs_approval == 9 && $v->fau_approval==9) || ($v->fau_approval == 2 && $v->fau_approval==2)){
                $return["zhuguan"] = $v->fau_user_name;
                /*$zhuguan = $v->fau_user_name;
                $zhuguan_id = $this->own->get_sys_staffid($zhuguan);
                if ($zhuguan_id) {
                    $return["zhuguan"] = $this->own->get_staff_name($zhuguan_id->staffid);
                }*/
            }

        }
        //echo "<pre>";var_dump($return);die;
        $return["companyrank"] = $this->dictionary->get_select_option($approvalview_companyid, $approvalview_storeid, $model);
        $this->load->view('viewheaders/charisma/header_print');
        if($flow_id == 1){
            // 请假打印
            $this->load->view('flow_block/own/ownflow_leaveprint_view', $return);
        }elseif($flow_id == 2){
            // 入职打印
            $this->load->view('flow_block/own/ownflow_entryprint_view', $return);
        }elseif($flow_id == 3){
            // 本店调动打印
            $this->load->view('flow_block/own/ownflow_storeprint_view', $return);
        }elseif($flow_id == 4){
            // 跨店调动打印
            $this->load->view('flow_block/own/ownflow_crossstoreprint_view', $return);
        }
        elseif($flow_id == 5){
            // 重回公司打印
            $this->load->view('flow_block/own/ownflow_backprint_view', $return);
        }
        elseif($flow_id == 6){
            // 离职打印
            $this->load->view('flow_block/own/ownflow_departureprint_view', $return);
        }elseif($flow_id == 7){
            // 薪资调整打印
            $this->load->view('flow_block/own/ownflow_salaryprint_view', $return);
        }elseif($flow_id == 14){
            // 会员退卡打印
            $this->load->view('flow_block/own/ownflow_returncardprint_view', $return);
        }elseif($flow_id == 15){
            // 会员卡补卡打印
            echo "暂不支持打印！";
        }
        $this->load->view('viewfeet/charisma/foot_print');
    }

    /*
     * 查看待审核的流程
     * */
    public function own_flowstep($user_flow_id)
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $return = $this->user->flow_header();

        $return["query"] = $this->own->get_user_flowstep($user_flow_id);
        $return["message"] = "";

        $this->load->view('viewheaders/charisma/header', $return);
        $this->load->view('flow_block/own/own_flowlist_flowstep_view', $return);
        $this->load->view('viewfeet/charisma/foot', $return);
    }

    /*
     * 查看表单
     * */
    public function own_flowform()
    {
        $this->load->model('flow_block/flow_own_model', 'own');
        $this->load->model('user/User_model', 'user');
        $this->load->model('flow_block/flow_dictionary_statics_model', 'dictionary');
        $return = $this->user->flow_header();

        $user_flow_id = $this->input->get("tid");
        $lufs_id = $this->input->get('id');
        $storeid = $this->input->get('storeid');
        $userflow_id = $this->input->get("userflow_id");
        if (!isset($user_flow_id)) {
            $user_flow_id = $this->input->get("tid");
        }

        if(!isset($user_flow_id)){
            echo "Entry is not correct!";
            exit;
        }

        $tid = $this->input->post("tid");
        if (!isset($tid)) {
            $tid = $this->input->get("tid");
        }

        if(!isset($tid)){
            echo "Entry is not correct!";
            exit;
        }

        $flowform = $this->own->get_user_flow_form($tid);
        
        $userdataflowstep = $this->own->get_user_flowstep_entity($lufs_id,$user_flow_id);
        $userdata_flow_entity = $this->own->get_userdata_flow_entity($user_flow_id);

        if($flowform[0]->flowform_id == 14){
            $url = "http://10.97.0.72:8000/appAPI/card/return/searchLcBackCard?applyId=".$userflow_id;
            /*$return = file_get_contents($url);
            var_dump($return);die;*/
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
            
            //echo "<pre>";var_dump($json);die; 
        }else{
            $userdataflowform = $this->own->get_userdata_flow_form($user_flow_id,$tid);
        }

        $return["flow_user_data"] = array("dm_systable_userdata_storeid"=> $userdata_flow_entity->storeid);
        $return["flowform"] = $flowform;
        $return["userdataflowform"] = $userdataflowform; //人事流程表单信息
        $return["userdataflowstep"] = $userdataflowstep;
        $return["userdata_flow_entity"] = $userdata_flow_entity;
        $return["storeid"] = $userdata_flow_entity->luf_storeid;
        $return["applyCardData"] = $applyCardData; // 卡操作流程表单信息
        $return["userflow_id"] = $userflow_id; // 卡操作流程申请id

        foreach ($return["userdataflowform"] as $key => $value) {
            if($value->lfuff_key == 'backCompany_staff_staffname'){
                $return['staffname'] = $value->lfuff_value;
            }
            if($value->lfuff_key == 'dmdate_backCompany_staff_leavedate_old'){
                $return['change_date'] = $value->lfuff_value;
            }
        }

        //$return["performancetype"] = $this->dictionary->get_staff_performancetype();
        //echo "<pre>";
        //var_dump($return["userdataflowform"]);die;
        $return["flw_storeid"] =  $user_flow->storeid;
        $this->load->view('viewheaders/flow/header',  $return);
        $this->load->view('flow_block/own/own_flowform_view', $return);
        $this->load->view('viewfeet/charisma/foot_own_form', $return);
        if($flowform[0]->flowform_id == 14){
            $this->load->view('flow_block/cardCheckAPiJs',array("submit_hide"=>"hide"));
        }else{
            $this->load->view('flow_block/flow_annotation_js',array("submit_hide"=>"hide"));
            $this->load->view('flow_block/flow_annotation_dynamic_js',array("submit_hide"=>"show"));
        }
    }

    public function own_flow_revocation($user_flowid)
    {
        $this->load->model('user/User_model', 'user');
        $data = $this->user->flow_header();

        $this->load->model('flow_block/flow_own_model', 'own');
        $return = $this->own->update_approve_and_adopt($user_flowid,$data["userid"]);
        //echo "<script>alert('操作成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        echo "<script>alert('操作成功');location.href='".site_url().'/flow_own/own_flow'."';</script>";
        //redirect(site_url("/flow_own/own_flow"));
    }

    public function own_flow_approval_user()
    {
        $this->load->model('flow_block/flow_own_model', 'own');

        $userid = $this->input->post("userid");
        $approve_status = $this->input->post("approve_status");
        $lufs_id = $this->input->post("flowstepid");
        $row = $this->own->approval_user($userid,$approve_status,$lufs_id);
        echo json_encode($row);exit();
    }
}

?>