<style>
#searcharea
{
	border:1px dotted #aaaaaa;
	height:60px;
	margin-top:3px;
	margin-bottom:3px;
	margin-left:200px;
	padding:6px 6px 6px  6px
}
</style>

<script>
$(function(){
	width = (getBrowser().name=="IE" && getBrowser().version < 7)?780:782;
	flexi_grid({buttons:[{name: '&nbsp'}],height:459,width:width});  
});
</script>

<?
function get_bx_status_name($mark)
{
	switch($mark)
	{
		case "0":
			return "未派单";
		case "1":
			return "<font color='red'>未登记</font>";
		case "2":
			return "<font color='orange'>未完成</font>";
		case "3":
			return "<font color='blue'>已完成</font>";
	}
}

?>
<table class="flexi_grid" type="db_grid"> 
	<thead>
	<tr>
		<th width="100">报修编号</td>
		<th width="75">报修报修部门</td>
		<th width="46">姓名</td>
		<th width="90">报修名称</td> 
		<th width="100">维修情况</td> 
		<th width="85">维修时间</td>
		<th width="50">工程师</td>
		<th width="50">评价</td>
		<th width="60">操作</td>
	</tr>
	</thead>
	<tbody>
	<? foreach($bxsheets as $bxsheet):?>
	<tr>
		<td><?=$bxsheet->number?></td>
		<td><?=$bxsheet->custom_company?></td>
		<td align="center"><?=$bxsheet->custom_name?></td>
		<td align="center"><?=$bxsheet->fault_title?></td>
		<td><?=$bxsheet->fault_reason." ".$bxsheet->wx_profile?></td>
		<td>
			<?=$bxsheet->wx_time=="0000-00-00 00:00:00"?"":date('Y-m-d H:i',strtotime($bxsheet->wx_time))?>
		</td>
		<td align="center">
			<?
				//$ci = &get_instance();
				$sql = "select * from assignwork a left join user u on a.user_id = u.id where bxsheet_id=".$bxsheet->id;
				$query = $this->db->query($sql);
				$engineers = $query->result();
				foreach($engineers as $engineer)
				{
			?>
			<?=$engineer->realname?>&nbsp;
			<? 
				}
			?>
		</td>
		<td align="center"><?= $bxsheet->assessment_class_name ?></td> 
		<td>
			<? if($isassessmentable){?>
			<a href="javascript:void(0)" onclick="showModel('w','客户评价','<?=$root_url?>index.php/custom_assessment/assessment/<?=$bxsheet->id?>','custom_assessmentform',660)">评价</a>
			<?}?>
			<? if($isshowable){?>
			<a href="javascript:void(0)" onclick="showModel('w','查看评价','<?=$root_url?>index.php/custom_assessment/show/<?=$bxsheet->id?>','<?="show-custom_assessment-".$bxsheet->id?>')">查看</a> 
			<?}?>
		</td>
	</tr> 
	<?php endforeach;?>
	</tbody>
</table>
<?
	$this->load->view(
		'v_pager',
		array(
			'controller'=>'custom_assessment',
			'action'=>'index',
			'current_page'=>$current_page,
			'pre_page'=>$pre_page,
			'next_page'=>$next_page,
			'page_count'=>$page_count
		)
	)
?>