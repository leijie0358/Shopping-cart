<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends JR_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['title'] = "在线报修系统";
		$data['navigate_string'] = "系统设置"; 

		$sys = $this->config->item('sys');
		
		$error = $this->session->flashdata('error'); 
		
		$system_data = array(
			"action" =>  $this->get_root_url()."index.php/system/set",
			"error" => $error,
			"root_url" => $this->get_root_url(),
			"company_name" => $sys["company_name"],
			"company_addr_province" => $sys["company_addr_province"],
			"company_addr_city" => $sys["company_addr_city"],
			"company_addr_detail" => $sys["company_addr_detail"],
			// 纬度
			"lat" => $sys["lat"],
			// 经度        
			"lng" => $sys["lng"],       
			"company_transit_station" => $sys["company_transit_station"],
			"gmap_key" => $sys["gmap_key"],
			'prompt_type_email' => $sys["prompt_type_email"],
			'prompt_type_sms' => $sys["prompt_type_sms"],
			'prompt_type_audio' => $sys["prompt_type_audio"],
			"admin_email" => $sys["admin_email"],
			"admin_mobilephone" => $sys["admin_mobilephone"],  
			'prompt_audio_expression' => $sys["prompt_audio_expression"],
			'prompt_audio_expireduration' => $sys["prompt_audio_expireduration"],
		);

		/*
		$this->load->vars($system_data);  
		$content_html = $this->load->view('v_system_form','',true);
		$data['content'] = $content_html; 
		$this->load->vars($data); 
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_system_form",$system_data,'v_adminlayout',$data);
	}

	public function set()
	{
		//echo $this->input->post('company_name');
		//exit;
		
		$company_name = trim($this->input->post('company_name'));
		$company_name = str_replace("'","",$company_name); 
		$company_addr_province = trim($this->input->post('company_addr_province'));
		$company_addr_province = str_replace("'","",$company_addr_province);
		$company_addr_city = trim($this->input->post('company_addr_city'));
		$company_addr_city = str_replace("'","",$company_addr_city);
		$company_addr_detail = trim($this->input->post('company_addr_detail'));
		$company_addr_detail = str_replace("'","",$company_addr_detail);
		$lat = trim($this->input->post('lat'));
		$lat = str_replace("'","",$lat);
		$lng = trim($this->input->post('lng'));
		$lng = str_replace("'","",$lng);
		$company_transit_station = trim($this->input->post('company_transit_station')); 
		$company_transit_station = str_replace("'","",$company_transit_station);
		$gmap_key = trim($this->input->post('gmap_key')); 
		$company_transit_station = str_replace("'","",$company_transit_station);
		
		$prompt_type_email = $this->input->post('prompt_type_email')==""?"false":"true"; 
		$prompt_type_sms = $this->input->post('prompt_type_sms')==""?"false":"true"; 
		$prompt_type_audio = $this->input->post('prompt_type_audio')==""?"false":"true"; 
		$admin_email = trim($this->input->post('admin_email'));
		$admin_email = str_replace("'","",$admin_email);
		$admin_mobilephone = trim($this->input->post('admin_mobilephone'));
		$admin_mobilephone = str_replace("'","",$admin_mobilephone);
		$prompt_audio_expression = trim($this->input->post('prompt_audio_expression'));
		$prompt_audio_expression = str_replace("'","",$prompt_audio_expression);
		$prompt_audio_expireduration = trim($this->input->post('prompt_audio_expireduration'));
		$prompt_audio_expireduration = str_replace("'","",$prompt_audio_expireduration);

		 
		
		$config  =  "<?\r\n\$config['sys'] = array(\r\n";
		$config .=  "'company_name' => '$company_name',\r\n";
		$config .=  "'company_addr_province' => '$company_addr_province',\r\n";
		$config .=  "'company_addr_city' => '$company_addr_city',\r\n";
		$config .=  "'company_addr_detail' => '$company_addr_detail',\r\n";
		$config .=  "'lat' => '$lat',\r\n";
		$config .=  "'lng' => '$lng',\r\n";
		$config .=  "'company_transit_station' => '$company_transit_station',\r\n";
		$config .=  "'gmap_key' => '$gmap_key',\r\n";
		$config .=  "'prompt_type_email' => $prompt_type_email,\r\n";
		$config .=  "'prompt_type_sms' => $prompt_type_sms,\r\n";
		$config .=  "'prompt_type_audio' => $prompt_type_audio,\r\n";
		$config .=  "'admin_email' => '$admin_email',\r\n";
		$config .=  "'admin_mobilephone' => '$admin_mobilephone',\r\n"; 
		$config .=  "'prompt_audio_expression' => '$prompt_audio_expression',\r\n";  
		$config .=  "'prompt_audio_expireduration' => '$prompt_audio_expireduration',\r\n";  
		$config .=  ");\r\n?>";
		$config_file_path = str_replace("system/", "", BASEPATH)."application/config/sys.php";
		//echo $config_file_path;
		//exit;
		write_file($config_file_path,$config); 
		
		$this->session->set_flashdata('error',"修改成功");
		
		redirect($this->get_root_url()."index.php/system/index"); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */