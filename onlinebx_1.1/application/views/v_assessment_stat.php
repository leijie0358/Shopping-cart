<style>

#searchsplitline
{
	margin-top: 10px;
}

.searchform td
{
	padding:3px 3px 3px 3px,
	font-size:10px
}
</style>   

<script>
	
	$(function() {
		$( "#bx_time_begin" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		$( "#bx_time_end" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
		$( "#bx_date" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
	});

</script>


<form action="<?=$searchaction?>" method="post">
<table class="searchform">
	<tr>
		<td>
			报修时间
		</td>
		<td>
			<input type="text" name="bx_time_begin" id="bx_time_begin" value="<?=$bx_time_begin?>"></input> 
			到 
			<input type="text" name="bx_time_end"  id="bx_time_end" value="<?=$bx_time_end?>"></input>
		</td>
		<td>
			<input type="submit" class='btn'  value="   统计  "></input>
		</td>
	</tr>
</table>
</form>
<div id="table">
<table class="datatable">
<thead>
<tr>
<?

if($results=="") 
{
	echo "<table><tr><td>请选择时间</td></tr></table>" ; 
	return;
}
if(sizeof($results)==0)
{
	echo "<table><tr><td>没有数据</td></tr></table>" ; 
	return;
}
foreach(array_keys($results[0]) as $key)
{
?> 
	<th><?=$key?></th>
	<? if($key!='姓名' && $key!='总计'){?>
	<th>比例</th>
	<?}?>
<?}?>
</tr>
</thead>
<tbody>
<?
foreach($results as $result){
?>
	<tr>
	<? foreach(array_keys($result) as $key){?>
		<td align="center"><?=$result[$key]?></td>
		<? if($key!='姓名' && $key!='总计'){?>
		<td align="center"><?=round(($result[$key]/($result['总计']==0?1:$result['总计'])),4)*100?>%</td> 
		<?}?> 
		
	<? }?>
	</tr>
<? }?>
</tbody>  
</table>
</div>
<div>
<script>
$(document).ready(function(){
	$('#btn_export_to_excel').click(function(){
		$('#hid').val($('#table').html());
		var tmp = { 
			beforeSubmit:  function(){
			}, 
			success:       function(data){
				// alert(data);
			}  // post-submit callback 

		}; 
		// alert($('#' + formid).attr("action"));
		$('#frm_export_to_excel').submit();
	});
});
</script>
<form action="<?=$root_url?>index.php/assessment_stat/toexcel" method='post' id="frm_export_to_excel">
<table style="margin-left:-3px">
	<tr>
		<td>
			<input type="submit" class='btn' id='btn_export_to_excel'  value=" 导出到EXCEL "></input>
			<input type="button" class='btn' id='btn_chart' onclick="showModel('w','查看图表','<?=$root_url?>index.php/assessment_stat/chart/','')"  value=" 查看统计图表 "></input>
		</td>
	</tr>
</table>
<input type="hidden" name='hid' id="hid" /> 
</form>
</div>




