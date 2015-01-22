<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends JR_Controller {

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
		
		/*
		$content_html = $this->load->view('v_welcome','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_welcome",array(),'v_adminlayout',$data);
	}

	public function help_download()
	{
		$this->view("v_help_download",array('root_url'=>$this->get_root_url()));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */