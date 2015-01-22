<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bxsheet extends JR_Controller 
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
		$data['title'] = "在线报修系统--报修单管理";
		$data['navigate_string'] = "报修单管理&nbsp;&nbsp;<a style='font-size:14px;color:red' href='" . JR_Controller::get_root_url() . "download/tts.zip'>下载报修语音提示系统</a>";
		
		$query =  $this->db->get("bxsheet_class");
		$bxsheet_classs = $query->result();
//		Bxsheet_class::index();
//		echo "hello".$this->bxsheet_classs;
		$sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id WHERE r.type =1 and u.banned=0";
		$query =  $this->db->query($sql);
		$customs = $query->result();

		$bxsheet_data = array(
			"page"=>$this->current_page(),
			"isaddable" => $this->isauth("bxsheet","add"),
			"customs" => $customs,
			"bxsheet_classs" => $bxsheet_classs,
			"searchaction" => $this->get_root_url()."index.php/bxsheet/search/".self::current_page()
		);
		/*
		$this->load->vars($bxsheet_data);
		$content_html = $this->load->view('v_bxsheet','',true);
		$data['content'] = $content_html;
		$this->load->vars($data);
		$this->load->view('v_adminlayout');
		*/

		$this->view("v_bxsheet",$bxsheet_data,"v_adminlayout",$data);
	}

	public function search()
	{
		if($this->id()=="clearsearch")
		{
			$this->session->set_userdata("searchcondition",null);
		}
		else
		{
			$this->session->set_userdata("searchcondition",
			array(
				"number" => trim($this->input->post("number")),
				"custom_id" => $this->input->post("custom_id"),
				"custom_company" => trim($this->input->post("custom_company")),
				"custom_name" => trim($this->input->post("custom_name")),
				"bxsheet_class_id" => $this->input->post("bxsheet_class_id"),
				"custom_workphone" => trim($this->input->post("custom_workphone")),
				"custom_mobilephone" => trim($this->input->post("custom_mobilephone")),
				"custom_addr" => trim($this->input->post("custom_addr")),
				"bx_time_begin" => trim($this->input->post("bx_time_begin")),
				"bx_time_end" => trim($this->input->post("bx_time_end")),
				"fault_title" => trim($this->input->post("fault_title")),
				"result" => trim($this->input->post("result")),	"supervisor" => trim($this->input->post("supervisor")),	
				"receiver" => trim($this->input->post("receiver")),	
				"service_person" => trim($this->input->post("service_person")),				
				"fault_profile" => trim($this->input->post("fault_profile")),
				"device_number" => trim($this->input->post("device_number")),
				"model" => trim($this->input->post("model"))
			));
		}

		$this->index();
	}

	public function datatable()
	{
	    //print_r($this->session->userdata("searchcondition")); 
		$user = $this->session->userdata("user"); 

		$sql = "select *,
		bsc.name as bxsheet_class,
		bs.id as id  
		from bxsheet bs 
		left join bxsheet_class bsc on bs.bxsheet_class_id = bsc.id 
		where bs.status < 2";   // 只能查看还没有派工以前的单子  

		// 假如是客户就只能查看属于他的单子 
		if($user->role_type == 1) 
		{
			 $sql.= " and bs.custom_id=".$user->id; 
		}

		if( $this->session->userdata("searchcondition") != null)
		{
			$searchcondition = $this->session->userdata("searchcondition");
			if(trim($searchcondition["number"])!="")
			{
				$sql.= " and bs.number like '%".$searchcondition["number"]."%'";
			}

			if($searchcondition["custom_id"]!="" && $searchcondition["custom_id"]!="0")
			{
				$sql.= " and bs.custom_id=".$searchcondition["custom_id"];
			}
		
		
			if(trim($searchcondition["custom_company"])!="")
			{
				$sql.= " and bs.custom_company like '%".$searchcondition["custom_company"]."%'";
			}

			
			if(trim($searchcondition["custom_name"])!="")
			{
				$sql.= " and bs.custom_name like '%".$searchcondition["custom_name"]."%'";
			}

			if($searchcondition["bxsheet_class_id"]!="" && $searchcondition["bxsheet_class_id"]!="0")
			{
				$sql.= " and bs.bxsheet_class_id=".$searchcondition["bxsheet_class_id"];
			}

			if(trim($searchcondition["custom_workphone"])!="")
			{
				$sql.= " and bs.custom_workphone = '".$searchcondition["custom_workphone"]."'";
			}

			
			if(trim($searchcondition["custom_mobilephone"])!="")
			{
				$sql.= " and bs.custom_mobilephone = '".$searchcondition["custom_mobilephone"]."'";
			}

			
			if(trim($searchcondition["custom_addr"])!="")
			{
				$sql.= " and concat(bs.custom_addr_province,bs.custom_addr_city,bs.custom_addr_detail) like '%".$searchcondition["custom_addr"]."%'";
			}
			
			if(trim($searchcondition["bx_time_begin"])!="" && trim($searchcondition["bx_time_end"])!="")
			{
				$sql.= " and bs.bx_time between '".$searchcondition["bx_time_begin"]." 00:00:00' and '".$searchcondition["bx_time_end"]." 23:59:59'";
			}
			else if(trim($searchcondition["bx_time_begin"])!="")
			{
				$sql.= " and bs.bx_time >= '".$searchcondition["bx_time_begin"]." 00:00:00'";
			}
			else if(trim($searchcondition["bx_time_end"])!="")
			{
				$sql.= " and bs.bx_time <= '".$searchcondition["bx_time_end"]." 23:59:59'";
			}

			
			if(trim($searchcondition["fault_title"])!="")
			{
				$sql.= " and bs.fault_title like '%".$searchcondition["fault_title"]."%'";
			}
			if(trim($searchcondition["service_person"])!="")
			{
				$sql.= " and bs.service_person like '%".$searchcondition["service_person"]."%'";
			}
			if(trim($searchcondition["supervisor"])!="")
			{
				$sql.= " and bs.supervisor like '%".$searchcondition["supervisor"]."%'";
			}			
			if(trim($searchcondition["fault_profile"])!="")
			{
				$sql.= " and bs.fault_profile like '%".$searchcondition["fault_profile"]."%'";
			}
			if(trim($searchcondition["result"])!="")
			{
				$sql.= " and bs.result like '%".$searchcondition["result"]."%'";
			}			if(trim($searchcondition["model"])!="")
			{
				$sql.= " and bs.model like '%".$searchcondition["model"]."%'";
			}	
			if(trim($searchcondition["device_number"])!="")
			{
				$sql.= " and bs.device_number like '%".$searchcondition["device_number"]."%'";
			}			
		}

		$sql .= " order by bs.id desc";
	
		// echo $sql;
		// exit;

		$query = $this->db->query($sql);
		$total_count = $query->num_rows();
		$page_size = 30;  
		$page_count = intval($total_count/$page_size) + 1;
		$current_page = $this->current_page();
		$pre_page = ($current_page - 1) < 1 ? 1 : ($current_page - 1);
		$next_page = ($current_page + 1) > $page_count ? $page_count : ($current_page + 1);
		
		$begin_index = ($current_page - 1) * $page_size;
		$sql .= " limit  $begin_index,$page_size";
		//echo $sql;

		//exit;

		$query = $this->db->query($sql);

		$bxsheets = $query->result();
		$data = array(
			"bxsheets" => $bxsheets,
			"pre_page" => $pre_page,
			"current_page" => $current_page, 
			"next_page" => $next_page,
			"page_count" => $page_count,
			"iseditable" => $this->isauth("bxsheet","edit"),
			"isdeleteable" => $this->isauth("bxsheet","delete"),
			"isshowable" => $this->isauth("bxsheet","show"),
			"isassigntaskable" => $this->isauth("bxsheet","assigntask"),
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_table');

		$this->view("v_bxsheet_table",$data);
	}

	public function build_bxsheet_number($bxsheet_class_id,$bxsheet_class_name)
	{
		$date_section = date("Ymd");
		$class_section = $this->get_pinyin_firstchar($bxsheet_class_name,true,"utf-8");
		$sql = "select number from bxsheet b where b.bxsheet_class_id=".$bxsheet_class_id." and DATE_FORMAT(create_time,'%Y%m%d')='".$date_section."' order by id desc limit  0,1";
		//echo $sql;
		//exit;
		$query = $this->db->query($sql);
		if($query->num_rows()==0)
		{
			$index = 1;
		}
		else
		{
			$number = $query->result();
			$number = $number[0];
			$index = intval(substr($number->number,-3,4))+1; 
		}
		//echo $index;
		//exit;
		$query = $this->db->get_where("bxsheet",array("bxsheet_class_id"=>$bxsheet_class_id,"DATE_FORMAT(create_time,'%Y%m%d')"=>$date_section));
		$count_section =  str_pad($index,4,'0',STR_PAD_LEFT);
		return $class_section.$date_section.$count_section;
	}

	public function outadd()
	{
		$query =  $this->db->get("bxsheet_class");
		$bxsheet_classs = $query->result();
		
		$sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id WHERE r.type =1 and u.banned=0";

		$query =  $this->db->query($sql);
		$customs = $query->result();
		//print_r($bxsheet_classs);
		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet/outaddpost",
			"is_show_number_row" => false,
			"number" => "",
			"customs" => $customs,
			"custom_id" => "" ,
			"model"=>"", 
			"device_number"=>"", 
			"custom_company" => "",
			"custom_name" => "",
			"bx_date" => date("Y-m-d"),
			"bx_hour" => date("H"),
			"bx_minute" => date("i"),
			"custom_addr_province" => "",
			"custom_addr_city" => "",
			"custom_addr_area" => "",
			"custom_addr_street" => "",
			"custom_addr_detail" => "",
			"custom_workphone" => "",
			"custom_mobilephone" => "",
			"hope_wx_date_begin" => "",
			"hope_wx_hour_begin" =>  "",
			"hope_wx_minute_begin" =>  "",
			"hope_wx_date_end" =>  "",
			"hope_wx_hour_end" =>  "",
			"hope_wx_minute_end" =>  "", 
			"bxsheet_classs" => $bxsheet_classs,
			"bxsheet_class_id" => "",
			"fault_title" => "",
			"result" => "",
			"service_person" => "",
			"receiver" => "",
			"fault_profile" => ""
		);

		$this->view('v_bxsheet_form',$data,'v_outlayout',array('root_url'=>$this->get_root_url()));
	}

	public function outaddpost()
	{
		$this->addpost() ;  
	}

	

	public function add()
	{
		/*
		$data["css"] = "
			<style>
				input {border:1px solid black}
			</style>
		";
		*/
	
		$sql = "select  * from bxsheet_class order by id desc";
		$query = $this->db->query($sql);
		$bxsheet_classs = $query->result();
//		print_r($bxsheet_classs);
		$sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id";

		$user = $this->session->userdata('user'); 
		// 假如是客户就只能查看属于他的单子 
		if($user->role_type == 1) 
		{
			 $sql.= " and u.id=".$user->id; 
		}

		$sql .= " and u.banned=0";

		// echo $sql;
		// exit;
		$query =  $this->db->query($sql);
		$customs = $query->result();
		
		//print_r($customs);
		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet/addpost",
			"is_show_number_row" => false,
			"number" => "",
			"customs" => $customs,
			"custom_id" => "" , 
			"model"=>"",
			"device_number"=>"",
			"custom_company" => "",
			"custom_name" => "",
			"bx_date" => date("Y-m-d"),
			"bx_hour" => date("H"),
			"bx_minute" => date("i"),
			"custom_addr_province" => "",
			"custom_addr_city" => "",
			"custom_addr_area" => "",
			"custom_addr_street" => "",
			"custom_addr_detail" => "",
			"custom_workphone" => "",
			"custom_mobilephone" => "",
			"hope_wx_date_begin" => "",
			"hope_wx_hour_begin" =>  "08",
			"hope_wx_minute_begin" =>  "",
			"hope_wx_date_end" =>  "",
			"hope_wx_hour_end" =>  "08", 
			"hope_wx_minute_end" =>  "", 
			"bxsheet_classs" => $bxsheet_classs,
			"bxsheet_class_id" => "",
			"fault_title" => "",
			"receiver" => "",
			"result" => "",
			"supervisor" => "",
			"service_person" => "",
			"fault_profile" => "",
			"title"=>"添加报修单"
		);

		//echo $this->get_root_url()."index.php/bxsheet/addpost";
		//exit;
		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_form');
		$this->postmail();
		$this->view("v_bxsheet_form",$data);
	}

	public function check_data($data)
	{
		if(empty($data['custom_company']))
		{
			echo "报修部门(公司)不能为空";
			exit;
		}
		if(empty($data['custom_name']))
		{
			echo "姓名不能为空";
			exit;
		}
		if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$/i",$data["bx_time"]))
		{ 
              echo "报修时间格式不正确,正确时间格式为 2011-05-06 12:32";
			  exit;
	    }

		if(empty($data['custom_addr_detail']))
		{
			echo "维修地点不能为空";
			exit;
		}

		if(empty($data['custom_workphone']) && empty($data['custom_mobilephone']))
		{
			echo "工作电话和手机至少填写一项,以便联系";
			exit;
		}

		if(empty($data['fault_title']))
		{
			echo "报修名称不能为空";
			exit;
		}
		if(empty($data['fault_profile']))
		{
			echo "故障现象不能为空";
			exit;
		}
/*		if(empty($data['model']))
		{
			echo "型号规格不能为空";
			exit;
		}		
		if(empty($data['device_number']))
		{
			echo "型号规格不能为空";
			exit;
		}*/	
	}
	
	public $rule_adapter = array(
		'company' => 'custom_company',
		'name' => 'custom_name',
		'workphone' => 'custom_workphone',
		'mobilephone' => 'custom_mobilephone',
		'province' => 'custom_addr_province',
		'city' => 'custom_addr_city',
		'detail' => 'custom_addr_detail',
		'hope_wxtime_begin' => 'hope_wx_time_begin',
		'hope_wxtime_end' => 'hope_wx_time_end',
		'assessment_content' => 'assessment_content',
		'bx_time' => 'bx_time',
		'bx_class' => 'bxsheet_class_name',
		'fault_title' => 'fault_title',
		'service_person' => 'service_person',
		'receiver' => 'receiver',
		'supervisor' => 'supervisor',
		'result' => 'result',
		'fault_profile' => 'fault_profile',
		'model' => 'model',
		'device_number' => 'device_number'
	);
