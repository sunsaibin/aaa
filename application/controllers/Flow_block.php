<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_block extends CI_Controller {
	public function index()
	{
		echo "200";
	}

	public function process_templet_list()
	{
		//$this->load->library('curl_librarie');
        //$this->load->model('flow_block/flow_block_model', 'flowBlock');
        $data = array();
        $this->load->view('viewheaders/header_1', $data);
        $this->load->view('flow_block/flow_template_view', $data);
        $this->load->view('viewfeet/foot_no_border', $data);
	}

	public function form_design()
	{
		$data = array();
        $this->load->view('viewheaders/header_no_border', $data);
        $this->load->view('flow_block/flow_template_design_form_view', $data);
        $this->load->view('viewfeet/foot_no_border', $data);
	}

	public function form_design_data()
	{
		$this->load->model('flow_block/flow_block_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_block();
		$data["message"] = "";
		$this->load->view('json/json_query_view', $data);
	}

	//创建流程(修改)
	public function json_flow()
	{
		$this->load->model('flow_block/flow_block_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flow();
		$data["message"] = "";
		$this->load->view('json/json_query_view', $data);
	}


	//创建步骤(修改)
	public function flow_list()
	{
		$this->load->model('flow_block/flow_block_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flow();
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_list', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	public function flow_add_form()
	{
		$this->load->model('flow_block/flow_block_model', 'flowBlock');

		$name = $this->input->post("name");
		$company = $this->input->post("company");
		$query = $this->flowBlock->get_flow_name($name, $company);

		$data = array();
		if (count($query) > 0) {
			$data["query"] = null;
			$data["message"] = "流程名称不能重复!";
		}
		else{

			$effect = $this->flowBlock->add_flow();
			$data["query"] = $effect;
			$data["message"] = "添加成功!";

			if ($effect < 1) {
				$data["query"] = null;
				$data["message"] = "添加失败!";
			}
		}
		$this->load->view('json/json_query_view', $data);
	}

	public function flow_edit()
	{
		$this->load->model('flow_block/flow_block_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flow();
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/test_2', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//子流程
	public function flow_flow_flowstep()
	{
		$this->load->model('flow_block/flow_flowstep_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flow_flowstep();
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_flowstep_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//触发条件
	public function flow_trigger($ff_id)
	{
		$this->load->model('flow_block/flow_flowstep_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flow_trigger($ff_id);
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_triger_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	// public function flow_step_list($flowstep_id)
	// {
	// 	$this->load->model('flow_block/flow_block_model', 'flowBlock');
	// 	$data["query"] = $this->flowBlock->get_flow_step_list($flowstep_id);
	// 	$data["message"] = "";

	// 	$this->load->view('viewheaders/charisma/header', $data);
 //        $this->load->view('flow_block/charisma/flow_step_list_view', $data);
 //        $this->load->view('viewfeet/charisma/foot', $data);
	// }

	public function flow_flowstep($flowstep_id)
	{  
		$this->load->model('flow_block/flow_flowstep_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_flowstep_list($flowstep_id);
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_flowstep_flowstep_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//执行管理
	public function flow_carry($ffs_id)
	{
		$this->load->model('flow_block/flow_flowstep_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_carry($ffs_id);
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_flowstep_carry_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//创建表单(修改)
	public function flow_form()
	{
		$this->load->model('flow_block/flow_flowstep_model', 'flowBlock');
		$data["query"] = $this->flowBlock->get_carry($ffs_id);
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_form_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}


	//创建表单元素权限


	
	//申请流程(查找符合自己的流程)
	public function user_flow()
	{
		$data = array();
        $this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('flow_block/charisma/flow_list', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}


	public function post_url()
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


		
/*		echo $data;*/
	}
//关联店铺员工角色接口
	public function role_url()
	{
		$this->load->model('flow_block/flow_info_model', 'geturl');
		$storeid = $this->input->get("selectid");//不同类型的select
		$type = $this->input->get("attr");
		$row = $this->geturl->get_pram($storeid,$type);
		print_r($row);exit;
   		if($row)
   		{	
     		$data =  $this->geturl->handle_json($row,$type); 			
   		}else{
   			echo 2;exit;
   		}

		echo json_encode($data);
	}
	//流程审核步骤记录

	//流程表单填写步骤记录


}


/*

INSERT INTO `yqapp13`.`fw_formitems` (`formitems_id`, `formitems_name`, `formitems_company`, `formitems_valuetype`, `formitems_value_scope`, `formitems_need`, `formitemscdate`) VALUES (NULL, '请假开始日期', '1', '1', '/\\d{4}-\\d{2}-\\d{2}\\s+\\d{2}:\\d{2}/', '0', CURRENT_TIMESTAMP);

*/
?>