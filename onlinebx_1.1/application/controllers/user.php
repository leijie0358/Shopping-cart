<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends JR_Controller 
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

	public function  index()
	{
		$data['title'] = "在线报修系统--用户管理";
		$data['navigate_string'] = "用户管理";
		$this->load->database();
		$total_count = $this->db->count_all_results("user");
		$page_size = 16; 
		$page_count = intval($total_count/$page_size) + 1;
		$current_page = $this->current_page();
		$pre_page = ($current_page - 1) < 1 ? 1 : ($current_page - 1);
		$next_page = ($current_page + 1) > $page_count ? $page_count : ($current_page + 1);
		
		$begin_index = ($current_page - 1) * $page_size;
		$sql = "select  *,user.id as userid,role.id as roleid,role.name as rolename,role.profile as roleprofile from user left join role on user.role_id = role.id order by user.id desc limit $begin_index,$page_size";
		$query = $this->db->query($sql);
		$users = $query->result();

		$user_data["users"] = $users;
		$user_data["current_page"] = $current_page;
		$user_data["pre_page"] = $pre_page;
		$user_data["next_page"] = $next_page;
		$user_data["page_count"] = $page_count;
		
		/*
		$this->load->vars($user_data);
		$content_html = $this->load->view('v_user','',true);

		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_user",$user_data,"v_adminlayout",$data);

	}

	public function get_json_roles()
	{
		$roles = $this->db->get("role")->result();
		/*
		role = [
			{
				id : 0,
				name : '角色名',
				resources :[
					{
						name:'bxsheet',
						chinesename:'报修单'
					}
				]
			}
		];
		*/
		$json_roles = "roles = ["; 

		foreach($roles as $role)
		{
			$json_roles  .= "{id:$role->id,name:'$role->name',resources :[{name:'welcome',chinesename:'欢迎界面'},";

			$sql = "SELECT res.id as id,res.name as name,res.chinesename AS chinesename FROM permission p 
					LEFT JOIN resource res ON p.resource_id = res.id
					LEFT JOIN role r ON p.role_id = r.id
					WHERE p.actionname = 'index' and  r.id=" . $role->id;
			
			$results = $this->db->query($sql)->result();
			
			foreach($results as $result)
			{
				$json_roles .= "{name:'$result->name',chinesename:'$result->chinesename'},"; 
			}
			$json_roles = trim($json_roles,",")."]";  
			$json_roles .= "},";
		}
		
		$json_roles = trim($json_roles,",")."];";
		
		return $json_roles; 
	}

	public function add()
	{
		$user_data = array(
			'json_roles' => $this->get_json_roles(),
			"action" => $this->get_root_url()."index.php/user/addpost",
			"role_id" => "",
			'controller' => '',
			"username" => "",
			"realname" => "",
			"password" => "",
			"confirmpassword" => "",
			"email" => "",
			"workphone" => "",
			"mobilephone" => "",
			"company" => "",
			"department" => "",
			"workaddress" => "",
			"work_addr_province" => "",
			"work_addr_city" => "",
			"work_addr_detail" => "",
			"banned" => "0",
			"ban_reason" => "", 
		);

		
		//$this->load->vars($user_data);
		//$this->load->view('v_user_form');
		

		$this->view("v_user_form",$user_data);
	}

	public function addpost()
	{
		$data = array( 
			"role_id" => trim($this->input->post('role')),
			"controller" => trim($this->input->post('resource')),
			"action" => "index",
			'username' => trim($this->input->post('username')),
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
		if (!preg_match("/^[a-zA-Z0-9]{1,25}$/i",$data["username"]))
		{ 
              echo "登录名由英文和数字组成的,不超过25";
			  exit;
	    }

		if (!preg_match("/^[^\s]+$/i",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }

		if (!preg_match("/^[^\s]+$/i",$data["password"]))
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

		$query = $this->db->insert("user",$data);
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

		$query = $this->db->get_where('user', array('id' => $id));
		$user = $query->row();
		
		/*
		echo $this->get_json_roles()."<br>";
		echo $user->id."<br>";
		echo $user->username."<br>";
		echo $user->role_id;
		
		exit; 
		*/ 
		//print_r($roles);
		$user_data = array(
			'json_roles' => $this->get_json_roles(),
			"action" => $this->get_root_url()."index.php/user/editpost/".$id, 
			"role_id" => $user->role_id,
			"controller" => $user->controller, 
			"username" => $user->username,
			"realname" => $user->realname,
			"password" =>  "",
			"confirmpassword" => "",
			"email" => $user->email,
			"workphone" => $user->workphone,
			"mobilephone" => $user->mobilephone,
			"company" => $user->company,
			"department" => $user->department,
			"workaddress" => $user->workaddress,
			"work_addr_province" =>$user->work_addr_province,
			"work_addr_city" => $user->work_addr_city,
			"work_addr_detail" => $user->work_addr_detail,
			"banned" => $user->banned,
			"ban_reason" => $user->ban_reason,
		);

		//$this->load->vars($data);
		//$this->load->view('v_user_form');

		$this->view("v_user_form",$user_data);
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
			'username' => trim($this->input->post('username')),
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

		if (!preg_match("^[a-zA-Z0-9]{1,25}$",$data["username"]))
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

		$query = $this->db->update("user",$data, array('id' => $id)); 

	
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
	SELECT bxsheet_id FROM assignwork WHERE user_id= $id
)
AND b.status = 1 AND ((SELECT COUNT(*) FROM assignwork a WHERE  a.bxsheet_id = b.id) = 1)
		"; 
		$this->db->query($sql);
		$this->db->delete('assignwork',array('user_id'=>$id));
		
		$this->db->delete('user', array('id' => $id)); 
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

	public function login()
	{	
		// $this->load->view('welcome_message');
		$data['title'] = "在线报修系统-登录";
		//$this->load->vars($data);
		//$this->load->view('v_login');
		$data['error'] = "&nbsp;";
		//$this->load->view('v_adminlayout');
		//$this->view("v_login",$data);
		//$this->view("v_adminlayout",$data);
		//$this->view("v_welcome",array(),'v_adminlayout',$data);
		redirect($this->get_root_url()."index.php/user/loginpost");
	}

	public function loginpost()
	{	
		$data = array(  
			'username' =>$this->input->post('username'),
			'authcode' => $this->input->post('authcode')
		);

		$sql = "select *,u.id as id,r.id as role_id,r.type as role_type,r.name as role_name from user u 
		left join role r on u.role_id = r.id";
//		where u.username='" . $_SESSION['phpCAS']['user'] ."'";

		$query = $this->db->query($sql);
		echo "<script>alert('".$query."');</script>";
		if ($query->num_rows() > 0)
		{
			//echo $data["authcode"] . "-" . $_SESSION['authcode'];
			//if($data["authcode"] == $_SESSION['authcode'])
			{
				$users = $query->result();
				$user = $users[0];
				// print_r($user);
				if($user->banned == 0)
				{	
					$this->session->set_userdata("user",$user);  
					
					if($this->input->post('db_grid_type')!=null)
					{
						$this->session->set_userdata("db_grid_type","datatable");
					}
					//echo $this->session->userdata("user");

					$controller = ($user->controller=="")?"welcome":$user->controller; 
					
					redirect($this->get_root_url()."index.php/$controller/index");    
				}
				else
				{
					$sys = $this->config->item('sys');
					$error = "<a href='mailto:".$sys['admin_email']."'>此用户已被禁用,点击联系管理员</a>";
				}
			}
			//else
			{
				//echo "验证码错误";
			}
		}
		else
		{
			$error =  "用户名或密码错误";
		}

		$data['title'] = "在线报修系统-登录";
		//$this->load->vars($data); 
		//$this->load->view('v_login');
		$data['error'] = $error; 
		$this->view("v_login",$data);
		
		//redirect($this->get_root_url()."index.php");
	}
	
	public function logout()
	{
		$this->session->sess_destroy();   
		redirect($this->get_root_url()."index.php/user/login"); 
//		redirect("?logout="); 
	}

	
	
	public function update_password()
	{
		$query = $this->db->get("role");
		$roles = $query->result();
		//print_r($roles);
		$user_data = array(
			"action" => $this->get_root_url()."index.php/user/update_password_post",
			"ori_password" => "",
			"password" => "",
			"confirm_password" => ""
		);

		$this->view("v_user_update_password_form",$user_data);
	}
	
	public function update_password_post()
	{
		$user = $this->session->userdata('user');
		
		$ori_password = trim($this->input->post('ori_password'));
		$password = trim($this->input->post('password'));
		$confirm_password = trim($this->input->post('confirm_password'));
		
		if(md5($ori_password)!= $user->password)
		{
			echo "原密码输入不正确";
			return;
		}
		
		if($password == "")
		{
			echo "密码不能为空";
			return;
		}
		
		if($password!= $confirm_password)
		{
			echo "两次密码输入不一样";
			return;
		}
		
		$this->db->update('user',array('password'=>md5($password)),array('id'=>$user->id));  
		
		$user->password = md5($password);
		
		$this->session->set_userdata('user',$user); 
		
		echo "success";
	}
}