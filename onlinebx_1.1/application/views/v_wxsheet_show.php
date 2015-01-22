<style>
.bxsheet_show
{
	border-bottom: 1px solid #666666;
}
.show td
{
	padding-top:6px;
	padding-bottom:6px;
}
</style>

<table class="show">
	<tr>
		<td width="90">
			报修编号
		</td>
		<td>
			<label class="bxsheet_show"><?=$number?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修部门
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_company?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			姓名
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_name?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			维修地点 
		</td>
		<td>
			<label class="bxsheet_show">北京朝阳区携程旅行网<?=$custom_addr_detail?>&nbsp;</label>
		</td>
	</tr>
	
	<tr>
		<td>
			工作电话	
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_workphone?>&nbsp;</label>
		</td>
	</tr>
	
	<tr>
		<td>
			手机	
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_mobilephone?>&nbsp;</label>
		</td>
	</tr>

	<tr>
		<td>
			希望维修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($hope_wx_time_begin))?> -- <?=date("Y-m-d H:i",strtotime($hope_wx_time_end))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($bx_time))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障类别
		</td>
		<td>
			<label class="bxsheet_show"><?=$bxsheet_class_name?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修名称
		</td>
		<td>
			<label class="bxsheet_show"><?=$fault_title?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障现象
		</td>
		<td>
			<div class="bxsheet_show"><?=$fault_profile?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			预约时间
		</td>
		<td>
			<div class="bxsheet_show"><?=$booking_time?></div>
		</td>
	</tr>
	<tr>
		<td>
			分配给
		</td>
		<td>
			<label class="bxsheet_show"><?=$engineer_names?></label>
		</td>
	</tr>
	<tr>
		<td>
			维修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=$wx_time==""?"":date("Y-m-d H:i",strtotime($wx_time))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障原因
		</td>
		<td>
			<div class="bxsheet_show"><?=$fault_reason?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			维修情况
		</td>
		<td>
			<div class="bxsheet_show"><?=$wx_profile?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			维修费用
		</td>
		<td>
			<label class="bxsheet_show"><?=$wx_fee?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			维修状态
		</td>
		<td>
			 <label class="bxsheet_show"><?= ($status==="3")?"已完成":(($status==="2")?"未完成":"未登记")?> </label>
		</td>
	</tr>
</table>
