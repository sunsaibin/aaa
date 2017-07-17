<?php
date_default_timezone_set("Asia/Shanghai");
class Oa_flow_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_oa_flow()
    {
        $sql = "SELECT * FROM `fw_flow_flowstep` where ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }
//流程ID
    public function get_flow($id)
    {
        $sql = "SELECT * FROM `log_fw_user_flow` where luf_id = ".$id;
        $query = $this->db->query($sql);
        return $query->row();        
    }

    public function get_user_flow()
    {
        $userid = $this->input->get("userid");

        if($_SESSION['type'])
        {
            $where = " AND l.type = ".$_SESSION['type'];
        }

        $sql = "SELECT * FROM `log_fw_user_flow` l LEFT JOIN  `fw_flow` f on f.`flow_id` = l.`luf_flow` where `luf_user`=?".$where;
        $query = $this->db->query($sql, array($userid));
        return $query->result();
    }

    //流程表单值
    public function get_form_value()
    {

        $userid = $_SESSION['userid'];

        $sql = "SELECT * FROM `log_fw_user_flow` l LEFT JOIN `log_fw_user_flowform` f on l.`luf_id` = f.`lfuff_userflow` where `luf_user`=? ";
        $query = $this->db->query($sql, array($userid));
        $info = $query->result();
        $arr = array();
        foreach ($info as $k => $v) {
            $arr[$v->luf_id]['userid'] =$v->luf_user;
            $arr[$v->luf_id]['value'][] =$v->lfuff_value;
        }
        return $arr;
    }

    public function get_user_flowstep()
    {
        $user_flow_id = $this->input->get("id");
        $sql = "SELECT * FROM `log_fw_user_flowstep` l LEFT JOIN `fw_flowstep_flowstep` f on l.`lufs_flowstep` = f.`ffs_id` LEFT JOIN `fw_approval` a on a.`fa_id` = l.`lufs_approval` LEFT JOIN `fw_approval_user` r on r.`fau_id` = l.`lufs_approval_user` where lufs_userflow=?";
        $query = $this->db->query($sql, array($user_flow_id));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_user_have_flows()
    {
        $level = $this->input->get("level");

        if($_SESSION['type'])
        {
            $where = "AND w.`type` =".$_SESSION['type'];
        }else{
            $where = '';
        }

       if($_SESSION['userid'])
        {
            $sql = " select * from sys_user where id=".$_SESSION['userid']." ";
	        $staffquery = $this->db->query($sql);
			$staffUser =  $staffquery->result();
			$companyid= $staffUser[0]->companyid;
			if($storeid > 0 )
				$where = "AND (w.company_id =".$companyid." or w.company_id =".$companyid.") ";
        }else{
            $where = '';
        }

        $sql = "SELECT * FROM `fw_flow_flowstep` f LEFT JOIN `fw_flow_restraint` r on f.`ff_restraint`=r.`ffr_id` LEFT JOIN `fw_flow` w on w.`flow_id` = f.`ff_flow`  where (r.`ffr_level`=? or r.`ffr_level`=-1)" .$where;
        $query = $this->db->query($sql, array($level));
/*        echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_flow_form()
    {
        $id = $this->input->get("flow_flowstep");
        if (!isset($id)) {
            $id = $this->input->post("flow_flowstep");
        }

/*        $sql = "SELECT * FROM `fw_flowstep` s LEFT JOIN `fw_flowstep_flowform` m on m.`fsff_flowstep`= s.`flowstep_id` LEFT JOIN `fw_flowform` f on m.`fsff_flowform`=f.`flowform_id` LEFT JOIN  `fw_flow_flowstep` p on p.`ff_flowstep` =  s.`flowstep_id` where p.`ff_id`=? and m.`fsff_enable`=1 ";
*/   
$sql = "SELECT * FROM `fw_flowstep` s LEFT JOIN `fw_flow_flowstep` p on p.`ff_from` = s.`flowstep_id` LEFT JOIN `fw_flowform` f on p.`ff_from`=f.`flowform_id`  where p.`ff_id`=? and p.`ff_enable`=1 ";
     $query = $this->db->query($sql, array($id));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    public function set_flow_form($filename)
    {
        $adopt = $this->input->get("adopt");
        if (!isset($id)) {
            $adopt = $this->input->post("adopt");
        }

        $formitems = $this->input->post("formitems");
        $array_formitems = explode(",",$formitems);
        $sqlArray = array();
        $sqlArray["luf_flow"] = $this->input->post("flowid");
        $sqlArray["luf_randid"] = $this->input->post("randid");
        $sqlArray["luf_user"] = $this->input->post("userid");
        $sqlArray["luf_user_type"] = $this->input->post("usertype");
        $sqlArray["luf_company"] = $this->input->post("company");
        $sqlArray["luf_remark"] = $this->input->post("explain");
        $sqlArray["type"] = $_SESSION['type'];

        $row = $this->db->insert('log_fw_user_flow', $sqlArray);
        $row = $this->db->affected_rows();

        if ($row < 1) {
            echo "不能重复提交申请! 请刷新页面!";
            exit;
        }
       /* echo $this->db->last_query();*/

        $newid = $this->db->insert_id();
        echo "newid=".$newid;

        $sqlArray = array();
        $sqlArray["lufs_userflow"] = $newid;
        $sqlArray["lufs_flowstep"] = $this->input->post("flowstepid");
        $sqlArray["lufs_sequence"] = 1;
        $sqlArray["lufs_approval"] = 0;
        $sqlArray["lufs_approval_user"] = 0;
        $sqlArray["lufs_approval_jump"] = 0;
        $sqlArray["lufs_is_adopt"] = 0;
        $sqlArray["lufs_explain"] =  $this->input->post("explain");

        $row = $this->db->insert('log_fw_user_flowstep', $sqlArray);
        $row = $this->db->affected_rows();
        /*echo $this->db->last_query();*/

        $newid2 = $this->db->insert_id();
        echo "newid2=".$newid2;

        foreach ($array_formitems as $key => $value) {
            if (strlen($value) > 0) {
                //echo $value."=".$this->input->post($value)."<br/>";
                $ag = $this->input->post($value);
                $sqlArray = array();
                $sqlArray["lfuff_user_flowstep"] =$newid2;
                $sqlArray["lfuff_userflow"] = $newid;
                $sqlArray["lfuff_formid"] = $this->input->post("flowformid");
                $sqlArray["lfuff_key"] = $value;
                $sqlArray["lfuff_value"] = isset($ag)?$ag:'';
                if(isset($filename[$value])){
                 $sqlArray["lfuff_value"] = base_url().'/upload/images/'.$filename[$value];

                }    
                $sqlArray["lfuff_value_type"] = 0;
                $row = $this->db->insert('log_fw_user_flowform', $sqlArray);
               /* echo  "<br/>sql3: ".$this->db->last_query();*/

            }
        }
    }

//审核第一不用户流程列表
    public function get_user_approval()
    {
        $userid = $this->input->get("userid");
        if(!$_GET["type"])
        {
            $where = '';
        }else{
           $where= " AND p.type = ".$_GET['type'];
        }

/*        $sql = "SELECT * FROM `log_fw_user_flowstep` p LEFT JOIN `fw_flowstep_flowstep` f on p.`lufs_flowstep`=f.`ffs_id` LEFT JOIN `fw_approval` a on f.`ffs_approval` = a.fa_id LEFT JOIN `fw_approval_user` u on a.`fa_id` = u.`fau_approval` LEFT JOIN `fw_flow` k on p.`lufs_flowstep` = k.`flow_id` WHERE `fau_userid` = ?";
        $query = $this->db->query($sql, array($userid));*/
        $sql = 
"        select * from log_fw_user_flow p LEFT JOIN fw_flow k on p.luf_flow = k.flow_id where k.flow_id is not null and p.luf_id in 
(
    select lufs_userflow  from  `log_fw_user_flowstep` u LEFT JOIN `fw_flowstep_flowstep` f on u.`lufs_flowstep`=f.`ffs_id` LEFT JOIN  `fw_approval` a on f.`ffs_approval` = a.`fa_id` LEFT JOIN `fw_approval_user` l on a.`fa_id` = l.`fau_approval` where `fau_userid` =?". $where.")";
        $query = $this->db->query($sql, array($userid));
        return $query->result();
    }

    public function get_user_approval_flowstep()
    {
        $lufs_id = $this->input->get("id");
        $userid = $_SESSION['userid'];
        $sql = "SELECT * FROM `fw_approval_user` WHERE `fau_approval` in (SELECT `ffs_approval` FROM `fw_flowstep_flowstep` f  LEFT JOIN `log_fw_user_flowstep` p on f.ffs_id = p.`lufs_flowstep` WHERE `lufs_userflow`=? and `lufs_is_adopt`=0) and  `fau_userid` = ?";
        $query = $this->db->query($sql, array($lufs_id, $userid));
/*        echo $this->db->last_query();*/
        return $query->row();
    }

    public function get_user_approval_form()
    {
        $lufs_id = $this->input->get("id");

        $sql = "SELECT * FROM `fw_flowform` WHERE `flowform_id` in (SELECT `lfuff_formid` FROM `log_fw_user_flowform` WHERE `lfuff_userflow`=?)";
        $query = $this->db->query($sql, array($lufs_id));
/*        echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_user_approval_formdata()
    {
        $luf_id = $this->input->get("id");
        if($_SESSION['pass'])
        {
            $where = "AND b.`fau_user_type`=".$_SESSION['pass'];
        }
        $sql = "SELECT f.* FROM `oa_direction_approval` f LEFT JOIN `log_fw_user_flowform` p on f.`from_id` = p.`lfuff_formid` LEFT JOIN `log_fw_user_flowstep` v on p.`lfuff_user_flowstep` = v.`lufs_id` LEFT JOIN `fw_approval_user` b on p.`lfuff_formid` = b.`fau_id` WHERE v.`lufs_flowstep` = f.`rec_lufs` ".$where." AND f.`from_id` = p.`lfuff_formid` AND p.`lfuff_userflow`=".$luf_id." AND f.`approve_user`= ".$_SESSION['userid'];
        $query = $this->db->query($sql);//约束key
/*        $info_key = isset($key->rec_key)?$key->rec_key:'';*/
/*        if($info_key)
        {
            $info = explode(',',$info_key);
        }
        $info = "'".join("','",$info)."'";
        $sql = "SELECT * FROM `log_fw_user_flowform` where `lfuff_key` not in ($info) AND `lfuff_userflow`=? ";
        $query = $this->db->query($sql, array($luf_id));*/
/*    echo $this->db->last_query();*/
        return $query->row();
    }


    public function get_oa_approval_rec_key()
    {
        $luf_id = $this->input->get("tid");
        if($_SESSION['type'])
        {
           $where = " AND b.`fau_user_type`=".$_SESSION['type'];  
        }
        $sql = "SELECT f.* FROM `oa_direction_approval` f LEFT JOIN `log_fw_user_flowform` p on f.`from_id` = p.`lfuff_formid` LEFT JOIN `fw_approval_user` b on p.`lfuff_formid` = b.`fau_id` WHERE  f.`from_id` = p.`lfuff_formid` ".$where." AND p.`lfuff_userflow`= ".$luf_id ." AND f.`approve_user`=".$_SESSION['userid'];
        $query = $this->db->query($sql);
        /* echo $this->db->last_query();*/
        return $query->row();
    }

     public function get_user_approval_info($id)
    {
        $lufs_id = $this->input->get("tid");
        if(!$lufs_id)
        {
            $lufs_id= $id;
        }
        $sql = "SELECT * FROM `log_fw_user_flowform` WHERE `lfuff_userflow`=?";
        $query = $this->db->query($sql, array($lufs_id));
/*        echo $this->db->last_query();*/
        return $query->result();
    }

    public function set_user_auditing_form()
    {
        $jump = -1;
        $adopt = $this->input->post("adopt");
        $adid = $this->input->post("adid");//流程号
        $setid =$this->input->post("setid");//步骤号
        $sql = "SELECT * FROM  `fw_flowstep_flowstep` k LEFT JOIN log_fw_user_flowstep v on k.`ffs_id`=v.`lufs_flowstep` left join `log_fw_user_flow` op on op.`luf_id` = v.`lufs_userflow`  WHERE v.`lufs_id` in (SELECT `lufs_id` FROM `log_fw_user_flowstep` WHERE `lufs_userflow` = ? and `lufs_is_adopt` = 0)";
        $query = $this->db->query($sql, array($setid));
        $info = $query ->row();
                //查询是否有可执行的sql
        if($info)
        {
            $sql = "SELECT * FROM  `fw_flow_result_value` where ffr_flow = ".$info->luf_flow." and ffr_flowstep_ffsid =".$info->ffs_id;
            $query = $this->db->query($sql);
            $sqlinfo = $query->row();    
        }

        if ($adopt == 2) {
            $jump = $info->ffs_step_pre;
        }
        else if ($adopt == 1) {
            $jump = $info->ffs_step_next;
        }
        $sqlArray = array();
        $sqlArray["lufs_is_adopt"] = $adopt;
        $sqlArray["lufs_approval"] = $info->ffs_approval;
        $sqlArray["lufs_explain"] = $this->input->post("explain");
        $sqlArray["lufs_approval_user"] = $_SESSION["userinfo"]->staffId;
        $sqlArray["lufs_approval_jump"] = $jump;
        $sqlArray["lufs_approval_cdate"] =  date('y-m-d h:i:s',time());
        $sqlWhere = array();
        $sqlWhere["lufs_id"] = $info->lufs_id;
        $row = $this->db->update('log_fw_user_flowstep', $sqlArray, $sqlWhere);
        $row = $this->db->affected_rows();
        /*echo $this->db->last_query();*/
        $insert_id='';
        if($row >0 && $jump != -1)
        {
                $sqlArray = array();
                $sqlArray["lufs_userflow"] = $info->lufs_userflow;
                $sqlArray["lufs_flowstep"] = $jump;
                $sqlArray["lufs_sequence"] = $info->ffs_step_next;
                $sqlArray["lufs_approval"] = 0;
                $sqlArray["lufs_approval_user"] = 0;
                $sqlArray["lufs_approval_jump"] = 0;
                $sqlArray["lufs_is_adopt"] = 0;

                $row = $this->db->insert('log_fw_user_flowstep', $sqlArray);
                $row = $this->db->affected_rows();
                $insert_id = $this->db->insert_id();
                /*echo $this->db->last_query();*/
        }

        //跟新·log_fw_user_flowform·
        if($insert_id)
        {
            $sqlArray = array();
            $sqlArray["lfuff_user_flowstep"] = $insert_id; 
            $sqlWhere = array();
            $sqlWhere["lfuff_userflow"] = $info->lufs_userflow;
            $row = $this->db->update('log_fw_user_flowform', $sqlArray, $sqlWhere);
        }
        $type = $_SESSION['type'];
        if($row>0 && $jump == -1)
        {
            $sqlArray = array();
            $sqlArray["is_approve"] = $adopt;
            $sqlWhere = array();
            $sqlWhere["luf_id"] = $info->lufs_userflow;
            $date = $this->db->update('log_fw_user_flow', $sqlArray, $sqlWhere);

//同步数据状态
            if($adopt==1 && $jump == -1 && $date>0)
            {
                $sql = "SELECT * FROM `log_fw_user_flow` WHERE luf_id = ".$info->lufs_userflow;
                $query = $this->db->query($sql);
                $data = $query ->row();                

                switch ($type) {
                    //仓库
                    case 2:
                        $sqlArray = array();
                        $sqlArray["audit_status"] = 2; 
                        $sqlWhere = array();
                        $sqlWhere["sc_order_id"] = $data->luf_ranid;
                        $row = $this->db->update('sc_order', $sqlArray, $sqlWhere);
                        break;
                    case 3:
                    //挂失卡
                        $sqlArray = array();
                        $sqlArray["card_stage"] = 3; 
                        $sqlWhere = array();
                        $sqlWhere["CARDNUM"] = $data->luf_ranid;
                        $row = $this->db->update('bm_card', $sqlArray, $sqlWhere);
                        break;                        
                }
            }
// 步骤 执行SQL
            if($adopt==1 && $sqlinfo){
                 $sql =  $this->processing_sql($sqlinfo,$info);  
            }


        }    

    }
//处理sql
    public function processing_sql($sqlinfo,$info)
    {
        $flow_id = $info->luf_id;
        
        $sql = "SELECT * FROM `log_fw_user_flowform` WHERE lfuff_userflow = ".$flow_id;
        $query = $this->db->query($sql);
        $data = $query ->result();

        $sql3 = $sqlinfo->ffr_result_sql;
        foreach ($data as $k => $v) {  
            isset($v->lfuff_value)?$v->lfuff_value:'';
            $sql3 = str_replace($v->lfuff_key, $v->lfuff_value, $sql3);
        }
        $query = $this->db->query($sql3);
        return $query;
    }


    public function get_log_user_flowstep($id)
    {
        $sql = "SELECT * FROM `log_fw_user_flowstep` WHERE `lufs_id`=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
//流程步骤列表方法
    public function get_user_li()
    {
        $id = $this->input->get("id");
        $userid = $this->input->get("userid");

/*        $sql = "SELECT * FROM `log_fw_user_flowstep` l LEFT JOIN `fw_flowstep_flowstep` k on l.`lufs_flowstep` = k.`ffs_id` ".
        "LEFT JOIN fw_approval a on l.`lufs_approval`= a.`fa_id`".
        "LEFT JOIN fw_approval_user v on a.`fa_id`= v.`fau_approval`".
        " WHERE `lufs_userflow`=?";
        $sql = "SELECT * FROM `log_fw_user_flowstep` l LEFT JOIN `fw_flowstep_flowstep` k on l.`lufs_flowstep` = k.`ffs_id`  WHERE `lufs_userflow`=?";*/
         $sql = "SELECT * FROM `log_fw_user_flowstep` l LEFT JOIN `fw_flowstep_flowstep` f on l.`lufs_flowstep` = f.`ffs_id` LEFT JOIN `fw_approval` a on a.`fa_id` = l.`lufs_approval` LEFT JOIN `fw_approval_user` r on r.`fau_id` = l.`lufs_approval_user` where lufs_userflow=?";
        $query = $this->db->query($sql, array($id));
         /*echo $this->db->last_query();*/
        return $query->result(); 
    }

    public function get_userftep()
    {
        $lufs_id = $this->input->get("tid");
        $sql = "SELECT * FROM `fw_flowform` where `flowform_id` in (SELECT `lfuff_formid` FROM `log_fw_user_flowform` WHERE `lfuff_userflow`=?)";
        $query = $this->db->query($sql, array($lufs_id));
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    public function get_user_flowstep_entity()
    {
        $user_flow_id = $this->input->get("id");
        $sql = "SELECT * FROM `log_fw_user_flowstep`  where `lufs_id` = ?";
        $query = $this->db->query($sql, array($user_flow_id));
/*        echo $this->db->last_query();*/
        return $query->row();
    }

    public function set_userunset_form()
    {


        $lufsid = $this->input->get("id");

        $sql = "SELECT * FROM `log_fw_user_flow` l LEFT JOIN `log_fw_user_flowstep` k on k.`lufs_userflow` = l.`luf_id` where k.`lufs_id` = ?";
        $query = $this->db->query($sql, array($lufsid));
        $info = $query->row();


        $sqlArray = array();
        $sqlArray["lufs_is_adopt"] = 3;
        $sqlArray["lufs_approval_jump"] = -1;
        $sqlWhere = array();
        $sqlWhere["lufs_id"] =$lufsid;
        $row = $this->db->update('log_fw_user_flowstep', $sqlArray, $sqlWhere);

  
        if($row)
        {
            $data = array();
            $data["is_approve"] = 3;
            $sqlWhere = array();
            $sqlWhere["luf_id"] =$info->luf_id;
            $temp = $this->db->update('log_fw_user_flow', $data, $sqlWhere);           
        }

        if($temp){
            return true;
        }else{
            return false;
        }


    }


    public function do_file()
    {
      $this->load->library('upload');
      
      //配置上传参数
      $upload_config = array(
          'upload_path'  => $_SERVER['DOCUMENT_ROOT'].'/upload/images/',
          'allowed_types' => 'jpg|png|gif',
          'file_name' => md5(time().'idcard'),
          'max_size'   => '500',
          'max_width'   => '1024',
          'max_height'  => '768',
      );
      $arr = $this->upload->initialize($upload_config);
        
      //循环处理上传文件
      $file_name = array();
      foreach ($_FILES as $key => $value) {
        if (!empty($key)) {
                if($this->upload->do_upload($key)){
                    $file_info = $this->upload->data();
                     $file_name[$key]=$file_info['orig_name'];

                }
            }

        }
     
                return $file_name;
    
    }


    public function staff_ajax($idcard)
    {
        $sql = "SELECT * FROM  `sm_user` v left join  `sm_staff` k on v.`USERID`= k.`STAFFID` left join `bm_store` l on k.`STOREID`= l.`STOREID` left join `sm_role` j on v.`ROLEID` = j.`ROLEID` left join `bm_company` b on l.`COMPANYID`= b.`COMPANYID` where (k.`IDCARD` = '".$idcard ."' or k.`STAFFNAME`= '".$idcard."' or  k.`STAFFNUMBER`='". $idcard."' ) and v.`ROLEID` <> 1";
        $query = $this->db->query($sql);
        $row = $query->row();
        /*echo $this->db->last_query();*/
        if($row)
        {
            return $row;
        }
            return false;
    }

    public function get_position()
    {
        $sql = "SELECT * FROM  `sm_role` WHERE `ROLEID` <> 1";
        $query = $this->db->query($sql);
        $row = $query->result(); 

        return $row;       
    }

   public function get_storeinfo($companyid)
   {    
        if($companyid)
        {
            $sql = "SELECT * FROM  `bm_store` WHERE `COMPANYID` = ".$companyid;
            $query = $this->db->query($sql); 
            $row = $query->result();  
            /* echo $this->db->last_query();*/
            return $row;   
        }else{
            return false;    
        }

   }


    public function get_companyinfo()
    {
        $userid = isset($_SESSION['staffinfo']->STAFFID)?$_SESSION['staffinfo']->STAFFID:$_SESSION['userid'];

        if($userid)
        {
            $sql = "SELECT b.* FROM `bm_company` b LEFT JOIN `sm_staff` s on b.`COMPANYID` = s.`COMPANYID` WHERE s.`STAFFID` = ".$userid;
            $query = $this->db->query($sql);    
            return $query->result();            
        }else{
            return false;
        }
    }

    //添加仓储
    public function warehouse_audit($numberid,$userid,$id,$type,$info,$luf_flow)
    {
        $sqlArray = array();
        $sqlArray["luf_flow"] = $luf_flow;
        $sqlArray["luf_randid"] = $id;
        $sqlArray["luf_user"] = $userid;
        $sqlArray["luf_user_type"] = '1';
        $sqlArray["luf_company"] ='1';
        $sqlArray["luf_remark"] = $numberid.",".$info;//订单号码
        $sqlArray["type"] = $type;


        $row = $this->db->insert('log_fw_user_flow', $sqlArray);

        $newid = $this->db->insert_id();

        $sqlArray = array();
        $sqlArray["lufs_userflow"] = $newid;
        $sqlArray["lufs_flowstep"] = 1;
        $sqlArray["lufs_sequence"] = 1;
        $sqlArray["lufs_approval"] = 0;
        $sqlArray["lufs_approval_user"] = 0;
        $sqlArray["lufs_approval_jump"] = 0;
        $sqlArray["lufs_is_adopt"] = 0;
        $sqlArray["lufs_explain"] =  '';

        $row = $this->db->insert('log_fw_user_flowstep', $sqlArray);

        return $row;
    }

//仓储审核列表
    public function get_warehouse_audit()
    {
        $sql = "SELECT b.* FROM `bm_company` b LEFT JOIN `sm_staff` s on b.`COMPANYID` = s.`COMPANYID` WHERE s.`STAFFID` = ".$userid;
        $query = $this->db->query($sql);    
        return $query->result();    
    }

//OA同步sql处理
    public function get_sql_result()
    {
        
    }

}
?>