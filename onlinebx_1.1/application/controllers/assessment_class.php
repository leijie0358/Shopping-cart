<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assessment_class  extends JR_Controller
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
		$data['title'] = "在线报修系统--评价类别管理";
		$data['navigate_string'] = "评价类别管理";

		$sql = "select  * from assessment_class order by id desc";
		$query = $this->db->query($sql);
		$assessment_classs = $query->result();
		$assessment_class_data["assessment_classs"] = $assessment_classs;
		$this->load->vars($assessment_class_data);
		$content_html = $this->load->view('v_assessment_class','',true);
		//$data['content'] = $content_html;
		//$this->load->vars($data);
		//$this->load->view('v_adminlayout');
		$this->view("v_assessment_class",$assessment_class_data,"v_adminlayout",$data);
	}

	public function add()
	{
		//print_r($appraise_classs);
		$assessment_class_data = array(
			"action" => $this->get_root_url()."index.php/assessment_class/addpost",
			"name" => "",
			"profile" => "",
		);

		//$this->load->vars($data);
		//$this->load->view('v_assessment_class_form');

		$this->view("v_assessment_class_form",$assessment_class_data);
	}

	public function addpost()
	{
		$data = array( 
			"name" => trim($this->input->post('name')),
			'profile' => trim($this->input->post('profile')),
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

		$query = $this->db->insert("assessment_class",$data);
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

		$query = $this->db->get_where('assessment_class', array('id' => $id));
		$appraise_classs = $query->result();
		if(count($appraise_classs) == 1)
		{
			$assessment_class = $appraise_classs[0];
		}

		//print_r($appraise_classs);
		$assessment_class_data = array(
			"action" => $this->get_root_url()."index.php/assessment_class/editpost/".$id,
			"name" => $assessment_class->name,
			"profile" => $assessment_class->profile, 
		);

		//$this->load->vars($data);
		//$this->load->view('v_assessment_class_form');

		$this->view("v_assessment_class_form",$assessment_class_data);
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

		$query = $this->db->update("assessment_class",$data, array('id' => $id)); 

	
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
		$this->db->delete('assessment_class', array('id' => $id)); 
		redirect($this->get_root_url()."index.php/assessment_class/index");
		//echo $id;
	}
}