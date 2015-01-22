<style>
.action
{
	font-size:12px;
	padding-top:2px;
	padding-bottom:2px;
	width:120px;
}
</style>
<script>
$(document).ready(function(){
	$(":input[type='checkbox']").click(function(){
		var me = $(this)[0];
		var tmp = me.id;
		
		tmps = tmp.split('_');
		action = tmps[0];
		id = tmps[1];
		topid = tmps[2];
		
		if(me.checked && topid!=null)
		{
			//alert(topid);
			var topobj = $("#top_" + topid)[0];
			// alert(top.id);
			topobj.checked = true;

			indexobj = $("#index_" + id + "_" + topid)[0];
			
			indexobj.checked = true;   
		}
	});
});
</script>
<?
function get_action_name($actionname)
{
	switch($actionname)
	{
		case "index":
			return "列表";
		case "add":
			return "添加";
		case "edit":
			return "编辑";
		case "delete":  
			return "删除";
		case "assigntask":
			return "派工";
		case "permission":
			return "授权";
		case "iprint":
			return "打印";  
		case "show":
			return "查看";
		case "optimize":
			return "优化";    
		case "backup":
			return "备份";   
		case "restore":
			return "还原"; 
		case "setdown":
			return "登记"; 
		case "assessment":
			return "评价"; 
		case "search":
			return "查询"; 
		case "toexcel":
			return "导出到EXCEL";  
		case "chart": 
			return "查看统计图";  
		case "mark": 
			return "标注";  
		case "config": 
			return "配置";  
		case "register":  
			return "注册";     
	}
}

$arr_permissions = array();

// $ci = &get_instance();
$this->load->library("autho");
$auth = $this->autho;
// echo $role_id;
?>
<form action="<?=$action?>" method="post" id="permissionform">
	<table>
		<?php foreach($top_resources as $top_resource):?>
		<tr>
			<td>
				+ <?=$top_resource->profile?>
			</td>
			<td>
				<? foreach(explode(',',$top_resource->actionlist) as $action):?>
				<span class="action"><?= get_action_name($action)?> <input type="checkbox" id="top_<?=$top_resource->id?>" name="<?= $top_resource->id."_".$action?>" <?= $auth->isauth($role_id,$top_resource->id,$action)?"checked":""?> /></span>
				<?php endforeach;?>
			</td>
		</tr>
		<?
		$subquery = $this->db->get_where("resource",array("parent_id" => $top_resource->id));
		$resources = $subquery->result();
		//$index = 0;
		foreach($resources as $resource)
		{
		?>
		<tr>
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;- <?=$resource->chinesename?> 
			</td>
			<td>
				<? foreach(explode(',',$resource->actionlist) as $action):?>
				<span class="action"><?= get_action_name($action)?> <input type="checkbox" id="<?=$action."_".$resource->id."_".$top_resource->id?>" name="<?= $resource->id."_".$action?>" <?= $auth->isauth($role_id,$resource->id,$action)?"checked":""?> /> </span> 
				<?php endforeach;?>
			</td>
		</tr>
		<?
		//$index++;
		}
		?>
		<?php endforeach;?>
	</table>
</form>
