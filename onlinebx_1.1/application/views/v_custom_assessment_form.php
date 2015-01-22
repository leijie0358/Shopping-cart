<style>
.bxsheet_show
{
	border-bottom: 1px solid #666666;
}
.show td
{
	padding-top:4px;
	padding-bottom:4px;
	font-size:14px;
}
</style>

<script>
	$(function() {
		$( "#wx_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});

</script>
<script>
	$(function() {
		$( "#ys_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});

</script>
<form action="<?=$action?>" method="post" id="custom_assessmentform">
<table class="show">
	<tr>
		<td width="90">
			评价
		</td>
		<td>
			<select name="assessment_class_id"> 
				<? foreach($assessment_classs as $assessment_class){?>
				<option value="<?=$assessment_class->id?>" <?=$assessment_class_id==$assessment_class->id?"selected":""?>><?=$assessment_class->name?></option>
				<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			评价详情
		</td>
		<td>
			<textarea cols="60" rows="3" name="assessment_content"><?=$assessment_content?></textarea>
		</td>
	</tr>
</table></form>

<div style="height:288px;OVERFLOW-y:auto">
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
			<label class="bxsheet_show">北京市朝阳区<?=$custom_addr_detail?>&nbsp;</label>
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
			<div class="bxsheet_show"><?=$booking_time?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			分配给
		</td>
		<td>
			<?=$engineer_names?>&nbsp;
		</td>
	</tr>
	<tr>
		<td>
			维修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($wx_time))?>&nbsp;</label>
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
</table>
</div> 