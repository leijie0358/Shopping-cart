<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Database extends JR_Controller 
{
	public function index()
	{
		$error = $this->session->flashdata('error');
		
		$data['title'] = "在线报修系统--数据库管理";
		$data['navigate_string'] = "数据库管理";

		$this->view("v_database",array('error'=>$error),"v_adminlayout",$data);
	}
	
	public function optimize_table($tablename)
	{
		$result = $this->dbutil->optimize_table($tablename); 
		if ($result)
		{
			return  "<tr><td>$tablename</td><td>优化成功</td></tr>" ; 
		}
		else
		{
			return "<tr><td>$tablename</td><td>优化失败</td></tr>"; 
		}
	}

	public function optimize()
	{
		$this->load->dbutil() ;
		$db_content = "<table wdith=100%><tr><td>表</td><td>结果</td></tr>";

		$db_content .= $this->optimize_table('assessment_class');
		$db_content .= $this->optimize_table('assignwork');
		$db_content .= $this->optimize_table('bxsheet');
		$db_content .= $this->optimize_table('bxsheet_class');
		$db_content .= $this->optimize_table('permission');
		$db_content .= $this->optimize_table('resource');
		$db_content .= $this->optimize_table('role');
		$db_content .= $this->optimize_table('user');

		$db_content .= "</table>" ; 
		$db_data['db_content'] = $db_content; 

		//$this->load->vars($db_data);
		//$this->load->view('v_database_optimize');

		$this->view("v_database_optimize",$db_data);
	}

	
	function backup()
	{
		$database_backup_data = array(
			"action" =>  $this->get_root_url()."index.php/database/backuppost",
			"backup_file_name" => date("YmdHi") 
		);  

		$this->view("v_database_backup",$database_backup_data);
	}

	function backuppost()
	{
		$backup_file_name = trim($this->input->post("backup_file_name"))  ; 

		if( $backup_file_name == "")
		{
			$data['title'] = "在线报修系统--数据库管理"; 
			$this->view(
				"v_database",
				array('error'=>'备份文件名称没有填写'),
				"v_adminlayout",
				$data
			);
			exit ;
		}

		// 加载数据库工具类
		$this->load->dbutil();

		$prefs = array(
			//'tables'      => array('table1', 'table2'),  // 包含了需备份的表名的数组.
			'ignore'      => array(),           // 备份时需要被忽略的表
			'format'      => 'txt',             // gzip, zip, txt
			'filename'    => $backup_file_name.'.sql',    // 文件名 - 如果选择了ZIP压缩,此项就是必需的
			'add_drop'    => TRUE,              // 是否要在备份文件中添加 DROP TABLE 语句
			'add_insert'  => TRUE,              // 是否要在备份文件中添加 INSERT 语句
			'newline'     => "\n"               // 备份文件中的换行符
		);
              
		// 备份整个数据库并将其赋值给一个变量 
		$backup =& $this->dbutil->backup($prefs);     

		// 加载文件辅助函数并将文件写入你的服务器
		$this->load->helper('file');
		write_file(BASEPATH.'db_backup/'.$backup_file_name.".sql", $backup); 

		// echo BASEPATH.'db_backup/'.$backup_file_name;

		if($this->input->post("is_backup_to_local")!="")
		{
			// 加载下载辅助函数并将文件发送到你的桌面
			$this->load->helper('download');
			force_download($backup_file_name.".sql", $backup);
		}

		$this->session->set_flashdata('error',"数据备份成功");
		
		redirect($this->get_root_url()."index.php/database/index");		
	}


	public function restore()
	{
		$this->load->helper('directory');
		$files = directory_map('./system/db_backup/',1);
		
		rsort($files);  
		
		$tmparr  = array();
		$index = 0;
		foreach ($files as $file)
		{
			$index ++ ;
			array_push($tmparr, $file);
			if($index>10) break;
		}
		//print_r($files);
		
		$database_backup_data = array(
			"action" =>  $this->get_root_url()."index.php/database/restorepost",
			"files" => $tmparr 
		);  

		$this->view("v_database_restore",$database_backup_data); 
	}
	
	public function restorepost()
	{
		$filename = $this->input->post("filename");
		$localfilename = "";
		if(array_key_exists("localfilename", $_FILES))
		{
			$localfilename = $_FILES["localfilename"]["tmp_name"];
		}
		
		$sql = "";
		
		if($localfilename!="")
		{
			$sql = read_file($localfilename);
		}
		else if($filename!="")
		{
			$sql = read_file(BASEPATH.'db_backup/'.$filename);
		}
		
		$error = "";
		
		if($sql!="")
		{
			//$sql = "SET NAMES utf8; \r\n".$sql;
			//$sql = iconv('utf-8', 'gb2312', $sql);
			$sql = str_replace("\r\n", "", $sql);
			$sql = str_replace("\r", "", $sql);
			$sql = str_replace("\n", "", $sql);
			$sql = str_replace("\s", "", $sql);
			
			$sqls = explode(";", $sql);
			
			$this->db->trans_start();
			
			foreach($sqls as $key=>$value)
			{
				$sql = "";
				if(substr($value, 0,2) == "##")
				{
					$sql = str_replace('#', '', strstr($value, "#DROP TABLE")) ;
				}
				else 
				{
					$sql = $value; 	
				}
				
				if(trim($sql)!="")
				{
					$this->db->query($sql);
				} 
			}
			//$this->db->query("set names utf8");
			//$this->db->query($sql);
			$this->db->trans_complete();

			if($this->db->trans_status()=== true)
			{
		    	$error = "成功恢复";
			}
			else {
				$error = "恢复失败";
			}
			//$error = mb_detect_encoding($sql); 
			//$error = $sql;
		
		}
		else 
		{
			$error = "错误:没有选择任何备份数据";            
		}
		
		$this->session->set_flashdata('error',$error);
		
		redirect($this->get_root_url()."index.php/database/index");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */