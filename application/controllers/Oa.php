<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oa extends CI_Controller {

	public function index()
	{
		/*$this->load->view('oa/oaform');*/
	}

	//创建流程
	public function oa_user_flow()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$this->load->model('flow_block/Flow_info_model','curl');
		$arr['userid'] = $_GET['userid'];
/*		$t_session = null;
		if (in_array("userinfo", $_SESSION)) {
			$t_session = $_SESSION['userinfo'];
		}*/

/*		if(!isset($t_session) or $t_session->staffId != $arr['userid']){
			$userinfo = $this->curl->get_pram($arr["userid"],'userinfo');
			$userinfo =json_decode($userinfo);
			$this->load->library('session');
			if($userinfo)
			{
			$this->session->set_userdata('userinfo',$userinfo->data->staff);
			}else{
			$this->session->set_userdata('userid',$_GET['userid']);
			}


		}*/
		$this->load->library('session');
		$this->session->set_userdata('userid',$_GET['userid']);
		$this->session->set_userdata('type',$_GET['type']);
		$data["query"] = $this->oaFlowBlock->get_user_flow();
		$data["info"] = $this->oaFlowBlock->get_form_value();
		$data["user_haveflows"] = $this->oaFlowBlock->get_user_have_flows();
		$data["message"] = "";
		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_useflowlist_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//仓储审核
	public function warehouse_audit()
	{
		$this->load->model('oa/Oa_flow_model', 'audit_creat');
		$userid =isset($_REQUEST['userid'])?$_REQUEST['userid']:'';
		$orderid =isset($_REQUEST['numberid'])?$_REQUEST['numberid']:'';//订单号码
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$info = isset($_REQUEST['info'])?$_REQUEST['info']:'';
		$warehouse =$this->audit_creat->warehouse_audit($orderid,$userid,$id,$type,$info,'11');
		$data = array();
		if($warehouse)
		{
			$data['code'] = '1';
			$data['msg'] = '操作成功';
		}else{
			$data['code'] = '2';
			$data['msg'] = '操作失败';
		}
			echo json_encode($data);
	}

	//挂失卡审核

	public function usercard_audit()
	{
		$this->load->model('oa/Oa_flow_model', 'audit_creat');
		$userid =isset($_REQUEST['userid'])?$_REQUEST['userid']:'';
		$cardid =isset($_REQUEST['numberid'])?$_REQUEST['numberid']:'';//卡号
		$info =isset($_REQUEST['username'])?$_REQUEST['username']:'';//持卡人
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$warehouse =$this->audit_creat->warehouse_audit($cardid,$userid,$cardid,$type,$info,'12');
		$data = array();
		if($warehouse)
		{
			$data['code'] = '1';
			$data['msg'] = '操作成功';
		}else{

			$data['code'] = '2';
			$data['msg'] = '操作失败';
		}
			echo json_encode($data);					
	}

	public function oa_user_flowstep()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["query"] = $this->oaFlowBlock->get_user_flowstep();
		$data["message"] = "";

		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_useflowsteplist_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}
	
	public function oa_user_flowform()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["query"] = $this->oaFlowBlock->get_flow_form();
		$data["message"] = "";
		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_flowform_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}

	//撤销申请
	public function oa_user_unset()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data = $this->oaFlowBlock->set_userunset_form();
		if($data)
		{	
			echo "<script type='application/javascript'>
			alert('操作成功')
			</script>";	
			redirect('oa/oa_user_flow?userid='.$_SESSION["userid"],'location');
			
		}else{
			echo "<script type='application/javascript'>
			alert('操作失败')
			</script>";		
		}	

	}




	public function oa_form()
	{
		$userid = $this->input->post("userid");
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
/*		$this->load->model('oa/Do_file_model', 'upfile');*/
		$fileinfo =$this->oaFlowBlock->do_file(); 
		if(!$fileinfo)
		{
			$fileinfo = '';
		}
		$data["query"] = $this->oaFlowBlock->set_flow_form($fileinfo);
		$data["message"] = "";

 		redirect('oa/oa_user_flow?userid='.$userid);

/*		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_form', $data);
        $this->load->view('viewfeet/charisma/foot', $data);*/
	}

	public function json_oa_form_data()
	{
		echo '{"items":}';
	}


	//待审核
	public function oa_user_approval()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');

		$this->load->model('flow_block/Flow_info_model','curl');
		$arr["userid"] = $_GET['userid'];
