<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2017/4/17
 * Time: 18:43
 */
class Operate_check_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //daily
    public function operate_check_bonus_check_data_data($storeWhere,$storeid, $query_startdate, $query_enddate, $staff_number)
    {
        $sql = "SELECT b.bonus_time,b.company_id, b.store_id, s.STAFFNAME,s.STAFFID, s.PTYPEID, s.RANKID,IFNULL(CONCAT('订单号:',b.order_number),CONCAT('卡号:',b.card_number)) as card_order,IFNULL(pt.product_attribute,'--') as number, p.PAYNAME, b.pay_type,IF(b.deduct_type=0,'订单业务','卡业务') as d_type,b.deduct_detailtype, b.total_performance, b.staff_performance,b.commission_ratio,b.commission_amount FROM fn_bonus b LEFT JOIN sm_staff s on b.staff_id = s.STAFFID LEFT JOIN bm_payment p on p.PAYID = b.pay_type LEFT JOIN bm_product pt on pt.PRODUCTID = b.product_id WHERE b.store_id  IN " . $storeWhere . " AND  b.store_id=?  AND DATE_FORMAT(b.bonus_time, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(b.bonus_time, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d') ORDER BY s.STAFFID limit 0,9000;";
        $whileArray = array($storeid, $query_startdate, $query_enddate);

        if (isset($staff_number) && count($staff_number) > 0 && !empty($staff_number)) {
            $sql = "SELECT b.bonus_time,b.company_id, b.store_id, s.STAFFNAME,s.STAFFID, s.PTYPEID, s.RANKID,IFNULL(CONCAT('订单号:',b.order_number),CONCAT('卡号:',b.card_number)) as card_order,IFNULL(pt.product_attribute,'--') as number, p.PAYNAME, b.pay_type,IF(b.deduct_type=0,'订单业务','卡业务') as d_type,b.deduct_detailtype, b.total_performance, b.staff_performance,b.commission_ratio,b.commission_amount FROM fn_bonus b LEFT JOIN sm_staff s on b.staff_id = s.STAFFID LEFT JOIN bm_payment p on p.PAYID = b.pay_type LEFT JOIN bm_product pt on pt.PRODUCTID = b.product_id WHERE b.store_id  IN " . $storeWhere . "  AND DATE_FORMAT(b.bonus_time, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(b.bonus_time, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d') and s.STAFFNUMBER=? ORDER BY s.STAFFID";
            $whileArray = array($query_startdate, $query_enddate,$staff_number);
        }
        $query = $this->db->query($sql, $whileArray);
        //echo $this->db->last_query();
        return $query->result_array();
    }
}
?>