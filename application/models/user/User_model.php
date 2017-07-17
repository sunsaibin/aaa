<?php
date_default_timezone_set('Asia/Shanghai');
class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

    /*
     * 清除用户数据
     * */
    public function cleanUserUrl()
    {
    	$this->session->unset_userdata('staffinfo');
    	$this->session->unset_userdata('type');
    }

    /*
     * 处理用户数据，
     * 10001:app
     * */
    public function dealUserUrl()
    {
    	$staffinfo = $this->session->userdata("staffinfo");
    	$userid = $this->input->get("userid");
	    if(isset($userid))
	    {
	        $username = $this->input->get("username");
	        $password = $this->input->get("userpwd");
	        $usertype = $this->input->get("type");
            $userpass = $this->input->get("pass");

            if($userpass=="1001"){
                $sql = "SELECT STAFFID id,STAFFNAME username, COMPANYID companyid,STOREID storeid FROM sm_staff where STAFFID in (SELECT USERID FROM sm_user WHERE LOGINNAME=? and USERID=?);";
                $query = $this->db->query($sql, array($username,$userid));
                $t_staffinfo = $query->row();
            }
            else if($userpass=="1002"){
                $sql = "SELECT * FROM `sys_user` u where (username=?) or staffid in (SELECT USERID FROM sm_user WHERE USERID = u.staffid and `PASSWORD`= ? and MOBILE=?)";
                $query = $this->db->query($sql, array($username,$password, $username));
                $t_staffinfo = $query->row();
                if(empty($t_staffinfo)){
                    $sql = "SELECT STAFFID id,STAFFNAME username, COMPANYID companyid,STOREID storeid FROM sm_staff where STAFFID in (SELECT USERID FROM sm_user WHERE LOGINNAME=? and USERID=?);";
                    $query = $this->db->query($sql, array($username,$userid));
                    $t_staffinfo = $query->row();
                }
            }
            else if($usertype=="1"){
                $sql = "SELECT * FROM sm_staff where STAFFID in (SELECT staffid FROM sys_user where id=? and username=?)";
                $query = $this->db->query($sql, array($username, $username));
                $t_staffinfo = $query->row();
            }
            else{
                $sql = "SELECT * FROM `sys_user` u where (id=? and username=?) or staffid in (SELECT USERID FROM sm_user WHERE USERID = u.staffid and `PASSWORD`= ? and MOBILE=?)";
                $query = $this->db->query($sql, array($userid,$username,$password, $username));
                $t_staffinfo = $query->row();
            }
            //echo $this->db->last_query();
	        if (isset($t_staffinfo) && count($t_staffinfo)>0) {
	            $this->load->library('session');
	            $this->session->set_userdata('staffinfo',$t_staffinfo);
	            $this->session->set_userdata('type',$_GET['type']);
	            $this->session->set_userdata('pass',$_GET['pass']);
	            $this->session->set_userdata('username',$_GET['username']);
	            $staffinfo = $t_staffinfo;
	        }
	    }

	   	if (!isset($staffinfo)) {
	   		echo "error! userid 为空!";
	   		exit;
	   	}
	    return $staffinfo;
    }

    /*
     * 获取当前用户的信息数据.
     * */
   	public function getStaffInfo()
   	{
   		$staffinfo = $this->session->userdata("staffinfo");
   		return $staffinfo;
   	}

    /*
     * 获取用户类型
     * */
   	public function getUserType()
   	{
   		$type = $this->session->userdata("type");
   		return $type;
   	}

    /*
     * 获取用户id的渠道/通道
     * */
   	public function getUserPass()
   	{
   		$pass = $this->session->userdata("pass");
   		return $pass;
   	}

    /*
     * 获取用户所在公司
     * */
   	public function getUserCompany()
   	{
   		$staffinfo = $this->getStaffInfo();
   		if (isset($staffinfo)) {
   			$sql = "SELECT * FROM bm_company WHERE COMPANYID in (SELECT companyid FROM sys_user where  id = ?)";
        	$query = $this->db->query($sql, array($staffinfo->id));
        	return $query->row();
   		}
   		return null;
   	}

    /*
     * 获取用户所在的子类公司集合.
     * */
    public function getCompanyParentid($companyid)
    {
        $sql = "SELECT * FROM bm_company WHERE PARENTID = ?";
        $query = $this->db->query($sql, array($companyid));
        $subCompanyData = $query->result();

        $subCompanyArr = array();
        foreach ($subCompanyData as $key => $value) {
            $subCompanyArr[$value->COMPANYID] = $value;
            $subCompanyArr_tem = $this->getCompanyParentid($value->COMPANYID);

            if (count($subCompanyArr_tem)) {
              $subCompanyArr = array_merge ($subCompanyArr, $subCompanyArr_tem);
            }
        }
        return $subCompanyArr;
    }

    /*
     * 获取用户选择公司
     * */
   	public function getUserHasCompany()
   	{
        $subCompany = array();
        $staffinfo = $this->getStaffInfo();

   		if (isset($staffinfo)) {
   			$sql = "SELECT * FROM bm_company WHERE COMPANYID in (SELECT IF(companyid=0,1,companyid) FROM sys_user where id = ?)";
   			$query = $this->db->query($sql, array($staffinfo->id));
            $userData = $query->row();

            if (count($userData) > 0) {
                if (intval($staffinfo->storeid) < 1) {
                   $subCompany = $this->getCompanyParentid($userData->COMPANYID);
                }
            }
            array_push($subCompany, $userData);
             //print_r($subCompany);
        }
        return $subCompany;
   	}


    /*
     * 获取用户选择公司
     * */
    public function getUserSelectCompany($companyid)
    {
        $subCompany = array();

        if (isset($companyid)) {
            $sql = "SELECT * FROM bm_company WHERE COMPANYID in (SELECT IF(companyid=0,1,companyid) FROM sys_user where COMPANYID = ?)";
            $query = $this->db->query($sql, array($companyid));
            $userData = $query->row();

            if (count($userData) > 0) {
                $subCompany = $this->getCompanyParentid($userData->COMPANYID);
            }
            array_push($subCompany, $userData);
            //print_r($subCompany);
        }
        return $subCompany;
    }

    /*
     * 获取用户门店数据。
     * */
   	public function getUserStore()
   	{
   		$staffinfo = $this->getStaffInfo();
   		if (isset($staffinfo)) {
   			$sql = "SELECT * FROM bm_store where STOREID in (SELECT storeid FROM sys_user where id=?)";
        	$query = $this->db->query($sql, array($staffinfo->id));
        	return $query->row();
   		}
   		return null;
   	}

    /*
     * 查询门店数据,参数门店编号
     * */
    public function queryUserStore($storeid)
    {
      $sql = "SELECT * FROM bm_store where STOREID =?";
      $query = $this->db->query($sql, array($storeid));
      //echo $this->db->last_query();
      return $query->row();
    }

    /*
     * 获取门店的树形结构.
     * */
	public function getUserSelectStore($companyArray)
   	{
        $sqlStoreIds = " (-1";
        //print_r($companyArray);
        foreach ($companyArray as $key => $value) {
            if (isset($value->COMPANYID)) {
                $sqlStoreIds .= " , ".$value->COMPANYID;
            }
        }
        $sqlStoreIds .= ") ";

        $sql = "SELECT * FROM bm_store where STORESTATUS=0 and COMPANYID in ".$sqlStoreIds;
        $query = $this->db->query($sql);
        return $query->result();
   	}

    /*
     * 获取门店的树形结构.
     * */
    public function getCompanyIdHasStore($companyid)
    {
        $companyArray = $this->getUserSelectCompany($companyid);

        $sqlStoreIds = " (-1";
        foreach ($companyArray as $key => $value) {
            if (isset($value->COMPANYID)) {
                $sqlStoreIds .= " , ".$value->COMPANYID;
            }
        }
        $sqlStoreIds .= ") ";

        $sql = "SELECT * FROM bm_store where STORESTATUS=0 and COMPANYID in ".$sqlStoreIds;
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*
    * 流程头
    * */
    public function flow_header()
    {
        $this->load->library('session');

        $flowid = $this->input->post("flowid");
        if (!isset($flowid)) {
            $flowid = $this->input->get("flowid");
        }

        $stallInfo = $this->user->dealUserUrl();
        if (!isset($storeid)) {
            $storeid = $stallInfo->storeid;
        }

        $userid = $stallInfo->id;
        $username = $stallInfo->username;

        $stallCompany = $this->user->getUserHasCompany();
        $stallStore = $this->user->queryUserStore($storeid);

        $level = $this->input->get("level");
        if(!isset($level)){
            $level = -1;
        }

        $type = $this->getUserType();
        if(!isset($type)){
            $type = "1";
        }

        $selectCompany = $this->user->getUserHasCompany();
        if (intval($stallInfo->storeid)<1) {
            $selectStore = $this->user->getUserSelectStore($selectCompany);
        }

	    $storeWhere = "(-1";
        foreach ($selectStore as $key => $value) {
          if (isset($value->STOREID)) {
            $storeWhere .= " , ".$value->STOREID;
          }
        }
        $storeWhere .= ") ";

        $return = array();
        $return["storeid"] = $storeid;
        $return["storename"] = $stallStore->STORENAME;
        $return["stallInfo"] = $stallInfo;
        $return["stallCompany"] = $stallCompany;
        $return["stallStore"] = $stallStore;
        $return["userid"] = $userid;
        $return["type"] = $type;
        $return["username"] = $username;
        $return["flowid"] = $flowid;
        $return["level"] = $level;
        $return["companyid"] = $stallInfo->companyid;
        $return["companyname"] = $stallCompany->COMPANYNAME;
        $return["storeWhere"] = $storeWhere;
        return $return;
    }


    /*
     * Store内容头
     * */
    public  function  store_header()
    {
        $this->load->library('session');
        $return = array();

        //choose_type
        $choose_type = 1;  //1:按日期, 2:按门店
        if (in_array("choose_type",array_keys($_REQUEST))) {
            $choose_type = $this->input->get_post("choose_type");
        }
        $return["choose_type"] = $choose_type;

        //start_date
        $start_date = date("Y-m-01",time());  //1:按日期, 2:按门店
        if (in_array("start_date",array_keys($_REQUEST))) {
            $start_date = $this->input->get_post("start_date");
        }
        $return["start_date"] = $start_date;

        //end_date
        $end_date = date("Y-m-d",time());  //1:按日期, 2:按门店
        if (in_array("end_date",array_keys($_REQUEST))) {
            $end_date = $this->input->get_post("end_date");
        }
        $return["end_date"] = $end_date;

        //staff
        $stallInfo = $this->dealUserUrl();
        $return["stallInfo"] = $stallInfo;

        //seach_name
        $seach_name = "";  //1:按日期, 2:按门店
        if (in_array("seach_name",array_keys($_REQUEST))) {
            $seach_name = $this->input->get_post("seach_name");
        }
        $return["seach_name"] = $seach_name;

        //seach_companyid
        $seach_companyid = $stallInfo->companyid;;  //1:按日期, 2:按门店
        if (in_array("seach_companyid",array_keys($_REQUEST))) {
            $seach_companyid = $this->input->get_post("seach_companyid");
        }
        $return["seach_companyid"] = $seach_companyid;

        //storeid
        $seach_storeid = $stallInfo->storeid;  //1:按日期, 2:按门店
        if (in_array("seach_storeid",array_keys($_REQUEST))) {
            $seach_storeid = $this->input->get_post("seach_storeid");
        }
        $return["seach_storeid"] = $seach_storeid;

        $storeWhere = "(".$seach_storeid.")";
        if (intval($seach_storeid)<1) {
            $selectStore = $this->getCompanyIdHasStore($seach_companyid);
            $storeWhere = "(-1";
            foreach ($selectStore as $key => $value) {
                if (isset($value->STOREID)) {
                    $storeWhere .= " , ".$value->STOREID;
                }
            }
            $storeWhere .= ") ";
        }
        $return["storeWhere"] = $storeWhere;

        return $return;
    }

    /*
     * 报表头-搜索使用..
     * */
    public function seach_header()
    {
        $this->load->library('session');
        $this->load->model('user/User_model', 'user');

        $storeid = $this->input->post("storeid");
        if (!isset($storeid)) {
          $storeid = $this->input->get("storeid");
        }

        $querydate = $this->input->post("querydate");
        if (!isset($querydate)) {
          $querydate = $this->input->get("querydate");
        }

        if (!isset($querydate)) {
            $sess_querydate = $this->session->userdata("sess_querydate");
            if(isset($sess_querydate)){
                $querydate = $sess_querydate;
            }
            else $querydate = date("Y-m-d");
        }
        else{
            $this->session->set_userdata('sess_querydate',$querydate);
        }

        $queryenddate = $this->input->post("queryenddate");
        if (!isset($queryenddate)) {
          $queryenddate = $this->input->get("queryenddate");
        }
        if (!isset($queryenddate)) {
            $sess_queryenddate = $this->session->userdata("sess_queryenddate");
            if(isset($sess_queryenddate)){
                $queryenddate = $sess_queryenddate;
            }
            else $queryenddate = date("Y-m-d");
        }
        else{
            $this->session->set_userdata('sess_queryenddate',$queryenddate);
        }

        $stallInfo = $this->user->dealUserUrl();
        if (!isset($storeid)) {
          $storeid = $stallInfo->storeid;
        }

        $userid = $stallInfo->id;
        $username = $stallInfo->username;

        $stallCompany = $this->user->getUserCompany();
        $stallStore = $this->user->queryUserStore($storeid);

        $selectCompany = $this->user->getUserHasCompany();
        $selectStore = array($stallStore);
        if (intval($stallInfo->storeid)<1) {
           $selectStore = $this->user->getUserSelectStore($selectCompany);
        }


        $storeWhere = "(-1";
        foreach ($selectStore as $key => $value) {
          if (isset($value->STOREID)) {
            $storeWhere .= " , ".$value->STOREID;
          }
        }
        $storeWhere .= ") ";

        if (!isset($stallStore)) {
          if (count($selectStore) > 0) {
            $stallStore = $selectStore[0];
          }
        }

        $return = array();
        $return["storeid"] = $storeid;
        $return["storename"] = $stallStore->STORENAME;
        $return["querydate"] = $querydate;
        $return["queryenddate"] = $queryenddate;
        $return["stallInfo"] = $stallInfo;
        $return["stallCompany"] = $stallCompany;
        $return["stallStore"] = $stallStore;
        $return["selectCompany"] = $selectCompany;
        $return["selectStore"] = $selectStore;
        $return["storeWhere"] = $storeWhere;
        $return["userid"] = $userid;
        $return["username"] = $username;
        $return["sess_querydate"] = $this->session->userdata("sess_querydate");
        $return["sess_queryenddate"] = $this->session->userdata("sess_queryenddate");

        return $return;
    }

}?>