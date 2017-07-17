<?php
/**
 * Created by PhpStorm.
 * User: chenzhenxing
 * Date: 2016/12/14
 * Time: 4:05
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Flow_initiate_api_appdata_model extends CI_Model
{
	public function api_flow_16($flow_userid){
		$sql = "SELECT STAFFLOGO FROM sm_staff where STAFFID = ?";
		$query = $this->db->query($sql, array($flow_userid));
        //echo $this->db->last_query();
        return $query->row();
	}

	//查找已通过的形象照
    public function get_is_approve($image_url)
    {
    	//select * from fw_userdata_flow f LEFT JOIN fw_userdata_flowform fm on f.luf_id = fm.lfuff_userflow  where f.luf_is_approve=2 AND lfuff_value='http://res.faxianbook.com/app/images/2017/01/13/2017011305062566.jpg'
    	$sql = "SELECT * FROM `fw_userdata_flow` f LEFT JOIN `fw_userdata_flowform` fm on f.`luf_id` = fm.`lfuff_userflow` where f.`luf_is_approve`='2' AND fm.`lfuff_value` = ?";
    	$query = $this->db->query($sql, array($image_url));
        //echo $this->db->last_query();
        return $query->row();
    }

    public function set_stafflogo($flow_data, $userid)
    {
    	//$tem_exec_sql = $this->get_flowstep_task();
    	$tem_exec_sql ="UPDATE sm_staff set STAFFLOGO_GROUP='{\"id\":\"table_userdata_flow_userid\",\"thumbUrl\":\"api_app_user_headimg_update_img_min\",\"url\":\"api_app_user_headimg_update_img_big\",\"mid\":\"api_app_user_headimg_update_img_mid\"}',STAFFLOGO='api_app_user_headimg_update_img_min' where STAFFID = table_userdata_flow_userid";

    	foreach ($flow_data as $k => $v) {
    		$tem_str = $v->lfuff_value;
            $tem_key = $v->lfuff_key;
            /*echo '<br>';
            print_r($tem_key."_V_".$tem_str."______");
            echo '<hr>';*/
            if(!isset($v->lfuff_value)){
                $tem_str = "";
            }
            if(isset($tem_key)){
                if($v->lfuff_key != 'staffid'){
                    $tem_exec_sql = str_ireplace($v->lfuff_key, $tem_str, $tem_exec_sql);
                    $tem_exec_sql = str_ireplace('table_userdata_flow_userid', $userid, $tem_exec_sql); 
                }             
            }
    	}

    	$row = $this->db->query($tem_exec_sql);
        $row = $this->db->affected_rows();
        //echo $this->db->last_query();die;
        return $row;
    }

    /*public function get_flowstep_task()
    {
    	$sql = "SELECT * FROM  `fw_flow_flowstep_task` where ffr_flowstep_ffsid in (SELECT lufs_flowstep FROM fw_userdata_flowstep where ffr_flow=16)  and ffr_is_use=1";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }*/

}
?>