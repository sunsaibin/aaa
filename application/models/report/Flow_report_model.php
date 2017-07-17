<?PHP
/**
 * Created by Sublime.
 * User: sunsaibin
 * Date: 2017/04/22
 * Time: 15:35
 *
 */
class flow_report_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    // 人事异动详情统计
    public function flow_personnel_report_detail($storeWhere,$start_date,$end_date,$flow_id)
    {
    	
    	if($flow_id == 4){
    		$sql = 'SELECT sc.*,ss.IDCARD,ss.PHONE,ss.ARRIVEDATE,ss.PTYPEID,bc.RANKNAME RANKNAME_OLD from sm_staffinfo_change sc LEFT JOIN sm_staff ss on sc.staffid=ss.STAFFID LEFT JOIN bm_companyrank bc on sc.rankid_old=bc.RANKID  where storeid_old IN '.$storeWhere.' and change_date BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" and staffchangetype=?;';
    	}else{
    		$sql = 'SELECT sc.*,ss.IDCARD,ss.PHONE,ss.ARRIVEDATE,ss.PTYPEID,bc1.RANKNAME RANKNAME_OLD,bc2.RANKNAME RANKNAME_NEW from sm_staffinfo_change sc LEFT JOIN sm_staff ss on sc.staffid=ss.STAFFID LEFT JOIN bm_companyrank bc1 on sc.rankid_old=bc1.RANKID LEFT JOIN bm_companyrank bc2 on sc.rankid_new=bc2.RANKID  where storeid_new IN '.$storeWhere.' and change_date BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59" and staffchangetype=?;';
    	}
    	$query = $this->db->query($sql,array($flow_id));
    	//echo $this->db->last_query();
    	return $query->result();
    }

    // 公司、门店职位
    public function flow_storerank_report_detail($companyid)
    {
        //$sql = "SELECT RANKID,RANKNAME from bm_companyrank where COMPANYID=?;";
        $sql = "select a.RANKID,RANKNAME from bm_companyrank a left join sm_staff b on(b.COMPANYRANKID=a.rankid) where  b.COMPANYID=? and RANKNAME is not null group by COMPANYRANKID,RANKNAME;";
        $query = $this->db->query($sql,array($companyid));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 人事职位人数统计
    public function flow_staffrank_report_detail($storeid,$companyid)
    {
        //$sql = "SELECT s.store_name,s.STOREID,s.RANKID,count(s.RANKID) rankid_count from sm_staff s LEFT JOIN bm_companyrank c on s.RANKID = c.RANKID WHERE STOREID IN ".$storeWhere." GROUP BY s.RANKID;";
        /*if(is_array($storeWhere)){
            $sql = "SELECT o.STORENAME,s.STOREID,s.RANKID,count(s.RANKID) rankid_count from sm_staff s LEFT JOIN bm_store o on s.STOREID=o.STOREID WHERE s.COMPANYID=? AND s.STOREID = 1 GROUP BY RANKID";
             $query = $this->db->query($sql,array($companyid));
        }else{
            $sql = "SELECT o.STORENAME,s.STOREID,s.RANKID,count(s.RANKID) rankid_count from sm_staff s LEFT JOIN bm_store o on s.STOREID=o.STOREID WHERE s.STOREID = ? GROUP BY RANKID";
             $query = $this->db->query($sql,array($storeWhere));
        }*/
        if(!isset($companyid)){
            $sql = "SELECT o.STORENAME,s.STOREID,s.RANKID,count(s.RANKID) rankid_count from sm_staff s LEFT JOIN bm_store o on s.STOREID=o.STOREID LEFT JOIN bm_companyrank c on(s.RANKID=c.RANKID) WHERE s.STOREID = ? GROUP BY RANKID";
             $query = $this->db->query($sql,array($storeid));
        }else{
            $sql = "SELECT o.STORENAME,s.STOREID,s.RANKID,count(s.RANKID) rankid_count from sm_staff s LEFT JOIN bm_store o on s.STOREID=o.STOREID LEFT JOIN bm_companyrank c on(s.RANKID=c.RANKID) WHERE s.STOREID = ? and s.COMPANYID=? GROUP BY RANKID";
             $query = $this->db->query($sql,array($storeid,$companyid));
        }    
       
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>