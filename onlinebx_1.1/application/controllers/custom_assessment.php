<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_assessment extends JR_Controller  
{
	public function current_page()
	{
		if ($this->uri->segment(3) === FALSE || $this->uri->segment(3)<1)
		{
			$page = 1;
		}
		else
		{
			$page = $this->uri->segment(3);
		} 

		return $page;
	}
 
	public function id()
	{
		if ($this->uri->segment(3) === FALSE || $this->uri->segment(3)<1)
		{
			$id = 1;
		}
		else
		{
			$id = $this->uri->segment(3);
		}

		return $id ; 
	}

	public function index()
	{
		$data['title'] = "在线报修系统--客户评价";
		$data['navigate_string'] = "客户评价管理"; 

		$user = $this->session->userdata["user"];

		$sql = "select *,bsc.name as bxsheet_class,bs.id as id, ac.name as assessment_class_name 
		from bxsheet bs 
		left join bxsheet_class bsc on bs.bxsheet_class_id = bsc.id 
		left join assessment_class ac on bs.assessment_class_id = ac.id 
		where bs.status > 1";  // 只有 2 未完成 3 已完成才能评价  

		// 假如是客户,只能对客户是自己的单子进行操作 
		if($user->role_type == 1) 
		{
			 $sql.= " and custom_id=" . $user->id;
		}

		$sql  .= "  order by bs.id desc";

		// echo $sql;

		$query = $this->db->query($sql);
		$total_count = $query->num_rows();
		$page_size = 10; 
		$page_count = intval($total_count/$page_size) + 1;
		$current_page = $this->current_page();
		$pre_page = ($current_page - 1) < 1 ? 1 : ($current_page - 1);
		$next_page = ($current_page + 1) > $page_count ? $page_count : ($current_page + 1);
		
		$begin_index = ($current_page - 1) * $page_size;
		$sql .= " limit  $begin_index,$page_size";
	
		$query = $this->db->query($sql);

		$bxsheets = $query->result();
		$bxsheet_data = array(
			"bxsheets" => $bxsheets,
			"pre_page" => $pre_page,
			"next_page" => $next_page,
			"page_count" => $page_count,
			"current_page" =>  $current_page,
			"page" => $this->current_page(),
			"isassessmentable" => $this->isauth("custom_assessment","assessment"), 
			"isshowable" => $this->isauth("custom_assessment","show"),
		);
 
		/*
		$this->load->vars($bxsheet_data);
		$content_html = $this->load->view('v_custom_assessment','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_custom_assessment",$bxsheet_data,"v_adminlayout",$data);
	}

	
	public function delete()
	{
		$pre_page_uri = $_SERVER["HTTP_REFERER"];
		$id = $this->id();
		// echo $id." ".$pre_page_uri;
		// exit;
		$this->db->delete('bxsheet', array('id' => $id)); 
		redirect($pre_page_uri);  
		//echo $id;
	}

	public function get_engineer_names($bxsheet_id)
	{
		$engineer_names = "";
		$sql = "select u.realname as value from assignwork aw left join user u on aw.user_id = u.id where bxsheet_id=".$this->id();
		//echo $sql;
		//exit;
		$query = $this->db->query($sql);
		$engineer_namess = $query->result();
		//print_r($engineer_idss);
		foreach($engineer_namess as $engineer_name)
		{
			$engineer_names .= $engineer_name->value."&nbsp;";
		}
		return $engineer_names;
	}

	public function assessment()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0]; 
		
		$sql = "select *,u.id as id from user u left join role r on u.role_id = r.id where r.type=2";
		$query =  $this->db->query($sql);
		$engineers = $query->result();

		$engineer_names = $this->get_engineer_names($this->id());
	
		$wx_time = $bxsheet->wx_time == "0000-00-00 00:00:00" ? date('Y-m-d H:i') : $bxsheet->wx_time;
		$ys_time = $bxsheet->ys_time == "0000-00-00 00:00:00" ? date('Y-m-d H:i') : $bxsheet->ys_time;		
		$booking_time = $bxsheet->booking_time == "0000-00-00 00:00:00" ? "" : $bxsheet->booking_time;

		$query = $this->db->get("assessment_class");
		$assessment_classs = $query->result();

		//print_r($assessment_classs);
		//exit;

		$data = array(
			"action" =>  $this->get_root_url()."index.php/custom_assessment/assessmentpost/".$this->id(),
			"number" => $bxsheet->number,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_time_begin" =>  $bxsheet->hope_wx_time_begin,
			"hope_wx_time_end" =>   $bxsheet->hope_wx_time_end, 
			"bx_time" =>   $bxsheet->bx_time, 
			"bxsheet_class_name" =>  $bxsheet->bxsheet_class_name,
			"fault_title" =>  $bxsheet->fault_title,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model,
			"booking_time" => $booking_time,
			"engineer_names" => $engineer_names,
			"wx_time" => $wx_time,
			"ys_time" => $ys_time,
			"fault_reason" =>  $bxsheet->fault_reason,  // 故障原因 
			"wx_profile" =>  $bxsheet->wx_profile,  //维修情况
			"inspection" =>  $bxsheet->inspection,
			"accepter" =>  $bxsheet->accepter,
			"wx_fee" =>  $bxsheet->wx_fee,  // 维修费
			"assessment_classs" => $assessment_classs,
			"assessment_class_id" =>  $bxsheet->assessment_class_id,  // 评价内容
			"assessment_content" =>  $bxsheet->assessment_content,  // 评价内容
			"status" =>  $bxsheet->status,  // 状态 
			"id" => $bxsheet->id ,
		);

		//$this->load->vars($data);
		//$this->load->view('v_custom_assessment_form'); 

		$this->view("v_custom_assessment_form",$data);
	}

	public function assessmentpost() 
	{
		$data = array(
			"assessment_class_id" => trim($this->input->post("assessment_class_id")),
			"assessment_content" => trim($this->input->post("assessment_content"))
		);
		
		//print_r($data);
		//exit;

		$bxsheet_id = $this->id(); 

		$this->db->update("bxsheet",$data,array("id"=>$bxsheet_id)); 

		echo "success";
	}


	public function get_show_html()
	{
		$sql = "select *,bc.name as bxsheet_class_name , ac.name as assessment_name 
		from bxsheet b 
		left join bxsheet_class bc on b.bxsheet_class_id = bc.id 
		left join assessment_class ac on b.assessment_class_id = ac.id 
		where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];
		
		$engineer_names = $this->get_engineer_names($this->id());

		$wx_time = "";
		if($bxsheet->wx_time != "0000-00-00 00:00:00")
		{
			$wx_time = $bxsheet->wx_time;
		}
		$ys_time = "";
		if($bxsheet->ys_time != "0000-00-00 00:00:00")
		{
			$ys_time = $bxsheet->ys_time;
		}
		$booking_time = $bxsheet->booking_time == "0000-00-00 00:00:00" ?"" : $bxsheet->booking_time;

		$data = array(
			"number" => $bxsheet->number,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"bx_time" =>  $bxsheet->bx_time,
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_time_begin" =>  $bxsheet->hope_wx_time_begin,
			"hope_wx_time_end" =>   $bxsheet->hope_wx_time_end, 
			"bxsheet_class_name" =>  $bxsheet->bxsheet_class_name,
			"fault_title" =>  $bxsheet->fault_title,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model,
			"booking_time" => $booking_time ,  
			"engineer_names" => $engineer_names, 
			"wx_time" => $wx_time , 
			"ys_time" => $ys_time ,  
			"fault_reason" =>  $bxsheet->fault_reason,  // 故障原因 
			"wx_profile" =>  $bxsheet->wx_profile,  //维修情况
			"inspection" =>  $bxsheet->inspection,
			"accepter" =>  $bxsheet->accepter,
			"wx_fee" =>  $bxsheet->wx_fee,  // 维修费
			"assessment_name" => $bxsheet->assessment_name,
			"assessment_content" => $bxsheet->assessment_content, 
			"status" =>  $bxsheet->status,  // 状态 
			"id" => $bxsheet->id    
		);

		//$this->load->vars($data);
		//return $this->load->view('v_custom_assessment_show','',true);

		return $this->html('v_custom_assessment_show',$data);
	}

	public function show()
	{
		echo $this->get_show_html(); 
	}

	public function iprint()
	{
		$tablebody = $this->get_show_html();

		$data["title"] = "打印";
		$data["tableheader"] = "报修单";
		$data["tablebody"] = $tablebody;
		
		//$this->load->vars($data); 
		//$this->load->view('v_printlayout');

		$this->view('v_printlayout',$data);
	}
}