<?php
class Staff_report_old_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function query_staff_salary($storeid, $query_date, $query_enddate)
    {
        $sql = "SELECT		storeid,storename, staffid, staff_name, staff_icon, staff_number, companyname, companyid, area_name, account_status, `year`,`month`,`day`, SUM(cash_max_performance) as cash_max_performance, SUM(cash_max_commission) as cash_max_commission, SUM(cash_min_performance) as cash_min_performance, SUM(cash_min_commission) as cash_min_commission, SUM(cash_product_performance) as cash_product_performance, SUM(cash_product_commission) as cash_product_commission, SUM(mem_max_performance) as mem_max_performance, SUM(mem_max_commission) as mem_max_commission, SUM(mem_min_performance) as mem_min_performance, SUM(mem_min_commission) as mem_min_commission, SUM(mem_product_performance) as mem_product_performance, SUM(mem_product_commission) as mem_product_commission, SUM(card_commission) as card_commission, SUM(card_performance) as card_performance, SUM(coupon_performance) as coupon_performance, SUM(coupon_commission) as coupon_commission,SUM(cash_performance) as cash_performance, SUM(server_performance) as server_performance, SUM(total_income) as total_income,SUM(course_performance) as course_performance,SUM(course_commission) as course_commission,SUM(manager_performance) as manager_performance ,SUM(manager_commission) as manager_commission, SUM(card_untread_performance) AS card_untread_performance, SUM(card_untread) AS card_untread, DATE_FORMAT(?,'%Y/%m/%d') as enddata FROM	rm_staff_salary_day WHERE storeid = ? AND ? >= time AND ? <= time GROUP BY staffid,staff_name ORDER BY total_income DESC ";
        $query = $this->db->query($sql, array($query_enddate, $storeid, $query_enddate,$query_date));
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

    public function query_staff_salary_month($storeid, $query_date, $query_enddate)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time());
        }


        $sql = "SELECT s.*,k.RANKNAME FROM rm_staff_salary_month s  LEFT JOIN sm_staff f on f.STAFFID = s.staffid  LEFT JOIN bm_companyrank k on k.RANKID = f.RANKID WHERE  `YEAR` = year(?) and `MONTH` = month(?) and s.storeid=?";
        $query = $this->db->query($sql, array($query_date, $query_date, $storeid));

        return $query->result_array();
    }

    public function query_staff_salary_detail($staffid, $query_date, $query_enddate)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time()-1);
        }

        //$sql = "SELECT *,(SELECT PRODUCTNAME from bm_orderproducts o where o.OPID = b.orderproduct_id LIMIT 0,1) as product_name FROM fn_bonus b LEFT JOIN sm_staff s on b.staff_id = s.STAFFID  WHERE bonus_year = year(?) and bonus_month = month(?) and bonus_day = day(?) and staff_id = ?";

        $sql = "SELECT b.*,s.STAFFID,s.STAFFNAME,s.STAFFNUMBER,(SELECT PRODUCTNAME from bm_orderproducts o where o.OPID = b.orderproduct_id LIMIT 0,1) as product_name FROM fn_bonus b LEFT JOIN sm_staff s on b.staff_id = s.STAFFID  WHERE
		 staff_id = ? and pay_type > 0 and bonus_year >= year(?) and bonus_month >= month(?) and bonus_day >= day(?)  and bonus_year <= year(?) and bonus_month <= month(?) and bonus_day <= day(?) AND b.staff_id = s.STAFFID";


        // $this->db->close();
        // $this->db->initialize();
        // //$this->db->reconnect();

        $query = $this->db->query($sql, array($staffid,$query_date,$query_date, $query_date,$query_enddate,$query_enddate, $query_enddate));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_staff_salary_month_detail($staffid, $query_date, $query_enddate)
    {
        $cdate = $query_date;
        if (!isset($query_date)) {
            $cdate = date('Y-m-d H:i:s',time()-1);
        }

        $sql = "SELECT *,(SELECT PRODUCTNAME from bm_orderproducts o where o.OPID = b.orderproduct_id LIMIT 0,1) as product_name FROM fn_bonus b LEFT JOIN sm_staff s on b.staff_id = s.STAFFID  WHERE bonus_year = year(?) and bonus_month = month(?) and staff_id = ? ";
        $query = $this->db->query($sql, array($query_date, $query_date,$staffid));
        //echo $this->db->last_query();
        return $query->result();
    }

    // public function query_staff_salary_card_detail($staffid, $query_date,$query_enddate)
    // {
    //     // $cdate = $query_date;
    //     // if (!isset($query_date)) {
    //     //     $cdate = date('Y-m-d H:i:s',time()-1);
    //     // }

    //     // $sql = "SELECT * FROM rm_staff_salary_day WHERE `YEAR` = year(?) and `MONTH` = month(?) and staffid=? and deduct_type=1";

    //     // $this->db->close();
    //     // $this->db->initialize();
    //     // //$this->db->reconnect();

    //     // $query = $this->db->query($sql, array($query_date,$staffid));  
    //     // //echo $this->db->last_query();
    //     // return $query->result(); 
    // }

}?>