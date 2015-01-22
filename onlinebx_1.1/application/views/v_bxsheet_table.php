<script>
$(function(){
	width = (getBrowser().name=="IE" && getBrowser().version < 7)?780:782;
	flexi_grid({height:459,width:width,height:455});   
});


function del_record(id)
{
	url = window.location.href;
	url_len = url.length;
	pos = url.indexOf("index.php");
	url = url.substr(pos,(url_len-pos));
	url = url.replace(/\//g,'-');
	// alert(url); 
	if(confirm('删除后将不能恢复,确定删除此条记录?'))
	{

		this.location.href = "<?=$root_url?>index.php/bxsheet/delete/" + id + "/" + url;
	}
}

</script> 

<?
function get_bx_status_name($mark)
{
	switch($mark)
	{
		case "0":
			return "<font color='red'>未派工</font>";
		case "1":
			return "<font color='blue'>已派工</font>";
		case "2":
			return "未完成";
		case "3":
			return "已完成";
	}
}
?>
<table class="flexi_grid" type="db_grid">
	<thead>
	<tr>
		<th width="100">报修编号</td>
		<th width="75">报修部门</td>
		<th width="46">姓名</td>
		<th width="56">故障类别</td>
		<th width="120">报修名称</td>  
		<th width="98">报修时间</td>
		<th width="50">状态</td>
		<th width="120">操作</td>
	</tr>
	</thead>
	<tbody> 
	<? foreach($bxsheets as $bxsheet):?>
	<tr>
		<td><?=$bxsheet->number?></td>
		<td><?=$bxsheet->custom_company?></td>
		<td align="center"><?=$bxsheet->custom_name?></td>
		<td align="center"><?=$bxsheet->bxsheet_class?></td>
		<td><?=$bxsheet->fault_title?></td>
		<td>
			<?=date('Y-m-d H:i',strtotime($bxsheet->bx_time))?> 
		</td>
		<td><?=get_bx_status_name($bxsheet->status)?></td>
		<td>
			<? if($iseditable){?>
			<a href="javascript:void(0)" onclick="document.location.href= '<?=$root_url?>index.php/bxsheet/edit/<?=$bxsheet->id?>';">编辑</a>
			<?}?>
			<? if($isdeleteable){?>
			<a href="javascript:void(0)" onclick="del_record('<?=$bxsheet->id?>');">删除</a>

			
			<?}?>
			<? if($isshowable){?>
			<a href="javascript:void(0)" onclick="document.location.href= '<?=$root_url?>index.php/bxsheet/show/<?=$bxsheet->id?>';">查看</a> 
			<?}?>
			<? if($isassigntaskable){?>
			<a href="javascript:void(0)" onclick="document.location.href= '<?=$root_url?>index.php/bxsheet/assigntask/<?=$bxsheet->id?>';">派工</a>
			<?}?>
		</td>
	</tr> 
  <?php endforeach;?>
	<tr>
		<td colspan="8">
			<?=date('H:i:s a');?>
		</td>
	</tr>
	</tbody>
</table>
<?
	$this->load->view(
		'v_pager',
		array(
			'controller'=>'bxsheet',
			'action'=>'index',
			'current_page'=>$current_page,
			'pre_page'=>$pre_page,
			'next_page'=>$next_page,
			'page_count'=>$page_count
		)
	)
?>
