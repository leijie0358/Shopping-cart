<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once substr(BASEPATH,0,strlen(BASEPATH)-7).'application/libraries/Spreadsheet/Excel/Writer.php';

class Assessment_stat  extends JR_Controller
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
		$data['title'] = "在线报修系统--客户满意度统计";
		$data['navigate_string'] = "客户满意度统计";

		$bt =  trim($this->input->post("bx_time_begin"));
		$et =  trim($this->input->post("bx_time_end"));

		if($et == "")
		{
			$et = date('Y-m-d');
		}

		$results = "";
		
		if($bt!="" || $et!="")
		{
			$query = $this->db->get('assessment_class');
			$assessment_classs = $query->result();
			
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
			
			$subsql = "";
			
			foreach($assessment_classs as $assessment_class)
			{
				$subsql .= "
				(
				SELECT COUNT(b.id)
				FROM assignwork aw
				LEFT JOIN bxsheet b ON aw.bxsheet_id = b.id
				WHERE aw.user_id = u.id AND b.assessment_class_id = $assessment_class->id $condition
				) AS $assessment_class->name ,";
			}
			
			//$subsql = trim($subsql,",");
			
			//echo $subsql;
			//exit;
			$sql = "
			SELECT 
				u.realname AS 姓名,
				$subsql
				(
				SELECT COUNT(b.id)
				FROM bxsheet b
				LEFT JOIN assignwork aw ON aw.bxsheet_id = b.id
				WHERE aw.user_id = u.id AND b.assessment_class_id  is null $condition
				) AS 未评价,
				(
				SELECT COUNT(b.id)
				FROM bxsheet b
				LEFT JOIN assignwork aw ON aw.bxsheet_id = b.id
				WHERE aw.user_id = u.id $condition
				) AS 总计
			FROM USER u 
			LEFT JOIN role r ON u.role_id = r.id
			WHERE r.type = 2
			";
			
			//echo $sql;
			
			// exit;
			//$sql = "select  * from bxsheet_class order by id desc";
			$query = $this->db->query($sql);
			$results = $query->result_array();
			//print_r($results);
		}
		$assessment_stat_data= array(
			'searchaction' => $this->get_root_url()."index.php/assessment_stat/index",
			'bx_time_begin' => $bt,
			'bx_time_end' => $et,
			'results' =>$results,
			'root_url'=>$this->get_root_url()
		);
		$this->view("v_assessment_stat",$assessment_stat_data,"v_adminlayout",$data);
	}
	
	public function chart()
	{
		$this->view("v_assessment_stat_chart",null);    
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