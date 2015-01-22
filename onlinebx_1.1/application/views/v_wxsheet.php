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
	flexi_grid({
		buttons:[{name: '&nbsp'}],
		height:459,
		width:width,
		onChangeSort : function(sortname,sortorder)
		{
			var lastcontent = null;
			var lasttr = null;

			$('.flexi_grid tbody tr').each(function(i){
				cindex = 4;
				if(sortname=='status')
				{
					cindex = 7;
				}
				var td = $(this).find('td').eq(cindex);
				var d = td.find('div');
				var content = d.text();
				if(lastcontent!=null)
				{
					// alert(lastcontent);
					if(content > lastcontent)
					{
						$(this).after(lasttr);
					}
					else
					{
						lasttr = $(this);
						lastcontent = content;
					}
				}
				else
				{
					lasttr = $(this);
					lastcontent = content;
				}
			});
		}
	});  

	
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
		<th width="46">报修人</td>
		<th width="90">报修名称</td> 
		<th width="85" abbr='booking_time'>预约时间</td>
		<th width="100">维修情况</td> 
		<th width="50">工程师</td>
		<th width="40" abbr='status'>状态</td>
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
		<td>
			<?=$bxsheet->booking_time=="0000-00-00 00:00:00"?"":date('Y-m-d H:i',strtotime($bxsheet->booking_time))?>
		</td>
		<td><?=$bxsheet->fault_reason." ".$bxsheet->wx_profile?></td>
		<td align="center">
			<?
				$ci = &get_instance();
				$sql = "select * from assignwork a left join user u on a.user_id = u.id where bxsheet_id=".$bxsheet->id;
				$query = $ci->db->query($sql);
				$engineers = $query->result();
				foreach($engineers as $engineer)
				{
			?>
			<?=$engineer->realname?>&nbsp;
			<? 
				}
			?>
		</td>
		<td align="center"><?=get_bx_status_name($bxsheet->status)?></td>
		<td>
			<? if($issetdownable){?>
			<a href="javascript:void(0)" onclick="showModel('w','维修登记','<?=$root_url?>index.php/wxsheet/setdown/<?=$bxsheet->id?>','wxsheetform','660')">登记</a>
			<?}?>
			<? if($isshowable){?>
			<a href="javascript:void(0)" onclick="showModel('w','查看维修登记','<?=$root_url?>index.php/wxsheet/show/<?=$bxsheet->id?>','<?="show-wxsheet-".$bxsheet->id?>')">查看</a> 
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
			'controller'=>'wxsheet',
			'action'=>'index',
			'current_page'=>$current_page,
			'pre_page'=>$pre_page,
			'next_page'=>$next_page,
			'page_count'=>$page_count
		)
	)
?>
