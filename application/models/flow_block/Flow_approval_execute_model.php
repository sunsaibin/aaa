<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 9:21
 *
 * adopt：0=待审核中.1=同意，2=驳回, 3=结束
 */
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');
class Flow_approval_execute_model extends CI_Model
{
    /*
     * 执行审批过程,同意,驳回,结束
     * */
    public function  execute_flow($userid, $type,$user_flow_id,$adopt,$explain)
    {
        $this->load->model('flow_block/flow_initiate_model', 'initiate');

        $userdata_flow = $this->get_userdata_flow($user_flow_id);
        $userdata_flow_flowstep = $this->get_userdata_flow_flowstep($user_flow_id,$userid, $type);
        //var_dump(!isset($userdata_flow_flowstep));die;
        if(!isset($userdata_flow_flowstep) || count($userdata_flow_flowstep) <1){
            print_r($userdata_flow_flowstep);
            echo '找不到用户的流程,或者SESSION过期！请重新登录!';
            echo $this->db->last_query();
            return;
        }

        $flow_flowform = $this->initiate->get_flow_form_entity($userdata_flow->luf_flow);
        $formitems = $flow_flowform->flowform_formitems;
        //var_dump($formitems);die;
        $array_formitems = explode(",",$formitems);

        $luf_is_approve = "2";
        $jump = -1;
        if ($adopt == 2) {
            $jump = $userdata_flow_flowstep[0]->ffs_step_pre;
            $luf_is_approve = "3";
        }
        else if ($adopt == 1) {
            $jump = $userdata_flow_flowstep[0]->ffs_step_next;
        }else{
            $luf_is_approve = "3";
        }

//var_dump($adopt);var_dump($userdata_flow_flowstep);var_dump($jump);die;
        if($jump != -1)
        {
            $sqlArray = array();
            $sqlArray["lufs_userflow"] = $userdata_flow_flowstep[0]->lufs_userflow;
            $sqlArray["lufs_flowstep"] = $userdata_flow_flowstep[0]->ffs_step;
            $sqlArray["lufs_flowstepid"] = $userdata_flow_flowstep[0]->ffs_id;
            $sqlArray["lufs_sequence"] = intval($userdata_flow_flowstep[0]->lufs_sequence)+1;
            $sqlArray["lufs_approval"] = 0;
            $sqlArray["lufs_approval_user"] = 0;
            $sqlArray["lufs_approval_jump"] = 0;
            $sqlArray["lufs_is_adopt"] = 0;

            $this->db->insert('fw_userdata_flowstep', $sqlArray);
            $this->db->affected_rows();
            $insert_id = $this->db->insert_id();
            //echo $this->db->last_query();

            $luf_is_approve = "1";
        }


        $sqlArray = array();
        $sqlArray["luf_is_approve"] = $luf_is_approve;
        $sqlWhere = array();
        $sqlWhere["luf_id"] = $userdata_flow_flowstep[0]->lufs_userflow;
        $this->db->update('fw_userdata_flow', $sqlArray, $sqlWhere);


        $sqlArray = array();
        $sqlArray["lufs_is_adopt"] = (isset($adopt)?$adopt:0);
        $sqlArray["lufs_approval"] = $userdata_flow_flowstep[0]->ffs_approval;
        $sqlArray["lufs_explain"] = $explain;
        $sqlArray["lufs_approval_user"] = $userid;
        $sqlArray["lufs_approval_jump"] = $jump;
        $sqlArray["lufs_approval_cdate"] =  date('Y-m-d H:i:s',time());
        $sqlWhere = array();
        $sqlWhere["lufs_id"] = $userdata_flow_flowstep[0]->lufs_id;

        $this->db->update('fw_userdata_flowstep', $sqlArray, $sqlWhere);

        // 修改表单数据(卡操作流程不做修改)
        if($userdata_flow->luf_flow != 12 || $userdata_flow->luf_flow != 13 || $userdata_flow->luf_flow != 14 || $userdata_flow->luf_flow != 15){
            $sqlArray1 = array();
            foreach ($array_formitems as $key => $value) {
                if (strlen($value) > 0) {
                    //echo $value."=".$this->input->post($value)."<br/>";
                    $ag = $this->input->post(strtoupper($value));
                    
                    $sqlArray = array();
                    $sqlArray["lfuff_value"] = isset($ag)?$ag:'';

                    if(isset($filename[$value])){
                        $sqlArray["lfuff_value"] = '/upload/images/'.$filename[$value];
                    }
                    //$sqlWhere = array();
                    //$sqlWhere["lfuff_userflow"] = $userdata_flow_flowstep[0]->lufs_userflow;
                    //$sqlWhere["lfuff_key"] = $value;
                    $query_data = $this->query_formdata_id( $userdata_flow_flowstep[0]->lufs_userflow,$value);
                    $sqlArray["lfuff_id"] = $query_data[0]->lfuff_id;
                    array_push($sqlArray1,$sqlArray);
                    
                     //echo  "<br/>sql3: ".$this->db->last_query();

                }
            }
            // 批量修改
            $row = $this->db->update_batch('fw_userdata_flowform', $sqlArray1, "lfuff_id");
        }
        
        //echo $this->db->last_query();die;
       //执行sql
        $urlExecuteArray = array();
        $sqlExecuteArray = array();
        $ffrIdArray = array();
        $flow_data = $this->get_userdata_flow_flowform($user_flow_id);

        $defaultArray = array('dm_flow_isapprove');
        $execSqlArray = $this->get_flowstep_task($userdata_flow->luf_flow,$user_flow_id,$userdata_flow_flowstep[0]->ffs_task);
        foreach ($execSqlArray as $key => $value) {
            array_push($ffrIdArray, $value->ffr_id);
            if($adopt==1){
                $execSql = $value->ffr_result_sql;
                $execUrl = $value->ffr_result_url;
            }
            else if($adopt==2){
                $execSql = $value->ffr_closure_sql;
                $execUrl = $value->ffr_closure_sql;
            }else{
                $execSql = $value->ffr_reject_sql;
                $execUrl = $value->ffr_reject_url;
            }
            if(!isset($execSql) && !isset($execUrl)){
                continue;
            }           

            $tem_exec_sql = $execSql;
            $tem_exec_url = $execUrl;
            foreach ($defaultArray as $key => $value) {
                if( strpos($tem_exec_sql, $value) ){
                    // applystate'单据状态 0 门店申请中 1 门店经理已审核  2 门店经理已驳回 3 人事专员已审核  4 人事专员已驳回 5 人事经理已审核  6人事经理已驳回 7 生效归档  '
                    // 单据审核完直接生效归档
                    $tem_exec_sql = str_ireplace($value, $userdata_flow->luf_is_approve, $tem_exec_sql);
                    //$tem_exec_url = str_ireplace($value, $userdata_flow->luf_is_approve, $tem_exec_url);
                }
            }

            foreach ($flow_data as $k => $v) {
                $tem_str = $v->lfuff_value;
                $tem_key = $v->lfuff_key;
                /*echo '<br>';
                print_r($tem_key."_V_".$tem_str."______");
                echo '<br>';*/
                if(!isset($tem_str)){
                    $tem_str = "";
                }
                if(isset($tem_key)){
                    $tem_str = str_replace("'","\"",$tem_str);
                    $new_key = "#".$tem_key;

                    if(strpos($tem_exec_sql, $new_key) !== false){
                        $tem_exec_sql = str_ireplace($new_key, $tem_str, $tem_exec_sql);
                    }

                    if(strpos($tem_key,"dmdate_") !== false && empty($tem_str)){
                        $tem_exec_sql = str_ireplace($v->lfuff_key, 'null ', $tem_exec_sql);
                    }
                    else{
                        $tem_exec_sql = str_ireplace($v->lfuff_key, "'".$tem_str."'", $tem_exec_sql);
                    }

                    $tem_exec_url = str_ireplace($v->lfuff_key, $tem_str, $tem_exec_url);
                }

                //userid,storeid,isapp,  dm_flow_userid,dm_flow_isappper
            }
            array_push($sqlExecuteArray, $tem_exec_sql);
            array_push($urlExecuteArray, $tem_exec_url);
        }
        /*echo "<pre>";
        print_r($sqlExecuteArray);
        exit;*/

        //执行sql
        foreach($sqlExecuteArray as $k => $v){
            if(empty($v)){
                continue;
            }
            $row = $this->db->query($v);

            $sqlArray = array();
            $sqlArray["fr_flow"] =$user_flow_id;
            $sqlArray["fr_userid"] =$userid;
            $sqlArray["fr_taskid"] =$ffrIdArray[$k];
            $sqlArray["fr_type"] ="1";
            $sqlArray["fr_apidata"] =$v;
            $sqlArray["fr_result"] ="";
            $sqlArray["fr_cdate"] =date('y-m-d h:i:s',time());
            $sqlArray["fr_isexec"] ="0";
            $this->db->insert('fw_userdata_task_result', $sqlArray);
            $lastId = $this->db->insert_id();
            //echo $this->db->last_query();echo "<br>";

            $this->exec_curl($lastId);
            //var_dump($row);echo "<br>";
            //$row = $this->db->affected_rows();

           //var_dump($row);echo "<br>";
            //echo $this->db->last_query();echo "<br>";
            //$this->db->_error_message();
            //$error = $this->db->error(); // Has keys 'code' and 'message'
            //var_dump($error);echo "<hr>";

        }
        

        // 退卡审核信息
        $applyUser = $this->input->post("applyuser");
        $applyMemo = $explain;
        $amount = $this->input->post("AMOUNT");
        $newNum = $this->input->post("NEWCARDNUM");
        $operator_type = $this->input->post("OPERATOR_TYPE");
        $accountId = $this->input->post("ACCOUNTID");
        $cardid = $this->input->post("CARD_ID");
        $storeid = $this->input->post("STORE_ID");
        $orderId = $this->input->post("ORDERID");
        $memo = $this->input->post("MEMO");
        if($luf_is_approve == 2){
            $status = 1;
        }else{
            $status = 0;
        }

        // 执行url
        foreach($urlExecuteArray as $k1 => $v1){
            if(empty($v1)){
                continue;
            }
            if($userdata_flow->luf_flow == 14){
                // 退卡拼接参数
                $v1 = $v1."&status=".$status."&backMoney=".$amount."&aMemo=".$applyMemo."&name=".$applyUser."";
            }elseif($userdata_flow->luf_flow == 15){
                // 补卡拼接参数
                $v1 = $v1."&status=".$status."&backMoney=0&aMemo=".$applyMemo."&name=".$applyUser."&newNum=".$newNum."";
            }elseif($userdata_flow->luf_flow == 12 && $luf_is_approve == 2){ //拒绝等(java那边)不做处理
                if($operator_type == 1){
                    // 返充(反卡)拼接参数
                    $v1 = $v1."backCard?accountId=".$accountId."&cardId=".$cardid;
                }elseif($operator_type == 3){
                    // 返充(反疗程)拼接参数
                    $v1 = $v1."backCardSub?accountId=".$accountId."&cardId=".$cardid."&storeId=".$storeid;
                }elseif($operator_type == 5){
                    // 返充(反充值)拼接参数
                    $v1 = $v1."backRecharge?accountId=".$accountId."&cardId=".$cardid."&storeId=".$storeid;
                }
                
            }elseif($userdata_flow->luf_flow == 13 && $luf_is_approve == 2){ //拒绝等(java那边)不做处理
                $v1 = $v1."&orderId=".$orderId."&checkMemo=".$memo."";
                
                /*$v1 = "http://10.1.8.133:8000/appAPI/web/back/backCheckOrder";
                $post_data = array("applyId"=>8720,"checkUserId"=>40,"orderId"=>$orderId,"checkMemo"=>$memo);
                $my_curl = curl_init();    //初始化一个curl对象
                curl_setopt($my_curl, CURLOPT_URL, $v1);    //设置你需要抓取的URL
                curl_setopt($ch, CURLOPT_POST, 1); // 设置post请求
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); // 设置post数据
                curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
                $str = curl_exec($my_curl);    //执行请求
                echo $str;exit();   //输出抓取的结果
                curl_close($curl);    //关闭url请求*/
            }

            $file_contents = file_get_contents($v1);

            /*$my_curl = curl_init();    //初始化一个curl对象
            curl_setopt($my_curl, CURLOPT_URL, $v1);    //设置你需要抓取的URL
            curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
            $str = curl_exec($my_curl);    //执行请求
            echo $str;exit();   //输出抓取的结果
            curl_close($curl);    //关闭url请求*/

        }
        //exit();
        //执行url
/*        foreach($urlExecuteArray as $k => $v){
            print_r("URL:");
            print_r($v);
        }*/
        //fw_userdata_task
    }

