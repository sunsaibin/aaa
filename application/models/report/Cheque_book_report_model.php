<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/11/30
 * Time: 14:51
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Cheque_book_report_model extends CI_Model
{
    public  function  aaa()
    {
        echo "aaa";
    }

    // 查询凭证记录 按日期
    public function get_cheque_book_daysort_data($storeWhere,$start_date,$end_date)
    {
    	//$sql = "SELECT * from `fn_cheque_book`";
        $sql = "SELECT cb_id,cb_store,cb_code,substring_index(cb_summary,',',3) cb_summary,cb_accounts,cb_particulars,cb_posting,cb_debit,cb_credit,cb_happendate,date_format(cb_happendate,'%Y-%m-%d') as col1,s.COMPANYID from `fn_cheque_book_copy` cb LEFT JOIN bm_store s on cb.cb_store=s.STOREID where cb_store in ".$storeWhere." and DATE_FORMAT(cb_happendate, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(cb_happendate, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d') and cb_status=0 order by cb_happendate";
    	$query = $this->db->query($sql,array($start_date,$end_date));
        //echo $this->db->last_query();
    	return $query->result();
    }

    // 查询凭证记录 按门店
    public function get_cheque_book_storesort_data($storeWhere,$start_date,$end_date)
    {
        $sql = "SELECT cb_id,cb_store,cb_code,substring_index(cb_summary,',',3) cb_summary,cb_accounts,cb_particulars,cb_posting,cb_debit,cb_credit,cb_status,cb_happendate,cb_createdate,s.storename as col1,s.COMPANYID from `fn_cheque_book_copy` cb LEFT JOIN bm_store s on cb.cb_store=s.STOREID where cb_store in ".$storeWhere." and DATE_FORMAT(cb_happendate, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(cb_happendate, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d') and cb_status=0";
        $query = $this->db->query($sql,array($start_date,$end_date));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 查询凭证记录 按cb_id
    private function get_cheque_book_data_byId($cb_ids, $cb_code, $storeid)
    {
        $sql = "SELECT GROUP_CONCAT(cb_id) cb_ids,cb_store,cb_company,cb_code,cb_summary,cb_accounts,cb_particulars,cb_posting,sum(cb_debit) cb_debit,sum(cb_credit) cb_credit,cb_status,cb_happendate,cb_createdate from (SELECT cb_id,cb_store,cb_company,cb_code,cb_summary,cb_accounts,cb_particulars,cb_posting,cb_debit,cb_credit,cb_status,cb_happendate,cb_createdate from fn_cheque_book_copy where cb_id in ".$cb_ids.") as fn_cheque_book_copy_temp where cb_code=? and cb_store=?";
        $query = $this->db->query($sql, array($cb_code, $storeid));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function insert_cheque_book_evidence()
    {
        $company_ids = $this->input->get_post("company_ids");
        $store_ids = $this->input->get_post("store_ids");
        $staffid = $this->input->get_post("staffid");
        $cb_ids = $this->input->get_post("cb_ids");
        $cb_codes = $this->input->get_post("cb_codes");

        
        $cb_ids_str = '('.implode(',',$cb_ids).')'; // cb_id集合

        $cb_codes_unique = array_unique($cb_codes); // 处理重复的科目代码
        $cb_codes_unique = array_values($cb_codes_unique);

        $cb_storeid_unique = array_unique($store_ids);
        $cb_storeid_unique = array_values($cb_storeid_unique);

        $cb_companyid_unique = array_unique($company_ids);
        $cb_companyid_unique = array_values($cb_companyid_unique);

        $cheque_book_data = array();

        foreach ($cb_storeid_unique as $key => $value) {
            $data = array();
            foreach ($cb_codes_unique as $key1 => $value1) {

                // 单科汇总
                $info = $this->get_cheque_book_data_byId($cb_ids_str,$value1,$value);
                if($info[0]->cb_ids != null && $info[0]->cb_store != null && $info[0]->cb_code != null){
                    $data[$key1] = $info;
                }

            }
            array_push($cheque_book_data, $data);           
        }
        // echo "<pre>";var_dump($cheque_book_data);die;
        foreach ($cheque_book_data as $k => $v) {
            // 分组
            $v_chunk = array_chunk($v,6);
            foreach ($v_chunk as $k1 => $v1) {
                //echo "<pre>";var_dump($v1);die;
                $sqlArray = array();
                $sqlArray['cbe_storeid'] = $v1[0][0]->cb_store;
                $sqlArray['cbe_company'] = $v1[0][0]->cb_company;
                $sqlArray['cbe_staffid'] = $staffid;
                $sqlArray['cbe_status'] = 1; // 默认1,未打印

                $this->db->insert('fn_cheque_book_evidence', $sqlArray);
                $insert_id = $this->db->insert_id();

                foreach ($v1 as $k2 => $v2) {
                    $sqlArray1 = array();
                    $sqlArray1['ced_cbeid'] = $insert_id;
                    $sqlArray1['ced_cbids'] = $v2[0]->cb_ids;
                    $sqlArray1['ced_code'] = $v2[0]->cb_code;
                    $sqlArray1['ced_summary'] = $v2[0]->cb_summary;
                    $sqlArray1['ced_accounts'] = $v2[0]->cb_accounts;
                    $sqlArray1['ced_particulars'] = $v2[0]->cb_particulars;
                    $sqlArray1['ced_posting'] = $v2[0]->cb_posting;
                    $sqlArray1['ced_debit'] = $v2[0]->cb_debit;
                    $sqlArray1['ced_credit'] = $v2[0]->cb_credit;

                    $this->db->insert('fn_cheque_evidence_detail', $sqlArray1);
                }
            }
        }
        // 分组
        /*$cheque_book_data_chunk = array_chunk($cheque_book_data,6); // array_chunk() 分割数组 param 子数组的长度
        //$cb_codes_chunk = array_chunk($cb_codes,6); 
        //$cb_ids_chunk = array_chunk($cb_ids,6);
        echo "<pre>";var_dump($cheque_book_data_chunk);die;
        foreach ($cheque_book_data_chunk as $k => $v) {
            $sqlArray = array();
            $sqlArray['cbe_storeid'] = $storeid;
            $sqlArray['cbe_company'] = $companyid;
            $sqlArray['cbe_staffid'] = $staffid;
            $sqlArray['cbe_status'] = 1; // 默认1,未打印
            //$sqlArray['cbe_cbids'] = $cb_ids;
            //$cbe_cbcodes = implode(',',$value); // cb_code集合
            //$sqlArray['cbe_cbcodes'] = $cbe_cbcodes;

            $this->db->insert('fn_cheque_book_evidence', $sqlArray);
            $insert_id = $this->db->insert_id();

            $sqlArray1 = array();
            foreach ($v as $k1 => $v1) {
                $sqlArray1['ced_cbeid'] = $insert_id;
                $sqlArray1['ced_cbids'] = $v1[0]->cb_ids;
                $sqlArray1['ced_code'] = $v1[0]->cb_code;
                $sqlArray1['ced_summary'] = $v1[0]->cb_summary;
                $sqlArray1['ced_accounts'] = $v1[0]->cb_accounts;
                $sqlArray1['ced_particulars'] = $v1[0]->cb_particulars;
                $sqlArray1['ced_posting'] = $v1[0]->cb_posting;
                $sqlArray1['ced_debit'] = $v1[0]->cb_debit;
                $sqlArray1['ced_credit'] = $v1[0]->cb_credit;

                $this->db->insert('fn_cheque_evidence_detail', $sqlArray1);
                //$this->db->insert_id();
            }
        }*/
        return $insert_id;
    }

    // 生成凭证单 凭证单数据不超过六条  (此程序逻辑错误:应先汇总在分组)
    /*public function insert_cheque_book_evidence()
    {
        $companyid = $this->input->get_post("companyid");
        $storeid = $this->input->get_post("storeid");
        $staffid = $this->input->get_post("staffid");
        $cb_ids = $this->input->get_post("cb_ids");
        $cb_codes = $this->input->get_post("cb_codes");

        // array_chunk() 分割数组 param 子数组的长度
        $cb_codes_chunk = array_chunk($cb_codes,6); // 分组
        $cb_ids_chunk = array_chunk($cb_ids,6);
        //echo "<pre>";var_dump($cb_codes_chunk);die;
        foreach ($cb_codes_chunk as $key => $value) {
            $sqlArray = array();
            $sqlArray['cbe_storeid'] = $storeid;
            $sqlArray['cbe_company'] = $companyid;
            $sqlArray['cbe_staffid'] = $staffid;
            $sqlArray['cbe_status'] = 1; // 默认1,未打印
            //$sqlArray['cbe_cbids'] = $cb_ids;
            $cbe_cbcodes = implode(',',$value); // cb_code集合
            $sqlArray['cbe_cbcodes'] = $cbe_cbcodes;

            $this->db->insert('fn_cheque_book_evidence', $sqlArray);
            $insert_id = $this->db->insert_id();

            $cb_ids_str = '('.implode(',',$cb_ids_chunk[$key]).')'; // cb_id集合
            $cb_codes_unique = array_unique($value); // 处理重复的科目代码
            $data = array();
            $sqlArray1 = array();
            foreach ($cb_codes_unique as $k1 => $v1) {
                $cheque_book_data = $this->get_cheque_book_data_byId($cb_ids_str,$v1); // 单科汇总
                $sqlArray1['ced_cbeid'] = $insert_id;
                $sqlArray1['ced_cbids'] = $cheque_book_data[0]->cb_ids;
                $sqlArray1['ced_code'] = $cheque_book_data[0]->cb_code;
                $sqlArray1['ced_summary'] = $cheque_book_data[0]->cb_summary;
                $sqlArray1['ced_accounts'] = $cheque_book_data[0]->cb_accounts;
                $sqlArray1['ced_particulars'] = $cheque_book_data[0]->cb_particulars;
                $sqlArray1['ced_posting'] = $cheque_book_data[0]->cb_posting;
                $sqlArray1['ced_debit'] = $cheque_book_data[0]->cb_debit;
                $sqlArray1['ced_credit'] = $cheque_book_data[0]->cb_credit;

                $this->db->insert('fn_cheque_evidence_detail', $sqlArray1);
                //$this->db->insert_id();
            }
        }
        return $insert_id;
    }*/

    // 修改凭证记录状态
    public function update_cheque_book()
    {
        $cb_ids = $this->input->get_post("cb_ids");
        $cb_ids = implode(',',$cb_ids); // cb_id集合
        $cb_ids = '('.$cb_ids.')';
        $sql = "UPDATE `fn_cheque_book_copy` set cb_status=1 where cb_id in ".$cb_ids."";
        $this->db->query($sql);
        //echo $this->db->last_query();
        return $result;
    }

    // 获取总记录数
    public function query_cheque_book_evidence_count($storeWhere,$start_date,$end_date)
    {
        $sql = "SELECT count(*) count from fn_cheque_book_evidence cbe LEFT JOIN bm_store s on cbe.cbe_storeid=s.STOREID WHERE cbe_storeid in ".$storeWhere." AND DATE_FORMAT(cbe_createdate, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(cbe_createdate, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d');";
        $query = $this->db->query($sql,array($start_date,$end_date));
        //echo $this->db->last_query();
        return $query->result();
    }

    // 获取凭证列表
    public function query_cheque_book_evidence_data($storeWhere,$start_date,$end_date,$per_page,$offset)
    {
        $sql = "SELECT cbe_id,cbe_storeid,cbe_company,cbe_staffid,cbe_staffname,cbe_status,date_format(cbe_createdate,'%Y%m%d') as cbe_number,cbe_createdate,s.STORENAME,substring_index(GROUP_CONCAT(ced_summary),',',3) summary,round(sum(IFNULL(ced_debit,0)+IFNULL(ced_credit,0)),2) amount from fn_cheque_book_evidence cbe LEFT JOIN fn_cheque_evidence_detail ced on cbe.cbe_id=ced.ced_cbeid LEFT JOIN bm_store s on cbe.cbe_storeid=s.STOREID WHERE cbe_storeid in ".$storeWhere." AND DATE_FORMAT(cbe_createdate, '%Y-%m-%d') >= DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(cbe_createdate, '%Y-%m-%d') <= DATE_FORMAT(?, '%Y-%m-%d') GROUP BY cbe_id,cbe_storeid,cbe_company,cbe_staffid,cbe_status limit ?,?;";
        $query = $this->db->query($sql,array($start_date,$end_date,$offset,$per_page));
        //echo $this->db->last_query();
        return $query->result();
    }

    public function query_cheque_book_name()
    {
    	$sql = "SELECT * from `fn_cheque_book_name`";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    public function query_cheque_evidence_detail($cbe_id)
    {
        $sql = "SELECT ced_cbeid, ced_code,substring_index(ced_summary,',',3) ced_summary, ced_accounts, ced_particulars, ced_posting, ced_debit, ced_credit from `fn_cheque_evidence_detail` where ced_cbeid =?";
        $query = $this->db->query($sql, array($cbe_id));
        return $query->result();
    }

    // 其他应收款
    public function get_receivable_cheque_data()
    {
        // 所有数据
        $sql = "SELECT companyid,storeid,cash_total_money,alipay_total_money,weixin_total_money,third_dianping_server_money,time FROM rm_store_day ;";
        // 前一天的数据
        //$sql = "SELECT companyid,storeid,cash_total_money,alipay_total_money,weixin_total_money,third_dianping_server_money,time FROM rm_store_day where time=date_sub(current_date,interval 1 day) ;";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }

    // 营业费用
    public function get_cost_cheque_data()
    {
        // 所有数据
        $sql = "SELECT entrytype,companyid,storeid,sum(entryamount) entryamount,GROUP_CONCAT(distinct entrymemo) entrymemo,applytime,entrydate from fn_store_cost_handmade where applystate=3 GROUP BY companyid,companyname,storeid,storename,entrytype;";
        // 前一天的数据
        //$sql = "SELECT entrytype,companyid,storeid,sum(entryamount) entryamount,GROUP_CONCAT(distinct entrymemo) entrymemo,applytime from fn_store_cost_handmade where applystate=3 and entrydate = date_sub(CURDATE(),interval 1 day) GROUP BY companyid,companyname,storeid,storename,entrytype;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function add_cheque_book($sqlArray)
    {
        $this->db->insert("fn_cheque_book_copy",$sqlArray);
        $this->db->affected_rows();
        return $this->db->insert_id();
    }
}

?>