<?php
date_default_timezone_set("Asia/Shanghai");
class Store_distribution_new_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function  query_order_type($storeid, $type, $cdate)
    {
        $sql = "SELECT *, c.ORDERNUMBER FROM fn_account a LEFT JOIN bm_card c on a.order_id = c.ORDERID where a.storeid=? and a.operator_type=? and create_date=?";
        $query = $this->db->query($sql, array($type));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_card_divide($storeWhere, $cdate,$seachkey,$seachkey2)
    {
        //$cdate = date('Y-m-d H:i:s',time());
        //$sql = "SELECT a.id as oid, a.*, b.*, f.STAFFNAME FROM fn_account a LEFT JOIN fn_bonus b on a.card_id = b.card_id LEFT JOIN sm_staff f on f.STAFFID = b.staff_id where operator_type = 1 and DATE_FORMAT(create_date, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d') AND b.store_id = ?";
        if(isset($seachkey) && !empty($seachkey)) {
            $sql = "SELECT a.id AS oid, a . *,( SELECT c.CARDNUM FROM  bm_card c where c.CARDID = a.card_id )as card_number,(select sum(performance_amount) from `fn_bonus` b where b.account_id=a.id and b.card_id = a.card_id) as total_commission_amount FROM fn_account a WHERE operator_type in(1,5) AND DATE_FORMAT( create_date, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d')  AND a.store_id IN ".$storeWhere." AND a.card_num = ?";
            $query = $this->db->query($sql, array($cdate, $seachkey));
        }
        else if(isset($seachkey2) && !empty($seachkey2)) {
            $sql = "SELECT a.id AS oid, a . *,( SELECT c.CARDNUM FROM  bm_card c where c.CARDID = a.card_id )as card_number,(select sum(performance_amount) from `fn_bonus` b where b.account_id=a.id and b.card_id = a.card_id) as total_commission_amount FROM fn_account a WHERE operator_type in(1,5) AND DATE_FORMAT( create_date, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d')  AND a.store_id IN ".$storeWhere." AND orderproduct_id in (SELECT orderproduct_id FROM bm_workorder where staff_id in (SELECT STAFFID FROM sm_staff where STAFFID = ? or STAFFNUMBER=?))";
            $query = $this->db->query($sql, array($cdate, $seachkey2, $seachkey2));
        }
        else{
            $sql = "SELECT a.id AS oid, a . *,( SELECT c.CARDNUM FROM  bm_card c where c.CARDID = a.card_id )as card_number,(select sum(performance_amount) from `fn_bonus` b where b.account_id=a.id and b.card_id = a.card_id) as total_commission_amount FROM fn_account a WHERE operator_type in(1,5) AND DATE_FORMAT( create_date, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d')  AND a.store_id IN ".$storeWhere."";
            $query = $this->db->query($sql, array($cdate));
        }
        //echo $this->db->last_query();
        return $query->result();
    }


    public function query_card_orderid_divide($storeid, $cdate, $orderid)
    {
        $sql = "SELECT a.id AS oid, a . * FROM fn_account a WHERE back <> 3 and operator_type =1 AND DATE_FORMAT( create_date, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d')  AND a.store_id =?";
        $query = $this->db->query($sql, array($cdate, $storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_card_divide_detail($storeid, $oid, $cardid)
    {
    	$sql = "SELECT	b.*, f.STAFFNAME FROM	fn_bonus b LEFT JOIN sm_staff f ON f.STAFFID = b.staff_id WHERE	account_id = ? AND b.store_id = ?";
        $query = $this->db->query($sql, array( $oid, $storeid));
        echo $this->db->last_query();
        return $query->result();
    }

    public function query_order_paytype($storeWhere, $cdate, $order_number, $card_number, $sequence_number){
        //$cdate = date('Y-m-d H:i:s',time());
        if(isset($seachkey) && !empty($seachkey)){
            //$sql = "SELECT o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name from bm_orderproducts o LEFT JOIN bm_workorder w on w.orderproduct_id = o.OPID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and STOREID=? and ORDERID in (SELECT ORDERID from bm_order where ORDERNUMBER=?) ";
            $sql ="SELECT	o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name FROM	bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID IN ".$storeWhere." AND od.ORDERNUMBER=?";
            $query = $this->db->query($sql, array($cdate,$seachkey));
        }
        else if(isset($seachkey2) && !empty($seachkey2)) {
            $sql ="SELECT	o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name FROM	bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID IN ".$storeWhere." AND OPID in (SELECT orderproduct_id FROM bm_workorder where staff_id in (SELECT STAFFID FROM sm_staff where STAFFID=? or STAFFNUMBER=?))";
            $query = $this->db->query($sql, array($cdate,$seachkey2,$seachkey2));
        }
        elseif(!empty($order_number)){
            $sql = "SELECT  o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute,o.PRODUCTNUMBER, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS,od.PAYNAME, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name, bc.CARDNUM, bs.STORENAME, od.MEMO FROM  bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  LEFT JOIN bm_card bc on od.CARDID=bc.CARDID LEFT JOIN BM_STORE bs on o.STOREID=bs.STOREID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID=? and od.ORDERNUMBER=? limit 1";
            $query = $this->db->query($sql, array($cdate,$storeid,$order_number));
        }
        elseif(!empty($card_number)){
            $sql = "SELECT  o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute,o.PRODUCTNUMBER, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS,od.PAYNAME, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name, bc.CARDNUM, bs.STORENAME, od.MEMO FROM  bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  LEFT JOIN bm_card bc on od.CARDID=bc.CARDID LEFT JOIN BM_STORE bs on o.STOREID=bs.STOREID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID IN ".$storeWhere." and bc.CARDNUM=? limit 1";
            $query = $this->db->query($sql, array($cdate,$card_number));
        }
        elseif(!empty($sequence_number)){
            $sql = "SELECT  o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute,o.PRODUCTNUMBER, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS,od.PAYNAME, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name, bc.CARDNUM, bs.STORENAME, od.MEMO FROM  bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  LEFT JOIN bm_card bc on od.CARDID=bc.CARDID LEFT JOIN BM_STORE bs on o.STOREID=bs.STOREID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID IN ".$storeWhere." and o.OPID=? limit 1";
            $query = $this->db->query($sql, array($cdate,$sequence_number));
        }
        else{
           // $sql = "SELECT o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name from bm_orderproducts o LEFT JOIN bm_workorder w on w.orderproduct_id = o.OPID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and STOREID=? ";
            //$sql ="SELECT	o.OPID,o.ORDERID,o.PRODUCTID, o.STOREID, o.product_attribute, o.PRODUCTNAME,o.pay_name,o.real_amount, o.server_time,o.is_delete,od.ORDERNUMBER, od.store_order_number,od.HANDNUMBER, od.PAYSTATUS, w.store_id,w.staff_min_id,w.staff_min_name,w.staff_id,w.staff_name, bc.CARDNUM FROM	bm_orderproducts o  LEFT JOIN bm_workorder w ON w.orderproduct_id = o.OPID LEFT JOIN bm_order od on od.ORDERID = o.ORDERID  LEFT JOIN bm_card bc on od.CARDID=bc.CARDID WHERE DATE_FORMAT(server_time,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID=? ";
            $sql = "SELECT o.ORDERID , o.ORDERNUMBER , IFNULL(c.CARDNUM,'散客') CARDNUM, o.store_order_number FROM bm_order o LEFT JOIN bm_card c on c.CARDID = o.CARDID LEFT JOIN bm_orderproducts bo on o.ORDERID=bo.ORDERID WHERE DATE_FORMAT(SERVERTIME,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID IN ".$storeWhere." and o.PAYSTATUS=1 group by o.ORDERID , o.ORDERNUMBER , c.CARDNUM, o.store_order_number order by o.store_order_number desc";
            $query = $this->db->query($sql, array($cdate));
        }
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function  query_order_divide_detail($storeid, $oid)
    {
        $sql = "SELECT * FROM bm_orderproducts o WHERE o.OPID = ? and STOREID=? ";
        $query = $this->db->query($sql, array($oid, $storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_store_staffs($storeWhere){
        $sql = "SELECT * FROM sm_staff where STOREID IN ".$storeWhere." and `ENABLE`=1 ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  query_order_workorder_detail($storeid, $oid)
    {
        $sql = "SELECT * from bm_workorder WHERE orderproduct_id=? and store_id=?";
        $query = $this->db->query($sql, array($oid, $storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  update_order_divide_detail($storeid, $oid, $paytype, $maxid, $minid)
    {
        //$sql = "UPDATE bm_orderproducts SET pay_name = (SELECT PAYNAME from bm_payment where PAYID=?), paytype = ? WHERE OPID = ?  and STOREID=? AND ? in (2,3,4,5,7)";
        if($paytype == 4 || $paytype == 5){
            $sql = "UPDATE bm_orderproducts SET pay_name = (SELECT PAYNAME from bm_payment where PAYID=? LIMIT 0,1), paytype = ? , STAFFID = ?, staff_max_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1), staff_min=?, staff_min_name = (SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1) WHERE OPID = ?  and STOREID=?";
            $query = $this->db->query($sql, array($paytype, $paytype,$maxid,$maxid,$minid,$minid, $oid, $storeid));
        }else{
            $sql = "UPDATE bm_orderproducts SET STAFFID = ?, staff_max_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1), staff_min=?, staff_min_name = (SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1) WHERE OPID = ?  and STOREID=?";
            $query = $this->db->query($sql, array($maxid,$maxid,$minid,$minid, $oid, $storeid));
        } 
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function update_orderwork_staff($storeid, $oid, $maxid, $minid, $specifyid, $specifyid_min)
    {
        if($maxid=='' && $minid == ''){
            $sql = "UPDATE bm_workorder SET is_specify=?, is_specify_min=?, staff_id=?, staff_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1), staff_min_id=?, staff_min_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1) WHERE orderproduct_id = ? and store_id=?;";
            $query = $this->db->query($sql, array($specifyid,$specifyid_min, $maxid, $maxid, $minid, $minid, $oid, $storeid));
        }
        else{
            $sql = "UPDATE bm_workorder SET is_specify=?, is_specify_min=?, staff_id=?, staff_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1), staff_min_id=?, staff_min_name=(SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? LIMIT 0,1) WHERE orderproduct_id = ? and store_id=? and EXISTS (SELECT STAFFNAME FROM sm_staff f where f.STAFFID=? or f.STAFFID=?);";
            $query = $this->db->query($sql, array($specifyid,$specifyid_min, $maxid, $maxid, $minid, $minid, $oid, $storeid, $maxid, $minid));
        }
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function update_order_explain($explain, $ordernumber)
    {
        $sql = "update bm_order set ORDERMEMO=? WHERE ORDERNUMBER=?";
        $query = $this->db->query($sql, array($explain, $ordernumber));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function  query_store_staff($storeid)
    {
        $sql = "SELECT STAFFNUMBER,STAFFID, STAFFNAME,STAFFNICKNAME,STOREID FROM sm_staff where STOREID=?";
        $query = $this->db->query($sql, array($storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  remove_store_card_staff($storeid, $accountid)
    {
        $sql = "DELETE FROM fn_bonus WHERE  account_id=".$accountid." and store_id = ".$storeid." and account_id>0";
        $query = $this->db->query($sql, array($storeid));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function query_order_paytype_fn_accounts($storeid, $cdate, $data_num, $order_number, $card_number, $sequence_number){
        if(!empty($order_number)){
            $sql = "SELECT fa.*,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bo.ORDERNUMBER,bo.PAYNAME, op.staff_max_name, op.staff_max_split, op.staff1_min_name, op.staff1_min_split, op.staff2_min_name, op.staff2_min_split from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID LEFT JOIN bm_orderproducts op on op.ORDERID=fa.order_id WHERE DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') AND store_id=? AND bo.ORDERNUMBER=? LIMIT 1";
            $query = $this->db->query($sql, array($cdate,$storeid,$order_number));
        }
        elseif(!empty($card_number)){
            $sql = "SELECT fa.*,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bo.ORDERNUMBER,bo.PAYNAME, op.staff_max_name, op.staff_max_split, op.staff1_min_name, op.staff1_min_split, op.staff2_min_name, op.staff2_min_split from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID LEFT JOIN bm_orderproducts op on op.ORDERID=fa.order_id WHERE DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') AND store_id=? AND bc.CARDNUM=? LIMIT 1";
            $query = $this->db->query($sql, array($cdate,$storeid,$card_number));
        }
        elseif(!empty($sequence_number)){
            $sql = "SELECT fa.*,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bo.ORDERNUMBER,bo.PAYNAME, op.staff_max_name, op.staff_max_split, op.staff1_min_name, op.staff1_min_split, op.staff2_min_name, op.staff2_min_split from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID LEFT JOIN bm_orderproducts op on op.ORDERID=fa.order_id WHERE DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') AND store_id=? AND op.OPID=? LIMIT 1";
            $query = $this->db->query($sql, array($cdate,$storeid,$sequence_number));
        }
        else{
            $sql = "SELECT fa.*,bo.ORDERNUMBER,bc.CARDNUM, op.OPID FROM fn_account fa LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_orderproducts op on op.ORDERID=fa.order_id WHERE DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') AND store_id=? AND operator_type=?";
            $query = $this->db->query($sql, array($cdate, $storeid, $data_num));
        }
        
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  query_fn_account($id)
    {
        $sql = "SELECT a.*,c.CARDNUM FROM fn_account a LEFT JOIN bm_card c on a.card_id = c.CARDID where a.id=?";
        $query = $this->db->query($sql, array($id));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function  query_fn_accounts($id)
    {
        $sql = "SELECT * FROM fn_account a LEFT JOIN bm_card c on a.card_id = c.CARDID where a.id=?";
        $query = $this->db->query($sql, array($id));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  update_account_paytype($sqlArray,$sqlWhereArra)
    {
        $this->db->update("fn_account",$sqlArray,$sqlWhereArra);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function  add_store_card_staff($sqlArray){
        $this->db->insert("fn_bonus",$sqlArray);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function query_store_close_bill($storeid, $oid)
    {
        $sql = "SELECT * FROM fn_store_day d LEFT JOIN bm_orderproducts p on DATE_FORMAT(p.server_time,'%Y-%m-%d') =  DATE_FORMAT(d.time,'%Y-%m-%d') where d.storeid=? and p.OPID = ?";
        $query = $this->db->query($sql, array($storeid, $oid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function  query_store_card_close_bill($storeid, $oid)
    {
        $sql = "SELECT * FROM fn_store_day d LEFT JOIN fn_account a on DATE_FORMAT(a.create_date,'%Y-%m-%d') =  DATE_FORMAT(d.time,'%Y-%m-%d') where d.storeid=? and a.id = ?";
        $query = $this->db->query($sql, array($storeid, $oid));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 修改 作废单据
    /*public function update_account_paystaftus($opid)
    {
        $sql = "UPDATE fn_account set pay_status = 0,operator_function=CONCAT(operator_function,'-作废单据') where order_id = (SELECT ORDERID FROM bm_orderproducts where OPID = ? LIMIT 0,1) and paytype_id in (4,5) and pay_status=1";
        $query = $this->db->query($sql, array($opid));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }*/

    public function query_account_by_opid($opid)
    {
        $sql = "SELECT * from fn_account where order_id = (SELECT ORDERID FROM bm_orderproducts where OPID = ? LIMIT 0,1)";
        $query = $this->db->query($sql, array($opid));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 删除原单据
    public function update_account_paystaftus($opid)
    {
        // DELETE from fn_account where order_id = (SELECT ORDERID FROM bm_orderproducts where OPID = ? LIMIT 0,1);
        $sql = "DELETE from fn_account where order_id = (SELECT ORDERID FROM bm_orderproducts where OPID = ? LIMIT 0,1);";
        $query = $this->db->query($sql, array($opid));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    // 作废单据后,生成新的单据
    public function add_account_paytype($opid, $cardid)
    {
        $sql = "INSERT INTO `fn_account` ( `name`, `version`, `create_date`, `memo`, `company_id`, `store_id`, `operator_type`, `operator_function`, `paytype_id`, `paytype_name`, `card_id`, `amount`, `is_cash`, `inorout`, `card_before`, `card_after`, `card_subid`, `come_company_id`, `come_store_id`, `order_id`, `orderproduct_id`, `recharge_id`, `out_card_id`, `out_card_num`, `refund_id`, `pay_status`, `card_num`, `card_subnum`, `back`, `relation_account_id`, `return_card_method`, `return_card_type`, `bundle_id` ) SELECT pay_name, '2' AS version, now() AS create_date, '' AS memo, COMPANYID, STOREID, 2 AS operator_type, '业务单据修改' AS operator_function, paytype, pay_name, ?, SUM(real_amount) AS amount, 1 AS is_cash, 1 AS inorout, 0, 0, 0, 0 AS come_company_id, STOREID, ORDERID, 0, 0 AS recharge_id, NULL, NULL, NULL, 1 AS pay_status, 0, 0, 0 AS back, 0, 0, 0, IFNULL(( SELECT bundle_id FROM fn_account WHERE order_id = ( SELECT ORDERID FROM bm_orderproducts WHERE OPID = ? LIMIT 0, 1 ) AND pay_status = 0 LIMIT 0, 1 ), NULL ) AS bundle_id FROM bm_orderproducts WHERE ORDERID in (SELECT ORDERID FROM bm_orderproducts WHERE OPID=?) AND NOT EXISTS ( SELECT id FROM fn_account WHERE order_id = ( SELECT ORDERID FROM bm_orderproducts WHERE OPID = ? LIMIT 0, 1 ) AND pay_status = 1 ) GROUP BY paytype, ORDERID, pay_name, COMPANYID, STOREID;";
        $this->db->query($sql,array($cardid,$opid,$opid,$opid));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }
}
?>