<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bxsheet_class  extends JR_Controller
{
	
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
		$data['title'] = "在线报修系统--报修类别管理";
		$data['navigate_string'] = "报修类别管理";

		$sql = "select  * from bxsheet_class order by id desc";
		$query = $this->db->query($sql);
		$bxsheet_classs = $query->result();
		$bxsheet_class_data["bxsheet_classs"] = $bxsheet_classs;

		/*
		$this->load->vars($bxsheet_class_data);
		$content_html = $this->load->view('v_bxsheet_class','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_bxsheet_class",$bxsheet_class_data,"v_adminlayout",$data);
	}

	public function add()
	{
		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet_class/addpost",
			"name" => "",
			"profile" => "",
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_class_form');

		$this->view("v_bxsheet_class_form",$data);
	}

	public function addpost()
	{
		$data = array( 
			"name" => trim($this->input->post('name')),
			"profile" => trim($this->input->post('profile')),
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
		
		// print_r($data);
		// exit;
		$query = $this->db->insert("bxsheet_class",$data);
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

		$query = $this->db->get_where('bxsheet_class', array('id' => $id));
		$bxsheet_classs = $query->result();
		if(count($bxsheet_classs) == 1)
		{
			$bxsheet_class = $bxsheet_classs[0];
		}

		//print_r($bxsheet_classs);
		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet_class/editpost/".$id,
			"name" => $bxsheet_class->name,
			"profile" => $bxsheet_class->profile, 
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_class_form');

		$this->view("v_bxsheet_class_form",$data);
	}

	public function editpost()
	{
		$id = $this->id();

		//echo $id;
		//exit;
		$data = array( 
			"name" => trim($this->input->post('name')), 
			'profile' => trim($this->input->post('profile'))
		);

		/*
		if (!preg_match("^[^\s]+$",$data["realname"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/

		$query = $this->db->update("bxsheet_class",$data, array('id' => $id)); 

	
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

		$this->load->database();
		$this->db->delete('bxsheet_class', array('id' => $id)); 
		redirect($this->get_root_url()."index.php/bxsheet_class/index");
		//echo $id;
	}
}