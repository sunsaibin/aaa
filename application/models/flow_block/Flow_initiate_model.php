<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_initiate_model extends CI_Model
{
    public function  get_flow_form($flowid)
    {
        $sql = "SELECT * FROM `fw_flowstep` s LEFT JOIN `fw_flow_flowstep` p on p.`ff_flowstep` = s.`flowstep_id` LEFT JOIN `fw_flowform` f on p.`ff_formid`=f.`flowform_id`  where p.`ff_id`=? and p.`ff_enable`=1 ";
        $query = $this->db->query($sql, array($flowid));
        //echo $this->db->last_query();
        return $query->result();
    }

    //test api call
    public function  get_flow_form_api_test($flowid)
    {
        $sql = "SELECT * FROM `fw_flowstep` s LEFT JOIN `fw_flow_flowstep` p on p.`ff_flowstep` = s.`flowstep_id` LEFT JOIN `fw_flowform` f on p.`ff_formid`=f.`flowform_id`  where p.`ff_id`=? and p.`ff_enable`=1 ";
        $query = $this->db->query($sql, array($flowid));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    //上传文件
    public function do_file()
    {
        $this->load->library('upload');

        //配置上传参数
        $upload_config = array(
            'upload_path'  => $_SERVER['DOCUMENT_ROOT'].'/upload/images/',
            'allowed_types' => 'jpg|png|gif',
            'file_name' => md5(time().'idcard'),
            'max_size'   => '500',
            'max_width'   => '1024',
            'max_height'  => '768'
        );
        $arr = $this->upload->initialize($upload_config);

        //循环处理上传文件
        $file_name = array();
        foreach ($_FILES as $key => $value) {
            if (!empty($key)) {
                if($this->upload->do_upload($key)){
                    $file_info = $this->upload->data();
                    $file_name[$key]=$file_info['orig_name'];
                }
            }
        }
        return $file_name;
    }

    public function  get_flow_form_entity($flowformid){
        $sql = "SELECT * FROM fw_flowform WHERE flowform_id = ? ";
        $query = $this->db->query($sql, array($flowformid));
        /*echo $this->db->last_query();*/
        return $query->row();
    }

    public function  get_flow_flowstep_entity($ffid){
        $sql = "SELECT * FROM fw_flow_flowstep WHERE ff_flow = ? ";
        $query = $this->db->query($sql, array($ffid));
        //echo $this->db->last_query();die;
        return $query->row();
    }

    public function  get_fw_userdata_flow_randid($randid){
        $sql = "SELECT * FROM fw_userdata_flow where luf_randid = ?;";
        $query = $this->db->query($sql, array($randid));
        /*echo $this->db->last_query();*/
        return $query->row();
    }

    public function get_store_name($storeid){
        $sql = "select COMPANYID,STORENAME from bm_store where STOREID=?";
        $query = $this->db->query($sql, array($storeid));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_seach_name($companyid){
        $sql = "select COMPANYID,COMPANYNAME from bm_company where COMPANYID=?";
        $query = $this->db->query($sql, array($companyid));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    public function save_flow_form($filename, $ffid, $userid, $usertype, $companyid, $storeid, $companyname, $storename, $username)
    {
        $flow_flowstep = $this->get_flow_flowstep_entity($ffid);
        if(!isset($flow_flowstep)){
            echo '流程数据不正确!ffid is null!';
            return;
        }
        $post_storeid = $this->input->post("flow_storeid");
        $post_companyid = $this->input->post("flow_compid");
        $flowstep = $this->input->post("flowstep");
        $randid = $this->input->post("randid");
        $userdata_flow = $this->get_fw_userdata_flow_randid($randid);//防止重复提交,做验证.
        if(isset($userdata_flow) && count($userdata_flow) > 0){
            echo '不能重复提交!请刷新界面';
            return;
        }
        $flow_flowform = $this->get_flow_form_entity($flow_flowstep->ff_formid);
        $formitems = $flow_flowform->flowform_formitems;
        //var_dump($formitems);die;
        $array_formitems = explode(",",$formitems);

        $sqlArray = array();
        $sqlArray["luf_flow"] = $flow_flowstep->ff_flow;
        $sqlArray["luf_randid"] = $randid;
        $sqlArray["luf_user"] = $userid;
        $sqlArray["luf_user_type"] = "1";
        //var_dump($post_companyid);die;
        if($ffid == 3 || $post_storeid == null || $post_companyid= null){
            // 本店调动不取节点，取流程头
            $sqlArray["luf_storeid"] = $storeid;
            $sqlArray["luf_company"] = $companyid;
            $sqlArray["luf_store_name"] = $storename;
            
            if($storeid == 0){
                $sqlArray["luf_store_name"] = '总部';
            }
            
            $sqlArray["luf_company_name"] = $companyname;
        }else{
            // 门店、公司等取节点
            
            $sqlArray["luf_storeid"] = $this->input->post("flow_storeid");
            $sqlArray["luf_company"] = $this->input->post("flow_compid");

            if($this->input->post("flow_storeid") == 0){
                $sqlArray["luf_store_name"] = '总部';
            }else{
                $storename = $this->get_store_name($this->input->post("flow_storeid"));
                $sqlArray["luf_store_name"] = $storename[0]->STORENAME;
            }
            
            $companyname = $this->get_seach_name($this->input->post("flow_compid"));
            $sqlArray["luf_company_name"] = $companyname[0]->COMPANYNAME;
        }
        $sqlArray["luf_remark"] = $this->input->post("explain");
        $sqlArray["luf_type"] = $usertype;
        $sqlArray["luf_user_name"] = $username;

        $this->db->insert('fw_userdata_flow', $sqlArray);
        $row = $this->db->affected_rows();

        if ($row < 1) {
            echo "不能重复提交申请! 请刷新页面!";
            exit;
        }
        /* echo $this->db->last_query();*/

        $newid = $this->db->insert_id();
        //echo "newid=".$newid;

        $sqlArray = array();
        $sqlArray["lufs_userflow"] = $newid;
        $sqlArray["lufs_flowstep"] = $flow_flowstep->ff_flowstep;
        if($flowstep != null){
            // 请假、加班申请有根据请假天数或加班时长设置分组审核
            $sqlArray["lufs_flowstep"] = $flowstep;
        }
        $sqlArray["lufs_flowstepid"] = 0;
        $sqlArray["lufs_sequence"] = 1;
        $sqlArray["lufs_approval"] = 0;
        $sqlArray["lufs_approval_user"] = 0;
        $sqlArray["lufs_approval_jump"] = 0;
        $sqlArray["lufs_is_adopt"] = 0;
        $sqlArray["lufs_explain"] =  $this->input->post("explain");

        $this->db->insert('fw_userdata_flowstep', $sqlArray);
        $row = $this->db->affected_rows();
        /*echo $this->db->last_query();*/

        $newid2 = $this->db->insert_id();
        //echo "newid2=".$newid2;
        $sqlArray1 = array();
        foreach ($array_formitems as $key => $value) {
            if (strlen($value) > 0) {
                //echo $value."=".$this->input->post($value)."<br/>";
                $ag = $this->input->post($value);
                
                $sqlArray = array();
                $sqlArray["lfuff_user_flowstep"] =$newid2;
                $sqlArray["lfuff_userflow"] = $newid;
                $sqlArray["lfuff_formid"] = $flow_flowstep->ff_formid;
                $sqlArray["lfuff_key"] = $value;
                $sqlArray["lfuff_value"] = isset($ag)?$ag:'';

                if($value == 'dmdate_entryAppli_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_askForLeave_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_storeTransfer_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_crossStoreTransfer_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_departure_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_salaryAdjustment_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }elseif($value == 'dmdate_backCompany_staff_applytime'){
                    $sqlArray['lfuff_value'] = date("Y-m-d H:i:s", time());
                }

                if(isset($filename[$value])){
                    $sqlArray["lfuff_value"] = '/upload/images/'.$filename[$value];
                }
                $sqlArray["lfuff_value_type"] = 0;
               array_push($sqlArray1,$sqlArray);
                /* echo  "<br/>sql3: ".$this->db->last_query();*/
            }
        }

        //$row = $this->db->insert('fw_userdata_flowform', $sqlArray1);
        // 批量插入
        $this->db->insert_batch("fw_userdata_flowform",$sqlArray1);
        //echo $this->db->last_query();
    }

    //$client_param=>{"image1","123"},{"image2":"11"}
    public function save_flow_form_api($filename, $ffid, $userid, $usertype, $companyid, $storeid, $companyname, $storename, $username, $client_param, $userflow_id)
    {
        $flow_flowstep = $this->get_flow_flowstep_entity($ffid);
        if(!isset($flow_flowstep)){
            echo '流程数据不正确!ffid is null!';
            return;
        }

        $randid = $this->input->post("randid");
        $userdata_flow = $this->get_fw_userdata_flow_randid($randid);
        if(isset($userdata_flow) && count($userdata_flow) > 0){
            echo '不能重复提交!请刷新界面';
            return;
        }

        //var_dump($formitems);die;
        $array_formitems = explode(",",$formitems);
        $sqlArray = array();
        $sqlArray["luf_userflow_id"] = $userflow_id;
        $sqlArray["luf_flow"] = $flow_flowstep->ff_flow;
        $sqlArray["luf_randid"] = $randid;//防止重复提交,做验证.
        $sqlArray["luf_user"] = $userid;
        $sqlArray["luf_user_type"] = "1";
        $sqlArray["luf_storeid"] = $storeid;
        $sqlArray["luf_company"] = $companyid;
        $sqlArray["luf_remark"] = '';
        $sqlArray["luf_type"] = $usertype;
        $sqlArray["luf_company_name"] = $companyname;
        $sqlArray["luf_store_name"] = $storename;
        $sqlArray["luf_user_name"] = $username;
        $sqlArray["luf_is_approve"] = "0";

        $this->db->insert('fw_userdata_flow', $sqlArray);
        $row = $this->db->affected_rows();

        if ($row < 1) {
            echo "不能重复提交申请! 请刷新页面!";
            exit;
        }
        /* echo $this->db->last_query();*/

        $newid = $this->db->insert_id();
        //echo "newid=".$newid;

        $sqlArray = array();
        $sqlArray["lufs_userflow"] = $newid;
        $sqlArray["lufs_flowstep"] = $flow_flowstep->ff_flowstep;
        $sqlArray["lufs_flowstepid"] = 0;
        $sqlArray["lufs_sequence"] = 1;
        $sqlArray["lufs_approval"] = 0;
        $sqlArray["lufs_approval_user"] = 0;
        $sqlArray["lufs_approval_jump"] = 0;
        $sqlArray["lufs_is_adopt"] = 0;
        $sqlArray["lufs_explain"] = '';

        $this->db->insert('fw_userdata_flowstep', $sqlArray);
        $row = $this->db->affected_rows();
        //echo $this->db->last_query();

        $newid2 = $this->db->insert_id();
        //echo "newid2=".$newid2;

        foreach ($client_param as $key => $value) {
            if (isset($key)) {
                //echo $value."=".$this->input->post($value)."<br/>";
                $sqlArray = array();
                $sqlArray["lfuff_user_flowstep"] =$newid2;
                $sqlArray["lfuff_userflow"] = $newid;
                $sqlArray["lfuff_formid"] = $flow_flowstep->ff_formid;
                $sqlArray["lfuff_key"] = $key;
                $sqlArray["lfuff_value"] = isset($value)?$value:'';
                if(isset($filename[$value])){
                    $sqlArray["lfuff_value"] = '/upload/images/'.$filename[$value];
                }
                $sqlArray["lfuff_value_type"] = 0;
                $row = $this->db->insert('fw_userdata_flowform', $sqlArray);
                /* echo  "<br/>sql3: ".$this->db->last_query();*/

            }
        }
    }

    public function get_user_flow_app($array)
    {
        $flowid=$array[0];
        $userid=$array[1];
        //SELECT a.lfuff_key,a.lfuff_value, b.luf_id, b.luf_is_approve FROM fw_userdata_flowform a LEFT JOIN fw_userdata_flow b on b.luf_id = a.lfuff_userflow where b.luf_flow = 16;
        $sql = "SELECT a.`lfuff_key`,a.`lfuff_value`, b.* FROM `fw_userdata_flowform` a LEFT JOIN `fw_userdata_flow` b on b.`luf_id` = a.`lfuff_userflow` where b.`luf_flow` = ? AND luf_isdelete='0' AND luf_user=?";
        $query = $this->db->query($sql, array($flowid, $userid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_exists_initiate_api($userid, $storeid)
    {
        $sql = "SELECT * FROM `fw_userdata_flow` WHERE `luf_flow` = 17 AND `luf_user` = ? AND `luf_storeid` = ?";
        $query = $this->db->query($sql, array($userid, $storeid));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

}

?>