    public function query_formdata_id($lfuff_userflow,$lfuff_key)
    {
        $sql = "select lfuff_id from fw_userdata_flowform where lfuff_userflow=? and lfuff_key=?";
        $query = $this->db->query($sql, array($lfuff_userflow,$lfuff_key));
        //echo $this->db->last_query();
        return $query->result();
    }

    private function get_userdata_flow_flowstep($user_flow_id,$userid, $type)
    {
        //$sql = "SELECT * FROM `fw_flowstep_flowstep` k LEFT JOIN fw_userdata_flowstep v ON k.`ffs_id` = v.`lufs_flowstep` LEFT JOIN `fw_userdata_flow` op ON op.`luf_id` = v.`lufs_userflow` WHERE v.`lufs_id` IN(SELECT `lufs_id` FROM `fw_userdata_flowstep` WHERE `lufs_userflow` = ? AND (`lufs_is_adopt` = 0))";
        $sql = "SELECT * FROM `fw_flowstep_flowstep` k LEFT JOIN fw_userdata_flowstep v ON k.`ffs_step` = v.`lufs_flowstep` LEFT JOIN `fw_userdata_flow` op ON op.`luf_id` = v.`lufs_userflow` WHERE `lufs_userflow` = ? AND (`lufs_is_adopt` = 0) AND (v.lufs_flowstepid = k.ffs_step_start) AND  ffs_approval in ( SELECT  a.`fa_id` FROM `fw_approval` a LEFT JOIN `fw_approval_user` l ON a.`fa_id` = l.`fau_approval` WHERE `fau_userid` = ? AND ( l.fau_user_type = ? OR l.fau_user_type =- 1 ));";
        $query = $this->db->query($sql, array($user_flow_id,$userid,$type));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    private function  get_flowstep_task($luf_flow,$lufs_flowstep,$ffs_task)
    {
        //SELECT * FROM  `fw_flow_flowstep_task` where ffr_flowstep_ffsid in (SELECT lufs_flowstep FROM fw_userdata_flowstep where lufs_userflow = 69) and ffr_flow=1;
        //$sql = "SELECT * FROM  `fw_flow_flowstep_task` where ffr_flowstep_ffsid = (SELECT lufs_flowstep FROM fw_userdata_flowstep where lufs_userflow = ? AND lufs_approval_jump = -1 ORDER BY lufs_flowstep desc LIMIT 0,1) and  ffr_flow=? and ffr_is_use=1 ORDER BY ffr_order asc";
        $sql = "SELECT * FROM  `fw_flow_flowstep_task` where ffr_id in (".$ffs_task.") and ffr_flow=? and ffr_is_use=1 ORDER BY ffr_order asc";
        $query = $this->db->query($sql,array($luf_flow));
        //echo $this->db->last_query();
        return $query->result();
    }

    private function get_userdata_flow($user_flow_id){
        $sql = "SELECT * FROM fw_userdata_flow where luf_id =?";
        $query = $this->db->query($sql,array($user_flow_id));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function  get_userdata_flow_flowform($lufs_flowstep){
        $sql = "SELECT * FROM `fw_userdata_flowform` WHERE lfuff_userflow = ".$lufs_flowstep;
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query ->result();
    }

    public function  exec_sql($sql){
        $query = $this->db->query($sql);
        return $query ->result();
    }

    public function exec_curl($sqlid)
    {
        $ch = curl_init();
        //$url = site_url()."/flow_approval/exec_approval_sql/".$sqlid;
        $url = base_url()."php/exec_sql.php?sqlid=".$sqlid;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
    }
}
?>