/*		$t_session = null;
		if (in_array("userinfo", $_SESSION)) {
			$t_session = $_SESSION['userinfo'];
		}

		if(!isset($t_session) or $t_session->staffId != $arr['userid']){
			$userinfo = $this->curl->get_pram($arr["userid"],'userinfo');
			$userinfo =json_decode($userinfo);
			$this->load->library('session');
			if($userinfo->data)
			{
		
			$this->session->set_userdata('userinfo',$userinfo->data->staff);
			}else{

			$this->session->set_userdata('userid',$_GET['userid']);
			}


		}*/

/*		$userinfo = $this->curl->get_pram($arr["userid"],'userinfo');
		$userinfo =json_decode($userinfo);

		$this->load->library('session');

		$this->session->set_userdata('userinfo',$userinfo->data->staff);*/
		$this->load->library('session');
		$this->session->set_userdata('userid',$_GET['userid']);
		$this->session->set_userdata('pass',$_GET['pass']);
		$this->session->set_userdata('type',$_GET['type']);


		$data["query"] = $this->oaFlowBlock->get_user_approval();
		$data["message"] = "";
		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_approval_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);
	}
//审核步骤
	public function get_user_li()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFunc');
		$data["info"] = $this->oaFunc->get_user_li();
		$this->load->view('viewheaders/charisma/header', $data);
        $this->load->view('oa/charisma/oa_userprovelist_view', $data);
        $this->load->view('viewfeet/charisma/foot', $data);		
	}
