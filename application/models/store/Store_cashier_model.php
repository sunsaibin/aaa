<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/2/3
 * Time: 12:05
 */

class Store_cashier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function query_date_store($storeid, $query_date)
    {
        $cdate = $query_date;
        if(!isset($query_date) || empty($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());

        }

        $sql = "call sp_report_day(?,?)";
        $query = $this->db->query($sql, array($cdate, $storeid));
        return $query->row();
    }

    // 开单收银
    public function query_funindex_order_list($storeid,$cdate,$fun_index)
    {
        //$sql ="SELECT o.ORDERID as col1,? as col2,  o.ORDERNUMBER col11, IFNULL(c.CARDNUM,'散客') as col12, o.store_order_number col13 FROM bm_order o LEFT JOIN bm_card c on c.CARDID = o.CARDID LEFT JOIN bm_orderproducts bo on o.ORDERID=bo.ORDERID WHERE DATE_FORMAT(SERVERTIME,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID=? and o.PAYSTATUS=1 and bo.is_delete=0 group by o.store_order_number order by o.store_order_number";
        $sql ="SELECT o.ORDERID as col1,? as col2, sum(bw.back) AS col3, o.ORDERNUMBER col11, IFNULL(c.CARDNUM,'散客') as col12, o.store_order_number col13 FROM bm_order o LEFT JOIN bm_card c on c.CARDID = o.CARDID LEFT JOIN bm_orderproducts bo on o.ORDERID=bo.ORDERID LEFT JOIN bm_workorder bw on o.ORDERID=bw.order_id WHERE DATE_FORMAT(SERVERTIME,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and o.STOREID=? and o.PAYSTATUS=1 and bo.is_delete=0 group by o.ORDERID , o.ORDERNUMBER , c.CARDNUM, o.store_order_number,bw.order_id order by o.store_order_number";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_order_list_item($list_index)
    {
        $sql = "SELECT bs.STORENAME,bo.ORDERNUMBER,bo.ORDERSTATUS,bc.CARDNUM,bo.PAYNAME,bo.store_order_number,bo.HANDNUMBER,bo.user_nickname,bo.ORDERMEMO,bo.order_source_name FROM bm_order bo LEFT JOIN bm_store bs on bo.STOREID=bs.STOREID LEFT JOIN bm_card bc on bo.CARDID=bc.CARDID WHERE ORDERID=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_orderproduct_list_item($list_index)
    {
        $sql = "SELECT op.OPID,op.PRODUCTNO,op.PRODUCTNAME,op.PRODUCTNUMBER,op.coupon_num,op.real_amount, op.pay_name,op.paytype,bw.staff_name,bw.staff_id,bw.staff_min_name,bw.staff_min_id,bw.is_specify,bw.is_specify_min, bw.back, bo.PAYNAME pay_state,bo.ORDERMEMO pay_memo FROM bm_orderproducts op LEFT JOIN bm_order bo on op.ORDERID=bo.ORDERID LEFT JOIN bm_workorder bw on op.OPID=bw.orderproduct_id WHERE op.ORDERID=? and op.is_delete=0";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_workorder_list_item($list_index)
    {
        $sql = "SELECT op.pay_name payname,op.PRODUCTNAME,op.real_amount amount,op.SUBVALUE,bo.ORDERMEMO memo, op.staff_max_name max_name,op.staff1_min_name min_name from bm_orderproducts op LEFT JOIN bm_order bo on op.ORDERID=bo.ORDERID WHERE op.ORDERID=? and op.is_delete=0";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 会员办卡
    public function query_funindex_order_list_card($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.back as col3, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=1 and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_card_list_item($list_index)
    {
        $sql = "SELECT fa.id accountid,fa.card_num,fa.amount,fa.memo,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bc.liability,su.USERNAME from fn_account fa LEFT JOIN bm_store bs on 
        fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_workinfo_item($list_index)
    {
        $sql = "SELECT fa.paytype_name,fa.amount,fa.pay_status card_pay_status,bo.PAYNAME,op.staff_max_name,op.staff1_min_name,op.staff2_min_name,op.staff3_min_name,op.staff_max_split,op.staff1_min_split,op.staff2_min_split,op.staff3_min_split from fn_account fa LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID LEFT JOIN bm_orderproducts op on fa.order_id=op.ORDERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_function_bouns_item($storeid,$list_index)
    {
        $sql = "SELECT case a.operator_type when 7 THEN round(ABS(b.performance_amount),2) else round(b.performance_amount,2) end as performance_amount,b.staff_id, f.STAFFNAME,f.STAFFNUMBER,a.operator_type FROM   fn_bonus b LEFT JOIN sm_staff f ON f.STAFFID = b.staff_id LEFT JOIN fn_account a on b.account_id=a.id WHERE account_id = ? AND b.store_id = ?";
        $query = $this->db->query($sql, array($list_index, $storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    //会员充值
    public function query_funindex_order_list_rechargecard($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=5 and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_rechargecard_list_item($list_index)
    {
       $sql = "SELECT fa.id accountid,fa.card_num,fa.pay_status card_pay_status,fa.amount,fa.memo,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bc.liability,su.USERNAME from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result(); 
    }

    // 购买疗程
    public function query_funindex_order_list_course($storeid,$cdate,$fun_index)
    {
       $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=3 and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result(); 
    }

    public function query_funindex_course_list_item($list_index)
    {
        $sql = "SELECT fa.id accountid,fa.card_num,fa.amount,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bc.liability,bc.CARDBALANCE,su.USERNAME from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_courseproduct_list_item($list_index)
    {
        $sql = "SELECT fa.order_id,fa.paytype_name,cs.product_name,cs.remain_number, cs.once_price,cs.product_price,cs.total_number,cs.total_number*cs.once_price paymoney,cs.remain_number*cs.once_price surplus_money from fn_account fa LEFT JOIN bm_card_sub cs on fa.card_num=cs.card_num WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 会员转卡
    public function query_funindex_order_list_changecard($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=4 and name like '%会员卡转卡%' and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_changecard_list_item($list_index)
    {
        $sql = "SELECT fa.id accountid,fa.card_num,fa.out_card_num,fa.amount,fa.memo,bs.STORENAME,bc.CARDNUM,bc.CARDNAME as newcard,bc2.CARDNAME as oldcard,bc2.CARDBALANCE,bc.liability,bc.CARDBALANCE,su.USERNAME from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_card bc2 on fa.out_card_id=bc2.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 会员并卡
    public function query_funindex_order_list_mergecard($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=4 and name like '%并卡%' and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_mergecard_list_item($list_index)
    {
        $sql = "SELECT fa.id accountid,fa.card_num,fa.out_card_num,fa.amount,fa.memo,bs.STORENAME,bc.CARDNUM,bc.CARDNAME,bc.liability,bc.CARDBALANCE,su.USERNAME from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_card bc2 on fa.out_card_id=bc2.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 会员补卡
    public function query_funindex_order_list_repaircard($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=4 and operator_function like '%会员补卡%' and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_repaircard_list_item($list_index)
    {
        $sql = "SELECT fa.card_num,fa.out_card_num,fa.amount,bs.STORENAME,bc.CARDNUM,bc.CREATEDATE,bc.CARDNAME,bc.liability,bc.CARDBALANCE,su.USERNAME,su.MOBILE from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID  WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 会员退卡
    public function query_funindex_order_list_retreatcard($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=7 and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_retreatcard_list_item($list_index)
    {
        $sql = "SELECT fa.id accountid,fa.card_num,fa.out_card_num,fa.amount,bs.STORENAME,bc.CARDNUM,bc.CREATEDATE,bc.CARDNAME,round(bc.liability,2) liability,round(bc.CARDBALANCE,2) CARDBALANCE,su.USERNAME,su.MOBILE,fb.commission_amount,fb.memo from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN sm_user su on bc.USERID=su.USERID LEFT JOIN fn_bonus fb on fa.card_num=fb.card_number WHERE fa.id=? ";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_bouns_retreatcard($list_index)
    {
        $sql = "SELECT card_num,abs(amount) returncard_amount,memo returncard_memo,return_card_method,return_card_type FROM fn_account where operator_type=7 and id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 开单返销
    public function query_funindex_order_list_buyback($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1, ? as col2, bo.ORDERNUMBER as col11, a.card_num as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_order bo on a.order_id=bo.ORDERID LEFT JOIN bm_card c on a.card_id=c.CARDID where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and a.store_id=? and operator_type=2 and name like '%返销%'";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_buyback_list_item($list_index)
    {
        $sql = "SELECT fa.card_num,bs.STORENAME,fa.create_date,fa.operator_function, bc.CARDBALANCE,bc.card_point,bo.ORDERNUMBER from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID LEFT JOIN bm_card bc on fa.card_id=bc.CARDID LEFT JOIN bm_order bo on fa.order_id=bo.ORDERID WHERE fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_buybackproduct_list_item($list_index)
    {
        $sql = "SELECT fa.amount,op.PRODUCTNAME,op.PRODUCTNUMBER,op.SUBVALUE,op.pay_name,op.staff_max_name from fn_account fa LEFT JOIN bm_orderproducts op on fa.order_id=op.ORDERID where fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 办卡返充
    public function query_funindex_order_list_rechargeback($storeid,$cdate,$fun_index)
    {
        $sql = "SELECT a.id as col1,? as col2, a.card_num as col11, u.username as col12, a.id as col13 FROM fn_account a LEFT JOIN bm_card c on a.card_id=c.CARDID LEFT JOIN sm_user u on c.USERID=u.USERID  where DATE_FORMAT(create_date,'%y-%M-%d') = DATE_FORMAT(?,'%y-%M-%d') and 
        a.store_id=? and operator_type=3 and name like '%返充%' and card_num is not null";
        $query = $this->db->query($sql, array($fun_index, $cdate,$storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_funindex_rechargeback_list_item($list_index)
    {
        $sql = "SELECT fa.card_num,bs.STORENAME,fa.operator_function,fa.amount,fa.paytype_name,fa.create_date from fn_account fa LEFT JOIN bm_store bs on fa.store_id=bs.STOREID where fa.id=?";
        $query = $this->db->query($sql, array($list_index));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_staff_list($storeid)
    {
        $sql = "SELECT s.STAFFNAME,s.STAFFID,s.STAFFNUMBER FROM `sm_staff` s LEFT JOIN `bm_companyrank` c on s.`RANKID`=c.`RANKID` WHERE s.`STOREID` = ?";
        $query = $this->db->query($sql, $storeid);
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_staff_num($staffid)
    {
        $sql = "SELECT STAFFID,STAFFNUMBER from sm_staff where STAFFID = ?;";
        $query = $this->db->query($sql, array($staffid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_payname_list()
    {   // select paytype_id,paytype_name from fn_account where paytype_id in (2,3,4,5,8) GROUP BY paytype_id
        //$sql = "select paytype_id,paytype_name from fn_account where paytype_id in (4,5) GROUP BY paytype_id,paytype_name;";
        $sql = "select PAYID paytype_id,PAYNAME paytype_name from bm_payment where payid in (4,5);";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }

    // 修改支付方式和服务员工(开单收银)
    public function  update_orderproducts($paytype,$staff_max_name,$staff_min_name)
    {
        $sql = "UPDATE bm_orderproducts set paytype=?, staff_max_name=?, staff1_min_name=?,pay_name=(SELECT pay_name from bm_orderproducts WHERE paytype=? and pay_name is not null GROUP BY pay_name);";

        $query = $this->db->query($sql, array($paytype,$staff_max_name,$staff_min_name));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }
}?>