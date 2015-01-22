<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oray extends JR_Controller {

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

	public function index()
	{
		$data['title'] = "在线报修系统-向日葵远程控制";
		$data['navigate_string'] = "向日葵远程控制";

		$sql = "select  * from oray order by id desc";
		$query = $this->db->query($sql);
		$orays = $query->result();
		$oray_data["orays"] = $orays;


		$this->view("v_oray",$oray_data,'v_adminlayout',$data);

		// $this->view("v_oray",array('html'=>$html),'v_adminlayout',$data);
	}

	public function add()
	{
		//print_r($orays);
		$data = array(
			"action" => $this->get_root_url()."index.php/oray/addpost",
			"username" => "", 
			"password" => "",
			"profile" => "",
		);

		//$this->load->vars($data);
		//$this->load->view('v_oray_form');

		$this->view("v_oray_form",$data);
	}

	public function addpost()
	{
		// echo "abc";
		// exit;
		$data = array( 
			"username" => trim($this->input->post('username')),
			'password' => trim($this->input->post('password')),
			'profile' => trim($this->input->post('profile')),
		);
		
		// print_r($data);
		// exit;

		/*
		if (!preg_match("^[^\s]+$",$data["name"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/

		if(empty($data["username"]))
		{
			echo "用户名不能为空";
			exit;
		}
		if(empty($data["password"]))
		{
			echo "密码不能为空";
			exit;
		}

		$query = $this->db->insert("oray",$data);

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

		$query = $this->db->get_where('oray', array('id' => $id));
		$oray = $query->row();


		//print_r($roles);
		$data = array(
			"action" => $this->get_root_url()."index.php/oray/editpost/".$id,
			"username" => $oray->username,
			"password" => $oray->password, 
			"profile" => $oray->profile
		);

		//$this->load->vars($data);
		//$this->load->view('v_role_form');

		$this->view("v_oray_form",$data);
	}

	public function editpost()
	{
		$id = $this->id();

		//echo $id;
		//exit;
		$data = array( 
			"username" => trim($this->input->post('username')),
			'password' => trim($this->input->post('password')),
			'profile' => trim($this->input->post('profile')),
		);

		/*
		if (!preg_match("^[^\s]+$",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/

		$query = $this->db->update("oray",$data, array('id' => $id)); 

	
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

		$this->db->delete('oray', array('id' => $id)); 
		redirect( $this->get_root_url()."index.php/oray/index");
		//echo $id; 
	}

	
	public function autologin()
	{
		$id = $this->id();

		$query = $this->db->get_where('oray', array('id' => $id));
		$oray = $query->row();

		$data = array(
			"root_url" => $this->get_root_url(),
			"id" => $id,
			"username" => $oray->username,
			"password" => $oray->password, 
			"profile" => $oray->profile
		);
		$this->view("v_oray_autologin",$data); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */