<?php
    class Day_report_model extends CI_Model {
             var $db;

        public function __construct()
        {
                parent::__construct();
                $this->db = $this->load->database('default', TRUE);

        }
        //店铺门店日报表
        public function rm_store_day($offset,$per_page,$table,$typeselect)
        {
            $storeid = $this->input->get("storeid");  
            $company = $this->input->get("company"); 
            $all_company = $this->input->get("brand"); 
            $city = $this->input->get("city");  
            $page = $this->input->get("per_page");  
            $start_time = $this->input->get("date_start");
            $staffnumber = $this->input->get("staffnumber");
            $end_time = $this->input->get("date_end");
            $start_time = strtotime($start_time);

            $end_time = strtotime($end_time);
            if($start_time > $end_time)
            {
                $start_time = $end_time;
                $end_time = $start_time;

            }

            $infotype = $this->input->get("infotype");//查询排序1.时间2.店号3.总金额
            $date_start = $start_time;
            $date_end = $end_time;  
            $where ='';
            if($start_time && $end_time)
            {
                $where = " k.`DATETIME` >= ".$start_time.""." AND k.`DATETIME` <= ".$end_time.""; 
            }

            if($city <> "*" && $city <> '' && $all_company)
            {
                if(!$where){
                $where .=' k.`COMPANYID` = '.$city;
            }else{
                $where .=' AND k.`COMPANYID` = '.$city;
            }   
                
            }else{
                if(!$where){
                    $where .=' k.`COMPANYID` = '.$company;
                }else{
                    $where .=' AND k.`COMPANYID` = '.$company;
                }  
            }


            if($storeid <> "*" && $city <> "*" && $storeid <> "" && $city <> "")
            {   
                if(!$where)
                {
                   $where .=' k.`STOREID` ='.$storeid; 
                }else{
                    $where .=' AND k.`STOREID` ='.$storeid;
                }
                
            }
            if($staffnumber && $typeselect=='achieve')
            {
                if(!$where)
                {
                    $where .= " l.`STAFFNUMBER` =".$staffnumber;
                }else{
                    $where .=' AND l.`STAFFNUMBER` = '.$staffnumber;
                }
                
            }

         $order_by= '';
            switch ($infotype) {
            case '1':
                $order_by =' ORDER BY k.`DATETIME` DESC';
                break;
            case '2':
                if($typeselect != 'achieve') {

                    $order_by =' ORDER BY k.`STOREID` DESC';
                }else{
                    $order_by = '';
                }
                break;
            case '3':
                $order_by =' ORDER BY k.`TOTALVALUE` DESC';
                break;            
            default:
                $order_by .=' ORDER BY k.`ID` DESC';
                break;
        }

        if($where)
        {
            $valuewhere =" WHERE";

        }
        if($typeselect && $typeselect == 'achieve')
        {
            $limit = " LIMIT ".$offset.",".$per_page;
            $sql = "SELECT k.*,l.`STAFFNAME`,l.`STAFFID` FROM `rm_staff_day` k LEFT JOIN `sm_staff` l on k.`STOREID`= l.`STOREID`".$valuewhere . $where.$order_by . $limit;
            $sql2 = "SELECT k.*,l.`STAFFNAME`,l.`STAFFID` FROM `rm_staff_day` k LEFT JOIN `sm_staff` l on k.`STOREID`= l.`STOREID`".$valuewhere .$where;
            $data["num"] = $this->db->query($sql2)->num_rows();
            $data["info"] = $this->db->query($sql)->result();
            return $data;exit;

        }
            $limit = " LIMIT ".$offset.",".$per_page;
            $sql = "SELECT k.*,l.`STORENAME`,l.`STOREID` FROM `".$table."` k LEFT JOIN `bm_store` l on k.`STOREID`= l.`STOREID`".$valuewhere . $where.$order_by . $limit;
            $sql2 = "SELECT k.*,l.`STORENAME`,l.`STOREID` FROM `".$table."` k LEFT JOIN `bm_store` l on k.`STOREID`= l.`STOREID`".$valuewhere .$where;
            $data["num"] = $this->db->query($sql2)->num_rows();
            $data["info"] = $this->db->query($sql)->result();
            echo $this->db->last_query();
            return $data;
                      
        }


        public function get_storeinfo()
        {
            $sql = "SELECT `STOREID`,`STORENAME` FROM `bm_store` WHERE `STOREID` <> 1 ";
            $query = $this->db->query($sql);
            return $query->result();

        }

        public function get_region($company)
        {
            if (!isset($company)) {
                return false;
            }

            $sql = "SELECT * FROM `bm_company` WHERE `PARENTID`=?";
            $query = $this->db->query($sql, $company);
            //echo $this->db->last_query(); 
            return $query->result();  
        }

        public function get_company($userid){
            $sql = "SELECT b.* FROM `bm_company` b LEFT JOIN `sys_user` s on b.`COMPANYID` = s.`COMPANYID` WHERE s.`id` = ?";
            $query = $this->db->query($sql, array($userid));    
            //echo $this->db->last_query();
            return $query->result();   
        }

        public function get_quyu_store($companyid)
        {
            $sql = "SELECT * FROM `bm_store` WHERE `COMPANYID` = ".$companyid;
            $query = $this->db->query($sql);  
            //echo $this->db->last_query();
            $row = $query->result();  
        }

        public function get_store($companyid)
        {
            $sql = "SELECT * FROM `bm_store` WHERE `COMPANYID` = ?";
            $query = $this->db->query($sql, array($companyid));  
            //echo $this->db->last_query();
            return $query->result();  
        }

        public function get_staff_info($userid, $password, $username)
        {
            $sql = "SELECT * FROM `sys_user` where id=? and `password`=? and username=?";
            $query = $this->db->query($sql, array($userid, $password, $username));
            //echo $this->db->last_query();
            return $query->row();

        }

    }

?>