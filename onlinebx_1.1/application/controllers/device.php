<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device extends JR_Controller  
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
		if ($this->uri->segment(3) === FALSE)
		{
			$id = 0;
		}
		else
		{
			$id = $this->uri->segment(3);
		}

		return $id;
	}

	public function get_json_device_types()
	{
		$types = $this->db->get_where("device_class",array("parent_id"=>0))->result();
		/*
		types = [
			{
				id : 0,
				name : '电脑',
				brands :[
					{
						id:'1',
						name:'报修单'
					}
				]
			}
		];
		*/
		$json_types = "types = ["; 

		foreach($types as $type)
		{
			$json_types  .= "{id:$type->id,name:'$type->name',brands :[{id:'',name:'请选择'},";

			$brands = $this->db->get_where("device_class",array("parent_id"=>$type->id))->result();
			
			foreach($brands as $brand)
			{
				$json_types .= "{id:'$brand->id',name:'$brand->name'},";  
			} 

			$json_types = trim($json_types,",")."]";  
			$json_types .= "},";
		}
		
		$json_types = trim($json_types,",")."];";
		
		// print_r($json_types);
		return $json_types; 
	}

	public function  index()
	{
		$data['title'] = "在线报修系统--设备管理";
		$data['navigate_string'] = "设备管理"; 
		$total_count = $this->db->count_all_results("device");
		$page_size = 16; 
		$page_count = intval($total_count/$page_size) + 1;
		$current_page = $this->current_page();
		$pre_page = ($current_page - 1) < 1 ? 1 : ($current_page - 1);
		$next_page = ($current_page + 1) > $page_count ? $page_count : ($current_page + 1);
		
		$begin_index = ($current_page - 1) * $page_size;
		$sql = "select  * from device order by device.id desc limit $begin_index,$page_size";
		$query = $this->db->query($sql);
		$devices = $query->result();

		$device_data["devices"] = $devices;
		$device_data["current_page"] = $current_page;
		$device_data["pre_page"] = $pre_page;
		$device_data["next_page"] = $next_page;
		$device_data["page_count"] = $page_count;
		
		/*
		$this->load->vars($device_data);
		$content_html = $this->load->view('v_device','',true);

		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_device",$device_data,"v_adminlayout",$data);

	}


	public function get_customers()
	{
		$sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id WHERE r.type =1 and u.banned=0";
		$query =  $this->db->query($sql);
		$customs = $query->result();
		return $customs;
	}

	public function add()
	{
		$device_data = array(
			"action" => $this->get_root_url()."index.php/device/addpost",
			"json_device_classs" => $this->get_json_device_types(),
			"customs" => $this->get_customers(),
			"user"=>"",
			"number" => "",
			'type' => '',
			"brand" => "",
			"model" => "",
			"buy_date" => "",
			"company" => "",
			"count" => "",
			"user" => "",
			"profile" => "",
		);

		
		//$this->load->vars($device_data);
		//$this->load->view('v_device_form');
		

		$this->view("v_device_form",$device_data);

		// echo $this->html("v_device_form",$device_data);
	}

	public function addpost()
	{
		$data = array( 
			"role_id" => trim($this->input->post('role')),
			"controller" => trim($this->input->post('resource')),
			"action" => "index",
			'devicename' => trim($this->input->post('devicename')),
			'password' => trim($this->input->post('password')),
			'realname' => trim($this->input->post('realname')),
			"email" => trim($this->input->post('email')),
			"workphone" => trim($this->input->post('workphone')),
			"mobilephone" => trim($this->input->post('mobilephone')),
			"company" => trim($this->input->post('company')),
			"department" =>  trim($this->input->post('department')),
			"workaddress" => trim($this->input->post('workaddress')),
			"work_addr_province" => trim($this->input->post('work_addr_province')),
			"work_addr_city" => trim($this->input->post('work_addr_city')),
			"work_addr_detail" => trim($this->input->post('work_addr_detail')),
			"banned" => trim($this->input->post('banned')),
			"ban_reason" => trim($this->input->post('ban_reason')),
			"last_ip" => $_SERVER["REMOTE_ADDR"]
		);

		// email ^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+
		if (!preg_match("^[a-zA-Z0-9]{1,25}$",$data["devicename"]))
		{ 
              echo "登录名由英文和数字组成的,不超过25";
			  exit;
	    }

		if (!preg_match("^[^\s]+$",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }

		if (!preg_match("^[^\s]+$",$data["password"]))
		{ 
              echo "密码的长度必须大于1";
			  exit;
	    }

		if($data["password"]!= $this->input->post('confirmpassword'))
		{
			echo "两次输入的密码不相同";
			exit;
		}

		/*
		if($data["workphone"] != "" && !(preg_match("^(\d{3}-\d{8})|(\d{4}-\d{7})$",$data["workphone"])))
		{
			echo "电话格式不对";
			exit;
		}

		if(!(preg_match("^\d{3}-\d{8}|\d{4}-\d{7}$",$data["workphone"]) || preg_match("^\d{11}|\d{12}$",$data["mobilephone"])))
		{
			echo "工作电话和手机至少一个不为空\r\n 电话: 0555-12345678 \r\n手机:13912345678";
			exit;
		}
		*/

		$data["password"] = md5($data["password"]);

		$query = $this->db->insert("device",$data);
		if($query == 1)
		{
			echo "success";
		}
		else
		{
			echo $query;
		}
	}

	public function edit()
	{
		$id = $this->id();

		$query = $this->db->get_where('device', array('id' => $id));
		$device = $query->row();
		
		/*
		echo $this->get_json_roles()."<br>";
		echo $device->id."<br>";
		echo $device->devicename."<br>";
		echo $device->role_id;
		
		exit; 
		*/ 
		//print_r($roles);
		$device_data = array(
			'json_roles' => $this->get_json_roles(),
			"action" => $this->get_root_url()."index.php/device/editpost/".$id, 
			"role_id" => $device->role_id,
			"controller" => $device->controller, 
			"devicename" => $device->devicename,
			"realname" => $device->realname,
			"password" =>  "",
			"confirmpassword" => "",
			"email" => $device->email,
			"workphone" => $device->workphone,
			"mobilephone" => $device->mobilephone,
			"company" => $device->company,
			"department" => $device->department,
			"workaddress" => $device->workaddress,
			"work_addr_province" =>$device->work_addr_province,
			"work_addr_city" => $device->work_addr_city,
			"work_addr_detail" => $device->work_addr_detail,
			"banned" => $device->banned,
			"ban_reason" => $device->ban_reason,
		);

		//$this->load->vars($data);
		//$this->load->view('v_device_form');

		$this->view("v_device_form",$device_data);
	}

	public function editpost()
	{
		$id = $this->id();
		
		if($id == 18) 
		{
			echo "试用版,不允许操作"; 
			return;
		}
		  
		//echo $id;
		//exit;
		$data = array( 
			"role_id" => trim($this->input->post('role')),
			"controller" => trim($this->input->post('resource')),
			"action" => "index", 
			'devicename' => trim($this->input->post('devicename')),
			'realname' => trim($this->input->post('realname')),
			"email" => trim($this->input->post('email')),
			"workphone" => trim($this->input->post('workphone')),
			"mobilephone" => trim($this->input->post('mobilephone')),
			"company" => trim($this->input->post('company')),
			"department" => trim($this->input->post('department')),
			"workaddress" => trim($this->input->post('workaddress')),
			"work_addr_province" => trim($this->input->post('work_addr_province')),
			"work_addr_city" => trim($this->input->post('work_addr_city')),
			"work_addr_detail" => trim($this->input->post('work_addr_detail')),
			"banned" => trim($this->input->post('banned')),
			"ban_reason" => trim($this->input->post('ban_reason')),
			"last_ip" => $_SERVER["REMOTE_ADDR"]
		);

		if (!preg_match("^[a-zA-Z0-9]{1,25}$",$data["devicename"]))
		{ 
              echo "登录名由英文和数字组成的,不超过25";
			  exit;
	    }

		if (!preg_match("^[^\s]+$",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }


		if($this->input->post('password')!="")
		{
			if($this->input->post('password')!= $this->input->post('confirmpassword'))
			{
				echo "两次输入的密码不相同";
				exit;
			}
			
			$data['password'] =  md5($this->input->post('password'));
		}

		$query = $this->db->update("device",$data, array('id' => $id)); 

	
		if($query == 1)
		{
			echo "success";
		}
		else
		{
			echo $query;
		}
	}

	public function delete()
	{
		$id = $this->id();
		
		if($id == 18) 
		{
			echo "试用版,不允许操作";
			return;
		}
		
		$pre_page_uri = $_SERVER["HTTP_REFERER"];
		
		$this->db->trans_start();
		
		// 如果报修单只分配给了这一个工程师,将 把 报修单的状态改成未分配.
		$sql = "
UPDATE bxsheet b SET b.status =  0 WHERE b.id IN
( 
	SELECT bxsheet_id FROM assignwork WHERE device_id= $id
)
AND b.status = 1 AND ((SELECT COUNT(*) FROM assignwork a WHERE  a.bxsheet_id = b.id) = 1)
		"; 
		$this->db->query($sql);
		$this->db->delete('assignwork',array('device_id'=>$id));
		
		$this->db->delete('device', array('id' => $id)); 
		$this->db->trans_complete();
		
		if($this->db->trans_status()=== true)
		{
			redirect($pre_page_uri);
		} 
		else
		{
			echo "出现错误";      
		}
		//echo $id;
	}


	
}