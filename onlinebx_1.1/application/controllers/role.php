<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends JR_Controller
{
	public $arr_permissions = array();

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
		$data['title'] = "在线报修系统--角色管理";
		$data['navigate_string'] = "角色管理";

		$sql = "select  * from role order by id desc";
		$query = $this->db->query($sql);
		$roles = $query->result();
		$role_data["roles"] = $roles;

		/*
		$this->load->vars($role_data);
		$content_html = $this->load->view('v_role','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_role",$role_data,'v_adminlayout',$data);
	}

	public function add()
	{
		//print_r($roles);
		$data = array(
			"action" => $this->get_root_url()."index.php/role/addpost",
			"type" => "", 
			"name" => "",
			"profile" => "",
		);

		//$this->load->vars($data);
		//$this->load->view('v_role_form');

		$this->view("v_role_form",$data);
	}

	public function addpost()
	{
		$data = array( 
			"name" => trim($this->input->post('name')),
			'profile' => trim($this->input->post('profile')),
			'type' => trim($this->input->post('type')),
		);

		// email ^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+
		/*
		if (!preg_match("^[^\s]+$",$data["name"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/
	
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

		$query = $this->db->insert("role",$data);
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

		$query = $this->db->get_where('role', array('id' => $id));
		$roles = $query->result();
		if(count($roles) == 1)
		{
			$role = $roles[0];
		}

		//print_r($roles);
		$data = array(
			"action" => $this->get_root_url()."index.php/role/editpost/".$id,
			"name" => $role->name,
			"profile" => $role->profile, 
			"type" => $role->type
		);

		//$this->load->vars($data);
		//$this->load->view('v_role_form');

		$this->view("v_role_form",$data);
	}

	public function editpost()
	{
		$id = $this->id();

		if($id == 1)
		{
			echo "试用版,不允许操作";
			return;
		}
		//echo $id;
		//exit;
		$data = array( 
			"name" => trim($this->input->post('name')), 
			'profile' => trim($this->input->post('profile')),
			'type' => trim($this->input->post('type')),
		);

		/*
		if (!preg_match("^[^\s]+$",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/

		$query = $this->db->update("role",$data, array('id' => $id)); 

	
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
		if($id == 1)
		{
			echo "试用版,不允许操作"; 
			return;
		}
		
		$id = $this->id(); 

		$this->load->database();
		$this->db->delete('role', array('id' => $id)); 
		redirect( $this->get_root_url()."index.php/role/index");
		//echo $id; 
	}


	// 是否授权
	public function isAuth($resource_id,$action)
	{
		$actionpermission = array();

		$sql = "select * from permission where resource_id=" . $resource_id . " and role_id=" . $this->id();
		$query = $this->db->query($sql);
		$permissions = $query->result();
		if(!array_key_exists($resource_id,$this->arr_permissions))
		{
			foreach($permissions as $permission)
			{
				$actionpermission[$permission->action] = $permission->denied;
			}
			$this->arr_permissions[$resource_id] = $actionpermission;
		}

		if(!array_key_exists($action,$this->arr_permissions[$resource_id]) )
		{
			return false;
		}

		if($this->arr_permissions[$resource_id][$action] == 1 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function permission()
	{
		$role_id = $this->id(); 
		
		$query = $this->db->get_where("resource",array("parent_id" => 0));
		$top_resources = $query->result();
		//print_r($top_resources);

		//exit;
		//print_r($roles);
		$data = array(
			"action" =>  $this->get_root_url()."index.php/role/permissionpost/".$role_id,
			"top_resources" => $top_resources,
			"role_id" => $role_id 
		);
		

		//$this->load->vars($data);
		//$this->load->view('v_permission_form');

		$this->view("v_permission_form",$data);
	}


	public function permissionpost()
	{
		$role_id = $this->id(); 

		$this->db->trans_start();
		$this->db->delete('permission', array('role_id' => $role_id)); 
		foreach($_POST as $key=>$value)
		{
			$arr =  explode('_',$key);
			$data = array(
				'resource_id' => $arr[0] ,
				'role_id' => $role_id,
				'actionname' => $arr[1],
				'denied' => 1
            );

			$this->db->insert('permission', $data); 
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo "错误";
		}
		else
		{
			$this->db->trans_commit();
			echo "success";
		}
	}
}