<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wxsheet extends JR_Controller  
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
		$data['title'] = "在线报修系统-检修单管理";
		$data['navigate_string'] = "检修单管理";
		
		$user = $this->session->userdata["user"];

		$sql = 
			"select *,bsc.name as bxsheet_class,bs.id as id  from bxsheet bs left join bxsheet_class bsc on bs.bxsheet_class_id = bsc.id where bs.status > 0";

		// 假如是工程师,为了其操作方便,只列出分配给他的单子,其他人员,可查看全部 
		if($user->role_type == 2) 
		{
			 $sql.= " and (select count(id) from assignwork aw where user_id=".$user->id." and bxsheet_id=bs.id)>0 ";
		}

		
		// 假如是客户就只能查看属于他的单子 
		if($user->role_type == 1) 
		{
			 $sql.= " and bs.custom_id=".$user->id;
		}

		$sql  .= "  order by bs.id desc";

		// echo $sql;

		$query = $this->db->query($sql);
		$total_count = $query->num_rows();
		$page_size = 30; 
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
			"current_page" => $current_page,    
			"page_count" => $page_count,
			"page" => $this->current_page(),
			"issetdownable" => $this->isauth("wxsheet","setdown"),
			"isshowable" => $this->isauth("wxsheet","show"),
		);
 
		/*
		$this->load->vars($bxsheet_data);
		$content_html = $this->load->view('v_wxsheet','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/
		$this->view("v_wxsheet",$bxsheet_data,'v_adminlayout',$data);
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

	public function setdown()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];
		
		$sql = "select *,u.id as id from user u left join role r on u.role_id = r.id where r.type=2";
		$query =  $this->db->query($sql);
		$engineers = $query->result();

		$engineer_names = $this->get_engineer_names($this->id());
	

		// echo $bxsheet->wx_time;

		$wx_time = $bxsheet->wx_time == "0000-00-00 00:00:00"?date('Y-m-d H:i'):$bxsheet->wx_time;
		$ys_time = $bxsheet->ys_time == "0000-00-00 00:00:00"?date('Y-m-d H:i'):$bxsheet->ys_time;		
		$booking_time = $bxsheet->booking_time == "0000-00-00 00:00:00" ? "" : $bxsheet->booking_time;

		$data = array(
			"action" =>  $this->get_root_url()."index.php/wxsheet/setdownpost/".$this->id(),
			"number" => $bxsheet->number,
			"model"=>"",
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
			"booking_time" =>  $booking_time,
			"engineer_names" => $engineer_names,
			"wx_date" => date('Y-m-d',strtotime($wx_time)),
			"wx_hour" => date('H',strtotime($wx_time)),
			"wx_minute" => date('i',strtotime($wx_time)), 
			"ys_date" => date('Y-m-d',strtotime($ys_time)),
			"ys_hour" => date('H',strtotime($ys_time)),
			"ys_minute" => date('i',strtotime($ys_time)), 			
			"fault_reason" =>  $bxsheet->fault_reason,  // 故障原因 
			"wx_profile" =>  $bxsheet->wx_profile,  //维修情况
			"accepter" =>  $bxsheet->accepter,
			"inspection" =>  $bxsheet->inspection,
			"wx_fee" =>  $bxsheet->wx_fee,  // 维修费
			"status" =>  $bxsheet->status,  // 状态 
			"id" => $bxsheet->id ,
		);

		//$this->load->vars($data);
		//$this->load->view('v_wxsheet_form'); 

		$this->view("v_wxsheet_form",$data);
	}

	public function setdownpost()
	{
		$data = array(
			"wx_time" => trim($this->input->post("wx_date"))." ".
						 trim($this->input->post("wx_hour")).":".
						 trim($this->input->post("wx_minute")),	
			"ys_time" => trim($this->input->post("ys_date"))." ".
						 trim($this->input->post("ys_hour")).":".
						 trim($this->input->post("ys_minute")),			
			"fault_reason" => trim($this->input->post("fault_reason")),
			"wx_profile" => trim($this->input->post("wx_profile")),
			"accepter" => trim($this->input->post("accepter")),
			"inspection" => trim($this->input->post("inspection")),
			"wx_fee" => trim($this->input->post("wx_fee")),
			"status" => trim($this->input->post("status"))
		);
		
		// print_r($data);
		// exit;
		if (!preg_match("^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$",$data["wx_time"]))
		{ 
              echo "维修时间格式不正确,正确时间格式为 2011-05-06 12:32"; 
			  exit;
	    }
		if (!preg_match("^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$",$data["ys_time"]))
		{ 
              echo "验收时间格式不正确,正确时间格式为 2011-05-06 12:32"; 
			  exit;
	    }
		if(empty($data['fault_reason']))
		{
			echo "故障原因不能为空";
			exit;
		}

		if(empty($data['wx_profile']))
		{
			echo "维修情况不能为空";
			exit;
		}

		if (!preg_match("^[0-9][0-9]*(\.[0-9]+){0,1}$",$data["wx_fee"]))
		{ 
              echo "维修费必须为数字 例如 200  100.23";
			  exit;
	    }

		$bxsheet_id = $this->id(); 

		$this->db->update("bxsheet",$data,array("id"=>$bxsheet_id)); 

		echo "success";
	}

	public function get_show_html()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];
		
		$engineer_names = $this->get_engineer_names($this->id());

		$wx_time = "";
		$ys_time = "";
		$booking_time="";
		if($bxsheet->wx_time != "0000-00-00 00:00:00")
		{
			$wx_time = $bxsheet->wx_time;
		}
		if($bxsheet->ys_time != "0000-00-00 00:00:00")
		{
			$ys_time = $bxsheet->ys_time;
		}
		if($bxsheet->booking_time != "0000-00-00 00:00:00")
		{
			$booking_time = $bxsheet->booking_time;
		}

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
			"booking_time" =>  $booking_time,
			"engineer_names" => $engineer_names, 
			"wx_time" => $wx_time , 
			"ys_time" => $ys_time ,  
			"fault_reason" =>  $bxsheet->fault_reason,  // 故障原因 
			"wx_profile" =>  $bxsheet->wx_profile,  //维修情况
			"accepter" =>  $bxsheet->accepter,
			"inspection" =>  $bxsheet->inspection,
			"wx_fee" =>  $bxsheet->wx_fee,  // 维修费
			"status" =>  $bxsheet->status,  // 状态 
			"id" => $bxsheet->id    
		);

		//$this->load->vars($data);
		//return $this->load->view('v_wxsheet_show','',true);
		return $this->html("v_wxsheet_show",$data);
	}

	public function show()
	{
		echo $this->get_show_html(); 
	}

	public function iprint()
	{
		$tablebody = $this->get_show_html(); 

		$data["title"] = "打印";
		$data["tableheader"] = "检修单";
		$data["tablebody"] = $tablebody;
		
		//$this->load->vars($data); 
		//$this->load->view('v_printlayout');

		return $this->view("v_printlayout",$data);
	}
}