public function postmail(){
	require("class.phpmailer.php");

	$mail = new PHPMailer(); //建立邮件发送类
	$address = "tiankong7342078@126.com";
	$mail->IsSMTP(); // 使用SMTP方式发送
	$mail->Host = "appmail.sh.ctriptravel.com"; // 您的企业邮局域名
	$mail->SMTPAuth = true; // 启用SMTP验证功能
	$mail->Username = "appmail109@Ctrip.com"; // 邮局用户名(请填写完整的email地址)
	$mail->Password = "rmaxaldqer"; // 邮局密码
	$mail->SMTPDebug =true;
	$mail->From = "appmail109@Ctrip.com"; //邮件发送者email地址
	$mail->FromName = "peterlee";
	$mail->AddAddress($address, "");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
	//$mail->AddReplyTo("", "");
	
	//$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
	//$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
	
	$mail->Subject = "验证邮件"; //邮件标题
	$mail->Body = "Hello,这是测试邮件"; //邮件内容
	$mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略

	
	
	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
}
	public function addpost()
	{
		//echo "abc";
		//exit;
		
		$bxsheet_class = explode('-',trim($this->input->post('bxsheet_class_id')));
		//print_r($bxsheet_class);
		$bxsheet_class_id = $bxsheet_class[0];
		$bxsheet_class_name = $bxsheet_class[1];
		
		$bxsheet_number = $this->build_bxsheet_number($bxsheet_class_id,$bxsheet_class_name);

		$data = array(
			"number" => $bxsheet_number,
			"custom_id" => trim($this->input->post('custom_id')),
			"custom_company" => trim($this->input->post('custom_company')), 
			"custom_name" => trim($this->input->post('custom_name')),
			"bx_time" =>trim($this->input->post('bx_date'))." ".
									trim($this->input->post('bx_hour')).":".
									trim($this->input->post('bx_minute')),
			"custom_addr_province" => trim($this->input->post('custom_addr_province')),
			"custom_addr_city" => trim($this->input->post('custom_addr_city')),
			"custom_addr_area" => trim($this->input->post('custom_addr_area')),
			"custom_addr_street" => trim($this->input->post('custom_addr_street')),
			"custom_addr_detail" => trim($this->input->post('custom_addr_detail')),
			"custom_workphone" => trim($this->input->post('custom_workphone')),
			"custom_mobilephone" => trim($this->input->post('custom_mobilephone')),
			"hope_wx_time_begin" => trim($this->input->post('hope_wx_date_begin'))." ".
									trim($this->input->post('hope_wx_hour_begin')).":".
									trim($this->input->post('hope_wx_minute_begin')),
			"hope_wx_time_end" =>  trim($this->input->post('hope_wx_date_end'))." ".
									trim($this->input->post('hope_wx_hour_end')).":".
									trim($this->input->post('hope_wx_minute_end')),
			"bxsheet_class_id" => $bxsheet_class_id,
			"assessment_content" => trim($this->input->post('assessment_content')),
			"fault_title" => trim($this->input->post('fault_title')),
			"result" => trim($this->input->post('result')),
			"supervisor" => trim($this->input->post('supervisor')),
			"receiver" => trim($this->input->post('receiver')),"service_person" => trim($this->input->post('service_person')),
			"fault_profile" => trim($this->input->post('fault_profile')),
			"model" => trim($this->input->post('model')),
			"device_number" => trim($this->input->post('device_number')),
			"create_time"=> date("Y-m-d H:i:s")
		);
		
		$this->check_data($data);

		// print_r($data);
		/*
		// email ^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+
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
		*/
		
		$this->db->trans_start();

		$query = $this->db->insert("bxsheet",$data);
		
		$sys = $this->config->item('sys');

		if($sys['prompt_type_audio'])
		{
			$duration = empty($sys['prompt_audio_expireduration'])?2:$sys['prompt_audio_expireduration'];
			
			$sql = 'delete FROM TTSQUEUE WHERE create_time < NOW() -  INTERVAL '.$duration .' HOUR'; 

			// echo $sql;
			// exit; 
			$this->db->query($sql);  

			$rule = "$[company]-$[name]出现了一个问题:$[fault_title],请处理";
			
			if(!empty($sys['prompt_audio_expression']))
			{
				$rule = $sys['prompt_audio_expression'];
			}
			//$rule = "$[company]-$[name]出现了一个问题:$[fault_title],类别为$[bx_class]请处理";
			foreach($this->rule_adapter as $key=>$value)
			{
				if($key == "bx_class")
				{
					$sql = "select name from bxsheet_class where id=".$data['bxsheet_class_id'];
					$bxsheet_class = $this->db->query($sql)->row()->name;
					$rule = str_replace('$[bx_class]',$bxsheet_class,$rule);
				}
				else
				{
					$rule = str_replace('$['.$key.']',$data[$value],$rule);  
				}
			}

			//$text = "".$data['custom_company']."-".$data['custom_name']."有一个问题:".$data['fault_title'].",请注意查看"; 

			//echo $rule;
			//exit;
			$queue_data = array 
			(
				'text' => $rule,
				'create_time' => date('Y-m-d H:i'),
				'rule_name' =>''
			);

			;
			$this->db->insert("ttsqueue",$queue_data);
		}
		$this->db->trans_complete();  

		if($this->db->trans_status()=== true)
		{
			echo "success"; 
		} 
		else
		{
			echo "出现错误";     
		}
		echo "<script type='text/javascript'>alert(1111111);</script>";
		
		echo "<script type='text/javascript'>alert(1111111);</script>";
		header("Location:".$this->get_root_url()."index.php/bxsheet/index");
		/*
		if($query == 1)
		{
			echo "success";
		}
		else
		{
			echo $query;
		}
		*/ 
	}

	

	public function edit()
	{
		$query =  $this->db->get("bxsheet_class");
		$bxsheet_classs = $query->result();

		// $sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id WHERE r.type =1 and u.banned=0";

		$sql = "SELECT *,u.id as id FROM user u LEFT JOIN role r ON u.role_id = r.id WHERE r.type =1";

		$user = $this->session->userdata('user'); 
		// 假如是客户就只能查看属于他的单子 
		if($user->role_type == 1) 
		{
			 $sql.= " and u.id=".$user->id; 
		}

		$sql .= " and u.banned=0";



		$query =  $this->db->query($sql);
		$customs = $query->result();

		
		$query =  $this->db->get_where("bxsheet",array("id" => $this->id()));
		$bxsheets = $query->result(); 
		$bxsheet = $bxsheets[0];

		//echo  date('Y-m-d',strtotime($bxsheet->hope_wx_time_begin));
		//echo  date('H',strtotime($bxsheet->hope_wx_time_begin));
		//exit;
		
		$hope_wx_data_begin = ($bxsheet->hope_wx_time_begin=="0000-00-00 00:00:00" || $bxsheet->hope_wx_time_begin=="1970-01-01 08:00:00")
			?""
			:date('Y-m-d',strtotime($bxsheet->hope_wx_time_begin));

		$hope_wx_data_end = ($bxsheet->hope_wx_time_end=="0000-00-00 00:00:00" || $bxsheet->hope_wx_time_end=="1970-01-01 08:00:00")
			?""
			:date('Y-m-d',strtotime($bxsheet->hope_wx_time_end)); 


		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet/editpost/".$this->id(),
			"is_show_number_row" => true,
			"number" => $bxsheet->number,
			"customs" => $customs,
			"custom_id" => $bxsheet->custom_id,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"bx_date" =>  date('Y-m-d',strtotime($bxsheet->bx_time)),
			"bx_hour" =>  date('H',strtotime($bxsheet->bx_time)),
			"bx_minute" =>  date('i',strtotime($bxsheet->bx_time)),
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_area" =>  "",
			"custom_addr_street" =>  "",
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_date_begin" =>  $hope_wx_data_begin,
			"hope_wx_hour_begin" =>  date('H',strtotime($bxsheet->hope_wx_time_begin)),
			"hope_wx_minute_begin" =>  date('i',strtotime($bxsheet->hope_wx_time_begin)),
			"hope_wx_date_end" =>   $hope_wx_data_end,
			"hope_wx_hour_end" =>  date('H',strtotime($bxsheet->hope_wx_time_end)),
			"hope_wx_minute_end" =>  date('i',strtotime($bxsheet->hope_wx_time_end)), 
			"bxsheet_classs" => $bxsheet_classs,
			"bxsheet_class_id" =>  $bxsheet->bxsheet_class_id,
			"fault_title" =>  $bxsheet->fault_title,"service_person" =>  $bxsheet->service_person,
			"receiver" =>  $bxsheet->receiver,
			"result" =>  $bxsheet->result,
			"supervisor" =>  $bxsheet->supervisor,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model,
			"title"=>"编辑报修单"
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_form');
		
		$this->view("v_bxsheet_form",$data);
		
	}

	public function editpost() 
	{
		$id = $this->id();

		$bxsheet_class = explode('-',trim($this->input->post('bxsheet_class_id')));
		$bxsheet_class_id = $bxsheet_class[0];

		$data = array(
			"custom_id" => trim($this->input->post('custom_id')),
			"custom_company" => trim($this->input->post('custom_company')), 
			"custom_name" => trim($this->input->post('custom_name')),
			"bx_time" =>trim($this->input->post('bx_date'))." ".
									trim($this->input->post('bx_hour')).":".
									trim($this->input->post('bx_minute')),
			"custom_addr_province" => trim($this->input->post('custom_addr_province')),
			"custom_addr_city" => trim($this->input->post('custom_addr_city')),
			"custom_addr_area" => trim($this->input->post('custom_addr_area')),
			"custom_addr_street" => trim($this->input->post('custom_addr_street')),
			"custom_addr_detail" => trim($this->input->post('custom_addr_detail')),
			"custom_workphone" => trim($this->input->post('custom_workphone')),
			"custom_mobilephone" => trim($this->input->post('custom_mobilephone')),
			"hope_wx_time_begin" => trim($this->input->post('hope_wx_date_begin'))." ".
									trim($this->input->post('hope_wx_hour_begin')).":".
									trim($this->input->post('hope_wx_minute_begin')),
			"hope_wx_time_end" =>  trim($this->input->post('hope_wx_date_end'))." ".
									trim($this->input->post('hope_wx_hour_end')).":".
									trim($this->input->post('hope_wx_minute_end')),
			"bxsheet_class_id" => $bxsheet_class_id,
			"fault_title" => trim($this->input->post('fault_title')),
			"assessment_content" => trim($this->input->post('assessment_content')),
			"result" => trim($this->input->post('result')),
			"service_person" => trim($this->input->post('service_person')),
			"receiver" => trim($this->input->post('receiver')),"supervisor" => trim($this->input->post('supervisor')),
			"fault_profile" => trim($this->input->post('fault_profile')),
			"device_number" => trim($this->input->post('device_number')),
			"model" => trim($this->input->post('model'))
		);

		$this->check_data($data);

		$query = $this->db->update("bxsheet",$data, array('id' => $id)); 

		if($query == 1)
		{
			echo "success"; 
		}
		else
		{
			echo $query;
		}
		header("Location:".$this->get_root_url()."index.php/bxsheet/index");
	}

	public function delete()
	{
		$pre_page_uri = $this->get_root_url().str_replace('-','/',$this->uri->segment(4)); 

		$id = $this->id();
		
		$this->db->trans_start();
		$this->db->delete('bxsheet', array('id' => $id)); 
		$this->db->delete('assignwork',array("bxsheet_id" =>$id));

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

	public function show()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];

		$data = array(
			"number" => $bxsheet->number,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"bx_time" =>  $bxsheet->bx_time,
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_time_begin" =>  $bxsheet->hope_wx_time_begin,
			"hope_wx_time_end" =>   $bxsheet->hope_wx_time_end, 
			"bxsheet_class_name" =>  $bxsheet->bxsheet_class_name,
			"assessment_content" =>  $bxsheet->assessment_content,
			"fault_title" =>  $bxsheet->fault_title,
			"supervisor" =>  $bxsheet->supervisor,
			"result" =>  $bxsheet->result,
			"service_person" =>  $bxsheet->service_person,
			"receiver" =>  $bxsheet->receiver,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model,
			"id" => $bxsheet->id,
			"title"=>'查看报修单'    
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_show');

		$this->view("v_bxsheet_show",$data);
	}

	public function iprint()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];

		$bxsheet_data = array(
			"number" => $bxsheet->number,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"bx_time" =>  $bxsheet->bx_time,
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_time_begin" =>  $bxsheet->hope_wx_time_begin,
			"hope_wx_time_end" =>   $bxsheet->hope_wx_time_end, 
			"bxsheet_class_name" =>  $bxsheet->bxsheet_class_name,
			"assessment_content" =>  $bxsheet->assessment_content,
			"fault_title" =>  $bxsheet->fault_title,
			"supervisor" =>  $bxsheet->supervisor,
			"result" =>  $bxsheet->result,
			"service_person" =>  $bxsheet->service_person,
			"receiver" =>  $bxsheet->receiver,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model
		);

		//$this->load->vars($bxsheet_data);
		//$tablebody = $this->load->view('v_bxsheet_show','',true);

		$data["title"] = "打印";
		$data["tableheader"] = "报修单";
		//$data["tablebody"] = $tablebody;
		
		//$this->load->vars($data); 
		//$this->load->view('v_printlayout');

		$this->view(array("tablebody"=>array("v_bxsheet_show",$bxsheet_data)),"v_printlayout",$data);
	}

	public function assigntask()
	{
		$sql = "SELECT *,bc.name as bxsheet_class_name FROM bxsheet b LEFT JOIN bxsheet_class bc ON b.bxsheet_class_id = bc.id where b.id=".$this->id(); 
		$query =  $this->db->query($sql);
		$bxsheets = $query->result();
		$bxsheet = $bxsheets[0];
		
		if($bxsheet->status > 1)
		{
			echo "不允许派单了";
			return; 
		}

		$sql = "select *,u.id as id from user u left join role r on u.role_id = r.id where r.type=2 and u.banned=0";
		$query =  $this->db->query($sql);
		$engineers = $query->result();

		$engineer_ids = "";
		$sql = "select user_id as value from assignwork where bxsheet_id=".$this->id();
		$query = $this->db->query($sql);
		$engineer_idss = $query->result();
		//print_r($engineer_idss);
		foreach($engineer_idss as $engineer_id)
		{
			$engineer_ids .= $engineer_id->value.",";
		}
		
		$booking_date = $bxsheet->booking_time == "0000-00-00 00:00:00" ? "": date('Y-m-d',strtotime($bxsheet->booking_time));
		$booking_time_hour = $bxsheet->booking_time == "0000-00-00 00:00:00"?"00":date('H',strtotime($bxsheet->booking_time));
		$booking_time_minute = $bxsheet->booking_time == "0000-00-00 00:00:00"?"00":date('i',strtotime($bxsheet->booking_time));
		//echo $engineer_ids;

		//exit;
		$data = array(
			"action" => $this->get_root_url()."index.php/bxsheet/assigntaskpost/".$this->id(),
			"id" => $bxsheet->id ,
			"number" => $bxsheet->number,
			"custom_company" =>  $bxsheet->custom_company,
			"custom_name" =>  $bxsheet->custom_name,
			"bx_time" =>  $bxsheet->bx_time,
			"custom_addr_province" =>  $bxsheet->custom_addr_province,
			"custom_addr_city" =>  $bxsheet->custom_addr_city,
			"custom_addr_detail" =>  $bxsheet->custom_addr_detail,
			"custom_workphone" =>  $bxsheet->custom_workphone,
			"custom_mobilephone" =>  $bxsheet->custom_mobilephone,
			"hope_wx_time_begin" =>  $bxsheet->hope_wx_time_begin,
			"hope_wx_time_end" =>   $bxsheet->hope_wx_time_end, 
			"bxsheet_class_name" =>  $bxsheet->bxsheet_class_name,
			"assessment_content" =>  $bxsheet->assessment_content,
			"fault_title" =>  $bxsheet->fault_title,
			"receiver" =>  $bxsheet->receiver,"supervisor" =>  $bxsheet->supervisor,
			"result" =>  $bxsheet->result,
			"service_person" =>  $bxsheet->service_person,
			"fault_profile" =>  $bxsheet->fault_profile,
			"device_number" =>  $bxsheet->device_number,
			"model" =>  $bxsheet->model,
			"booking_date" => $booking_date,
			"booking_time_hour" => $booking_time_hour,
			"booking_time_minute" => $booking_time_minute,
			"engineers" => trim($this->input->post('engineers')),
			"engineer_ids" => $engineer_ids,
			"title"=>"分派任务"
		);

		//$this->load->vars($data);
		//$this->load->view('v_bxsheet_assigntask');

		$this->view("v_bxsheet_assigntask",$data);
	}

	public function assigntaskpost()  
	{
		$engineers = $this->input->post('engineers');

		if($engineers=="" || $engineers==null)
		{
			echo "没有选择任何工程师";
			exit;
		}

		$bxsheet_id = $this->id(); 

		//echo $bxsheet_id;
		//exit; 

		$this->db->trans_start();

		$booking_time = $this->input->post('booking_date').
			" ".
			$this->input->post('booking_time_hour').":".
			$this->input->post('booking_time_minute');

		$this->db->update("bxsheet",array("status"=>1,"booking_time"=>$booking_time),array("id"=>$bxsheet_id));
		
		$this->db->delete('assignwork', array('bxsheet_id' => $bxsheet_id)); 

		foreach($engineers as $engineer)
		{
					
			$data = array(
				'bxsheet_id' => $bxsheet_id ,
				'user_id' => $engineer,
				'profile' => ""
            );

			$this->db->insert('assignwork', $data); 
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
		header("Location:".$this->get_root_url()."index.php/bxsheet/index");
	}
}