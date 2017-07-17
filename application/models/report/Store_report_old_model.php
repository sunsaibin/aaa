<?php
class Store_report_old_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    //totalprice, proCount
    public function get_store_day_total_money($storeid, $querDate)
    {
        $sql = "SELECT SUM(real_amount) as totalprice, COUNT(*) as proCount, DATE_FORMAT(?,'%Y-%m-%d') as currDate FROM bm_orderproducts WHERE  DATE_FORMAT(OPTIME,'%Y-%m-%d')=DATE_FORMAT(?,'%Y-%m-%d') AND ORDERID in (SELECT ORDERID FROM bm_order where STOREID=?) ";

        $query = $this->db->query($sql, array($querDate,$querDate, $storeid));
        //echo $this->db->last_query();
        return $query->row();
    }

    //订单数
    public function get_store_day_total_orderCount($storeid, $querDate)
    {
        $sql = "SELECT COUNT(*) as orderCount FROM bm_order WHERE STOREID=? AND DATE_FORMAT(CREATEDATE,'%Y-%m-%d')=DATE_FORMAT(?,'%Y-%m-%d') ";

        $query = $this->db->query($sql, array($storeid,$querDate));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function query_date_bill_store_log($storeid, $querDate)
    {
        $sql = "SELECT *,(SELECT username FROM sys_user WHERE id = operator LIMIT 0,1) as username FROM fn_store_day where storeid=? AND  DATE_FORMAT(time, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')";

        $query = $this->db->query($sql, array($storeid,$querDate));
        // echo $this->db->last_query();
        return $query->result();
    }

    public function get_store_card_order()
    {
        $sql = "";
    }

    //服务项目明细
    public function get_store_day_taill($storeid, $querDate)
    {
        $sql = "SELECT s.STAFFID,(SELECT STAFFNAME from sm_staff where STAFFID = s.STAFFID) as STAFFNAME,o.STOREID, (SELECT STORENAME FROM bm_store WHERE STOREID=?)  as STORENAME,o.COMPANYID, (SELECT COMPANYNAME FROM bm_company WHERE COMPANYID in (SELECT COMPANYID FROM bm_store WHERE STOREID=?)) as COMPANYNAME,SUM(s.real_amount) as price,COUNT(*) as cout,staff1_min, staff1_min_name, staff_max_name,PRODUCTNAME,(SELECT PAYNAME FROM bm_order  WHERE ORDERID =o.ORDERID)as PAYNAME FROM bm_orderproducts s LEFT JOIN bm_order o on s.ORDERID=o.ORDERID WHERE  DATE_FORMAT(OPTIME,'%Y-%m-%d')=DATE_FORMAT(?,'%Y-%m-%d') AND o.STOREID = ? GROUP BY s.STAFFID,s.STOREID,s.COMPANYID, staff1_min, staff1_min_name, staff_max_name,PRODUCTNAME";

        $query = $this->db->query($sql, array($storeid,$storeid,$querDate,$storeid));
        echo $this->db->last_query();
        return $query->result();
    }


    public function store_day_query($storeid, $query_date = null)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());
        }

        $sql = "SELECT * FROM fn_store_day WHERE storeid=? and DATE_FORMAT(time,'%Y-%m-%d')=DATE_FORMAT(?,'%Y-%m-%d')";
        $query = $this->db->query($sql, array($storeid,  $cdate));
        return $query->row();
    }

    public function store_day_period_query($storeid, $query_date, $query_enddate)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());
        }

        $sql = "SELECT * FROM rm_store_day WHERE storeid = ".$storeid." and DATE_FORMAT(time,'%Y-%m-%d')>=DATE_FORMAT(?,'%Y-%m-%d') and DATE_FORMAT(time,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') order by time";
        $query = $this->db->query($sql, array($query_date,  $query_enddate));
        //echo $this->db->last_query();
        return $query->result();
    }

    //nodel @czx
    public function store_day_period_query_sum($storeWhere, $query_date, $query_enddate,$addkind)
    {
        if($addkind==1)
        {
            $sql = "
		SELECT
storeid as storeid,storename as storename,memo as memo,storeaddress as storeaddress,storemanager as storemanager,companyname as companyname, companyid as companyid, area_name as area_name, account_status as account_status, print_time as print_time, time as time,sum(cash_server_money) as cash_server_money,sum(cash_server_money_count) as cash_server_money_count,sum(cash_product_money) as cash_product_money,sum(cash_product_money_count) as cash_product_money_count,sum(cash_changes_money) as cash_changes_money,sum(cash_changes_money_count) as cash_changes_money_count,sum(cash_cancel_money) as cash_cancel_money,sum(cash_cancel_money_count) as cash_cancel_money_count,sum(cash_total_money) as cash_total_money,sum(unionpay_server_money) as unionpay_server_money,sum(unionpay_product__money) as unionpay_product__money,sum(unionpay_changes_money) as unionpay_changes_money,sum(unionpay_cancel_money) as unionpay_cancel_money,sum(unionpay_total_money) as unionpay_total_money,sum(alipay_server_money) as alipay_server_money,sum(alipay_produc_money) as alipay_produc_money,sum(alipay_changes_money) as alipay_changes_money,sum(alipay_cancel_money) as alipay_cancel_money,sum(alipay_total_money) as alipay_total_money,sum(weixin_server_money) as weixin_server_money,sum(weixin_product_money) as weixin_product_money,sum(weixin_changes_money) as weixin_changes_money,sum(weixin_cancel_money) as weixin_cancel_money,sum(weixin_total_money) as weixin_total_money,sum(card_cancel_money) as card_cancel_money,sum(card_server_money) as card_server_money,sum(card_product_money) as card_product_money,sum(card_total_money) as card_total_money,sum(card_course_server_money) as card_course_server_money,sum(third_dianping_server_money) as third_dianping_server_money,sum(third_total_money) as third_total_money,sum(card_count) as card_count,sum(transfer_changes_money) as transfer_changes_money,sum(transfer_cancel_money) as transfer_cancel_money,sum(transfer_total_money) as transfer_total_money,
sum(order_count) as order_count,sum(coupon_server_money) as coupon_server_money,sum(coupon_product_money) as coupon_product_money,sum(coupon_total_money) as coupon_total_money,sum(count_coupon) as count_coupon,sum(cosmetic_cash) as cosmetic_cash,sum(hairdress_cash) as hairdress_cash,sum(cosmetic_server) as cosmetic_server,sum(hairdress_server) as hairdress_server,sum(cosmetic_card) as cosmetic_card,sum(hairdress_card) as hairdress_card,sum(total_cash) as total_cash,sum(total_server) as total_server,sum(total_card) as total_card,sum(total_product) as total_product,sum(total_sale_card) as total_sale_card,sum(manager_bill) as manager_bill,sum(expend_record) as expend_record,operator as operator, createdate as createdate
from rm_store_day  WHERE storeid in ".$storeWhere." and DATE_FORMAT(time,'%Y-%m-%d')>=DATE_FORMAT(?,'%Y-%m-%d') and DATE_FORMAT(time,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') group by storeid"; //,
        }
        else if($addkind==2){
            $sql = "
		SELECT
'0' as storeid,'所选店' as storename,memo as memo,storeaddress as storeaddress,storemanager as storemanager,companyname as companyname, companyid as companyid, area_name as area_name, account_status as account_status, print_time as print_time, time as time,sum(cash_server_money) as cash_server_money,sum(cash_server_money_count) as cash_server_money_count,sum(cash_product_money) as cash_product_money,sum(cash_product_money_count) as cash_product_money_count,sum(cash_changes_money) as cash_changes_money,sum(cash_changes_money_count) as cash_changes_money_count,sum(cash_cancel_money) as cash_cancel_money,sum(cash_cancel_money_count) as cash_cancel_money_count,sum(cash_total_money) as cash_total_money,sum(unionpay_server_money) as unionpay_server_money,sum(unionpay_product__money) as unionpay_product__money,sum(unionpay_changes_money) as unionpay_changes_money,sum(unionpay_cancel_money) as unionpay_cancel_money,sum(unionpay_total_money) as unionpay_total_money,sum(alipay_server_money) as alipay_server_money,sum(alipay_produc_money) as alipay_produc_money,sum(alipay_changes_money) as alipay_changes_money,sum(alipay_cancel_money) as alipay_cancel_money,sum(alipay_total_money) as alipay_total_money,sum(weixin_server_money) as weixin_server_money,sum(weixin_product_money) as weixin_product_money,sum(weixin_changes_money) as weixin_changes_money,sum(weixin_cancel_money) as weixin_cancel_money,sum(weixin_total_money) as weixin_total_money,sum(card_cancel_money) as card_cancel_money,sum(card_server_money) as card_server_money,sum(card_product_money) as card_product_money,sum(card_total_money) as card_total_money,sum(card_course_server_money) as card_course_server_money,sum(third_dianping_server_money) as third_dianping_server_money,sum(third_total_money) as third_total_money,sum(card_count) as card_count,sum(transfer_changes_money) as transfer_changes_money,sum(transfer_cancel_money) as transfer_cancel_money,sum(transfer_total_money) as transfer_total_money,
sum(order_count) as order_count,sum(coupon_server_money) as coupon_server_money,sum(coupon_product_money) as coupon_product_money,sum(coupon_total_money) as coupon_total_money,sum(count_coupon) as count_coupon,sum(cosmetic_cash) as cosmetic_cash,sum(hairdress_cash) as hairdress_cash,sum(cosmetic_server) as cosmetic_server,sum(hairdress_server) as hairdress_server,sum(cosmetic_card) as cosmetic_card,sum(hairdress_card) as hairdress_card,sum(total_cash) as total_cash,sum(total_server) as total_server,sum(total_card) as total_card,sum(total_product) as total_product,sum(total_sale_card) as total_sale_card,sum(manager_bill) as manager_bill,sum(expend_record) as expend_record,operator as operator, createdate as createdate
from rm_store_day  WHERE storeid in ".$storeWhere." and DATE_FORMAT(time,'%Y-%m-%d')>=DATE_FORMAT(?,'%Y-%m-%d') and DATE_FORMAT(time,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') group by DATE_FORMAT(time,'%Y-%m-%d')"; //storeid,
        }
        else if($addkind==3)
            $sql = "
		SELECT
'0' as storeid,'所选店' as storename,memo as memo,storeaddress as storeaddress,storemanager as storemanager,companyname as companyname, companyid as companyid, area_name as area_name, account_status as account_status, print_time as print_time, time as time,sum(cash_server_money) as cash_server_money,sum(cash_server_money_count) as cash_server_money_count,sum(cash_product_money) as cash_product_money,sum(cash_product_money_count) as cash_product_money_count,sum(cash_changes_money) as cash_changes_money,sum(cash_changes_money_count) as cash_changes_money_count,sum(cash_cancel_money) as cash_cancel_money,sum(cash_cancel_money_count) as cash_cancel_money_count,sum(cash_total_money) as cash_total_money,sum(unionpay_server_money) as unionpay_server_money,sum(unionpay_product__money) as unionpay_product__money,sum(unionpay_changes_money) as unionpay_changes_money,sum(unionpay_cancel_money) as unionpay_cancel_money,sum(unionpay_total_money) as unionpay_total_money,sum(alipay_server_money) as alipay_server_money,sum(alipay_produc_money) as alipay_produc_money,sum(alipay_changes_money) as alipay_changes_money,sum(alipay_cancel_money) as alipay_cancel_money,sum(alipay_total_money) as alipay_total_money,sum(weixin_server_money) as weixin_server_money,sum(weixin_product_money) as weixin_product_money,sum(weixin_changes_money) as weixin_changes_money,sum(weixin_cancel_money) as weixin_cancel_money,sum(weixin_total_money) as weixin_total_money,sum(card_cancel_money) as card_cancel_money,sum(card_server_money) as card_server_money,sum(card_product_money) as card_product_money,sum(card_total_money) as card_total_money,sum(card_course_server_money) as card_course_server_money,sum(third_dianping_server_money) as third_dianping_server_money,sum(third_total_money) as third_total_money,sum(card_count) as card_count,sum(transfer_changes_money) as transfer_changes_money,sum(transfer_cancel_money) as transfer_cancel_money,sum(transfer_total_money) as transfer_total_money,
sum(order_count) as order_count,sum(coupon_server_money) as coupon_server_money,sum(coupon_product_money) as coupon_product_money,sum(coupon_total_money) as coupon_total_money,sum(count_coupon) as count_coupon,sum(cosmetic_cash) as cosmetic_cash,sum(hairdress_cash) as hairdress_cash,sum(cosmetic_server) as cosmetic_server,sum(hairdress_server) as hairdress_server,sum(cosmetic_card) as cosmetic_card,sum(hairdress_card) as hairdress_card,sum(total_cash) as total_cash,sum(total_server) as total_server,sum(total_card) as total_card,sum(total_product) as total_product,sum(total_sale_card) as total_sale_card,sum(manager_bill) as manager_bill,sum(expend_record) as expend_record,operator as operator, createdate as createdate
from rm_store_day  WHERE storeid in ".$storeWhere." and DATE_FORMAT(time,'%Y-%m-%d')>=DATE_FORMAT(?,'%Y-%m-%d') and DATE_FORMAT(time,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') group by storeid,DATE_FORMAT(time,'%Y-%m-00')"; //,
        else
            $sql = "SELECT * FROM rm_store_day WHERE storeid in ".$storeWhere." and DATE_FORMAT(time,'%Y-%m-%d')>=DATE_FORMAT(?,'%Y-%m-%d') and DATE_FORMAT(time,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d')";

        $query = $this->db->query($sql, array($query_date,  $query_enddate));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function store_month_period_query($storeWhere, $query_date, $query_enddate)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());
        }

        $sql = "SELECT `storeid`, `storename`, `year`, `month`, sum(`cash_server_money`) as `cash_server_money`, sum(`cash_server_money_count`) as `cash_server_money_count`, sum(`cash_product_money`) as `cash_product_money`, sum(`cash_product_money_count`) as `cash_product_money_count`, sum(`cash_changes_money`) as `cash_changes_money`, sum(`cash_changes_money_count`) as `cash_changes_money_count`, sum(`cash_cancel_money`) as `cash_cancel_money`, sum(`cash_cancel_money_count`) as `cash_cancel_money_count`, sum(`cash_total_money`) as `cash_total_money`, sum(`unionpay_server_money`) as `unionpay_server_money`, sum(`unionpay_product__money`)  as `unionpay_product__money`, sum(`unionpay_changes_money`) as `unionpay_changes_money`, sum(`unionpay_cancel_money`) as `unionpay_cancel_money`, sum(`unionpay_total_money`) as `unionpay_total_money`, sum(`alipay_server_money`) as `alipay_server_money`, sum(`alipay_produc_money`) as `alipay_produc_money`, sum(`alipay_changes_money`) as `alipay_changes_money`, sum(`alipay_cancel_money`) as `alipay_cancel_money`, sum(`alipay_total_money`) as `alipay_total_money`, sum(`weixin_server_money`) as `weixin_server_money`, sum(`weixin_product_money`) as `weixin_product_money`,sum(`weixin_changes_money`) as `weixin_changes_money`, sum(`weixin_cancel_money`) as `weixin_cancel_money`, sum(`weixin_total_money`) as `weixin_total_money`, sum(`card_cancel_money`) as `card_cancel_money`, sum(`card_server_money`) as `card_server_money`, sum(`card_product_money`) as `card_product_money`, sum(`card_total_money`) as `card_total_money`, sum(`card_count`) as `card_count`, sum(`transfer_changes_money`) as `transfer_changes_money`, sum(`transfer_cancel_money`) as `transfer_cancel_money`, sum(`transfer_total_money`) as `transfer_total_money`, sum(`order_count`) as `order_count`, sum(`coupon_server_money`) as `coupon_server_money`, sum(`coupon_product_money`) as `coupon_product_money`, sum(`coupon_total_money`) as `coupon_total_money`, sum(`count_coupon`) as `count_coupon`, sum(`total_cash`) as `total_cash`, sum(`total_server`) as `total_server`, sum(`total_card`) as `total_card`, sum(`total_product`) as `total_product` FROM `rm_store_day` WHERE 1 and storeid in ".$storeWhere." and DATE_FORMAT(time,'%Y-%m')>=DATE_FORMAT(?,'%Y-%m') and DATE_FORMAT(time,'%Y-%m')<=DATE_FORMAT(?,'%Y-%m') GROUP BY `storeid`, `storename`, `year`, `month`";
        $query = $this->db->query($sql, array($query_date,  $query_enddate));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function bill_date_store($storeid, $query_date = null, $operator)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());
        }

        $sql = "call sp_storebill_report_day(?,?,?)";
        $query = $this->db->query($sql, array($cdate, $storeid,$operator));
        // echo $this->db->last_query();
        // print_r($query->result());
        // exit;
        return $query->result();
    }

    public function check_bill($storeid,$querDate)
    {
        $sql = "SELECT a.amount,a.card_id,a.card_num, (SELECT IFNULL(SUM(performance_amount),0) FROM fn_bonus WHERE deduct_type=1 and card_id=a.card_id AND account_id = a.id) as already_performance FROM fn_account a where store_id=? AND operator_type in (1,5)  and DATE_FORMAT(create_date, '%Y-%m-%d') = DATE_FORMAT(? , '%Y-%m-%d') AND a.back = 0";
        // $sql = "SELECT COUNT(*) as orderCount FROM bm_order WHERE STOREID=? AND DATE_FORMAT(CREATEDATE,'%Y-%m-%d')=DATE_FORMAT(?,'%Y-%m-%d') ";

        $query = $this->db->query($sql, array($storeid,$querDate));
        //echo $this->db->last_query();
        return $query->result();
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

    public function query_curr_date_store($storeid)
    {
        $sql = "call sp_report_day(?,?)";
        $cdate = date('Y-m-d H:i:s',time());
        $query = $this->db->



        query($sql, array($cdate, $storeid));
        return $query->row();
    }

    public function query_date_zone_store($storeid, $sDate,$eDate)
    {
        $sql = "SELECT *, ( SELECT COMPANYNAME FROM bm_company WHERE COMPANYID = s.COMPANYID ) AS COMPANYNAME, YEAR (now()) AS YEAR, MONTH (now()) AS MONTH, DAY (now()) AS DAY, NOW() AS time, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 0 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 5 AND STOREID = s.STOREID )) AS cash_server_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 1 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 5 AND STOREID = s.STOREID )) AS cash_product_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 5 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount > 0 ) AS cash_changes_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 5 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount < 0 ) AS cash_cancel_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 0 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 4 AND STOREID = s.STOREID )) AS unionpay_server_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 1 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 4 AND STOREID = s.STOREID )) AS unionpay_product__money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 4 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount > 0 ) AS unionpay_changes_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 4 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount < 0 ) AS unionpay_cancel_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 0 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 2 AND STOREID = s.STOREID )) AS alipay_server_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 1 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 2 AND STOREID = s.STOREID )) AS alipay_produc_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 2 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount > 0 ) AS alipay_changes_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 2 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount < 0 ) AS alipay_cancel_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 0 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 3 AND STOREID = s.STOREID )) AS weixin_server_money, ( SELECT IFNULL(sum(real_amount), 0.00) FROM bm_orderproducts o WHERE is_goods = 1 AND ORDERID IN ( SELECT ORDERID FROM bm_order WHERE ORDERID = o.ORDERID AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(PAYTIME, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND PAYTYPE = 3 AND STOREID = s.STOREID )) AS weixin_product_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 3 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount > 0 ) AS weixin_changes_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 3 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.e_date, '%Y-%m-%d') AND amount < 0 ) AS weixin_cancel_money, ( SELECT IFNULL(sum(amount), 0.00) FROM fn_account WHERE paytype_id = 1 AND store_id = s.STOREID AND DATE_FORMAT(create_date, '%Y-%m-%d') > DATE_FORMAT(ref.s_date, '%Y-%m-%d') AND DATE_FORMAT(create_date, '%Y-%m-%d') < DATE_FORMAT(ref.E_date, '%Y-%m-%d') AND amount > 0 ) AS card_cancel_money, ref.* FROM bm_store s, ( SELECT ? AS s_date, ? AS e_date ) ref WHERE STOREID = ?";

        $query = $this->db->query($sql, array($sDate, $eDate, $storeid));
        echo $this->db->last_query();
        return $query->row();
    }

    public function query_classify_performance($storeid, $sDate,$eDate)
    {
        $sql = "";

        $query = $this->db->query($sql, array($sDate, $eDate, $storeid));
        //echo $this->db->last_query();
        return $query->row();
    }
}
?>