//表单模板数据
	public function oa_user_approval_form()
	{
		$id = $this->input->get("id");
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["info"] = $this->oaFlowBlock->get_user_li();//步骤列表
		$data["query"] = $this->oaFlowBlock->get_user_approval_form();
		$data["querydata"] = $this->oaFlowBlock->get_user_approval_formdata();
/*		print_r($data["querydata"]);exit;*/
		$data["allkey"] = $this->oaFlowBlock->get_user_approval_info($id);
		$data["queryflowstep"] = $this->oaFlowBlock->get_user_approval_flowstep();
		$data["user_flow"] = $this->oaFlowBlock->get_flow($id);
		$data["message"] = "";
		$this->load->view('viewheaders/charisma/header', $data);
		if(isset($data["queryflowstep"]) && $data["queryflowstep"]->fau_userid == $_SESSION["userid"])
		{
			$this->load->view('oa/charisma/oa_auditing_view', $data);
		}
		$this->load->view('oa/charisma/oa_userprovelist_view', $data);

        $this->load->view('viewfeet/charisma/foot', $data);
	}

	public function oa_auditing_form()
	{

		$adid = $this->input->post("adid");//流程号
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["query"] = $this->oaFlowBlock->set_user_auditing_form();
		$data["message"] = "";
/*		if(!$data["query"])
		{
			$type = "-1";//流程结束不显示
		}else{
			$type = "1";
		}*/
		redirect('oa/oa_user_approval_form?id='.$_GET['id'].'&userid='.$_SESSION["userid"]);

	}
	//查看表单步骤
	public function oa_list_form()
	{
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["query"] = $this->oaFlowBlock->get_userftep();
		$data["querydata"] = $this->oaFlowBlock->get_user_approval_info();
		$data["queryflowstep"] = $this->oaFlowBlock->get_user_flowstep_entity();
		$this->load->view('viewheaders/charisma/header', $data);
		$this->load->view('oa/charisma/oa_approval_form_view', $data);
		$this->load->view('viewfeet/charisma/foot', $data);		
	}

		public function oa_list_form_approve()
	{
		$id = $this->input->get("tid");
		$this->load->model('oa/Oa_flow_model', 'oaFlowBlock');
		$data["query"] = $this->oaFlowBlock->get_userftep();
		$data["approval_info"] = $this->oaFlowBlock->get_oa_approval_rec_key();
		$data["querydata"] = $this->oaFlowBlock->get_user_approval_info();
		$data["queryflowstep"] = $this->oaFlowBlock->get_user_flowstep_entity();
		$data["user_flow"] = $this->oaFlowBlock->get_flow($id);
 		$this->load->view('viewheaders/charisma/header', $data);
		$this->load->view('oa/charisma/oa_approve_new_from', $data);
		$this->load->view('viewfeet/charisma/foot', $data);		
	}


	//data
	public function oa_input_data()
	{
		echo '[{"title":"Text Input","fields":{"id":{"label":"yonghuming","type":"input","value":"textinput"},"label":{"label":"Label Text","type":"input","value":"Text Input"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Password Input","fields":{"id":{"label":"ID / Name","type":"input","value":"passwordinput"},"label":{"label":"Label Text","type":"input","value":"Password Input"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}}]';
		//echo '[{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"textinput"},"label":{"label":"Label Text","type":"input","value":"Text Input"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Password Input","fields":{"id":{"label":"ID / Name","type":"input","value":"passwordinput"},"label":{"label":"Label Text","type":"input","value":"Password Input"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Search Input","fields":{"id":{"label":"ID / Name","type":"input","value":"searchinput"},"label":{"label":"Label Text","type":"input","value":"Search Input"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Prepended Text","fields":{"id":{"label":"ID / Name","type":"input","value":"prependedtext"},"label":{"label":"Label Text","type":"input","value":"Prepended Text"},"prepend":{"label":"Prepend","type":"input","value":"prepend"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Appended Text","fields":{"id":{"label":"ID / Name","type":"input","value":"appendedtext"},"label":{"label":"Label Text","type":"input","value":"Appended Text"},"append":{"label":"Append","type":"input","value":"append"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Prepended Checkbox","fields":{"id":{"label":"ID / Name","type":"input","value":"prependedcheckbox"},"label":{"label":"Label Text","type":"input","value":"Prepended Checkbox"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"checked":{"label":"Checked","type":"checkbox","value":false},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Appended Checkbox","fields":{"id":{"label":"ID / Name","type":"input","value":"appendedcheckbox"},"label":{"label":"Label Text","type":"input","value":"Appended Checkbox"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"help"},"checked":{"label":"Checked","type":"checkbox","value":false},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Button Drop Down","fields":{"id":{"label":"ID / Name","type":"input","value":"buttondropdown"},"label":{"label":"Label Text","type":"input","value":"Button Drop Down"},"placeholder":{"label":"Placeholder","type":"input","value":"placeholder"},"buttontext":{"label":"Button Text","type":"input","value":"Action"},"buttonoptions":{"label":"Options","type":"textarea-split","value":["Option one","Option two","Option three"]},"required":{"label":"Required","type":"checkbox","value":false},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","label":"Mini","selected":false},{"value":"input-small","label":"Small","selected":false},{"value":"input-medium","label":"Medium","selected":false},{"value":"input-large","label":"Large","selected":false},{"value":"input-xlarge","label":"Xlarge","selected":true},{"value":"input-xxlarge","label":"Xxlarge","selected":false}]}}},{"title":"Text Area","fields":{"id":{"label":"ID / Name","type":"input","value":"textarea"},"label":{"label":"Label Text","type":"input","value":"Text Area"},"textarea":{"label":"Starting Text","type":"textarea","value":"default text"}}}]';
	}

	public function staff_ajax()
	{
		$idcard = $this->input->post("idcard");
		$this->load->model('oa/Oa_flow_model', 'ajax');
		$value = $this->ajax->staff_ajax($idcard);
		echo json_encode($value);
	}

	public function info_ajax()
	{
		$this->load->model('oa/Oa_flow_model', 'ajax');
/*		$this->load->model('report/day_report_model', 'ajax_info');*/

		if($_POST["type"] == "positioninfo")
		{
			$value = $this->ajax->get_position();

		}
		if($_POST["type"] == "storeinfo")
		{
			$companyid = $_POST['companyid'];
			$value = $this->ajax->get_storeinfo($companyid);
		}
		if($_POST["type"] == "companyinfo")
		{
			$value = $this->ajax->get_companyinfo();
		}
		    echo json_encode($value);exit;
	}

	//http://www.bootcss.com/p/bootstrap-form-builder/
	//表单流程设计
	//1 请假单 1 NULL NULL 2016-05-31 16:11:55
}
?>