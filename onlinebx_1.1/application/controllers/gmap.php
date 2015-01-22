<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gmap extends JR_Controller {

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
		$data['title'] = "在线报修系统--googlemap";
		$data['navigate_string'] = "Google地图";

		/*
		$content_html = $this->load->view('v_welcome','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$sql = "SELECT u.id as id,realname,company FROM USER u 
				LEFT JOIN role r ON u.role_id = r.id 
				WHERE r.type =1";

		$query =  $this->db->query($sql);
		$customs = $query->result();
		
		$sys = $this->config->item('sys'); 

		$action = $this->get_root_url()."index.php/gmap/mark";
		$this->view("v_gmap",array(
			'customs'=>$customs,
			'action'=>$action,
			'root_url'=>$this->get_root_url(),
			'gmap_key'=> $sys["gmap_key"],
			'lat' =>  empty($sys["lat"])?"39.99135":$sys["lat"],
			'lng' =>  empty($sys["lng"])?"116.514066":$sys["lng"]
			),'v_adminlayout',$data);
	}

	public function mark()
	{
		$data = array( 
			"user_id" => trim($this->input->post('user_id')),
			"lat" => trim($this->input->post('lat')),
			"lng" => trim($this->input->post('lng')),
			"title" => trim($this->input->post('title')),
			"profile" => trim($this->input->post('profile')),
			"transit_station" => trim($this->input->post('transit_station')) 
		);

		if(empty($data["title"]))
		{
			echo "标注标题不能为空";
			exit;
		}
		// email ^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+
		/*
		if (!preg_match("^[^\s]+$",$data["name"]))
		{ 
              echo "姓名不能为空";
			  exit;
	    }
		*/

		$query = $this->db->insert("latlng",$data);

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
		$pre_page_uri = $this->get_root_url().str_replace('-','/',$this->uri->segment(4)); 

		$pre_page_uri = $this->get_root_url()."index.php/gmap/index";

		$id = $this->id();
		
		$this->db->trans_start();
		$this->db->delete('latlng', array('id' => $id)); 

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo "错误";
		}
		else
		{
			$this->db->trans_commit();
			redirect($pre_page_uri); 
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */ 