<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/9
 * Time: 10:40
 */
class Flow_dictionary_model extends CI_Model
{
    private $select_sql;

    public function __construct()
    {
        parent::__construct();

        $this->select_sql["get_store_companyrank"] = "SELECT RANKID as option_key, RANKNAME as option_value FROM bm_companyrank where COMPANYID in (IFNULL((SELECT COMPANYID FROM bm_store where STOREID=?),?))";
        //$this->select_sql["get_store_companyranklevel"] = "SELECT RANKID as option_key, RANKNAME as option_value FROM bm_companyrank where COMPANYID in (IFNULL((SELECT COMPANYID FROM bm_store where STOREID=?),?))";
        $this->select_sql["bm_store_kv"] = "SELECT STOREID as option_key,STORENAME as option_value from bm_store WHERE COMPANYID in (IFNULL((SELECT COMPANYID FROM bm_store where STOREID=?),?))";
        $this->select_sql["get_staff_companyrank"] = "SELECT RANKID as option_key, RANKNAME as option_value FROM bm_companyrank where RANKID = ?";
    }

    public function get_staff_entity($staff_number,$storeid)
    {
        $sql = "SELECT * FROM sm_staff where STAFFNUMBER= ? and STOREID = ?";
        $query = $this->db->query($sql,array($staff_number, $storeid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_staff_entity_h5($staffinfo, $storeid, $flowid)
    {
        
        if($flowid == 5){
            $sql = "SELECT s.*,c.RANKNAME FROM sm_staff s LEFT JOIN sm_user u on s.STAFFID=u.USERID LEFT JOIN bm_companyrank c on s.RANKID=c.RANKID where s.IDCARD= ? AND s.STOREID=2 AND s.blacklistflag=0 AND u.STOREID=?";
            $query = $this->db->query($sql, array($staffinfo, $storeid));
        }else{
            $sql = "SELECT s.*,c.RANKNAME FROM sm_staff s LEFT JOIN bm_companyrank c on s.RANKID=C.RANKID where (STAFFNUMBER=? OR STAFFNAME=? OR PHONE=?) AND STOREID=?";
            $query = $this->db->query($sql, array($staffinfo, $staffinfo, $staffinfo, $storeid));
        }
        
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_staff_entity_idcard($staff_idcard,$storeid)
    {
        $sql = "SELECT s.* FROM sm_staff s LEFT JOIN sm_user u on s.STAFFID=u.USERID where s.IDCARD= ? AND s.STOREID=2 AND s.blacklistflag=0 AND u.STOREID=?";//storeid=2为离职员工,离职且未被拉黑的员工可以重回公司
        $query = $this->db->query($sql,array($staff_idcard,$storeid));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_select_option($companyid,$storeid,$model)
    {
        if (array_key_exists($model, $this->select_sql)) {
            $sql = $this->select_sql[$model];
            $query = $this->db->query($sql,array($storeid,$companyid));
            //echo $this->db->last_query();

            return $query->result();
        }
    }

    public function get_change_date($staffid)
    {
        $sql = "select DATE_FORMAT(change_date,'%Y-%m-%d') change_date from sm_staffinfo_change where staffchangetype = 4 and staffid = ?";
        $query = $this->db->query($sql,$staffid);
        //echo $this->db->last_query();
        return $query->row();
    }
    //-----check data------
    private function check_data_user_phone($phone){
        $sql = "select * from sm_user WHERE LOGINNAME=? or MOBILE=?";
        $query = $this->db->query($sql, array($phone,$phone));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function check_data_user_number($storeid, $staffnumber){
        $sql = "select * from sm_staff where STOREID=? and STAFFNUMBER=?";
        $query = $this->db->query($sql, array($storeid, $staffnumber));
        //echo $this->db->last_query();
        return $query->result();
    }

    private function check_data_user_approvar_data($data,$storeid){
        //$sql = "SELECT * FROM fw_userdata_flowform WHERE lfuff_userflow in (SELECT luf_id from fw_userdata_flow where luf_is_approve in (0,1,2)  and luf_flow=2) and lfuff_value = ?";
        $sql = "SELECT * from fw_userdata_flowform where ((lfuff_key='entryAppli_staff_staffnumber' and lfuff_value=?) or (lfuff_key='entryAppli_staff_phone' and lfuff_value=?) or (lfuff_key='backCompany_staff_staffnumber_new' and lfuff_value=?) or (lfuff_key='backCompany_staff_phone' and lfuff_value=?)) AND lfuff_userflow IN (SELECT luf_id from fw_userdata_flow where luf_is_approve IN (0,1) AND luf_storeid=?);";
        $query = $this->db->query($sql, array($data,$data,$data,$data,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    // return true/false
    public function get_check_data($storeid,$model,$check_data)
    {
        $return = array();
        $return["status"] = "000";
        $return["message"] = "success";
        $return["model"] = $model;
        
        if($model == "user_staff_phone"){
            if (!isset($check_data)) {
                $return["status"] = "003";
                $return["message"] ="手机号码不能为空!";
                return $return;
            }

            $result = $this->check_data_user_phone($check_data);
            if(count($result)>0){
                $return["status"] = "001";
                $return["message"] =$check_data."已经存在！不可以重复!";
                return $return;
            }
            
        }

        if($model == "user_staff_number"){
            if (empty($check_data)) {
                $return["status"] = "003";
                $return["message"] ="员工工号不能为空!";
                return $return;
            }

            $result = $this->check_data_user_number($storeid, $check_data);
            if(count($result)>0){
                $return["status"] = "001";
                $return["message"] =$check_data."已经存在！不可以重复!";
                return $return;
            }
        }

        $result = $this->check_data_user_approvar_data($check_data,$storeid);
        if(count($result)>0){
            $return["status"] = "002";
            $return["message"] =$check_data."正在审核中..！不可以重复!";
        }
        
        return $return;
    }

    public function get_store_list()
    {
        $sql = "SELECT storeid,storeshortnum,storename FROM `bm_store`";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_staff_list($storeid, $staff_number)
    {

        if(!empty($staff_number)){
            $sql = "SELECT * FROM `sm_staff` s LEFT JOIN `bm_companyrank` c on s.`RANKID`=c.`RANKID` WHERE STOREID = ? AND STAFFNUMBER = ?";
            $query = $this->db->query($sql,array($storeid, $staff_number));
        }else{
            $sql = "SELECT * FROM `sm_staff` s LEFT JOIN `bm_companyrank` c on s.`RANKID`=c.`RANKID` WHERE s.`STOREID` = ? AND s.`enable`=1";
            $query = $this->db->query($sql, $storeid);
        }
        
        return $query->result();
    }

    public function getStoreInfo($storeShortNum)
    {
        $sql = "select STOREID,COMPANYID,STORENAME FROM bm_store where STORESHORTNUM=? AND STORESTATUS=0";
        $query = $this->db->query($sql,array($storeShortNum));
        return $query->result();
    }

}