<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
public function day_report()
{	

    $userid = $_GET['userid'];
    $username = $_GET['username'];
    $userpwd = $_GET['userpwd'];
    $usertype = $_GET['type'];
    $pass = $_GET['pass'];
    redirect(site_url("report_store/store_day_checkout?pass=".$pass."&userid=".$userid."&username=".$username."&userpwd=".$userpwd));


    exit;


    $this->load->model('report/day_report_model', 'day_report');
    $this->load->library('pagination');

    $info='';

    $staffinfo = $this->session->userdata("staffinfo");
    if($_GET['userid'])
    {
        $userid = $_GET['userid'];
        $username = $_GET['username'];
        $userpwd = $_GET['userpwd'];
        $usertype = $_GET['type'];
        $staffinfo = $this->day_report->get_staff_info($userid, $userpwd, $username);

        if (isset($staffinfo) && count($staffinfo)>0) {
            //print_r("setting session user!");
            $this->load->library('session');
            $this->session->set_userdata('staffinfo',$staffinfo);
            $this->session->set_userdata('type',$_GET['type']);
        }
    }

    if($_GET['storeid'])
    {
        $config = array();
        $config['per_page']    = 10;         //每页显示的数据数
        $current_page          = intval($this->input->get('per_page'));  //获取当前分页页码数

        if(!$current_page)
    	{
    	   $current_page = 1;
    	}

	    $offset  = ($current_page - 1) * $config['per_page'];
	    $data    = $this->day_report->rm_store_day($offset,$config['per_page'],'rm_store_day'); 
	    $info['query'] = $data['info'];
	    $config['base_url']       =$this->config->item('base_url').'index.php/Report/day_report?brand='.$_GET['brand'].'&company='.$_GET['company'].'&city='.$_GET['city'].'&storeid='.$_GET['storeid'].'&date_start='.$_GET['date_start'].'&date_end='.$_GET['date_end'].'&infotype='.$_GET['infotype'];
        $config['prev_link'] = '上一页';
        $config['next_link']  = '下一页';
        $config['total_rows']   = $data['num'];         //获取查询数据的总记录数
        $config['cur_tag_open'] = ' <a href="" class="active">'; // 当前页开始样式  
	    $config['cur_tag_close'] = '</a>';

        //默认分页URL中是显示每页记录数,启用use_page_numbers后显示的是当前页码   
        $config['use_page_numbers'] = TRUE;        

        //把 $config['enable_query_strings'] 设置为TRUE，链接将自动地被用查询字符串（url中的参数）重写。 
        $config['page_query_string']= TRUE;                   
        $row = $this->pagination->initialize($config);	
        $info['page'] = $this->pagination->create_links();
    }
  	    
    $info['brand_id']  = $this->day_report->get_company($staffinfo->id);

    //分公司
    $tem_companyid = $info['brand_id'][0]->COMPANYID;
    $tem_parentid = $tem_companyid;
    if (isset($tem_parentid)) {
        $info['fen_company'] = $this->day_report->get_region($tem_parentid);
        $tem_companyid2 = $info['fen_company'][0]->COMPANYID;
        if (isset($tem_companyid2)) {
            $tem_parentid = $tem_companyid2;
        }
    }
    
    if (isset($tem_parentid)) {
       $info['quyu'] = $this->day_report->get_region($tem_parentid);
       $tem_companyid2 = $info['quyu'][0]->COMPANYID;
       if (isset($tem_companyid2)) {
            $tem_parentid = $tem_companyid2;
        }
    }
    
    if (isset($tem_parentid)) {
        $info['storeid'] =$this->day_report->get_store($tem_companyid);
    }

	$this->load->view('viewheaders/charisma/header');
    $this->load->view('oa/charisma/dailyreport', $info);
    $this->load->view('viewfeet/charisma/foot');

    //print_r($info);
}

//AJAX brand
public function ajax_query()
{
    $this->load->model('report/day_report_model', 'ajax_info');
    if($_POST["type"]== "company")
    {
        $companyid = $_POST["company"];
        $info = $this->ajax_info->get_region($companyid);

        echo json_encode($info);exit;
    }
    elseif($_POST["type"]== "store")
    {
         $fen_companyid = $_POST["company"];
         $fen_companyid = $this->ajax_info->get_store($fen_companyid);

         echo json_encode($fen_companyid);
    }
}

public function post_curl()
{
	$this->load->model('flow_block/flow_info_model', 'curl');
	$type = $this->input->get("att");//不同类型的select
	$page= $this->input->get("page");//页数++

	$row = $this->curl->get_pram($page,$type);
	if($row)
	{
		$data = $this->curl->handle_json($row,$type);
		echo json_encode($data);
	}
}


