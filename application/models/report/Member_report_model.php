<?php
/**
 * Created by Sublime.
 * User: sunsaibin
 * Date: 2017/06/28
 * Time: 14:32
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Member_report_model extends CI_Model {

	public function getCardType($companyid,$storeid) {
		$sql = "SELECT CARDTYPEID,CARDTYPENAME from bm_cardtype where (COMPANYID=? OR (COMPANYID=? AND STOREID=?)) and CARDORTICKET=1;";
		$query = $this->db->query($sql,array($companyid,$companyid,$storeid));
		//echo $this->db->last_query();
		return $query->result();
	}

	/*public function getMemberAlienationDetail($storeWhere, $start_date, $end_date, $cardTypeId, $cardnum) {
		if($cardnum == ''){
			// 非卡号查询
			$sql = "SELECT m.storeid,m.companyid as col1, c.COMPANYNAME as col2,m.cardnum as col3,m.cardid,m.cardtypeid,m.cardtypename as col4,m.membername as col5,m.phone as col6,CASE WHEN m.sex=0 THEN '女' WHEN m.sex=1 THEN '男' ELSE '' END as col7,round(m.totalconnamt,2) as col8,round(m.totalrechange,2) as col9,round(m.cardbalance,2) as col10,m.days as col11,m.opendate,m.lastdate from rm_member_day m LEFT JOIN bm_company c on m.companyid=c.COMPANYID where storeid in ".$storeWhere." and cardtypeid=?";
			$query = $this->db->query($sql, array($cardTypeId));
		}else{
			// 卡号查询
			$sql = "SELECT m.storeid,m.companyid as col1, c.COMPANYNAME as col2,m.cardnum as col3,m.cardid,m.cardtypeid,m.cardtypename as col4,m.membername as col5,m.phone as col6,CASE WHEN m.sex=0 THEN '女' WHEN m.sex=1 THEN '男' ELSE '' END as col7,round(m.totalconnamt,2) as col8,round(m.totalrechange,2) as col9,round(m.cardbalance,2) as col10,m.days as col11,m.opendate,m.lastdate from rm_member_day m LEFT JOIN bm_company c on m.companyid=c.COMPANYID where storeid in ".$storeWhere." and cardtypeid=? and cardnum=?";
			$query = $this->db->query($sql, array($cardTypeId, $cardnum));
		}
		
		return $query->result();
	}*/

	public function call_sp_get_card_reprot($seach_storeid,$card_typeid,$cardnum,$fromdays,$todays) {
		$sql = "CALL sp_get_card_reprot('".$seach_storeid."','".$card_typeid."','".$cardnum."','".$fromdays."','".$todays."')";
		$query = $this->db->query($sql);
		return $query->result();
	}

}