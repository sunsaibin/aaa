<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/11/30
 * Time: 14:51
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Flow_own_model extends CI_Model
{
    public  function  aaa()
    {
        echo "aaa";
    }

    public function get_user_flow($userid, $type = null)
    {
        $where = "";
        $order = " ORDER BY luf_cdate DESC";
        if($type) {
            $where = " AND l.luf_type = ".$type;
        }
        // 我发起的
        $sql = "SELECT * FROM `fw_userdata_flow` l LEFT JOIN  `fw_flow` f on f.`flow_id` = l.`luf_flow` where `luf_user`=?".$where.$order;
        //$sql = "SELECT * FROM `fw_userdata_flow` l LEFT JOIN  `fw_flow` f on f.`flow_id` = l.`luf_flow` and f.flow_enable=1 LEFT JOIN bm_company c on l.luf_company=c.companyid and into_s3=0 LEFT JOIN bm_store s on l.luf_storeid=s.storeid where `luf_user`=?";
        $query = $this->db->query($sql, array($userid));
        //echo $this->db->last_query();die;
        return $query->result();
    }
    // 总记录数 own
    public function get_userdata_flow_own($storeWhere,$companyid,$start_date,$end_date,$luf_is_approve,$user_name,$user_id,$user_type)
    {
        if($luf_is_approve == ''){
            $sql = 'SELECT count(*) as count from fw_userdata_flow where (luf_storeid IN '.$storeWhere.' or (luf_storeid=0 and luf_company=?)) and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7,14) ORDER BY luf_cdate desc';
            //$sql = "SELECT count(*) as count FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate";
            $query = $this->db->query($sql,array($companyid));
        }else{
            $sql = 'SELECT count(*) as count from fw_userdata_flow where (luf_storeid IN '.$storeWhere.' or (luf_storeid=0 and luf_company=?)) and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7,14) AND luf_is_approve <> 2 ORDER BY luf_cdate desc';
            //$sql = "SELECT count(*) as count FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND luf_is_approve <> 2 AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) AND (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate";
            $query = $this->db->query($sql,array($companyid));
            //$query = $this->db->query($sql, array($luf_is_approve));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }
    // 分页 own
    public function get_userdata_flow_own_limit($storeWhere,$companyid,$start_date,$end_date,$luf_is_approve,$per_page,$offset)
    {
        if($luf_is_approve == ''){
            // 查询所有(待审核，审核中，审核通过，已撤销的)申请
            $sql = 'SELECT uf.luf_id, uf.luf_user_name, uf.luf_flow, uf.luf_storeid, uf.luf_company, uf.luf_store_name, uf.luf_cdate, uf.luf_is_approve,ff.lfuff_key,ff.lfuff_value FROM fw_userdata_flow uf LEFT JOIN fw_userdata_flowform ff on uf.luf_id=ff.lfuff_userflow WHERE (ff.lfuff_key LIKE "%change_date%" or ff.lfuff_key LIKE "%staff_hand_startdate%") AND (luf_storeid IN '.$storeWhere.' or (luf_storeid=0 and luf_company=?)) and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7,14,15) ORDER BY luf_cdate desc  limit ?,?';
            //$sql = "SELECT luf_id, luf_user_name, luf_flow, luf_storeid, luf_company, luf_store_name, luf_cdate, luf_is_approve FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?";
            $query = $this->db->query($sql, array($companyid,$offset,$per_page));
        }else{
            // 默认查询轮到自己审核的申请，及撤销的
            $sql = 'SELECT uf.luf_id, uf.luf_user_name, uf.luf_flow, uf.luf_storeid, uf.luf_company, uf.luf_store_name, uf.luf_cdate, uf.luf_is_approve,ff.lfuff_key,ff.lfuff_value FROM fw_userdata_flow uf LEFT JOIN fw_userdata_flowform ff on uf.luf_id=ff.lfuff_userflow WHERE (ff.lfuff_key LIKE "%change_date%" or ff.lfuff_key LIKE "%staff_hand_startdate%") and (luf_storeid IN '.$storeWhere.' or (luf_storeid=0 and luf_company=?)) and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7,14,15) AND luf_is_approve <> 2 ORDER BY luf_cdate desc limit ?,?';
            //$sql = "SELECT luf_id, luf_user_name, luf_flow, luf_storeid, luf_company, luf_store_name, luf_cdate, luf_is_approve FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND luf_is_approve <> 2 AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?";
            $query = $this->db->query($sql, array($companyid,$offset,$per_page));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }
    // 总记录数 approval
    public function get_userdata_flow($storeWhere,$companyid,$start_date,$end_date,$luf_is_approve,$user_name,$user_id,$user_type)
    {
        if($luf_is_approve == ''){
            //$sql = 'SELECT luf_id,luf_user_name,luf_flow,luf_storeid,luf_company,luf_store_name,luf_cdate,luf_is_approve from fw_userdata_flow where luf_storeid IN '.$storeWhere.' and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7) ORDER BY luf_cdate desc';
            $sql = "SELECT count(*) as count FROM fw_userdata_flow WHERE (luf_storeid IN ".$storeWhere." or (luf_storeid=0 and luf_company=?)) AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate";
            $query = $this->db->query($sql,array($companyid,$user_name,$user_id,$user_type,$user_name,$user_id,$user_type));
        }else{
            //$sql = 'SELECT luf_id,luf_user_name,luf_flow,luf_storeid,luf_company,luf_store_name,luf_cdate,luf_is_approve from fw_userdata_flow where luf_storeid IN '.$storeWhere.' and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7) AND luf_is_approve=? ORDER BY luf_cdate desc';
            $sql = "SELECT count(*) as count FROM fw_userdata_flow WHERE (luf_storeid IN ".$storeWhere." or (luf_storeid=0 and luf_company=?)) AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND luf_is_approve <> 2 AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) AND (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate";
            $query = $this->db->query($sql,array($companyid,$user_name,$user_id,$user_type,$user_name,$user_id,$user_type));
            //$query = $this->db->query($sql, array($luf_is_approve));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }
    // 分页 approval
    public function get_userdata_flow_limit($storeWhere,$companyid,$start_date,$end_date,$luf_is_approve,$per_page,$offset,$user_name,$user_id,$user_type)
    {
        if($luf_is_approve == ''){
            // 查询所有(待审核，审核中，审核通过，已撤销的)申请
            //$sql = 'SELECT luf_id,luf_user_name,luf_flow,luf_storeid,luf_company,luf_store_name,luf_cdate,luf_is_approve from fw_userdata_flow where luf_storeid IN '.$storeWhere.' and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7) ORDER BY luf_cdate desc  limit ?,?';
            //$sql = "SELECT luf_id, luf_user_name, luf_flow, luf_storeid, luf_company, luf_store_name, luf_cdate, luf_is_approve FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?"; 未明确生效日期的查询
            $sql = "SELECT uf.luf_id, uf.luf_user_name, uf.luf_flow, uf.luf_storeid, uf.luf_company, uf.luf_store_name, uf.luf_cdate, uf.luf_is_approve,ff.lfuff_key,ff.lfuff_value FROM fw_userdata_flow uf LEFT JOIN fw_userdata_flowform ff on uf.luf_id=ff.lfuff_userflow WHERE (ff.lfuff_key LIKE '%change_date%' or ff.lfuff_key LIKE '%staff_hand_startdate%') and (luf_storeid IN ".$storeWhere." or (luf_storeid=0 and luf_company=?)) AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?";
            $query = $this->db->query($sql, array($companyid,$user_name,$user_id,$user_type,$user_name,$user_id,$user_type,$offset,$per_page));
        }else{
            // 默认查询轮到自己审核的申请，及撤销的
            //$sql = 'SELECT luf_id,luf_user_name,luf_flow,luf_storeid,luf_company,luf_store_name,luf_cdate,luf_is_approve from fw_userdata_flow where luf_storeid IN '.$storeWhere.' and luf_cdate BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" AND luf_flow in(1,2,3,4,5,6,7) AND luf_is_approve=? ORDER BY luf_cdate desc limit ?,?';
            //$sql = "SELECT luf_id, luf_user_name, luf_flow, luf_storeid, luf_company, luf_store_name, luf_cdate, luf_is_approve FROM fw_userdata_flow WHERE luf_storeid IN ".$storeWhere." AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND luf_is_approve <> 2 AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?"; 未明确生效日期的查询
            $sql = "SELECT uf.luf_id, uf.luf_user_name, uf.luf_flow, uf.luf_storeid, uf.luf_company, uf.luf_store_name, uf.luf_cdate, uf.luf_is_approve,ff.lfuff_key,ff.lfuff_value FROM fw_userdata_flow uf LEFT JOIN fw_userdata_flowform ff on uf.luf_id=ff.lfuff_userflow WHERE (ff.lfuff_key LIKE '%change_date%' or ff.lfuff_key LIKE '%staff_hand_startdate%') and (luf_storeid IN ".$storeWhere." or (luf_storeid=0 and luf_company=?)) AND luf_cdate BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' AND luf_is_approve <> 2 AND ( luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep WHERE lufs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? )) OR luf_id IN ( SELECT lufs_userflow FROM fw_userdata_flowstep f LEFT JOIN fw_flowstep_flowstep p ON f.lufs_flowstep = p.ffs_step WHERE p.ffs_approval IN ( SELECT fau_approval FROM fw_approval_user WHERE fau_user_name = ? AND fau_userid = ? AND fau_user_type = ? ) and (f.lufs_flowstepid = p.ffs_step_start or (f.lufs_flowstepid=0 and p.ffs_step_start =0)) AND f.lufs_approval_jump = 0 )) ORDER BY luf_cdate DESC LIMIT ?,?";
            $query = $this->db->query($sql, array($companyid,$user_name,$user_id,$user_type,$user_name,$user_id,$user_type,$offset,$per_page));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function get_userdata_flowstep_cdate($flowstep_id)
    {
        $sql ="SELECT lufs_approval_cdate from fw_userdata_flowstep where lufs_id=? and lufs_approval_jump=-1";
        $query = $this->db->query($sql, array($flowstep_id));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function get_userdata_flowform_staffnumber($luf_id,$luf_flow,$staff_number)
    {
        if($staff_number == ''){
            $sql = 'SELECT * from fw_userdata_flowform where lfuff_userflow=? AND lfuff_formid=? AND lfuff_key like "%staff_staffnumber%"';
            $query = $this->db->query($sql, array($luf_id,$luf_flow));
        }else{
            $sql = 'SELECT * from fw_userdata_flowform where lfuff_userflow=? AND lfuff_formid=? AND lfuff_key like "%staff_staffnumber%" and lfuff_value=?';
            // 按工号 身份证号 姓名 查询 (但数据显示有问题)
            // $sql = 'SELECT * from fw_userdata_flowform where lfuff_userflow=? AND lfuff_formid=? AND (lfuff_key like "%staff_staffnumber%" and lfuff_value=?) or (lfuff_key like "%staff_staffname%" and lfuff_value=?) or (lfuff_key like "%staff_idcard%" and lfuff_value=?)';
            $query = $this->db->query($sql, array($luf_id,$luf_flow,$staff_number));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function get_userdata_flowform_staffname($luf_id,$luf_flow)
    {
        $sql = 'SELECT lfuff_value from fw_userdata_flowform where lfuff_userflow=? AND lfuff_formid=? AND lfuff_key like "%staff_staffname%"';
        $query = $this->db->query($sql, array($luf_id,$luf_flow));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function get_userdata_flowform_cdate($luf_id,$luf_flow)
    {
        $sql = 'SELECT lfuff_cdate from fw_userdata_flowform where lfuff_userflow=? AND lfuff_formid=? limit 1';
        $query = $this->db->query($sql, array($luf_id,$luf_flow));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function get_form_carddata($luf_id)
    {
        $sql = "SELECT * from fw_userdata_flowform where lfuff_key LIKE '%cardnumber%' or lfuff_key LIKE '%userflow_id%' and lfuff_userflow=?";
        $query = $this->db->query($sql, array($luf_id));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    // 获取审核信息
    public function get_userdata_flowstep($user_flowid)
    {
        //$sql = "SELECT a.lufs_id,a.lufs_userflow,a.lufs_is_adopt,a.lufs_explain,a.lufs_approval_cdate,b.fau_user_name,b.fau_approval from fw_userdata_flowstep a LEFT JOIN fw_approval_user b on a.lufs_approval_user=b.fau_userid WHERE lufs_userflow=? GROUP BY lufs_approval_cdate";
        //$sql = "SELECT a.lufs_id,a.lufs_userflow,a.lufs_is_adopt,a.lufs_explain,a.lufs_approval_cdate,b.fau_user_name,b.fau_approval from fw_userdata_flowstep a LEFT JOIN fw_approval_user b on a.lufs_approval_user=b.fau_userid WHERE lufs_userflow=? GROUP BY a.lufs_id,a.lufs_userflow,a.lufs_is_adopt,a.lufs_explain,a.lufs_approval_cdate,b.fau_user_name,b.fau_approval";
        $sql = "SELECT a.lufs_id,max(a.lufs_userflow) lufs_userflow,max(a.lufs_is_adopt) lufs_is_adopt,max(a.lufs_explain) lufs_explain,max(a.lufs_approval_cdate) lufs_approval_cdate,max(b.fau_user_name) fau_user_name,max(b.fau_approval) fau_approval from fw_userdata_flowstep a LEFT JOIN fw_approval_user b on a.lufs_approval_user=b.fau_userid WHERE lufs_userflow=? GROUP BY a.lufs_id";
        $query = $this->db->query($sql, array($user_flowid));
        //echo $this->db->last_query();die;
        return $query->result();
    }

    //app形象照审核接口
    public function get_user_flow_api($flowid)
    {
        $sql = "SELECT * FROM `fw_userdata_flow` l LEFT JOIN  `fw_flow` f on f.`flow_id` = l.`luf_flow` where `luf_flow`=? ";
        $query = $this->db->query($sql, array($flowid));
        //echo $this->db->last_query();
        return $query->result();
    }
    //伪删除
    public function get_fake_delete($luf_id, $userid)
    {
        $sql = "UPDATE `fw_userdata_flow` SET `luf_isdelete`='1' WHERE `luf_id` = ? AND `luf_user` = ?";
        $this->db->query($sql, array($luf_id, $userid));
        return $this->db->affected_rows();
    }

    //流程表单值
    public function get_form_value($userid)
    {
        $sql = "SELECT * FROM `fw_userdata_flow` l LEFT JOIN `fw_userdata_flowform` f on l.`luf_id` = f.`lfuff_userflow` where `luf_user`=? ";
        $query = $this->db->query($sql, array($userid));
        $info = $query->result();
        $arr = array();
        foreach ($info as $k => $v) {
            $arr[$v->luf_id]['userid'] =$v->luf_user;
            $arr[$v->luf_id]['value'][] =$v->lfuff_value;
        }
        return $arr;
    }

    //获取用户的流程
    public function get_user_have_flows($level, $type = null)
    {
        $sql = "SELECT	* FROM	`fw_flow_flowstep` f LEFT JOIN `fw_flow_restraint` r ON f.`ff_restraint` = r.`ffr_id` AND r.ffr_enable = 1 LEFT JOIN `fw_flow` w ON w.`flow_id` = f.`ff_flow` AND w.flow_enable = 1 WHERE (r.`ffr_level` = 1 OR r.`ffr_level` =?) AND ff_enable = 1 AND w.flow_type = 1;";
        $query = $this->db->query($sql, array($level));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 查询用户流程审批步骤
     * */
    public function get_user_flowstep($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowstep` l LEFT JOIN `fw_flowstep_flowstep` f on l.`lufs_flowstep` = f.`ffs_id` LEFT JOIN `fw_approval` a on a.`fa_id` = l.`lufs_approval` LEFT JOIN `fw_approval_user` r on r.`fau_userid` = l.`lufs_approval_user` LEFT JOIN `fw_userdata_flow` u on l.`lufs_userflow`=u.`luf_id` where lufs_userflow=? GROUP BY lufs_sequence,lufs_approval";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 查询用户的表单html/h5内容
     * */
    public function get_user_flow_form($tid)
    {
        $sql = "SELECT * FROM `fw_flowform` where `flowform_id` in (SELECT `lfuff_formid` FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?)";
        $query = $this->db->query($sql, array($tid));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    /*
     * 获取用户表单数据.
     * */
    public function get_userdata_flow_form($tid)
    {
        $sql = "SELECT * FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?";
        $query = $this->db->query($sql, array($tid));
        return $query->result();
    }

    /*
     * 获取用户流程
     * */
    public function get_user_flowstep_entity($lufs_id, $id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowstep`  where `lufs_id` = ? AND`lufs_userflow` = ?";
        $query = $this->db->query($sql, array($lufs_id, $id));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function  get_user_approval($userid, $type = -1)
    {
        $sql = "select * from fw_userdata_flow p LEFT JOIN fw_flow k on p.luf_flow = k.flow_id where k.flow_id is not null and p.luf_id in( select lufs_userflow  from  `fw_userdata_flowstep` u LEFT JOIN `fw_flowstep_flowstep` f on u.`lufs_flowstep`=f.`ffs_id` LEFT JOIN  `fw_approval` a on f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l on a.`fa_id` = l.`fau_approval` where `fau_userid` =? and (p.type =? or p.type =-1))";
        $query = $this->db->query($sql, array($userid,$type));
        //echo $this->db->last_query();
        return $query->result();
    }

    //流程步骤列表方法
    public function get_user_li($userid, $id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowstep` l LEFT JOIN `fw_flowstep_flowstep` f on l.`lufs_flowstep` = f.`ffs_id` LEFT JOIN `fw_approval` a on a.`fa_id` = l.`lufs_approval` LEFT JOIN `fw_approval_user` r on r.`fau_id` = l.`lufs_approval_user` where lufs_userflow=?";
        $query = $this->db->query($sql, array($id));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    //
    public function get_user_approval_form($id)
    {
        $sql = "SELECT * FROM `fw_flowform` WHERE `flowform_id` in (SELECT `lfuff_formid` FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?)";
        $query = $this->db->query($sql, array($id));
        /*        echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_user_approval_formdata($userid, $id, $type)
    {
        $sql = "SELECT f.* FROM `oa_direction_approval` f LEFT JOIN `fw_userdata_flowform` p on f.`from_id` = p.`lfuff_formid` LEFT JOIN `fw_userdata_flowstep` v on p.`lfuff_user_flowstep` = v.`lufs_id` LEFT JOIN `fw_approval_user` b on p.`lfuff_formid` = b.`fau_id` WHERE v.`lufs_flowstep` = f.`rec_lufs` AND (b.`fau_user_type`=? or b.`fau_user_type`=-1)  AND f.`from_id` = p.`lfuff_formid` AND p.`lfuff_userflow`=? AND f.`approve_user`= ?";
        $query = $this->db->query($sql, array($type,$id,$userid));//约束key
        return $query->row();
    }

    public function get_user_approval_info($id)
    {
        $sql = "SELECT * FROM `fw_userdata_flowform` WHERE `lfuff_userflow`=?";
        $query = $this->db->query($sql, array($id));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_user_approval_flowstep($userid,$id, $type)
    {
        $sql = "SELECT * FROM `fw_approval_user` WHERE `fau_approval` in (SELECT `ffs_approval` FROM `fw_flowstep_flowstep` f  LEFT JOIN `fw_userdata_flowstep` p on f.ffs_id = p.`lufs_flowstep` WHERE `lufs_userflow`=? and `lufs_is_adopt`=0) and  `fau_userid` = ?";
        $query = $this->db->query($sql, array($id, $userid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_flow($id)
    {
        $sql = "SELECT * FROM `fw_userdata_flow` where luf_id = ".$id;
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_userdata_flow_entity($user_flow_id)
    {
        $sql = "SELECT * FROM `fw_userdata_flow`  where `luf_id` = ?";
        $query = $this->db->query($sql, array($user_flow_id));
        //echo $this->db->last_query();die;
        return $query->row();
    }

    public function update_approve_and_adopt($user_flowid, $userid)
    {
        $sql = "update fw_userdata_flow set luf_is_approve=4 where luf_id=? and luf_user=?";
        $query = $this->db->query($sql,array($user_flowid, $userid));
        $sql = "update fw_userdata_flowstep set lufs_is_adopt=4 where lufs_userflow=? and lufs_approval_jump=0 and lufs_userflow in (SELECT luf_id FROM fw_userdata_flow where luf_user=? and luf_is_approve=4)";
        $query = $this->db->query($sql,array($user_flowid,$userid));
    }

    public function get_user_info($staffid)
    {
        $sql = "select STAFFNUMBER,STOREID,USERNAME,MOBILE from sm_user where USERID=?";
        $query = $this->db->query($sql,array($staffid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_staff_info($staffid)
    {
        $sql = "select STAFFNAME,STAFFNUMBER,STOREID,PHONE,IDCARD from sm_staff where STAFFID=?";
        $query = $this->db->query($sql,array($staffid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_store_num($storeid)
    {
        $sql = "select STORESHORTNUM,STORENAME from bm_store where STOREID=?";
        $query = $this->db->query($sql,array($storeid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_sys_staffid($uesrname)
    {
        $sql = "select staffid from sys_user where username=?";
        $query = $this->db->query($sql,array($uesrname));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_staff_name($staffid)
    {
        $sql = "select STAFFNAME from sm_staff where STAFFID=?";
        $query = $this->db->query($sql,array($staffid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function approval_user($userid,$approve_status,$lufs_id)
    {
        if($approve_status == '待审核'){
            $sql = "SELECT * from fw_userdata_flowstep fs LEFT JOIN fw_flowstep_flowstep ff on fs.lufs_flowstep=ff.ffs_step where fs.lufs_id=? and fs.lufs_is_adopt = 0 and ff.ffs_approval in (SELECT fau_approval from fw_approval_user where fau_userid=?)";
            $query = $this->db->query($sql,array($lufs_id,$userid));
            //echo $this->db->last_query();
            return $query->result();
            
        }
        elseif($approve_status == '审核中'){
            $sql = "SELECT * from fw_userdata_flowstep  where lufs_id=? and lufs_approval_user=? and lufs_is_adopt=1";
            $query = $this->db->query($sql,array($lufs_id,$userid));
            //echo $this->db->last_query();
            $row =  $query->row();
            if($row > 0){
                return null;
            }else{
                return 1;
            }
        }
        
    }
}