public function month_report()
{
    
    $this->load->model('report/day_report_model', 'day_report');
    $this->load->library('pagination');

    $info='';

    $staffinfo = $this->session->userdata("staffinfo");
    if($_GET['userid'])
    {
        $userid = $_GET['userid'];
        $username = $_GET['username'];
        $userpwd = $_GET['userpwd'];
        $usertype = $_GET['type'];
        $staffinfo = $this->day_report->get_staff_info($userid, $userpwd, $username);

        if (isset($staffinfo) && count($staffinfo)>0) {
            //print_r("setting session user!");
            $this->load->library('session');
            $this->session->set_userdata('staffinfo',$staffinfo);
            $this->session->set_userdata('type',$_GET['type']);
        }
    }

    if($_GET['storeid'])
    {
        $config = array();
        $config['per_page']    = 10;         //每页显示的数据数
        $current_page          = intval($this->input->get('per_page'));  //获取当前分页页码数

        if(!$current_page)
        {
           $current_page = 1;
        }

        $offset  = ($current_page - 1) * $config['per_page'];
        $data    = $this->day_report->rm_store_day($offset,$config['per_page'],'rm_store_day'); 
        $info['query'] = $data['info'];
        $config['base_url']       =$this->config->item('base_url').'index.php/Report/day_report?brand='.$_GET['brand'].'&company='.$_GET['company'].'&city='.$_GET['city'].'&storeid='.$_GET['storeid'].'&date_start='.$_GET['date_start'].'&date_end='.$_GET['date_end'].'&infotype='.$_GET['infotype'];
        $config['prev_link'] = '上一页';
        $config['next_link']  = '下一页';
        $config['total_rows']   = $data['num'];         //获取查询数据的总记录数
        $config['cur_tag_open'] = ' <a href="" class="active">'; // 当前页开始样式  
        $config['cur_tag_close'] = '</a>';

        //默认分页URL中是显示每页记录数,启用use_page_numbers后显示的是当前页码   
        $config['use_page_numbers'] = TRUE;        

        //把 $config['enable_query_strings'] 设置为TRUE，链接将自动地被用查询字符串（url中的参数）重写。 
        $config['page_query_string']= TRUE;                   
        $row = $this->pagination->initialize($config);  
        $info['page'] = $this->pagination->create_links();
    }
        
    $info['brand_id']  = $this->day_report->get_company($staffinfo->id);

    //分公司
    $tem_companyid = $info['brand_id'][0]->COMPANYID;
    $tem_parentid = $tem_companyid;
    if (isset($tem_parentid)) {
        $info['fen_company'] = $this->day_report->get_region($tem_parentid);
        $tem_companyid2 = $info['fen_company'][0]->COMPANYID;
        if (isset($tem_companyid2)) {
            $tem_parentid = $tem_companyid2;
        }
    }
    
    if (isset($tem_parentid)) {
       $info['quyu'] = $this->day_report->get_region($tem_parentid);
       $tem_companyid2 = $info['quyu'][0]->COMPANYID;
       if (isset($tem_companyid2)) {
            $tem_parentid = $tem_companyid2;
        }
    }
    
    $info['storeid'] =$this->day_report->get_store($tem_companyid);
    $this->load->view('viewheaders/charisma/header');
    $this->load->view('oa/charisma/dailyreport', $info);
    $this->load->view('viewfeet/charisma/foot', $info);

}
//员工业绩
public function achievement_report()
{
	$info='';
	$this->load->model('report/day_report_model', 'achievement_report');
	$this->load->library('pagination');
    if($_GET['userid'])
    {
        $userid = $_GET['userid'];
        $staffinfo = $this->achievement_report->get_staff_info($userid);
        $this->load->library('session');
        $this->session->set_userdata('staffinfo',$staffinfo);
        $this->session->set_userdata('type',$_GET['type']);
    }	

    if($_GET['storeid'])
    {
    $config = array();
    $config['per_page']    = 2;         //每页显示的数据数
    $current_page          = intval($this->input->get('per_page'));  //获取当前分页页码数
    if(!$current_page)
	{
	   $current_page = 1;
	}
	$offset   = ($current_page - 1) * $config['per_page'];
	$data = $this->achievement_report->rm_store_day($offset,$config['per_page'],'rm_staff_day','achieve'); 
	$info['query'] = $data['info'];
/*	$info['page_num']=ceil($data['num']/10);*/
	$config['base_url']       =$this->config->item('base_url').'index.php/Report/achievement_report?company='.$_GET['company'].'&city='.$_GET['city'].'&storeid='.$_GET['storeid'].'&date_start='.$_GET['date_start'].'&date_end='.$_GET['date_end'].'&infotype='.$_GET['infotype'].'&staffid='.$_GET['staffid'];
    $config['prev_link'] = '上一页';
    $config['next_link']  = '下一页';
    $config['total_rows']   = $data['num'];         //获取查询数据的总记录数
    $config['cur_tag_open'] = ' <a href="" class="active">'; // 当前页开始样式  
	$config['cur_tag_close'] = '</a>';
    $config['use_page_numbers'] = TRUE;            //默认分页URL中是显示每页记录数,启用use_page_numbers后显示的是当前页码
    $config['page_query_string']= TRUE;            //把 $config['enable_query_strings'] 设置为 TRUE，链接将自动地被用查询字符串（url中的参数）重写。        
    $row = $this->pagination->initialize($config);	
    $info['page'] = $this->pagination->create_links();
    }
    $info['brand_id']  = $this->achievement_report->get_company();
    $info['fen_company'] = $this->achievement_report->get_region($info['brand_id'][0]->COMPANYID);//分公司
    $info['quyu'] = $this->achievement_report->get_region($info['fen_company'][0]->COMPANYID);
 	$info['storeid']  = $this->achievement_report->get_store($info['quyu'][0]->COMPANYID);
	$this->load->view('viewheaders/charisma/header');
    $this->load->view('oa/charisma/employeeperformance', $info);
    $this->load->view('viewfeet/charisma/foot', $info);
}


}
?>