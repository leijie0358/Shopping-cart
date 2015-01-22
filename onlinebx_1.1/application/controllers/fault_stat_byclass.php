<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once substr(BASEPATH,0,strlen(BASEPATH)-7).'application/libraries/Spreadsheet/Excel/Writer.php';

class Fault_stat_byclass  extends JR_Controller
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
		$data['title'] = "在线报修系统--故障类别统计";
		$data['navigate_string'] = "故障类别统计";

		$bt =  trim($this->input->post("bx_time_begin"));
		$et =  trim($this->input->post("bx_time_end"));
		
		if($et == "")
		{
			$et = date('Y-m-d');
		}

		$results = "";
		
		if($bt!="" || $et!="")
		{
			$condition ="";
			
			if($bt!="" && $et!="")
			{
				$condition = " and b.bx_time between '".$bt." 00:00:00' and '".$et." 23:59:59'";
			}
			else if($bt!="")
			{
				$condition = " and b.bx_time >= '".$bt." 00:00:00'";
			}
			else if($et!="")
			{
				$condition = " and b.bx_time <= '".$et." 23:59:59'";
			}
			//$condition = " and b.bx_time >='2011-3-6'";
			
			$sql = "
			SELECT NAME AS 类别,COUNT(bc.id) AS 总单数,
			(SELECT COUNT(*) FROM bxsheet nbx WHERE nbx.bxsheet_class_id=bc.id AND nbx.status=0 $condition) AS 未派单,
			(SELECT COUNT(*) FROM bxsheet nbx WHERE nbx.bxsheet_class_id=bc.id AND nbx.status=1 $condition) AS 已派单,
			(SELECT COUNT(*) FROM bxsheet nbx WHERE nbx.bxsheet_class_id=bc.id AND nbx.status=3 $condition) AS 已完成,
			(SELECT COUNT(*) FROM bxsheet nbx WHERE nbx.bxsheet_class_id=bc.id AND nbx.status=2 $condition) AS 未完成
			FROM bxsheet_class bc
			LEFT JOIN bxsheet b ON bc.id = b.bxsheet_class_id
			where 1=1 $condition
			GROUP BY bc.name ";

			$query = $this->db->query($sql);
			$results = $query->result_array();
			//print_r($results);
		}
		$assessment_stat_data= array(
			'searchaction' => $this->get_root_url()."index.php/fault_stat_byclass/index",
			'bx_time_begin' => $bt,
			'bx_time_end' => $et,
			'results' =>$results,
			'root_url'=>$this->get_root_url()
		);
		$this->view("v_fault_stat_byclass",$assessment_stat_data,"v_adminlayout",$data);
	}

	public function chart()
	{
		$this->view("v_fault_stat_byclass_chart",null);
	}
	
	public function toexcel()
	{
		$hid = $this->input->post('hid'); 
		header("Content-type: application/vnd.ms-excel;charset=gb2312");
		header("Accept-Length: ".strlen($hid));
		header("Content-Transfer-Encoding: binary"); 
		header('Content-Disposition: attachment; filename=tmp.xls');
		$hid = iconv("utf-8", "gb2312", $hid);
		echo $hid;
	}
}