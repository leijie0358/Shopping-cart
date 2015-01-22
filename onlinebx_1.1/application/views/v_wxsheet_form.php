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
	$(function() {
		$( "#ys_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});
</script>

<form action="<?=$action?>" method="post" id="wxsheetform">
<table class="show">
	<tr>
		<td>
			设备名称
		</td>
		<td>
			<label class="bxsheet_show"><?=$bxsheet_class_name?></label>
		</td>
	</tr>
	
	<tr>
		<td>
			设备编号	
		</td>
		<td>
			<input name="device_number" value="<?=$device_number?>"/>
		</td>
	</tr>
	
	<tr>
		<td>
			型号规格	
		</td>
		<td>
			<input name="model" value="<?=$model?>"/>
		</td>
	</tr>
	<tr>
		<td width="90">
			维修时间
		</td>
		<td>
			<input type="text" name="wx_date" id="wx_date" value="<?=$wx_date?>" /> 
			<select  name="wx_hour">
			<? for($i=0;$i<=23;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"  <?= $wx_hour==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
			:
			<select name="wx_minute">
			<? for($i=0;$i<=59;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $wx_minute==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			故障原因
		</td>
		<td>
			<textarea name="fault_reason" cols="60" rows="3"><?=$fault_reason?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
			检修记录
		</td>
		<td>
			<textarea name="wx_profile" cols="60" rows="3"><?=$wx_profile?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
			维修费用
		</td>
		<td>
			<input name="wx_fee" value="<?=$wx_fee?>" /> 
		</td>
	</tr>
	<tr>
		<td>
			维修状态
		</td>
		<td>
			<select name="status">
				<option value="3" <?=$status==3?"selected":""?>>已完成</option> 
				<option value="2" <?=$status==2?"selected":""?>>未完成</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			验收记录
		</td>
		<td>
			<textarea name="inspection" cols="60" rows="3"><?=$inspection?></textarea> 
		</td>
	</tr>
	<tr>
		<td>
			验收人
		</td>
		<td>
			<input name="accepter" value="<?=$accepter?>" />
		</td>
	</tr>
	<tr>
		<td width="90">
			验收时间
		</td>
		<td>
			<input type="text" name="ys_date" id="ys_date" value="<?=$ys_date?>" /> 
			<select  name="ys_hour">
			<? for($i=0;$i<=23;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"  <?= $ys_hour==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
			:
			<select name="ys_minute">
			<? for($i=0;$i<=59;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $ys_minute==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
		</td>
	</tr>
</table>
</form>
<div style="height:220px;OVERFLOW-y:auto">
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
			申报人
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_name?>&nbsp;</label>
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
			<div class="bxsheet_show"><?=$fault_profile?></div>
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
			<?=$engineer_names?>
		</td>
	</tr>
</table>
</div>