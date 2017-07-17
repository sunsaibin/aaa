<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 4:05
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Flow_approval_model extends CI_Model
{
    /*
     * 获取用户审批流程
     * */
    public function  get_user_approval($storeWhere,$companyid,$user_name,$user_id,$user_type)
    {
        //$sql = "select * from fw_userdata_flow p LEFT JOIN fw_flow k on p.luf_flow = k.flow_id where k.flow_id is not null and p.luf_id in( select lufs_userflow  from  `fw_userdata_flowstep` u LEFT JOIN `fw_flowstep_flowstep` f on u.`lufs_flowstep`=f.`ffs_id` LEFT JOIN  `fw_approval` a on f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l on a.`fa_id` = l.`fau_approval` where `fau_userid` =? and (l.fau_user_type =? or l.fau_user_type =-1)) ORDER BY p.luf_cdate desc";
        //$sql = "SELECT luf_id, luf_user_name, luf_flow, luf_storeid, luf_company, luf_store_name, luf_cdate, luf_is_approve FROM fw_userdata_flow uf WHERE (( luf_company = 3 AND luf_storeid = 0 ) OR luf_storeid IN (3)) AND luf_flow IN ( SELECT ff_flow FROM `fw_flow_flowstep` fw LEFT JOIN `fw_flowstep_flowstep` f ON fw.ff_flowstep = f.ffs_step LEFT JOIN `fw_approval` a ON f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l ON a.`fa_id` = l.`fau_approval` WHERE `fau_userid` = '145' AND f.ffs_step_start IN ( SELECT lufs_flowstepid FROM fw_userdata_flowstep WHERE lufs_userflow = uf.luf_id ) AND ( l.fau_user_type = '1' OR l.fau_user_type =- 1 )) ORDER BY luf_cdate DESC;";
        
        $sql = "SELECT uf.luf_id, uf.luf_user_name, uf.luf_flow, uf.luf_storeid, uf.luf_company, uf.luf_store_name, uf.luf_cdate, uf.luf_is_approve,ff.lfuff_key,ff.lfuff_value,GROUP_CONCAT(fs.lufs_approval_user) lufs_approval_user FROM fw_userdata_flow uf LEFT JOIN fw_userdata_flowform ff on uf.luf_id=ff.lfuff_userflow LEFT JOIN fw_userdata_flowstep fs ON uf.luf_id = fs.lufs_userflow WHERE (ff.lfuff_key LIKE '%change_date%' or ff.lfuff_key LIKE '%staff_hand_startdate%') and (luf_storeid IN ".$storeWhere." or (luf_storeid=0 and luf_company=?))  AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and f.lufs_flowstepid = p.ffs_step_start AND f.lufs_approval_jump = 0 )) GROUP BY luf_id ORDER BY luf_cdate DESC";
        $query = $this->db->query($sql, array($companyid,$user_name,$user_id,$user_type,$user_name,$user_id,$user_type));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    /*
     * 获取用户已经审批完成流程
     * */
    public function  get_user_approval_finish($userid, $type = -1)
    {
        $sql = "select * from fw_userdata_flow p LEFT JOIN fw_flow k on p.luf_flow = k.flow_id where k.flow_id is not null and p.luf_id in( select lufs_userflow  from  `fw_userdata_flowstep` u LEFT JOIN `fw_flowstep_flowstep` f on u.`lufs_flowstep`=f.`ffs_id` LEFT JOIN  `fw_approval` a on f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l on a.`fa_id` = l.`fau_approval` where `fau_userid` =? and (l.fau_user_type =? or l.fau_user_type =-1)) AND p.luf_id NOT IN (SELECT	lufs_userflow FROM `fw_userdata_flowstep` u1 WHERE lufs_approval_jump = -1) ORDER BY luf_cdate desc";
        $query = $this->db->query($sql, array($userid,$type));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 获取用户待审批流程,待批复
     * */
    public function  get_user_approval_reply($userid, $type = -1)
    {
        $sql = "select * from fw_userdata_flow p LEFT JOIN fw_flow k on p.luf_flow = k.flow_id where k.flow_id is not null and p.luf_id in( select lufs_userflow  from  `fw_userdata_flowstep` u LEFT JOIN `fw_flowstep_flowstep` f on u.`lufs_flowstep`=f.`ffs_id` LEFT JOIN  `fw_approval` a on f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l on a.`fa_id` = l.`fau_approval` where `fau_userid` =? and (l.fau_user_type=? or l.fau_user_type =-1)) AND p.luf_id IN (SELECT	lufs_userflow FROM `fw_userdata_flowstep` u1 WHERE lufs_approval_jump = -1) ORDER BY luf_cdate desc";
        $query = $this->db->query($sql, array($userid,$type));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 查询用户的表单html/h5内容
     * */
    public function get_user_flow_form($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_flowform` where `flowform_id` in (SELECT `lfuff_formid` FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?)";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 获取用户表单数据.
     * */
    public function get_userdata_flow_form($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 获取用户流程
     * */
    public function get_userdata_flowstep_entity($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowstep`  where `lufs_userflow` = ? ORDER BY lufs_sequence desc limit 1";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();
        return $query->row();
    }

    /*
     * 获取用户流程
     * */
    public function get_userdata_flow_entity($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_userdata_flow`  where `luf_id` = ?";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function exec_approval_sql_task($id)
    {
        $sql = "SELECT * FROM fw_userdata_task_result where fr_id=?";
        $query = $this->db->query($sql, array($id));
        echo $this->db->last_query();
        $data = $query->row();

        if (!isset($data)) {
            return;
        }
        $execSql = $data->fr_apidata;

        if (isset($execSql)) {
            $this->load->database();
            $this->db->close();
            $this->db->query($execSql);
            $row = $this->db->affected_rows();
            if($row == 0){
                echo "again";
                $this->db->query($execSql);
                $row = $this->db->affected_rows();
            }
print_r("a".$row."b");
            if($row>0){
                $sqlArray = array();
                $sqlArray["fr_result"] =$row;
                $sqlArray["fr_isexec"] ="1";

                $sqlWhere = array();
                $sqlWhere["fr_id"] = $id;
                $this->db->update('fw_userdata_task_result',$sqlArray, $sqlWhere);
                echo $this->db->last_query();
            }

        }

 print_r($execSql);
    }

    public function exec_staffinfo_change()
    {
        $sql = "SELECT lfuff_userflow,lfuff_key,lfuff_value from fw_userdata_flowform ff LEFT JOIN fw_userdata_flow uf on ff.lfuff_userflow=uf.luf_id where lfuff_formid=1 and uf.luf_is_approve=2 and uf.luf_id not in (210,211,212);";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function add_staffchange_info($dataArray)
    {
       $companyid = $dataArray["askForLeave_staff_compid_old"];
       $storeid = $dataArray["askForLeave_staff_storeid_old"];
       $storename = $dataArray["askForLeave_staff_store_name_old"];
       $staffid = $dataArray["askForLeave_staff_staffid"];
       $staffname = $dataArray["askForLeave_staff_staffname"];
       $companyrankname = $dataArray["askForLeave_staff_companyrankname_old"];
       $companyrankid = $dataArray["askForLeave_staff_companyrankid_old"];
       $staffnumber = $dataArray["askForLeave_staff_staffnumber_old"];
       $gender = $dataArray["askForLeave_staff_gender_old"];
       $rankid = $dataArray["askForLeave_staff_rankid_old"];
       $handtype = $dataArray["askForLeave_staff_hand_type"];
       $hand_startdate = $dataArray["askForLeave_staff_hand_startdate"];
       $hand_starthour = $dataArray["askForLeave_staff_hand_starthour"];
       $hand_startminute = $dataArray["askForLeave_staff_hand_startminute"];
       $hand_endminute = $dataArray["askForLeave_staff_hand_endminute"];
       $hand_enddate = $dataArray["askForLeave_staff_hand_enddate"];
       $hand_endhour = $dataArray["askForLeave_staff_hand_endhour"];
       $hand_days = $dataArray["askForLeave_staff_hand_days"];
       $hand_memo = $dataArray["askForLeave_staff_hand_memo"];
       $applytime = $dataArray["dmdate_askForLeave_staff_applytime"];
       $applyuser = $dataArray["askForLeave_staff_applyuser"];
       $appstate = $dataArray["askForLeave_staff_applystate"];

       $startleavedate = $hand_startdate." ".$hand_starthour.":".$hand_startminute.":00";
       $endleavedate = $hand_enddate." ".$hand_endhour.":".$hand_endminute.":00";
        $sql = "insert sm_staffinfo_change(staffchangetype,companyid_old,storeid_old,storename_old,staffid,staffname,staffnumber_old,companyrankid_old,rankid_old,companyid_new,storeid_new,storename_new,staffnumber_new,companyrankid_new,rankid_new,changememo,change_date,applytime,applyuser,applystate,startleavedate,endleavedate,leaveday,leavetype) values(8,'".$companyid."','".$storeid."','".$storename."','".$staffid."','".$staffname."','".$staffnumber."','".$rankid."','".$rankid."','".$companyid."','".$storeid."','".$storename."','".$staffname."','".$rankid."','".$rankid."','".$hand_memo."','".$hand_startdate."','".$applytime."','".$applyuser."','".$appstate."',date_format('".$startleavedate."','%Y-%m-%d %H:%i:%s'),date_format('".$endleavedate."','%Y-%m-%d %H:%i:%s'),'".$hand_days."','".$handtype."')";
        echo $sql;die;
        $this->db->query($sql);
        return $this->db->insert_id();
    }

}

?>