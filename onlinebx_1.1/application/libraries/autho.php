<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Autho
{
	public $arr_permissions = array();

	public $ci;

    function __construct()
    {
		 $this->ci =  &get_instance(); 
    }

    // 目前此处处理的不好,导致其它地方调用的重复代码过多 ,而且效率不好
    // 最好是把第一个参数改成 user,第二个改成资源名,这样效率 会高很多,而且其它地方重复代码也会少很多. 
	public function isauth($role_id,$resource_id,$actionname)
	{
		if($this->ci->session->userdata('user') == null)
		{
			redirect($this->ci->get_root_url()."index.php/user/login");
//			redirect("?logout=");
		}
		
		$user =  $this->ci->session->userdata('user');

		// if($user->role_type == 3) return true;
		$sql = "select * from permission where resource_id=" . $resource_id . " and role_id=" . $role_id . " and actionname='" . $actionname."'";
		// echo $sql;

		$query = $this->ci->db->query($sql); 
		$permissions = $query->num_rows();

		if($permissions == 0)
			return false;
		return true; 
	}

	/*
	public function isauth($role_id,$resource_id,$actionname)
	{
		$arr_permissions = array();

		$actionpermission = array();
		
		//echo $role_id;

		if(!array_key_exists($resource_id,$this->arr_permissions))
		{
			$sql = "select * from permission where resource_id=" . $resource_id . " and role_id=" . $role_id;
			// echo $sql;

			$query = $this->ci->db->query($sql); 
			$permissions = $query->result();

			foreach($permissions as $permission)
			{
				$actionpermission[$permission->actionname] = $permission->denied;
			}
			$this->arr_permissions[$resource_id] = $actionpermission;
		}

		if(!array_key_exists($actionname,$this->arr_permissions[$resource_id]) )
		{
			return false;
		}

		//echo $resource_id."-".$actionname.":".$this->arr_permissions[$resource_id][$actionname];

		//return true;

		if($this->arr_permissions[$resource_id][$actionname] == 1 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	*/

	public function action_isauth()
	{
		$controller = "";

		if ($this->ci->uri->segment(1) === FALSE)
		{
			$controller = "welcome";
		}
		else
		{
			$controller = $this->ci->uri->segment(1);
		}
 
		$action = "";
		if ($this->ci->uri->segment(2) === FALSE)
		{
			$action = "index";
		}
		else
		{
			$action = $this->ci->uri->segment(2); 
			//$action ="edit";
		}
		
		$action = str_replace("post","",$action);  

		if($controller == "gmap") return; 
		if($controller == "bmap") return; 
		if($controller == "bxsheet" && $action == "outadd")  return;
		if($controller == "user" && $action == "login")  return;
		if($controller == "user" && $action == "logout")  return; 
		if($controller == "welcome")   return;


		if($this->ci->session->userdata('user') == null)
		{
			redirect($this->ci->get_root_url()."index.php/user/login");
//			redirect("?logout=");
		}
		
		$user =  $this->ci->session->userdata('user');

		if($user->role_type == 3) return true;

		$this->ci->load->helper('url'); 
		
		$query = $this->ci->db->get_where("resource",array("name"=>$controller) ) ;
		$resources = $query->result();
		$resource = $resources[0];
		
		if(!array_key_exists("HTTP_REFERER",$_SERVER))   
		{
			$pre_page_uri = "";
		}
		else
		{
			$pre_page_uri = $_SERVER["HTTP_REFERER"];
		}
		if($controller == "bxsheet" && $action == "datatable")
		{
			if(!$this->isauth($user->role_id,$resource->id,"index"))
			{
				// $this->ci->error($controller."-".$action,'你没有权限访问此页',$pre_page_uri);
				$this->ci->error($controller."-".$action,'你没有权限访问此页',null);
				exit;
			}
			return;
		}
   
		if(!$this->isauth($user->role_id,$resource->id,$action))
		{
			
			$this->ci->error($controller."-".$action,'你没有权限访问此页',null);
			exit;
		}
	}
}

?>